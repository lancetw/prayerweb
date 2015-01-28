<?php

class UserController extends \BaseController {

  public function __construct()
  {
    $this->beforeFilter('auth.basic', array('except' => array('index', 'show', 'store')));
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    return 'user';
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    $statusCode = 200;
    $in = Input::only('uuidx', 'email');

    $rules = array(
        'uuidx' => 'required | unique:users',
        'email' => 'required | unique:users'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) {
      $statusCode = 400;
      $response = [];
      return Response::json($response, $statusCode);
    }

    mt_srand(crc32(microtime()));

    $data = array(
      'uuidx' => $in['uuidx'],
      'email' => $in['email'],
      'seed' => mt_rand()
    );

    $response = User::firstOrCreate($data);

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
    //
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    //
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $user = User::find($id);
    $user->delete();
  }


}
