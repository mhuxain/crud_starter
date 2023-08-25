<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Quote extends BaseModel
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'id' => 'integer',
        'quoted_on' => 'date:Y-m-d',
    ];

    public function validationRules(array $rules = []) { 
        return [
            'author' => ['required', 'string', 'max:255'],
            'quote' => ['required', 'string', 'max:255'],
        ];
    }
}
