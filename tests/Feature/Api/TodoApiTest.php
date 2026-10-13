<?php

namespace Tests\Feature\Api;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the index endpoint retrieves a paginated list of todos.
     */
    public function test_it_can_list_all_todos(): void
    {
        // Arrange: Create 3 todos
        Todo::factory()->count(3)->create();

        // Act: Make a GET request to the index endpoint
        $response = $this->getJson('/api/todos');

        // Assert: Verify the response structure and status code
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => [
                         'data' => [
                             '*' => ['id', 'title', 'description', 'is_completed', 'due_date']
                         ]
                     ]
                 ]);
    }

    /**
     * Test the store endpoint successfully creates a new todo.
     */
    public function test_it_can_create_a_todo(): void
    {
        // Arrange: Define payload data
        $payload = [
            'title' => 'Learn Laravel Testing',
            'description' => 'Write awesome tests for the API.',
            'due_date' => now()->addDays(5)->format('Y-m-d'),
        ];

        // Act: Make a POST request to create the todo
        $response = $this->postJson('/api/todos', $payload);

        // Assert: Verify creation and database insertion
        $response->assertStatus(201)
                 ->assertJsonPath('data.title', 'Learn Laravel Testing')
                 ->assertJsonPath('success', true);

        $this->assertDatabaseHas('todos', [
            'title' => 'Learn Laravel Testing',
        ]);
    }

    /**
     * Test validation rules when creating a todo.
     */
    public function test_it_validates_required_fields_when_creating_todo(): void
    {
        // Arrange: Empty payload missing the required 'title'
        $payload = [
            'description' => 'This should fail validation.',
        ];

        // Act: Make the POST request
        $response = $this->postJson('/api/todos', $payload);

        // Assert: Verify validation error for 'title'
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title']);
    }

    /**
     * Test the show endpoint retrieves a specific todo.
     */
    public function test_it_can_show_a_todo(): void
    {
        // Arrange: Create a single todo
        $todo = Todo::factory()->create();

        // Act: Make a GET request to the specific resource
        $response = $this->getJson("/api/todos/{$todo->id}");

        // Assert: Verify the returned data matches
        $response->assertStatus(200)
                 ->assertJsonPath('data.id', $todo->id)
                 ->assertJsonPath('data.title', $todo->title);
    }

    /**
     * Test the update endpoint modifies an existing todo.
     */
    public function test_it_can_update_a_todo(): void
    {
        // Arrange: Create a todo
        $todo = Todo::factory()->create([
            'title' => 'Old Title',
            'is_completed' => false,
        ]);

        $payload = [
            'title' => 'New Awesome Title',
            'is_completed' => true,
        ];

        // Act: Make a PUT request to update it
        $response = $this->putJson("/api/todos/{$todo->id}", $payload);

        // Assert: Verify the response and database changes
        $response->assertStatus(200)
                 ->assertJsonPath('data.title', 'New Awesome Title')
                 ->assertJsonPath('data.is_completed', true);

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'title' => 'New Awesome Title',
            'is_completed' => 1,
        ]);
    }

    /**
     * Test the destroy endpoint soft-deletes a todo.
     */
    public function test_it_can_delete_a_todo(): void
    {
        // Arrange: Create a todo
        $todo = Todo::factory()->create();

        // Act: Make a DELETE request
        $response = $this->deleteJson("/api/todos/{$todo->id}");

        // Assert: Verify successful response and soft deletion in DB
        $response->assertStatus(200)
                 ->assertJsonPath('success', true);

        $this->assertSoftDeleted('todos', [
            'id' => $todo->id,
        ]);
    }
}
