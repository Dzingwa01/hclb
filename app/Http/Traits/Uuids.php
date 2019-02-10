<?php
/**
 * Created by PhpStorm.
 * User: Gandanga
 * Date: 2019-01-14
 * Time: 08:10 PM
 */
namespace App\Traits;
use Webpatser\Uuid\Uuid;

trait Uuids
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });
    }
}