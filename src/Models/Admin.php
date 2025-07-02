<?php

namespace Saseuz\LaravelAuthRdy\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

class Admin extends Authenticatable
{
    use HasRoles;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $guard = 'admin';
    
    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
