<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends \Eloquent implements UserInterface, RemindableInterface {

  use UserTrait, RemindableTrait;
  use SoftDeletingTrait;

  protected $dates = ['deleted_at'];
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'users';

  protected $fillable = array('uuidx', 'email', 'seed');

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = array('uuidx', 'password', 'remember_token', 'deleted_at', 'seed', 'created_at', 'updated_at', 'id');

  /**
   * Override UserTrait#getAuthPassword
   *
   */
  public function getAuthPassword()
  {
    return $this->uuidx;
  }

}
