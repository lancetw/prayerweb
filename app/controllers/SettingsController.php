<?php

class SettingsController extends \BaseController {

  public function __construct()
  {
    $this->beforeFilter('auth.api', array('except' => array('index', 'show')));
  }

  /**
   * Display a listing of the resource.
   * GET /settings
   *
   * @return Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   * GET /settings/create
   *
   * @return Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   * POST /settings
   *
   * @return Response
   */
  public function store()
  {
    $response = [];
    $statusCode = 201;
    $in = Input::only('email', 'subscription', 'phone');

    $rules = array(
      'email'        => 'required | email | unique:settings',
      'subscription' => 'boolean'
    );

    // 先檢查身分
    $authId = Auth::user()->id;
    $email = User::where(
      array(
        'id' => $authId,
        'email' => $in['email']
      )
    )->pluck('email');

    $vd = Validator::make($in, $rules);
    if($vd->fails()) {
      $errs = $vd->messages();
      $statusCode = 400;

      if ($errs->has('email')) {
        if ($email == $in['email']) {
          $setting = Setting::where(
            array(
              'email' => $in['email']
            )
          );

          if (!$setting->update($in)) {
            $statusCode = 304;
            $response = $errs->all();
          } else {
            $statusCode = 200;
          }
        }
      }

    } else {
      if ($email == $in['email']) {
        $response = Setting::firstOrCreate($in);
      } else {
        $statusCode = 401;
      }
    }

    return Response::json($response, $statusCode);
  }

  /**
   * Display the specified resource.
   * GET /settings/{id}
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   * GET /settings/{id}/edit
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   * PUT /settings/{id}
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
   * DELETE /settings/{id}
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    //
  }

}
