<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\ExpenseType;

class ExpenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExpenseType::insert([
            ['type' => 'Accrual', 'description' => 'New Accrual', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'AdminFee', 'description' => 'Administrative Fee', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'Benefits', 'description' => 'Benefits', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'Commission', 'description' => 'Commission', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'CreditSlip', 'description' => 'Credit Slip', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'Fixed', 'description' => 'Fixed Expense', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'GrossRec', 'description' => 'Gross Receipts Tax', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'Insurance', 'description' => 'Business Insurance', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'ManageFee', 'description' => 'Management Fee', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'OnCall', 'description' => 'On Call Labor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'Other', 'description' => 'Other', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'Payroll', 'description' => 'Payroll/Labor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'PayrollAdj', 'description' => 'Payroll Adjustment', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'PettyCash', 'description' => 'Petty Cash', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'ReAccrual', 'description' => 'Re-Accrual', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'Receipt', 'description' => 'Misc. Receipt', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'Reversal', 'description' => 'Reversal of Accrual', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'ShipTicket', 'description' => 'Shipping Ticket', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['type' => 'VendIncome', 'description' => 'Vending Income', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
