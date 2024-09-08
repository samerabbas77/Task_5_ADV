<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Traits\ResponseTraint;
use App\Services\Api\TaskService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\AssignToRequest;
use App\Http\Requests\Task\IndexTaskRequest;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Requests\Task\DeletedTaskRequest;
use App\Http\Requests\Task\ChangStautusRequest;

class TaskController extends Controller
{
    use ResponseTraint;

    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }
    /**
     * fetching data wit filter on status or priority(optional)
     * @param \App\Http\Requests\Task\IndexTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexTaskRequest $request)
    {
       $validated =  $request->validated();
       $tasks = $this->taskService->getAllTasks($validated);

       return $this->succeesTrait($tasks,"Fetching data Successfully");
       
    }
    //.........................................................................
    //.........................................................................
    /**
     * Store a task (but not assigned to any one)(only admin)
     * @param \App\Http\Requests\Task\StoreTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTaskRequest $request)
    {
        $request->validated();
       
        $validated = $request->only(['title','description','priority','due_date','status','user_id']);
        
        $task = $this->taskService->storeTask($validated);

        return $this->succeesTrait($task,"Stroe Task Succefully");
    }
//................................................................................
//................................................................................
    /**
     * show all task of thr currnt user
     * @return mixed
     */
    public function show()
    {
        $tasks = $this->taskService->getUserTasks();
        if($tasks == null)
        {
            return $this->faildTrait("You dont have any tasks");
        }else{
            return $this->succeesTrait($tasks,"Fetching user tasks Susseccfully");
        }
    }
//.........................................................................................
//.........................................................................................
    /**
     * update the task info
     * @param \App\Http\Requests\Task\UpdateTaskRequest $request
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update( UpdateTaskRequest $request, Task $task)
    {
        $request->validated();
        $validated = $request->only(['status']); 
        
        $new = $this->taskService->updateTask($validated, $task);

        if($new == null)
        {
            return $this->faildTrait("You are Not allowed to Update (only assigned to(user) of the task");
        }else{
            return $this->succeesTrait($new,"Updating task successfully");
        }
    }

    //........................................................................................
    //........................................................................................
    /**
     * Assign a task to a user 
     * @param \App\Http\Requests\Task\AssignToRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignedTo(AssignToRequest $request,$id)
    {
        $request->validated();
       
        $validated = $request->only(['user_id']);
       
        $task = $this->taskService->assignedToService($validated,$id);

        return $this->succeesTrait($task,'Assigned task successfully');
    }
//..................................................................
//..................................................................
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( DeletedTaskRequest $request,$id)
    {
        $validated = $request->validated();
        $old = $this->taskService->deleteTaskService($validated,$id);

        if($validated['force_Delete'] == 1)
        { 
           return $this->succeesTrait($old,'Force Deleting task info successfully',200);
        }else{
           return $this->succeesTrait($old,'Soft Deleting task info successfully',200);
        }
    }
    //....................................................................................
    //....................................................................................


    public function restore($id)
    {      
            $task = $this->taskService->restoreTask($id);

            if($task == null)
            {
                return $this->faildTrait('There are no deleted record for this id');
            }else{
                return $this->succeesTrait($task,'Restore task account successfully',200);
            }      

    }

}
