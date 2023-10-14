<?php

namespace App\Enums;

enum Table:string{
    case USERS = "users";
    case PASSWORD_RESET_TOKENS = "password_reset_tokens";
    case FAILED_JOBS = "failed_jobs";
    case PERSONAL_ACCESS_TOKENS = "personal_access_tokens";
    case PROFILES = "profiles";
}
