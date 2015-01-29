<?php

require_once('JSONH.class.php');
use Location\Coordinate;
use Location\Distance\Haversine;

class MapController extends \BaseController {

  public function __construct()
  {
    $this->beforeFilter('auth.api');
  }

  public function getIndex()
  {
    return 'map';
  }


  // lat: 24.182984,
  // lng: 120.589952
  public function postIndex()
  {
    $in = Input::only('lat', 'lng');
    $out = Array();

    $rules = array(
        'lat' => 'required',
        'lng' => 'required'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) return;

    try {
      $geo = Geocoder::reverse($in['lat'], $in['lng']);

      $out['code'] = $geo->getCountryCode();
      $out['city'] = $geo->getRegionCode();
      $out['town'] = $geo->getCity();
      $out['zipcode'] = $geo->getZipCode();
      $out['streetName'] = $geo->getStreetName();

    } catch (\Exception $e) {

      return Response::json(array('error' => $e->getMessage()));
    }

    return Response::json($out);
  }


  public function getNearby()
  {
    return 'nearby';
  }


  public function postNearby($dist='1000')
  {
    $in = Input::only('code', 'city', 'town', 'lat', 'lng');
    $out = Array();

    $rules = array(
        'code' => 'required',
        'city' => 'required'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) return;

    if ($this->is_lat($in['lat']) && $this->is_lng($in['lng'])) {
      $lat = $in['lat'];
      $lng = $in['lng'];

      $rdata = $this->mapInfo_($in);
      $this->getSort_($rdata, $lat, $lng);

      $out = array_filter($rdata, function ($a) use ($lat, $lng, $dist) {
          if ($this->is_lat($a->lat) && $this->is_lng($a->lng)) {
            if ($this->dist_($lat, $lng, $a->lat, $a->lng) <= $dist) {
              return true;
            }
          }
          return false;
      });
    } else {
      if (empty($in['town'])) return;

      $out = $this->mapInfo_($in);
    }

    return Response::json($out);
  }


  function getSort_(&$rdata, $lat, $lng)
  {
    usort($rdata, function ($a, $b) use ($lat, $lng) {

      $dist1 = $this->dist_($lat, $lng, $a->lat, $a->lng);
      $dist2 = $this->dist_($lat, $lng, $b->lat, $b->lng);

      if ($dist1 === $dist2) return 0;
      return $dist1 > $dist2 ? 1 : -1;

    });
  }


  function is_lat($lat)
  {
    return $this->is_coordinate($lat, 90, -90);
  }


  function is_lng($lng)
  {
    return $this->is_coordinate($lng, 180, -180);
  }


  function is_coordinate($c, $limit_positive, $limit_negative)
  {
    if (isset($c) &&
        !empty($c) &&
        $c > 0 &&
        $c !== null &&
        $c !== 'null' &&
        $c < $limit_positive &&
        $c > $limit_negative
    ) return true;
    return false;
  }


  function dist_($lat1, $lng1, $lat2, $lng2)
  {
    if ($this->is_lat($lat1) &&
        $this->is_lng($lng1) &&
        $this->is_lat($lat2) &&
        $this->is_lng($lng2)
        ) {
      $c1 = new Coordinate($lat1, $lng1);
      $c2 = new Coordinate($lat2, $lng2);
      return $c1->getDistance($c2, new Haversine());
    } else {
      return PHP_INT_MAX;
    }
  }


  function mapInfo_($in)
  {
    $mapOptions = array(
      'mode' => !empty($in['town']) ? 'phone' : 'pad',
      'code' => $in['code'],
      'city' => $in['city'],
      'town' => $in['town']
    );
    $url = cURL::buildUrl('http://church.oursweb.net/lite/mapinfo', $mapOptions);
    $rdata = cURL::get($url);
    $data = json_decode($rdata, true);
    $body = JSONH::parse($data['geoinfo']);

    return $body;
  }

}
