<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Watchlist;
use App\Models\User;
use App\Models\Film;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Watchlist::truncate();
        User::truncate();
        Film::truncate();

        $user = User::factory(10)->create();
        $wlist1 = Watchlist::create(['naziv_zanra' => "Akcija"]);
        $wlist2 = Watchlist::create(['naziv_zanra' => "Komedija"]);
        $wlist3 = Watchlist::create(['naziv_zanra' => "Fantastika"]);







}
}
