<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Traits\CrudDeleteTrait;
use App\Traits\CrudIndexTrait;
use App\Traits\CrudShowTrait;
use App\Traits\CrudStoreTrait;
use App\Traits\CrudUpdateTrait;
use App\Traits\GetModelTrait;
use App\Traits\MakeValidatorTrait;
use Illuminate\Http\Request;
class PersonController extends Controller
{
    use GetModelTrait;
    use CrudIndexTrait;
    use CrudShowTrait;
    use CrudUpdateTrait;
    use CrudDeleteTrait;
    use MakeValidatorTrait;

    public function __construct(public $model = Person::class) {}

    public function store(Request $request) {
        $data = $request->all();
        $addressId = collect($data)->only('address_id');
        $data = collect($data)->forget('address_id')->all();
        $model = $this->getModel();
        $validator = $this->makeValidator($data, $model);
        if($validator->fails()) {
          return response()->json([
            'errors' => $validator->errors()->toArray()
          ], 422);
        }
        $createdModel = $model->create($data);
        $createdModel->addresses()->attach($addressId);
        return response()->json($createdModel, 201);
      }

      function addAddress($personId, $addressId) {
        return Person::findOrFail($personId)->addresses()->syncWithoutDetaching([$addressId]);
      }

      function removeAddress($personId, $addressId) {
        return Person::findOrFail($personId)->addresses()->detach($addressId);
      }

}
