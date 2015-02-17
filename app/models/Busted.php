<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Busted extends \Eloquent {
  use SoftDeletingTrait;

  protected $dates = ['deleted_at'];
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'busteds';

  protected $fillable = ['uid', 'busted_at', 'name', 'mask', 'freq', 'sinner', 'baptized', 'meeter', 'email', 'nick', 'church'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = array('uid', 'name', 'deleted_at', 'created_at', 'updated_at', 'id');

  public function user()
  {
    return $this->hasOne('User', 'uid');
  }

}
