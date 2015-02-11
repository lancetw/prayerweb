<?php

class LogController extends \BaseController {

  public function __construct()
  {
    $this->beforeFilter('auth.api', array('except' => array('')));
  }
  /**
   * Store a newly created resource in storage.
   * POST /statistics
   *
   * @return Response
   */
  public function store()
  {
    $response = new stdClass;
    $statusCode = 201;
    $in = Input::only('email', 'uuidx', 'type', 'data', 'info');
    $rules = array(
      'email' => 'required | email',
      'uudix' => 'required | alpha_dash',
      'type'  => 'required',
      'data'  => 'required',
      'info'  => 'required'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) {
      $errs = $vd->messages();
      $statusCode = 400;
      $response = $errs->all();
    } else {
      $authId = Auth::user()->id;
      $in['uid'] = $authId;

      $response = Log::create($in);
    }

    return Response::json($response, $statusCode);
  }


}
