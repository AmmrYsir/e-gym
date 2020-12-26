<?php

namespace App\Http\Livewire;

use Illuminate\Auth\Events\Validated;
use Livewire\Component;

use App\Models\Subscription;

class SubscriptionMemberFormEdit extends Component
{
    public $subscription;
    public $subscriptions;
    public $subscription_types;

    public $name;
    public $desc;
    public $type;
    public $trial_able = 0;
    public $durations;
    public $parent;
    public $trial_duration_in_weeks;
    public $count = 0;
    public $user_id;

    // For duration
    public $duration_value = 1;
    public $duration_type = 'Week';
    public $duration_price;

    protected $rules = [
        'duration_value' => 'required|integer',
        'duration_type' => 'required|string',
        'duration_price' => 'required|integer',
    ];

    public function mount($subscription, $id)
    {
        $this->subscriptions = Subscription::where('type', 1)->get();

        $this->user_id = $id;
        $this->name = $subscription->name;
        $this->desc = $subscription->desc;
        $this->type = $subscription->type;
        $this->trial_able = $subscription->trial_able;
        $this->durations = $subscription->duration;
        $this->parent = $subscription->parent_id;
        $this->trial_duration_in_weeks = $subscription->trial_duration_in_weeks;
        $this->count = count($subscription->duration) - 1;
    }

    public function render()
    {
        return view('livewire.subscription-member-form-edit');
    }

    public function addNewDuration()
    {
        $this->validate();

        array_push($this->durations, $this->duration_value . ' ' . $this->duration_type . ' | RM' . $this->duration_price);
        $this->count++;
    }

    public function removeSelectedDuration($count)
    {
        unset($this->durations[$count]);
    }
}