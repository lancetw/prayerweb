<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Carbon\Carbon;

class Church extends \Eloquent {

  use SoftDeletingTrait;

  protected $dates = ['deleted_at'];
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'churches';

  protected $fillable = ['name', 'lat', 'lng', 'qlink', 'cid'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = array('id', 'cid', 'deleted_at', 'created_at', 'updated_at');

  public function users()
  {
    return $this->hasManyThough('User', 'UserChurches', 'cid', 'id');
  }


  public function targets()
  {
    return $this->users->targets();
  }


  public function busteds()
  {
    return $this->users->busteds();
  }


  public function newCollection(array $models = array())
  {
      return new Extensions\ChurchCollection($models);
  }


  public function scopeYesterday($query)
  {
    return $query->where('created_at', '>', Carbon::yesterday()->startOfDay())
                 ->where('created_at', '<', Carbon::yesterday()->endOfDay())
                 ->get();
  }

}
