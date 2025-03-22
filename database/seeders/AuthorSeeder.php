<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::create([
            'name' => 'فاطمة حيشية',
        ]);

        Author::create([
            'name' => 'عدي بشر',
        ]);

        Author::create([
            'name' => 'مصطفى محمود',
        ]);

        Author::create([
            'name' => 'محمد علي',
        ]);

        Author::create([
            'name' => 'علي علي',
        ]);

        Author::create([
            'name' => 'محمد احمد',
        ]);
    }
}
