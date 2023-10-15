<?php

namespace App\Enums;

enum Table:string{
    case USERS = "users";
    case PASSWORD_RESET_TOKENS = "password_reset_tokens";
    case FAILED_JOBS = "failed_jobs";
    case PERSONAL_ACCESS_TOKENS = "personal_access_tokens";
    case PROFILES = "profiles";
    case ROLES = "roles";
    case PERMISSIONS = "permissions";
    case MODEL_HAS_PERMISSIONS = "model_has_permissions";
    case MODEL_HAS_ROLES = "model_has_roles";
    case ROLE_HAS_PERMISSIONS = "role_has_permissions";
}
