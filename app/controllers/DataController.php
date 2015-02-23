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


  public function getTargets()
  {
    $in = Input::only('qlink');
    $out = Array();

    $rules = array(
        'qlink' => 'required | alpha_num'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) return;

    $church = Church::where('qlink', $in['qlink'])->first();
    if ($church) {
      $out['count'] = $church->targets()->count();
    }

    $queries = DB::getQueryLog();
    $last_query = end($queries);
    echo $last_query;
    //return Response::json($out);
  }


  public function getActions()
  {
    $in = Input::only('qlink');
    $out = Array();

    $rules = array(
        'qlink' => 'required | alpha_num'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) return;

    $cid = Church::where('qlink', $in['qlink'])->pluck('id');
    if ($cid) {
      $out['count_today'] = Action::where('cid', $cid)->today()->count();
    }

    return Response::json($out);
  }


  public function getUsers()
  {
    $in = Input::only('qlink');
    $out = Array();

    $rules = array(
        'qlink' => 'required | alpha_num'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) return;

    $cid = Church::where('qlink', $in['qlink'])->pluck('id');
    if ($cid) {
      $out['count'] = UserChurch::where('cid', $cid)->count();
    }

    return Response::json($out);
  }


  public function getStat($type) {
    if ($type === 'today') {
      return $this->getStatToday();
    }

    if ($type === 'lastweek') {
      return $this->getStatLastWeek();
    }

    if ($type === 'month') {
      return $this->getStatMonth();
    }

    if ($type === 'year') {
      return $this->getStatYear();
    }

    if ($type === 'month_by_weeks') {
      return $this->getStatMonthByWeeks();
    }
  }

  public function getStatToday()
  {
    $in = Input::only('qlink');
    $out = Array();

    $rules = array(
        'qlink' => 'required | alpha_num'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) return;

    $cid = Church::where('qlink', $in['qlink'])->pluck('id');
    $church = Church::where('qlink', $in['qlink'])->first();
    if ($cid) {
      $actions = array_fill(0, 24, null);
      foreach (Action::where('cid', $cid)->groupTodayByHours() as $k => $v) {
        foreach ($v as $key => $value) {
          $actions[$k]++;
        }
      };

      $users = array_fill(0, 24, null);
      foreach (UserChurch::where('cid', $cid)->groupTodayByHours() as $k => $v) {
        foreach ($v as $key => $value) {
          $users[$k]++;
        }
      };

      $out['statistic_actions_today'] =  $actions;
      $out['statistic_users_today'] =  $users;
    }

    return Response::json($out);
  }


  public function getStatLastWeek()
  {
    $in = Input::only('qlink');
    $out = Array();

    $rules = array(
        'qlink' => 'required | alpha_num'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) return;

    $cid = Church::where('qlink', $in['qlink'])->pluck('id');
    $church = Church::where('qlink', $in['qlink'])->first();
    if ($cid) {
      $actions = array_fill(1, 7, '');
      foreach (Action::where('cid', $cid)->groupLastWeekByDays() as $k => $v) {
        foreach ($v as $key => $value) {
          $actions[$k]++;
        }
      };

      $users = array_fill(1, 7, '');
      foreach (UserChurch::where('cid', $cid)->groupLastWeekByDays() as $k => $v) {
        foreach ($v as $key => $value) {
          $users[$k]++;
        }
      };

      $out['statistic_actions_lastweek'] =  array_values($actions);
      $out['statistic_users_lastweek'] =  array_values($users);
    }

    return Response::json($out);
  }

  public function getStatMonth()
  {
    $in = Input::only('qlink');
    $out = Array();

    $rules = array(
        'qlink' => 'required | alpha_num'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) return;

    $cid = Church::where('qlink', $in['qlink'])->pluck('id');
    $church = Church::where('qlink', $in['qlink'])->first();
    if ($cid) {
      $actions = array_fill(1, 31, '');
      foreach (Action::where('cid', $cid)->groupMonthByDays() as $k => $v) {
        foreach ($v as $key => $value) {
          $actions[$k]++;
        }
      };

      $users = array_fill(1, 31, '');
      foreach (UserChurch::where('cid', $cid)->groupMonthByDays() as $k => $v) {
        foreach ($v as $key => $value) {
          $users[$k]++;
        }
      };

      $out['statistic_actions_month'] =  array_values($actions);
      $out['statistic_users_month'] =  array_values($users);
    }

    return Response::json($out);
  }


  public function getStatYear()
  {
    $in = Input::only('qlink');
    $out = Array();

    $rules = array(
        'qlink' => 'required | alpha_num'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) return;

    $cid = Church::where('qlink', $in['qlink'])->pluck('id');
    $church = Church::where('qlink', $in['qlink'])->first();
    if ($cid) {
      $actions = array_fill(1, 12, '');
      foreach (Action::where('cid', $cid)->groupMonthByMonths() as $k => $v) {
        foreach ($v as $key => $value) {
          $actions[$k]++;
        }
      };

      $users = array_fill(1, 12, '');
      foreach (UserChurch::where('cid', $cid)->groupMonthByMonths() as $k => $v) {
        foreach ($v as $key => $value) {
          $users[$k]++;
        }
      };

      $out['statistic_actions_year'] =  array_values($actions);
      $out['statistic_users_year'] =  array_values($users);
    }

    return Response::json($out);
  }


  public function getStatMonthByWeeks()
  {
    $in = Input::only('qlink');
    $out = Array();

    $rules = array(
        'qlink' => 'required | alpha_num'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) return;

    $cid = Church::where('qlink', $in['qlink'])->pluck('id');
    $church = Church::where('qlink', $in['qlink'])->first();
    if ($cid) {
      $actions = array_fill(1, 5, '');
      foreach (Action::where('cid', $cid)->groupMonthByWeeks() as $k => $v) {
        foreach ($v as $key => $value) {
          $actions[$k]++;
        }
      };

      $users = array_fill(1, 5, '');
      foreach (UserChurch::where('cid', $cid)->groupMonthByWeeks() as $k => $v) {
        foreach ($v as $key => $value) {
          $users[$k]++;
        }
      };

      $out['statistic_actions_month_by_weeks'] =  array_values($actions);
      $out['statistic_users_month_by_weeks'] =  array_values($users);
    }

    return Response::json($out);
  }


  public function getTargetall($per = 5)
  {
    $in = Input::only('qlink');
    $out = Array();

    $rules = array(
        'qlink' => 'required | alpha_num'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) return;

    $church = Church::where('qlink', $in['qlink'])->first();
    if ($church) {
      $rdata = $church->targets()->orderBy('created_at', 'DESC')->get()->each(function ($item) {
        $item->setHidden(['cid', 'id', 'uid', 'name', 'deleted_at', 'updated_at']);
      })->toArray();

      $current = Input::get('page') - 1;
      $data = array_slice($rdata, $current * $per, $per);
      $out = Paginator::make($data, count($rdata), $per);
    }

    return Response::json($out);
  }


  public function getBustedall($per = 5)
  {
    $in = Input::only('qlink');
    $out = Array();

    $rules = array(
        'qlink' => 'required | alpha_num'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) return;

    $church = Church::where('qlink', $in['qlink'])->first();
    if ($church) {
      $rdata = $church->busteds()->orderBy('created_at', 'DESC')->get()->each(function ($item) {
        $item->setHidden(['cid', 'id', 'uid', 'name', 'deleted_at', 'updated_at']);
      })->toArray();

      $current = Input::get('page') - 1;
      $data = array_slice($rdata, $current * $per, $per);
      $out = Paginator::make($data, count($rdata), $per);
    }

    return Response::json($out);
  }

  public function getTest()
  {
    $in = Input::only('qlink');
    $out = Array();

    $rules = array(
        'qlink' => 'required | alpha_num'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) return;

    $church = Church::where('qlink', $in['qlink'])->first();
    $out = $church->targets()->get();

    return Response::json($out);
  }

  public function getInfo()
  {
    $in = Input::only('qlink');
    $out = Array();

    $rules = array(
        'qlink' => 'required | alpha_num'
    );

    $vd = Validator::make($in, $rules);
    if($vd->fails()) return;

    $church = Church::where('qlink', $in['qlink'])->first();
    $sinners = $church->targets()->where('sinner', '=', true)->count();
    $baptizeds = $church->targets()->where('baptized', '=', true)->count();
    $meeters = $church->targets()->where('meeter', '=', true)->count();

    if ($church) {
      $out = array(
        'sinner' => $sinners,
        'baptized' => $baptizeds,
        'meeter' => $meeters
      );
    }

    return Response::json($out);
  }


  public function getNewchurches()
  {
    //$in = Input::only('date');
    $out = Array();

    /*$rules = array(
        'date' => 'required | date'
    );*/

    /*$vd = Validator::make($in, $rules);
    if($vd->fails()) return;
    */

    $out = Church::yesterday();

    return Response::json($out);
  }

  public function getNewchurchesmail()
  {
    $churches = Church::yesterday();

    $data['churches'] = $churches;

    return View::make('emails.dailynewchurches', $data);

  }


  public function getMailtest()
  {
    $churches = Church::yesterday();

    if ($churches && $churches->count() > 0) {
      $data['churches'] = $churches;
      Mail::send('emails.dailynewchurches', $data, function($message)
      {
        // 測試
        $message->to('lancetw@gmail.com', '一領一禱告認領同工')->subject('一領一禱告認領：新加入教會通知 ' . date('Y/m/d'));
      });
    }
  }


}
