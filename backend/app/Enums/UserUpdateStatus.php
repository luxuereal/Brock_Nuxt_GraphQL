<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserUpdateStatus extends Enum
{
    const UPDATED = 'updated';
    const ERROR = 'error';
}
