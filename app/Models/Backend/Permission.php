<?php

namespace App\Models\Backend;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    public function group()
    {
        return $this->belongsTo(PermissionGroup::class, 'permission_group_id');
    }
}
