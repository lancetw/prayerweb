<?php namespace Extensions;

use Illuminate\Support\Collection;

class ChurchCollection extends Collection {

  public function getByPage($page = 1, $limit = 10, $with = array())
  {
    $result             = new StdClass;
    $result->page       = $page;
    $result->limit      = $limit;
    $result->totalItems = 0;
    $result->items      = array();

    $query = $this->make($with);

    $model = $query->skip($limit * ($page - 1))
                   ->take($limit)
                   ->get();

    $result->totalItems = $this->model->count();
    $result->items      = $model->all();

    return $result;
  }
}
