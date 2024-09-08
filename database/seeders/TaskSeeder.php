<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taskes =[
                    [
                        'title'           => 'task1',
                        'description'   => 'hard task',
                        'priority'   => 1,
                        'due_date'   =>'10-09-2024 15:30',
                        'status'   => false,
                        'assigned_to'  => 1

                    ],
                    [   'title'           => 'task2',
                        'description'   => 'easy task',
                        'priority'   => 5,
                        'due_date'   => '10-09-2024 15:30',
                        'status'   => false,
                        'assigned_to'  => 2
                    ],
                    [
                        'title'           => 'task1',
                        'description'   => 'hard task',
                        'priority'   => 1,
                        'due_date'   => '10-09-2024 15:30',
                        'status'   => true,
                        'assigned_to'  =>1
                    ],
                    [   'title'           => 'task2',
                        'description'   => 'easy task',
                        'priority'   => 5,
                        'due_date'   => '10-09-2024 15:30',
                        'status'   => true,
                        'assigned_to'  =>1
                    ],
                ];
                foreach ($taskes as $task)
                 {
                    Task::create($task);
                }

    }
}
