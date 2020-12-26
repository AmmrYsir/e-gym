<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Subscription;
use App\Models\User_Subscription;

class SubscriptionMemberForm extends Component
{
    public $subscription;
    public $packages;
    public $addons;
    public $count = 0;
    public $user_id;
    public $package_select;
    public $addon_select = array();

    public function mount($id)
    {
        $this->packages = User_Subscription::whereHas('subscription', function ($q) {
            return $q->where('type', 1);
        })->where('user_id', $id)->get();

        $this->addons = User_Subscription::whereHas('subscription', function ($q) {
            return $q->where('type', 2);
        })->where('user_id', $id)->get();

        $this->subscription = Subscription::all();

        $this->user_id = $id;
    }

    public function render()
    {
        return view('livewire.subscription-member-form');
    }
}