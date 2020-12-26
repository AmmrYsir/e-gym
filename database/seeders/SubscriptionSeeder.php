<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $element = [
            ['Pro Membership', 'Pro member could receive many benefit such as statistic', 1, ["1 Month | RM60"], 1, 0, 1],
            ['Pro Plus Membership', 'Pro member could receive many benefit such as statistic', 1, ["1 Month | RM80"], 1, 0, 1],
            ['Gym Trainer', 'Gym Trainer that could help you with tips and teach', 2, ["1 Month | RM35", "2 Month | RM70"], 0, 0, 0],
            ['Food & Drink Refill', 'Unlimited utilities for water and food sources', 2, ["1 Month | RM15"], 0, 0, 0],
            ['Gym Insurance', 'Gym Insurance will cover your misfortune injury', 2, ["1 Month | RM30"], 0, 0, 0],
            ['Premium Gym Trainer', 'Specialized Gym Trainer that could help you more than normal Gym Trainer', 2, ["1 Month | RM45"], 0, 0, 0]
        ];

        foreach ($element as $el) {
            Subscription::create([
                'name' =>  $el[0],
                'desc' => $el[1],
                'type' => $el[2],
                'duration' => $el[3],
                'trial_able' => $el[4],
                'parent_id' =>  $el[5],
                'trial_duration_in_weeks' => $el[6],
            ]);
        }
    }
}