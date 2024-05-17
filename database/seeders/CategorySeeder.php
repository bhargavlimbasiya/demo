<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = [['name' => 'category one', 'description' => 'category one description','status'=>1],
        ['name' => 'category one', 'description' => 'category one description','status'=>1]];
        Category::upsert($category, 'name');
    }
}
