<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait GetModelTrait {

  public function getModel($id = null)
  {
    return $id ? app()->make($this->model)->findOrFail($id) : app()->make($this->model);
  }
}