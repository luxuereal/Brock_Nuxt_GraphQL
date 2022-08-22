<?php

namespace Database\Seeders;

use App\Models\Term;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Term::insert([
            ['name' => '39 days', 'due_days' => '39', 'disc_percent' => '0', 'disc_days' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'upon receipt', 'due_days' => '1', 'disc_percent' => '0', 'disc_days' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '2% upon receipt', 'due_days' => '39', 'disc_percent' => '0.02', 'disc_days' => '39', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '2% net', 'due_days' => '39', 'disc_percent' => '0.02', 'disc_days' => '39', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '15 days', 'due_days' => '15', 'disc_percent' => '0', 'disc_days' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '24 days', 'due_days' => '24', 'disc_percent' => '0', 'disc_days' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '21 days', 'due_days' => '21', 'disc_percent' => '0', 'disc_days' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '30 days', 'due_days' => '30', 'disc_percent' => '0', 'disc_days' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '1% upon receipt', 'due_days' => '39', 'disc_percent' => '0.01', 'disc_days' => '39', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => '10 days', 'due_days' => '10', 'disc_percent' => '0', 'disc_days' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
