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
  protected $table = 'user_churches';

  protected $fillable = ['uid', 'cid'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = array('deleted_at', 'created_at', 'updated_at');

}

