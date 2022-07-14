<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DBSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Admin::create([
            "loginID" => "clearanceadmin",
            "password" => Hash::make('clear@2022passkey'),
            "token" => substr(sha1("passkey"), 12, 10)
        ]);
    }
}
