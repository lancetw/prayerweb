<?php

class ChurchesController extends \BaseController {

  public function __construct()
  {
    $this->beforeFilter('auth.api', array('except' => array('index', 'show')));
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    return 'churches';
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    $response = new stdClass;
    $statusCode = 201;
    $in = Input::only('name', 'lat', 'lng', 'cid');

    $rules = array(
      'name' => 'required | alpha_dash | unique:churches',
      'lat'  => 'required | numeric',
      'lng'  => 'required | numeric',
      'cid'  => 'integer'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) {
      $errs = $vd->messages();
      $statusCode = 400;
      $response = $errs->all();

      if ($errs->has('name')) {
        // 教會已有建檔，嘗試建立教會與使用者之間的關係
        $cid = Church::where('name', $in['name'])->pluck('id');
        $relation = array(
          'cid' => $cid,
          'uid' => Auth::user()->id
        );
        $statusCode = 201;
        UserChurch::firstOrCreate($relation);
        $response = new stdClass;
        return Response::json($response, $statusCode);
      }

    } else {
      $in['qlink'] = XUtil::makeQlink($in['name']);
      $church = Church::create($in);

      // 建立教會與使用者之間的關係
      $relation = array(
        'cid' => $church->id,
        'uid' => Auth::user()->id
      );
      UserChurch::firstOrCreate($relation);
      $response = new stdClass;
    }

    return Response::json($response, $statusCode);
  }


  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    return 'church';
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    /* TODO: 只有管理者可以更新 */
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    /* TODO: 只有管理者可以刪除 */
  }


}
