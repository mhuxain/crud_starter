<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait CrudStoreTrait {

    // eg: method: POST url: /api/posts

    public function store(Request $request) {
      $data = $request->all();
      $model = $this->getModel();
      $validator = $this->makeValidator($data, $model);
      if($validator->fails()) {
        return response()->json([
          'errors' => $validator->errors()->toArray()
        ], 422);
      }
      $createdModel = $model->create($data);
      return response()->json($createdModel, 201);
    }
}