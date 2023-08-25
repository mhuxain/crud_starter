<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait CrudUpdateTrait {

    // eg: method: PUT url: /api/posts/{modelId}

    public function update(Request $request, $modelId) {

      
      $data = $request->all();
      $data['id'] = $modelId;
      $model = $this->getModel($modelId);
      $validator = $this->makeValidator($data, $model, $ignoreRequired = true);
      if($validator->fails()) {
        return response()->json([
          'errors' => $validator->errors()->toArray()
        ], 422);
      }
      
      $saved = $model
        ->fill($data)
        ->save();
      if($saved) {
        return response()->json($model, 200);
      } else {
        return response()->json([ 'error' => 'not updated', 400]);
      }
      
    }
}