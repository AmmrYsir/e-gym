<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Subscription;

class SubscriptionForm extends Component
{
    public $packages;
    public $addOns;

    public $selectedPackage;
    public $selectedPackageDuration;
    public $selectedAddOns = array();
    public $selectedAddOnsDuration;

    public $count = 0;

    public function render()
    {
        return view('livewire.subscription-form');
    }
}