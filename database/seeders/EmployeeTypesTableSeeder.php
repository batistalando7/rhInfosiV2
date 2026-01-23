<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('employee_types')->delete();

        DB::table('employee_types')->insert(array(
            0 =>
            array(
                'id' => 1,
                'name' => 'Contratado',
                'description' => NULL,
                'paymentDelayDays' => 0,
                'created_at' => '2026-01-20 13:42:10',
                'updated_at' => '2026-01-20 13:42:10',
            ),
            1 =>
            array(
                'id' => 2,
                'name' => 'Efectivo',
                'description' => NULL,
                'paymentDelayDays' => 0,
                'created_at' => '2026-01-20 13:42:18',
                'updated_at' => '2026-01-20 13:42:18',
            ),
        ));
    }
}
