<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

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
  protected $hidden = array('id', 'deleted_at', 'cid', 'created_at', 'updated_at');


}
