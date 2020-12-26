<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscription_Types;

class Subscription_Types_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $element = ['Package', 'Adds On'];

        foreach ($element as $el) {
            Subscription_Types::create([
                'name' => $el,
            ]);
        }
    }
}