<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait CrudDeleteTrait {

    // eg: method: DELETE url: /api/post/{modelId}
    public function destroy(Request $request, $modelId) {
      $this->getModel($modelId)->delete();
      return response()->json(['message' => 'Deleted'], 200);
    }
}