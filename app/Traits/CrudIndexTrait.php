<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

trait CrudIndexTrait {

    // eg: method: GET url: /api/posts
    public function index(Request $request) {
      $model = $this->getModel();
      $data = QueryBuilder::for($model)
        ->allowedFilters($model->allowedFilters())    
        ->with($model->defaultIncludes())
        ->orderBy('id', 'desc')    
        ->simplePaginate();
      $data = $data->appends('filter', $request->filter);
      $response = response()->json($data, 200);
      return $response;
    }
}