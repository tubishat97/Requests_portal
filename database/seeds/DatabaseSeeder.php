<?php

use App\Models\Customer;
use App\Models\CustomerProfile;
use App\Models\User;
use App\Models\UserProfile;

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
        $faker = Faker\Factory::create();
        $faker->addProvider(new Xvladqt\Faker\LoremFlickrProvider($faker));

        #region User

        echo ("Seeding: User ...\n");
        factory(UserProfile::class, 1)->create();
        User::find(1)->update([
            'username' => 'admin@flighttracker.com',
        ]);

        #endregion

        #region Customer

        echo ("Seeding: Customer ...\n");
        factory(CustomerProfile::class, 1)->create();
        Customer::find(1)->update([
            'username' => 'customer@flighttracker.com',
        ]);

        #endregion
    }
}
