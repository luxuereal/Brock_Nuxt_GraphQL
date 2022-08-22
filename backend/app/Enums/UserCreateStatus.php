<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserCreateStatus extends Enum
{
    const CREATED = 'created';
    const ERROR = 'error';
}
