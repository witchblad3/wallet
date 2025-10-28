<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('accounts')->upsert([
            ['user_id' => 1, 'balance' => '1000.00', 'created_at'=>now(), 'updated_at'=>now()],
            ['user_id' => 2, 'balance' => '0.00',    'created_at'=>now(), 'updated_at'=>now()],
        ], ['user_id'], ['balance','updated_at']);
    }
}
