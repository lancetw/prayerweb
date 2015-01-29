<?php

class UserController extends \BaseController {

  public function __construct()
  {
    $this->beforeFilter('auth.api', array('except' => array('index', 'show', 'store')));
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
    $response = [];
    $statusCode = 201;
    $in = Input::only('uuidx', 'email');

    $rules = array(
      'uuidx' => 'required | alpha_dash | unique:users',
      'email' => 'required | email | unique:users'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) {
      $errs = $vd->messages();

      if ($errs->has('uuidx') || $errs->has('email')) {

        if ($errs->has('email')) {

          $credentials['email'] = $in['email'];
          $credentials['password'] = $in['uuidx'];

          if (Auth::attempt($credentials, false)) {
            $statusCode = 200;
            $response = Auth::user();
          } else {
            $statusCode = 401;
            $response = $errs->all();
          }
        } else {
          $statusCode = 401;
          $response = $errs->all();
        }
      }

      return Response::json($response, $statusCode);
    }

    mt_srand(crc32(microtime()));

    $data = array(
      'uuidx' => Hash::make($in['uuidx']),
      'email' => $in['email'],
      'seed' => mt_rand()
    );

    $response = User::create($data);

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
