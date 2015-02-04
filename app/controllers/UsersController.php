<?php

class UsersController extends \BaseController {

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
    return 'users';
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

    } else {
      mt_srand(crc32(microtime()));

      $in['uuidx'] = Hash::make($in['uuidx']);
      $in['seed'] = mt_rand();

      $response = User::create($in);
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
    return 'user';
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    $response = new stdClass;
    $statusCode = 200;

    $in = Input::only('uuidx', 'email');

    $rules = array(
      'uuidx' => 'required | alpha_dash | unique:users',
      'email' => 'required | email'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) {
      $errs = $vd->messages();

      if ($errs->has('uuidx') || $errs->has('email')) {
        $statusCode = 401;
        $response = $errs->all();
      }
    } else {
      $authId = Auth::user()->id;

      if ($id === $authId) {
        $user = User::find($id);
        $user->uuidx = Hash::make($in['uuidx']);
        $user->save();

        $response = $user;
      } else {
        $statusCode = 401;
      }
    }

    return Response::json($response, $statusCode);
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $response = new stdClass;
    $statusCode = 200;

    $authId = Auth::user()->id;

    if ($id === $authId) {
      $user = User::find($id);
      $user->delete();
    } else {
      $statusCode = 401;
    }

    return Response::json($response, $statusCode);
  }


}
