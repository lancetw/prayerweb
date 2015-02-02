<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Setting extends \Eloquent {
  use SoftDeletingTrait;

  protected $dates = ['deleted_at'];
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'settings';

  protected $fillable = ['email', 'subscription', 'phone'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = array('deleted_at', 'created_at', 'updated_at', 'id', 'phone');

}
