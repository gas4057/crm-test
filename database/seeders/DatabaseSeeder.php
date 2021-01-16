<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(3)->create();
        \App\Models\Company::factory(12000)->create();

        \App\Models\Client::factory(12000)->create();
        $company = \App\Models\Company::all();

        \App\Models\Client::all()->each(function ($client) use ($company) {
            $client->company()->attach(
                $company->random(rand(1, 2))->pluck('id')->toArray()
            );
        });
    }
}
