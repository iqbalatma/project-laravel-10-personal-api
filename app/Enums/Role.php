<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum Role:string {
    use Values;
    case SUPERADMIN = "superadmin";
    case ADMIN = "admin";
}
