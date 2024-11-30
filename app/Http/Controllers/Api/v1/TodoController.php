<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Http\Requests\CreateTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use Carbon\Carbon;
use App\Traits\ApiResponse;

class TodoController extends Controller
{
    // Using the ApiResponse trait for standardizing responses
    use ApiResponse;

    // Get a list of all todos, ordered by ID in descending order.
    public function list()
    {
        $todos = Todo::orderBy("id", "desc")->get();
        return $this->success(TodoResource::collection($todos), 'Todo List');
    }

    // Show a specific todo by its ID.
    public function show($id) {
        $todo = $this->checkTodoId($id);
        if (!$todo){
            return $this->error(null, 'Todo not found', 404);
        }
        return $this->success(new TodoResource($todo), 'Todo retrieved successfully');
    }

    // Create a new todo item.
    public function create(CreateTodoRequest $request)
    {
        $validatedData = $request->validated();
        if ($request->has('due_date')) {
            $due_date_input = $request->input('due_date');
            $formats = ['d-m-Y', 'Y-m-d', 'm/d/Y'];

            foreach ($formats as $format) {
                try {
                    $due_date = \Carbon\Carbon::createFromFormat($format, $due_date_input)->toDateString();
                    break;
                } catch (\Exception $e) {
                    // Continue trying other formats
                }
            }

            $validatedData['due_date'] = $due_date;
        }

        // Create the todo item
        $todo = Todo::create($validatedData);

        return $this->success(new TodoResource($todo), 'Todo created successfully!', 201);
    }

    // Check if the Todo with the specified ID exists.
    public function checkTodoId($id)
    {
        return Todo::find($id);
    }

    // Update an existing todo item.
    public function update(UpdateTodoRequest $request, $id)
    {
        $todo = $this->checkTodoId($id);
        if (!$todo) {
            return $this->error(null, 'Todo not found', 404);
        }

        $validatedData = $request->validated();

        if ($request->has('due_date')) {
            $due_date_input = $request->input('due_date');
            $formats = ['d-m-Y', 'Y-m-d', 'm/d/Y'];

            $due_date = null;
            foreach ($formats as $format) {
                try {
                    $due_date = \Carbon\Carbon::createFromFormat($format, $due_date_input)->toDateString();
                    break;
                } catch (\Exception $e) {
                    // Continue to the next format
                }
            }

            if (!$due_date) {
                return $this->error(null, 'Invalid date format', 400);
            }

            $validatedData['due_date'] = $due_date;
        } else {
            // Use the old value if due_date is not provided
            $validatedData['due_date'] = $todo->due_date;
        }

        // Update the todo
        $updated = $todo->update($validatedData);

        if ($updated) {
            return $this->success(new TodoResource($todo), 'Todo updated successfully', 200);
        }

        return $this->error(null, 'Failed to update', 500);
    }

    // Delete a specific todo item by ID.
    public function destroy($id, Request $request)
    {
        $todo = $this->checkTodoId($id);
        if (!$todo){
            return $this->error(null, 'Todo not found', 404);
        }
        $todo->delete();
        return $this->success(new TodoResource($todo), 'Todo deleted successfully', 200);
    }
}
