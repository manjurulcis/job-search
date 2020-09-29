<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;


class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i < 100; $i++) {
                DB::table('jobs')->insert([
                    'title' => Str::random(10),
                    'description' => Str::random(100),
                    'company' => Str::random(100),
                    'reference' => Hash::make(Str::random(10)),
                ]);
        }
    }
}
