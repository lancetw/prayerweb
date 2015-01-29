<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class UserChurch extends \Eloquent {

  use SoftDeletingTrait;

  protected $dates = ['deleted_at'];
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'user_church';

  protected $fillable = ['uid', 'cid'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = array('uid', 'cid', 'deleted_at', 'created_at', 'updated_at', 'id');

}

