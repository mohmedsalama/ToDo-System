<?php

namespace App\Services;

use App\Models\Todo;
use App\Repositories\Contracts\TodoRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class TodoService
{
    /**
     * Inject the TodoRepositoryInterface.
     * We depend on the abstraction, not the concrete implementation.
     */
    public function __construct(
        protected TodoRepositoryInterface $todoRepository
    ) {}

    /**
     * Get paginated todos for a specific user.
     * 
     * @param int $userId
     * @param int $perPage
     * @param array<string, mixed> $filters
     * @return LengthAwarePaginator<Todo>
     */
    public function getTodosForUser(int $userId, int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        // Business Rule: A user can only retrieve their own Todos.
        $filters['user_id'] = $userId;
        
        return $this->todoRepository->paginate($perPage, $filters);
    }

    /**
     * Find a specific todo and verify ownership.
     *
     * @param int $userId
     * @param int $todoId
     * @return Todo
     */
    public function getTodoForUser(int $userId, int $todoId): Todo
    {
        $todo = $this->todoRepository->findById($todoId);

        // Business Rule: Ensure the Todo exists.
        if (! $todo) {
            abort(404, 'Todo not found.');
        }

        return $todo;
    }

    /**
     * Create a new todo associated with the user.
     *
     * @param int $userId
     * @param array<string, mixed> $data
     * @return Todo
     */
    public function createTodo(int $userId, array $data): Todo
    {
        // Business Rule: Forcibly assign the todo to the currently authenticated user
        $data['user_id'] = $userId;
        
        return $this->todoRepository->create($data);
    }

    /**
     * Update an existing todo after verifying ownership.
     *
     * @param int $userId
     * @param int $todoId
     * @param array<string, mixed> $data
     * @return bool
     */
    public function updateTodo(int $userId, int $todoId, array $data): bool
    {
        // Fetching it automatically enforces the ownership rule
        $this->getTodoForUser($userId, $todoId);

        return $this->todoRepository->update($todoId, $data);
    }

    /**
     * Delete a todo after verifying ownership.
     *
     * @param int $userId
     * @param int $todoId
     * @return bool
     */
    public function deleteTodo(int $userId, int $todoId): bool
    {
        // Fetching it automatically enforces the ownership rule
        $this->getTodoForUser($userId, $todoId);

        return $this->todoRepository->delete($todoId);
    }
}
