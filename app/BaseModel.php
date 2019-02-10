<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    //
    use SoftDeletes;
    use Uuids;
    public $incrementing = false;
    protected $keyType = "string";
}
