<?php

namespace Database\Factories;

use App\Models\ServiceSchedule;
use App\Models\WorshipPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorshipPlanFactory extends Factory
{
    protected $model = WorshipPlan::class;

    public function definition()
    {
        return [
            'service_schedule_id' => ServiceSchedule::factory(),
            'order_number' => 1,
            'item_type' => 'worship_song',
            'title' => 'Amazing Grace',
            'duration_minutes' => 5,
        ];
    }
}
