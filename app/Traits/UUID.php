<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UUID
{
    /**
     * Automatically assign a UUID to the model when creating.
     */
    protected static function bootUUID()
    {

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

    /**
     * Disable auto-incrementing since UUIDs are strings.
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Use string key type.
     */
    public function getKeyType()
    {
        return 'string';
    }
}
