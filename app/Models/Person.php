<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Person extends BaseModel
{
    use HasFactory;
    protected $casts = [
        'id' => 'integer',
        'dob' => 'date:Y-m-d',
    ];

    public function validationRules(array $rules = []) { 
        return [
            'national_id' => ['required', 'regex:/^A\d{6}$/'],
            'dob' => [
                'required',
                'before:today'
            ],
        ];
    }

    public function defaultIncludes() {
        return ['addresses'];
    }

    public function addresses() {
        return $this->belongsToMany(Address::class);
    }
}
