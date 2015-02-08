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

    return Response::json($out);
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
      $actions = array_fill(0, 7, null);
      foreach (Action::where('cid', $cid)->groupLastWeekByDays() as $k => $v) {
        foreach ($v as $key => $value) {
          $actions[$k]++;
        }
      };

      $users = array_fill(0, 7, null);
      foreach (UserChurch::where('cid', $cid)->groupLastWeekByDays() as $k => $v) {
        foreach ($v as $key => $value) {
          $users[$k]++;
        }
      };

      $out['statistic_actions_lastweek'] =  $actions;
      $out['statistic_users_lastweek'] =  $users;
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
      $actions = array_fill(1, 31, null);
      foreach (Action::where('cid', $cid)->groupMonthByDays() as $k => $v) {
        foreach ($v as $key => $value) {
          $actions[$k]++;
        }
      };

      $users = array_fill(1, 31, null);
      foreach (UserChurch::where('cid', $cid)->groupMonthByDays() as $k => $v) {
        foreach ($v as $key => $value) {
          $users[$k]++;
        }
      };

      $out['statistic_actions_month'] =  $actions;
      $out['statistic_users_month'] =  $users;
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
      $actions = array_fill(1, 12, null);
      foreach (Action::where('cid', $cid)->groupMonthByMonths() as $k => $v) {
        foreach ($v as $key => $value) {
          $actions[$k]++;
        }
      };

      $users = array_fill(1, 12, null);
      foreach (UserChurch::where('cid', $cid)->groupMonthByMonths() as $k => $v) {
        foreach ($v as $key => $value) {
          $users[$k]++;
        }
      };

      $out['statistic_actions_year'] =  $actions;
      $out['statistic_users_year'] =  $users;
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
      $actions = array_fill(1, 5, null);
      foreach (Action::where('cid', $cid)->groupMonthByWeeks() as $k => $v) {
        foreach ($v as $key => $value) {
          $actions[$k]++;
        }
      };

      $users = array_fill(1, 5, null);
      foreach (UserChurch::where('cid', $cid)->groupMonthByWeeks() as $k => $v) {
        foreach ($v as $key => $value) {
          $users[$k]++;
        }
      };

      $out['statistic_actions_month_by_weeks'] =  $actions;
      $out['statistic_users_month_by_weeks'] =  $users;
    }

    return Response::json($out);
  }


  public function getTargetall()
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
      $out = $church->targets()->get();
    }

    return Response::json($out);
  }


  public function getBustedall()
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
      $out = $church->busteds()->get();
    }

    return Response::json($out);
  }

}
