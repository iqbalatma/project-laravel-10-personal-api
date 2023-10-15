<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum Permission:string {
    use Values;
    case PERMISISONS_INDEX = "permissions.index";
    case USERS_INDEX = "users.index";
}
