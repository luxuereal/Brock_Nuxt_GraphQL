<?php

namespace Database\Seeders;

use App\Models\County;
use Illuminate\Database\Seeder;

class CountySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $counties = [
            ['name' => 'Albemarle', 'state' => 'VA', 'tax' => '0'],
            ['name' => 'Allentown', 'state' => 'PA', 'tax' => '0'],
            ['name' => 'Arapahoe', 'state' => 'CO', 'tax' => '0'],
            ['name' => 'Baltimore', 'state' => 'MD', 'tax' => '0'],
            ['name' => 'Bergen', 'state' => 'NJ', 'tax' => '0'],
            ['name' => 'Berks', 'state' => 'PA', 'tax' => '0'],
            ['name' => 'Brookline', 'state' => 'MA', 'tax' => '0'],
            ['name' => 'Bucks', 'state' => 'PA', 'tax' => '0'],
            ['name' => 'Calvert', 'state' => 'MD', 'tax' => '0'],
            ['name' => 'Camden', 'state' => 'NJ', 'tax' => '0'],
            ['name' => 'Cecil', 'state' => 'MD', 'tax' => '0'],
            ['name' => 'Chester', 'state' => 'PA', 'tax' => '0'],
            ['name' => 'College Park', 'state' => 'MD', 'tax' => '0'],
            ['name' => 'Colorado Springs', 'state' => 'CO', 'tax' => '0'],
            ['name' => 'Delaware', 'state' => 'PA', 'tax' => '0'],
            ['name' => 'Denver', 'state' => 'CO', 'tax' => '0'],
            ['name' => 'Douglas', 'state' => 'CO', 'tax' => '0'],
            ['name' => 'Durham', 'state' => 'NC', 'tax' => '0'],
            ['name' => 'Dutchess County', 'state' => 'NY', 'tax' => '0'],
            ['name' => 'El Paso', 'state' => 'CO', 'tax' => '0'],
            ['name' => 'Fairfax', 'state' => 'VA', 'tax' => '0'],
            ['name' => 'Fairfield County', 'state' => 'CT', 'tax' => '0'],
            ['name' => 'Farmington', 'state' => 'CT', 'tax' => '0'],
            ['name' => 'Foo', 'state' => 'DC', 'tax' => '0'],
            ['name' => 'Harrisburg', 'state' => 'PA', 'tax' => '0'],
            ['name' => 'Howard', 'state' => 'MD', 'tax' => '0'],
            ['name' => 'Indiana', 'state' => 'PA', 'tax' => '0'],
            ['name' => 'Jefferson', 'state' => 'CO', 'tax' => '0.005'],
            ['name' => 'Kent', 'state' => 'DE', 'tax' => '0'],
            ['name' => 'Lehigh County', 'state' => 'PA', 'tax' => '0'],
            ['name' => 'Lyndon Center', 'state' => 'VT', 'tax' => '0'],
            ['name' => 'Mercer', 'state' => 'NJ', 'tax' => '0'],
            ['name' => 'Middlesex', 'state' => 'NJ', 'tax' => '0'],
            ['name' => 'Middlesex County', 'state' => 'MA', 'tax' => '0'],
            ['name' => 'Montgomery', 'state' => 'MD', 'tax' => '0'],
            ['name' => 'Montgomery', 'state' => 'PA', 'tax' => '0'],
            ['name' => 'Morris', 'state' => 'NJ', 'tax' => '0'],
            ['name' => 'Natick', 'state' => 'MA', 'tax' => '0'],
            ['name' => 'New Castle', 'state' => 'DE', 'tax' => '0'],
            ['name' => 'New Lebanon', 'state' => 'NY', 'tax' => '0'],
            ['name' => 'New York', 'state' => 'NY', 'tax' => '0'],
            ['name' => 'North Hampton', 'state' => 'PA', 'tax' => '0'],
            ['name' => 'Onondaga', 'state' => 'NY', 'tax' => '0'],
            ['name' => 'Parsippany Troy Hill', 'state' => 'NJ', 'tax' => '0'],
            ['name' => 'Philadelphia', 'state' => 'PA', 'tax' => '0'],
            ['name' => 'Pomfret Center', 'state' => 'CT', 'tax' => '0'],
            ['name' => 'Providence', 'state' => 'RI', 'tax' => '0'],
            ['name' => 'Raleigh', 'state' => 'NC', 'tax' => '0'],
            ['name' => 'Research Triangle', 'state' => 'NC', 'tax' => '0'],
            ['name' => 'Somerset', 'state' => 'NJ', 'tax' => '0'],
            ['name' => 'Springfied', 'state' => 'VA', 'tax' => '0'],
            ['name' => 'Suffolk County', 'state' => 'NY', 'tax' => '0'],
            ['name' => 'Sussex', 'state' => 'DE', 'tax' => '0'],
            ['name' => 'Wake County', 'state' => 'NC', 'tax' => '0.01'],
            ['name' => 'Warren Township', 'state' => 'NJ', 'tax' => '0'],
            ['name' => 'Washington', 'state' => 'DC', 'tax' => '0'],
            ['name' => 'Westchester County', 'state' => 'NY', 'tax' => '0'],
            ['name' => 'Worcester County', 'state' => 'MA', 'tax' => '0'],
            ['name' => 'York', 'state' => 'PA', 'tax' => '0'],
        ];

        foreach ($counties as $county)
            County::create([
                'name'     => $county['name'],
                'state_id' => \App\Models\State::where('code', $county['state'])->first()->id,
                'tax'      => $county['tax'],
            ]);
    }
}
