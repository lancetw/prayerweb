<?php

class ActionsController extends \BaseController {

  public function __construct()
  {
    $this->beforeFilter('auth.api', array('except' => array('index', 'show')));
  }

  /**
   * Display a listing of the resource.
   * GET /actions
   *
   * @return Response
   */
  public function index()
  {
    return 'actions';
  }

  /**
   * Store a newly created resource in storage.
   * POST /actions
   *
   * @return Response
   */
  public function store()
  {
    $response = new stdClass;
    $statusCode = 201;
    $in = Input::only('tid');

    $rules = array(
      'tid'  => 'required | integer'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) {
      $errs = $vd->messages();
      $statusCode = 400;
      $response = $errs->all();
    } else {
      $authId = Auth::user()->id;

      // 先檢查是否在 Target 有登記
      $uid = Target::where(
        array(
          'id' => $in['tid'],
          'uid' => $authId
        )
      )->pluck('uid');

      if ($uid == $authId) {
        $in['uid'] = Auth::user()->id;
        $response = Action::create($in);
      } else {
        $statusCode = 401;
      }

    }

    return Response::json($response, $statusCode);
  }

  /**
   * Display the specified resource.
   * GET /actions/{id}
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    //
  }

}
