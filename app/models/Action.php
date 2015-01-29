<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Action extends \Eloquent {
  use SoftDeletingTrait;

  protected $dates = ['deleted_at'];
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'actions';

  protected $fillable = ['uid', 'tid'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = array('id', 'uid', 'tid', 'created_at', 'updated_at', 'deleted_at');
}
