<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('employee_categories')->delete();
        
        DB::table('employee_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Técnico Superior',
                'description' => NULL,
                'created_at' => '2026-01-20 13:42:35',
                'updated_at' => '2026-01-20 13:42:35',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Técnico médio',
                'description' => NULL,
                'created_at' => '2026-01-20 13:42:48',
                'updated_at' => '2026-01-20 13:42:48',
            ),
        ));
        
        
    }
}