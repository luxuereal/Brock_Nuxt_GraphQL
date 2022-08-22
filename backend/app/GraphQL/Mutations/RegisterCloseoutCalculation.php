<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Gate;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class RegisterCloseoutCalculation
{
    public function __construct()
    {
        //
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        Gate::allowIf(fn($user) => !$user->isAdministrator());

        $lastClosedRegister = \App\Models\RegisterCloseout::where('period_id', $args['period_id'])
            ->where('unit_id', $args['unit_id'])
            ->where('register_id', $args['register_id'])
            ->orderBy('created_at', 'DESC')
            ->first();

        $fields = $args['fields'];

        $lastNonResettable = $lastClosedRegister ? $lastClosedRegister->non_resetable : 0;
        $totalToDistribute = $fields['non_resetable'];
        $netTotal = $totalToDistribute - $fields['tax_from_the_tape'];
        $netCash = $netTotal - $fields['net_o_v'] - $fields['net_charge'] - $fields['net_voucher'];
        $cashTax = $fields['tax_from_the_tape'] - $fields['overring_void_tax'] - $fields['charge_tax'] - $fields['voucher_tax'];
        $customerCountTotal = $fields['customer_count_breakfast'] + $fields['customer_count_lunch'] + $fields['customer_count_dinner'];
        $netSalesTotal = $fields['net_sales_breakfast'] + $fields['net_sales_lunch'] + $fields['net_sales_dinner'];

        $totalDailyDeposit = \App\Models\RegisterCloseout::where('period_id', $args['period_id'])
            ->where('unit_id', $args['unit_id'])
            ->sum('actual_cash_deposit');

        $totalNetSales = $totalToDistribute - $fields['tax_from_the_tape'] - $fields['net_o_v'] - $fields['net_voucher'];
        $charge = $fields['net_charge'];
        $cashTotal = $totalNetSales - $charge;
        $pettyCash = $fields['total_petty_cash'];
        $calculatedCashDeposit = $cashTotal + $cashTax - $pettyCash;
        $actualDeposit = $fields['actual_cash_deposit'];
        $overShort = $actualDeposit - $calculatedCashDeposit;

        return [
            'fields'     => [
                'net_total'               => number_format($netTotal, 2),
                'last_non_resettable'     => number_format($lastNonResettable, 2),
                'total_to_distribute'     => number_format($totalToDistribute, 2),
                'net_cash'                => number_format($netCash, 2),
                'cash_tax'                => number_format($cashTax, 2),
                'calculated_cash_deposit' => number_format($calculatedCashDeposit, 2),
                'over_short'              => number_format($overShort, 2),
                'customer_count_totals'   => number_format($customerCountTotal, 2),
                'net_sales_total'         => number_format($netSalesTotal, 2),
            ],
            'statistics' => [
                'total_daily_deposit' => number_format($totalDailyDeposit, 2),
                'total_net_sales'     => number_format($totalNetSales, 2),
                'charge'              => number_format($charge, 2),
                'cash_total'          => number_format($cashTotal, 2),
                'cash_tax'            => number_format($cashTax, 2),
                'petty_cash'          => number_format($pettyCash, 2),
                'calced_deposit'      => number_format($calculatedCashDeposit, 2),
                'actual_deposit'      => number_format($actualDeposit, 2),
                'over_short'          => number_format($overShort, 2),
            ],
        ];
    }
}
