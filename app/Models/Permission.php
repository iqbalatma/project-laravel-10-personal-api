<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * @property string id
 * @property string name
 * @property string guard_name
 * @property string description
 * @property string feature
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory, HasUuids;

    protected $fillable = [
        "name", "guard_name", "description", "feature"
    ];
}
