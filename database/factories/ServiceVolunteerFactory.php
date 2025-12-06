<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\ServiceSchedule;
use App\Models\ServiceVolunteer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceVolunteerFactory extends Factory
{
    protected $model = ServiceVolunteer::class;

    public function definition()
    {
        return [
            'service_schedule_id' => ServiceSchedule::factory(),
            'member_id' => 1, // Assuming member factory or id exists/will be overridden
            'role' => 'usher',
            'status' => 'assigned',
        ];
    }
}
