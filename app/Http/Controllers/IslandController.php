<?php

namespace App\Http\Controllers;

use App\Models\Island;
use App\Traits\CrudDeleteTrait;
use App\Traits\CrudIndexTrait;
use App\Traits\CrudShowTrait;
use App\Traits\CrudStoreTrait;
use App\Traits\CrudUpdateTrait;
use App\Traits\GetModelTrait;
use App\Traits\MakeValidatorTrait;
use Illuminate\Http\Request;
class IslandController extends Controller
{
    use GetModelTrait;
    use CrudIndexTrait;
    use CrudStoreTrait;
    use CrudShowTrait;
    use CrudUpdateTrait;
    use CrudDeleteTrait;
    use MakeValidatorTrait;

    public function __construct(public $model = Island::class) {}

}