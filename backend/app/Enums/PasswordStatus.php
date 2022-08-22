<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use Illuminate\Support\Facades\Password;

final class PasswordStatus extends Enum
{
    const EMAIL_SENT = Password::RESET_LINK_SENT;

    const PASSWORD_RESET = Password::PASSWORD_RESET;
}
