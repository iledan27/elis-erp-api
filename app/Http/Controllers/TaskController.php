<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/tasks/",
     *      operationId="index",
     *      tags={"Tasks"},
     *      description="Returns list of tasks",
     *      security={{"authbearer": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *             mediaType="application/json"
     *          )
     *      )
     * )
     */
    public function index()
    {
        return Task::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $task = Task::create($request->all());

        return response()->json([
            'message' => 'Great success! New task created',
            'task' => $task
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/tasks/{id}",
     *      operationId="show",
     *      tags={"Tasks"},
     *      description="Returns a tasks",
     *      security={{"authbearer": {}}},
     *      @OA\Parameter(
     *         description="ID of task to fetch",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *             mediaType="application/json"
     *          )
     *      )
     * )
     */
    public function show(Task $task)
    {
        return $task;
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
           'title'       => 'nullable',
           'description' => 'nullable'
        ]);

        $task->update($request->all());

        return response()->json([
            'message' => 'Great success! Task updated',
            'task' => $task
        ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Successfully deleted task!'
        ]);
    }
}
