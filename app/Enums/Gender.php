<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum Gender:string {
    use Values;
    case MALE = "male";
    case FEMALE = "female";
}
