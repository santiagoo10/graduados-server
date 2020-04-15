<?php

namespace App\Security;

abstract class Role
{

    public const ROLE_OWNER = 'ROLE_OWNER';
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_GRADUATE = 'ROLE_GRADUATE';
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    public const ROLE_ALLOWED_TO_SWITCH = 'ROLE_ALLOWED_TO_SWITCH';

}

