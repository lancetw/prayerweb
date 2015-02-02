<?php

class TargetsController extends \BaseController {

  public function __construct()
  {
    $this->beforeFilter('auth.api', array('except' => array('index', 'show')));
  }

  /**
   * Display a listing of the resource.
   * GET /targets
   *
   * @return Response
   */
  public function index()
  {
    return 'target';
  }

  /**
   * Store a newly created resource in storage.
   * POST /targets
   *
   * @return Response
   */
  public function store()
  {
    $response = [];
    $statusCode = 201;
    $in = Input::only('name', 'mask', 'freq', 'sinner');

    $rules = array(
      'name'   => 'required',
      'mask'   => 'required',
      'freq'   => 'required | integer',
      'sinner' => 'required | boolean'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) {
      $errs = $vd->messages();
      $statusCode = 400;
      $response = $errs->all();
    } else {
      // 先檢查有沒有登記過再新增
      $authId = Auth::user()->id;
      $uid = Target::where(
        array(
          'uid' => $authId,
          'name' => $in['name']
        )
      )->pluck('uid');

      if (!$uid) {
        $in['uid'] = Auth::user()->id;
        $response = Target::firstOrCreate($in);
      } else {
        $statusCode = 302;
      }
    }

    return Response::json($response, $statusCode);
  }

  /**
   * Display the specified resource.
   * GET /targets/{id}
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   * PUT /targets/{id}
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    $response = [];
    $statusCode = 200;

    $in = Input::only('name', 'mask', 'freq', 'sinner', 'baptized', 'meeter', 'email', 'nick', 'church');

    $rules = array(
      'name' => 'required',
      'mask' => 'required',
      'freq' => 'required | integer',
      'sinner' => 'required | boolean',
      'baptized' => 'required | boolean',
      'meeter' => 'required | boolean',
      'email' => 'email'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) {
      $errs = $vd->messages();
      $statusCode = 401;
      $response = $errs->all();
    } else {
      $authId = Auth::user()->id;
      $target = Target::find($id);

      if ($target && $target->uid == $authId) {
        if (!$target->update($in)) {
          $statusCode = 304;
        }
      } else {
        $statusCode = 401;
      }
    }

    return Response::json($response, $statusCode);
  }

  /**
   * Remove the specified resource from storage.
   * DELETE /targets/{id}
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $response = [];
    $statusCode = 200;

    $authId = Auth::user()->id;
    $target = Target::find($id);

    if ($target && $target->uid == $authId) {
      // 紀錄在 busted
      Busted::create($target->toArray());
      $target->forceDelete();

    } else {
      $statusCode = 401;
    }

    return Response::json($response, $statusCode);
  }

}
