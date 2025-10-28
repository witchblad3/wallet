<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create(['id' => 1, 'name' => 'Alice']);
        User::factory()->create(['id' => 2, 'name' => 'Bob']);
    }
}
