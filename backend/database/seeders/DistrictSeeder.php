<?php

namespace Database\Seeders;

use App\Models\District;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        District::insert([
            ['code' => 'AB', 'name' => 'Andrew Brock', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'BD', 'name' => 'Bryan Davis', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'CC', 'name' => 'Cary Callahan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'CL', 'name' => 'Christopher LaFrance', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'CS', 'name' => 'Carl Scharle', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'CT', 'name' => 'Christine Trapaga', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'DG', 'name' => 'David Grant', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'DM', 'name' => 'David Manion', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'ER', 'name' => 'Eric Rappaport', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'GD', 'name' => 'Gerry Dodge', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'GG', 'name' => 'Gerry Guthridge', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'JB', 'name' => 'James Brant', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'Jba', 'name' => 'Joel Barrish', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'JM', 'name' => 'Jon Mabry', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'JMD', 'name' => 'James McDonnell', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'JT', 'name' => 'Jennifer Topper', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'KB', 'name' => 'Kevin Blake', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'KS', 'name' => 'Kilene Smith', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'LE', 'name' => 'Lynne Eddy', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'LS', 'name' => 'Larry Stelitano', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'MA', 'name' => 'Mark Anderson', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'NM', 'name' => 'Neil Mulhearn', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'RD', 'name' => 'Reinier Daams', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'RG', 'name' => 'Richard Galing', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'RJ', 'name' => 'Regina Jakacki', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'SD', 'name' => 'Sharon DeFelices', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'SG', 'name' => 'Scott Greenley', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'SH', 'name' => 'Sheryl Humphrey', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'TF', 'name' => 'Ted Fekete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'TK', 'name' => 'Tod Kalkstein', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'TL', 'name' => 'Tim Loadman', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'TS', 'name' => 'Tony Stokke', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
