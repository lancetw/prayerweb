<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Log extends \Eloquent {

  use SoftDeletingTrait;

  protected $dates = ['deleted_at'];
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'logs';

  protected $fillable = ['uid', 'email', 'uuidx', 'type', 'data', 'info'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = array('id', 'uid', 'deleted_at', 'created_at', 'updated_at');

}

