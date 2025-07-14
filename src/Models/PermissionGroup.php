<?php

namespace Saseuz\LaravelAuthRdy\Models;

use Illuminate\Database\Eloquent\Model;
use Saseuz\LaravelAuthRdy\Models\Permission;

class PermissionGroup extends Model 
{
    protected $fillable = [
        'name',
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'permission_group_id');
    }
}
