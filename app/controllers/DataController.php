<?php

require_once('JSONH.class.php');

class DataController extends \BaseController {

  public function __construct()
  {
    //$this->beforeFilter('auth.api');
  }

  public function getIndex()
  {
    $in = Input::only('qlink');
    $out = Array();

    $rules = array(
        'qlink' => 'required | alpha_num'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) return;

    $out = Church::where('qlink', $in['qlink'])->first();

    return Response::json($out);
  }

  public function getIndex()
  {
    $in = Input::only('qlink');
    $out = Array();

    $rules = array(
        'qlink' => 'required | alpha_num'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) return;

    $cid = Church::where('qlink', $in['qlink'])->pluck('id');

    return Response::json($out);
  }

}
