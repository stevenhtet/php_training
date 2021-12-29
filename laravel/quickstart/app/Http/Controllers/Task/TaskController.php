<?php

namespace App\Http\Controllers\Task;

use App\Contracts\Services\Task\TaskServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * task interface
     */
    private $taskInterface;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(TaskServiceInterface $taskServiceInterface)
    {
        $this->taskInterface = $taskServiceInterface;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $tasks = $this->taskInterface->getTaskList();

        return view('tasks', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Save the data into database
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('tasks.index')
                ->withInput()
                ->withErrors($validator);
        }

        $task = $this->taskInterface->saveTask($request);

        if ($task) {
            return redirect()
                ->route('tasks.index')
                ->with('success', 'Task created successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Task $task
     * @return Response
     */
    public function destroy(Task $task)
    {
        $result = $this->taskInterface->deleteTask($task);

        if ($result) {
            return redirect()
                ->route('tasks.index')
                ->with('success', 'Task deleted successfully.');
        }
    }
}