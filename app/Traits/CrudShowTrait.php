<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait CrudShowTrait {

    // eg: method: GET url: /api/posts/{modelId}

    public function show(Request $request, $modelId) {

      $data = $request->all();
      $data['id'] = $modelId;
      $model = $this->getModel($modelId);
      $model->load($model->defaultIncludes());
      return response()->json($model, 200);

      
    }
}