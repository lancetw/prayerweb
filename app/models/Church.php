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
  protected $hidden = array('id', 'cid', 'deleted_at', 'created_at', 'updated_at');

  public function users()
  {
    return $this->hasMany('Users');
  }


  public function targets()
  {
    return $this->hasManyThrough('Target', 'UserChurch', 'cid', 'uid');
  }


  public function busteds()
  {
    return $this->hasManyThrough('Busted', 'UserChurch', 'cid', 'uid');
  }

  public function newCollection(array $models = array())
  {
      return new Extensions\ChurchCollection($models);
  }
}

