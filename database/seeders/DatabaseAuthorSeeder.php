<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::Create([
            'id' => Str::uuid(),
            'first_name' => 'Akmal Rahmattullah',
            'last_name' => 'Nugraha',
        ]);

        Author::Create([
            'id' => Str::uuid(),
            'first_name' => 'Fajar Nur Soleh',
            'last_name' => 'Wibawa',
        ]);
    }
}
