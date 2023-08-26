<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Island extends BaseModel
{
    use HasFactory;
    protected $guarded = [];

    public function validationRules(array $rules = []) { 
        return [ ];
    }
}
