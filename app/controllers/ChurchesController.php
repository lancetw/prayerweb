<?php

class ChurchesController extends \BaseController {

  public function __construct()
  {
    $this->beforeFilter('auth.api', array('except' => array('show')));
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $response = new stdClass;
    $statusCode = 200;

    $authId = Auth::user()->id;

    if ($authId) {
       $cid = UserChurch::where(array('uid' => $authId))->pluck('cid');
       $response = Church::find($cid);
    } else {
      $statusCode = 403;
    }

    return Response::json($response, $statusCode);
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
      'lat'  => 'numeric',
      'lng'  => 'numeric',
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
        $statusCode = 201;
        // 先檢查是否已經加入教會
        $uc = UserChurch::where('uid', Auth::user()->id)->first();
        if ($uc && $uc->uid === Auth::user()->id) {
          $uc->cid = $cid;
          $uc->save();
        } else {
          $relation = array(
            'cid' => $cid,
            'uid' => Auth::user()->id
          );
          UserChurch::firstOrCreate($relation);
        }
        $response = new stdClass;
        return Response::json($response, $statusCode);
      }

    } else {
      $in['qlink'] = XUtil::makeQlink($in['name']);
      $church = Church::create($in);

      // 先檢查是否已經加入教會
      $uc_ = UserChurch::where('uid', Auth::user()->id)->first();
      if ($uc_ && $uc_->uid === Auth::user()->id) {
        $uc = UserChurch::find($uc_->id);
        $uc->cid = $church->id;
        $uc->save();
      } else {
        // 建立教會與使用者之間的關係
        $relation = array(
          'cid' => $church->id,
          'uid' => Auth::user()->id
        );
        UserChurch::firstOrCreate($relation);
      }
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
