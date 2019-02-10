<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends BaseModel
{
    //
    protected $fillable =['location_name','city','description'];

    protected function agents(){
        return $this->hasMany(User::class,'location_id');
    }
}
