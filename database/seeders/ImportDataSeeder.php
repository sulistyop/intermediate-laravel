<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sqlPath = storage_path('app/public/farmagitech.sql');
        $sql = file_get_contents($sqlPath);

        // Split the SQL statements using the semicolon as a delimiter
        $statements = explode(';', $sql);

        // Iterate through each statement and execute it
        foreach ($statements as $statement) {
            if (trim($statement) !== '') {
                \DB::statement($statement);
            }
        }
    }
}
