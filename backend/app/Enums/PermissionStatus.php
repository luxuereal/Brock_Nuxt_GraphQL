<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PermissionStatus extends Enum
{
    const ALLOWED = 1;
    const NOTALLOWED = 0;
}
