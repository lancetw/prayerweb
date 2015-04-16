<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Carbon\Carbon;

class Action extends \Eloquent {
  use SoftDeletingTrait;

  protected $dates = ['deleted_at'];
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'actions';

  protected $fillable = ['uid', 'tid', 'cid'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = array('id', 'uid', 'tid', 'cid', 'created_at', 'updated_at', 'deleted_at');
  //protected $appends = array('minute', 'second');

  /*
  public function getMinuteAttribute()
  {
      return Carbon::parse($this->attributes['created_at'])->minute;
  }*/

  /*
  public function getSecondAttribute()
  {
      return Carbon::parse($this->attributes['created_at'])->second;
  }*/

  public function scopeToday($query)
  {
    return $query->where('created_at', '>', Carbon::today()->startOfDay())
                 ->where('created_at', '<', Carbon::today()->endOfDay())
                 ->get();
  }


  public function scopeGroupTodayByHours($query)
  {
    return $query
      ->where('created_at', '>', Carbon::today()->startOfDay())
      ->where('created_at', '<', Carbon::today()->endOfDay())
      ->get()
      ->groupBy(function($date) {
        return Carbon::parse($date->created_at)->format('G');
      });
  }


  public function scopeGroupLastWeekByDays($query)
  {
    /* Handle Sunday */
    if (Carbon::now()->dayOfWeek == Carbon::SUNDAY) {

      return $query
        ->where('created_at', '>', Carbon::now()->startOfWeek()->subDay())
        ->where('created_at', '<', Carbon::now()->endOfWeek()->subDay())
        ->get()
        ->groupBy(function($date) {
          return Carbon::parse($date->created_at)->format('w');
        });

    } else {

      return $query
        ->where('created_at', '>', Carbon::now()->subWeek()->startOfWeek()->subDay())
        ->where('created_at', '<', Carbon::now()->subWeek()->endOfWeek()->subDay())
        ->get()
        ->groupBy(function($date) {
          return Carbon::parse($date->created_at)->format('w');
        });

    }
  }


  public function scopeGroupMonthByDays($query)
  {
    return $query
      ->where('created_at', '>', Carbon::now()->startOfMonth())
      ->where('created_at', '<', Carbon::now()->endOfMonth())
      ->get()
      ->groupBy(function($date) {
        return Carbon::parse($date->created_at)->format('j');
      });
  }


  public function scopeGroupMonthByMonths($query)
  {
    return $query
      ->where('created_at', '>', Carbon::now()->startOfYear())
      ->where('created_at', '<', Carbon::now()->endOfYear())
      ->get()
      ->groupBy(function($date) {
        return Carbon::parse($date->created_at)->format('n');
      });
  }


  public function scopeGroupMonthByWeeks($query)
  {
    return $query
      ->where('created_at', '>', Carbon::now()->startOfMonth())
      ->where('created_at', '<', Carbon::now()->endOfMonth())
      ->get()
      ->groupBy(function($date) {
        $day = Carbon::parse($date->created_at);

        $end = $day->copy()->addDay()->weekOfYear;
        $start = $day->startOfMonth()->weekOfYear;
        $weeknum = $end - $start + 1;

        if ($weeknum < 0) {
          $end = $day->copy()->subDay()->weekOfYear;
          $start = $day->startOfMonth()->weekOfYear;
          $weeknum = $end - $start + 1;
        }

        return $weeknum;
      });
  }

}
