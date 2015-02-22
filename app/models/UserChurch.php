<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Carbon\Carbon;

class UserChurch extends \Eloquent {

  use SoftDeletingTrait;

  protected $dates = ['deleted_at'];
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'user_churches';

  protected $fillable = ['uid', 'cid'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = array('deleted_at', 'created_at', 'updated_at');

  public function scopeToday($query)
  {
    return $query->where('created_at', '>', Carbon::now()->startOfWeek()->subDay())
                 ->where('created_at', '<', Carbon::now()->endOfWeek()->subDay())
                 ->get();
  }

  public function user()
  {
    return $this->belongsTo('User', 'id', 'uid');
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
    return $query
      ->where('created_at', '>', Carbon::now()->startOfWeek()->subWeek())
      ->where('created_at', '<', Carbon::now()->endOfWeek()->subWeek())
      ->get()
      ->groupBy(function($date) {
        return Carbon::parse($date->created_at)->format('N');
      });
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
        return Carbon::parse($date->created_at)->weekOfMonth;
      });
  }


}

