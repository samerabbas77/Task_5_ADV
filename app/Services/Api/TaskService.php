<?php
namespace App\Services\Api;

use Exception;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Traits\ResponseTraint;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    use ResponseTraint;
    /**
     * fetching data wit filter on status or priority(optional)
     * @param mixed $validated
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getAllTasks($validated)
    {
        try {
            $tasks = Task::query();
            if(isset($validated["priority"]))
            {
                $tasks->where("priority", $validated["priority"]);
            }
    
            if(isset($validated["status"]))
            {
                $tasks->where("status", $validated["status"]);
            }

            $tasks->orderBy("created_at","desc");
    
            return TaskResource::collection($tasks->get());
        } catch (Exception $e) {
            throw new Exception('Somthing went rong : '.$e->getMessage()) ;        }
    }
 //...........................................................................................................
 //...............................................................................................................
        /**
         * Store a task (but not assigned to any one)(only admin)
         * @param mixed $validated
         * @return TaskResource|\Illuminate\Http\JsonResponse
         */
        public function storeTask($validated)
        {
            try {
                $task = Task::create([
                    'title'       => $validated['title'],
                    'description' => $validated['description'],
                    'priority'    => $validated['priority'],
                    'due_date'    => Carbon::parse($validated['due_date'])->format('d-m-Y H:i'),
                    'status'      => $validated['status'],
                ]);              
                $task->assigned_to =  $validated['user_id'];
                $task->save();
                
                return new TaskResource($task);
            } catch (Exception $e) {
                throw new Exception('Somthing went rong : '.$e->getMessage()) ;            }
        }

//................................................................................................................
 //................................................................................................................
        /**
         *  get all tasks of the currnt user
         * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|null
         */
        public function getUserTasks()
        {
            try {
                    $tasks =Task::where('assigned_to',Auth::id())->orderBy('created_at','desc')->get();
                   
                    if($tasks->isEmpty())
                    {
                        return null;
                    }else{
                        
                        return  TaskResource::collection($tasks);
                    }
                    
            } catch (Exception $e) {
                throw new Exception('Somthing went rong : '.$e->getMessage()) ;            }
        }

 //..........................................................................................................
 //......................................................................................................................
     
        /**
         * Update the task info(only admins)
         * @param mixed $vaidated
         * @param mixed $task
         * @return TaskResource|\Illuminate\Http\JsonResponse|null
         */
        public function updateTask($validated, $task)
        {
           
            try {
                if(Auth::id() == $task->assigned_to)
                {     
                    if($validated['status']!=null) $task->status = $validated['status'];
                    
                    return new TaskResource($task);
                }else{
                    return null;
                }
            } catch (Exception $e) {
                throw new Exception('Somthing went rong : '.$e->getMessage()) ;            }
        }

 //........................................................................................................
 //........................................................................................................
        /**
         * assign a task to a user
         * @param mixed $validated
         * @param mixed $id
         * @return TaskResource|\Illuminate\Http\JsonResponse
         */
        public function assignedToService($validated,$id)
        {
            try {
                $task = Task::findOrFail($id);

                //user_id is the value i created in the request(passedValidation) by  a querry from the name that send by the request
                $task->assigned_to = $validated['user_id'];
                $task->save();
                return new TaskResource($task); 

            } catch (Exception $e) {
                throw new Exception('Somthing went rong : '.$e->getMessage()) ;            }
        }
 //.........................................................................................................
 //.........................................................................................................
        
 
 /**
         * Delete task softly of force delete the task
         * @param mixed $validated
         * @param mixed $id
         * @throws \Exception
         * @return TaskResource
         */
        public function deleteTaskService($validated,$id)
        {
            try {             
                if( ($validated['force_Delete'] == null) || ($validated['force_Delete'] == 0))
                {
                    $old = Task::findOrFail($id);
                    $old->delete();
                    return new TaskResource($old); 
                }else{
                    $old = Task::withTrashed()->findOrFail($id);
                    $old->forceDelete();
                    return new TaskResource($old);
                }
            } catch (Exception $e) {
                throw new Exception('Somthing went rong : '.$e->getMessage()) ;
            }
        }
//.......................................................................................................
//.......................................................................................................

      
        public function restoreTask($id)
        {
            try {
                $task = Task::withTrashed()->findOrFail($id);
                if($task->deleted_at === null)
                {
                    return null;
                }else{
                    $task->restore();
                    return new TaskResource($task);
                }
    
            } catch (Exception $e) {
                throw new Exception('Somthing went rong : '.$e->getMessage()) ;
           }
        }

}