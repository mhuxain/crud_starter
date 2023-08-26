<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends BaseModel
{
    protected $appends = ['label'];
    use HasFactory;

    public function validationRules(array $rules = []) { 
        return [
        ];
    }

    public function defaultIncludes() {
        return ['island'];
    }

    public function getLabelAttribute()
    {

        return $this->house_name.", ".$this->street;

    }

    function island() {
        return $this->belongsTo(Island::class);
    }
}
