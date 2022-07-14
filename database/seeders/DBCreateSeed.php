<?php

namespace Database\Seeders;

use App\Models\Session;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DBCreateSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // DB::statement('create database clearance');
        Session::create([
            "session_date" => date("Y") . "/" . (date("Y") + 1),
            "status" => 1,
        ]);
    }
}
