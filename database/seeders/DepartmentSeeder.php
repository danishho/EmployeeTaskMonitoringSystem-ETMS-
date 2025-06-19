<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            ['id' => 'JPA', 'name' => 'Jabatan Pengajian Am'],
            ['id' => 'JPP', 'name' => 'Jabatan Pengurusan Perniagaan'],
            ['id' => 'JE', 'name' => 'Jabatan English'],
            ['id' => 'JSQ', 'name' => 'Jabatan Sains Quantitative'],
        ]);
    }
}
