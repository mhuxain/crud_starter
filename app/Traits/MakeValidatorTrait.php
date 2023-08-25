<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

trait MakeValidatorTrait {


    public function makeValidator($data, $model, $ignoreRequired = false) {
      
      $rules = $ignoreRequired ?
        collect($model->validationRules($data))->map(function ($rule) { 
          return collect($rule)->filter(fn ($r) => $r !== 'required')->all();
        })->all() : $model->validationRules();
      return Validator::make($data, $rules);
    }
    
}