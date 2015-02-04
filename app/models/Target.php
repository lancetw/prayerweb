<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Target extends \Eloquent {
  use SoftDeletingTrait;

  protected $dates = ['deleted_at'];
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'targets';

  protected $fillable = ['uid', 'name', 'mask', 'freq', 'sinner', 'baptized', 'meeter', 'email', 'nick', 'church'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = array('deleted_at', 'created_at', 'updated_at');

  public function user()
  {
    return $this->hasOne('User', 'uid');
  }

}
