<?php
use App\Models\Todo;

// Get all todos
test('user can get list of todo', function () {
    // Create a Todo instance
    $todo = Todo::factory()->create();

    // Send a GET request to fetch the Todo list
    $response = $this->get('/api/v1/todo');

    // Assert the status code and the correct structure of the response
    $response->assertStatus(200)->assertJson([
        'status' => true,
        'message' => 'Todo List',
        'data' => [
            [
                'id' => $todo->id,
                'title' => $todo->title,
                'due_date' => $todo->due_date,
                'status_check' => 0,
            ]
        ]
    ]);
});

// Get todo by id
test('user can get a todo', function() {
    // Create a new Todo instance using the factory
    $todo = Todo::factory()->create();
    // Send a GET request to fetch the specific Todo by its ID
    $response = $this->getJson('/api/v1/todo/'. $todo->id);
    // Assert the response status is 200 (OK)
    $response->assertStatus(200)->assertJson([
        'data' => [
            'id' => $todo->id,
            'title' => $todo->title,
            'due_date' => $todo->due_date,
            'status_check' => $todo->status_check,
        ]
    ]);
});

// Create todo
test('user can create a new todo', function() {
    // Generate raw data from factory
    $data = Todo::factory()->raw([
        'due_date' => now()->format('Y-m-d'),
    ]);
    // Make a POST request and assert the response status
    $response = $this->postJson('/api/v1/todo', $data);
    $response->assertStatus(201)
             ->assertJson([
                 'status' => true,
                 'message' => 'Todo created successfully!',
                 'data' => [
                     'title' => $data['title'],
                     'due_date' => $data['due_date'],
                 ],
             ]);
    // Assert the todo is saved in the database
    $this->assertDatabaseCount('todos', 1);
    $this->assertDatabaseHas('todos', [
        'title' => $data['title'],
        'due_date' => $data['due_date'],
    ]);
});

// Update todo
test('user can update a todo', function () {
    // Create a Todo using the factory
    $todo = Todo::factory()->create();

    // Generate raw data from factory
    $data = Todo::factory()->raw([
        'due_date' => now()->format('Y-m-d'),
    ]);

    // Send PUT request to update the Todo
    $response = $this->putJson('/api/v1/todo/' . $todo->id, $data);

    // Assert the response status and structure
    $response->assertStatus(200)
             ->assertJson([
                 'status' => true,
                 'message' => 'Todo updated successfully',
                 'data' => [
                     'id' => $todo->id,
                     'title' => $data['title'],
                     'due_date' => $data['due_date'],
                 ],
             ]);

    // Assert the database has the updated Todo data
    $this->assertDatabaseHas('todos', [
        'id' => $todo->id,
        'title' => $data['title'],
        'due_date' => $data['due_date'],
    ]);
});

// Delete todo
test('user can delete a todo', function() {
    // Create a Todo using the factory
    $todo = Todo::factory()->create();

    // Send DELETE request to delete the specific Todo by its ID
    $response = $this->deleteJson('/api/v1/todo/' . $todo->id);

    // Assert the response status is 200 (OK)
    $response->assertStatus(200);

    // Assert the response JSON has the expected message
    $response->assertJson([
        'status' => true,
        'message' => 'Todo deleted successfully',
    ]);

    // Assert that the Todo record no longer exists in the database
    $this->assertDatabaseMissing('todos', [
        'id' => $todo->id,
    ]);
});

