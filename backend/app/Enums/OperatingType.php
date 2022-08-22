<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OperatingType extends Enum
{
    const OPERATING = 'operating';
    const COMPLETE = 'complete';
    const CATERING = 'catering';
    const CATERING_STATISTICS = 'catering-statistics';
    const INVENTORY = 'inventory';
    const PURCHASE = 'purchase';
    const CLOSEOUT = 'closeout';
    const EXPENSE = 'expense';
    const LABOR = 'labor';
}
