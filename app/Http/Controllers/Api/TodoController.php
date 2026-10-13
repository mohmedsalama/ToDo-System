<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\StoreTodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Services\TodoService;
use Illuminate\Http\JsonResponse;
use Exception;

class TodoController extends Controller
{
    public function __construct(
        protected TodoService $todoService
    ) {}

    /**
     * Helper to return consistent JSON responses.
     */
    protected function jsonResponse(bool $success, string $message, mixed $data = null, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            // Retrieve current authenticated user ID, or fallback to 1 for testing purposes
            $userId = auth()->id() ?? 1; 
            
            $todos = $this->todoService->getTodosForUser($userId);

            // getData(true) ensures pagination meta/links are included in the 'data' key
            return $this->jsonResponse(
                true,
                'Todos retrieved successfully.',
                TodoResource::collection($todos)->response()->getData(true)
            );
        } catch (Exception $e) {
            return $this->jsonResponse(false, 'Failed to retrieve todos: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request): JsonResponse
    {
        try {
            $userId = auth()->id() ?? 1;
            
            $todo = $this->todoService->createTodo($userId, $request->validated());

            return $this->jsonResponse(
                true,
                'Todo created successfully.',
                new TodoResource($todo),
                201
            );
        } catch (Exception $e) {
            return $this->jsonResponse(false, 'Failed to create todo: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $userId = auth()->id() ?? 1;
            
            $todo = $this->todoService->getTodoForUser($userId, $id);

            return $this->jsonResponse(
                true,
                'Todo retrieved successfully.',
                new TodoResource($todo)
            );
        } catch (Exception $e) {
            // Using 404 status code if not found or unauthorized
            return $this->jsonResponse(false, 'Failed to retrieve todo: ' . $e->getMessage(), null, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, int $id): JsonResponse
    {
        try {
            $userId = auth()->id() ?? 1;
            
            $this->todoService->updateTodo($userId, $id, $request->validated());
            
            // Retrieve the updated instance to return it
            $todo = $this->todoService->getTodoForUser($userId, $id);

            return $this->jsonResponse(
                true,
                'Todo updated successfully.',
                new TodoResource($todo)
            );
        } catch (Exception $e) {
            return $this->jsonResponse(false, 'Failed to update todo: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $userId = auth()->id() ?? 1;
            
            $this->todoService->deleteTodo($userId, $id);

            return $this->jsonResponse(
                true,
                'Todo deleted successfully.'
            );
        } catch (Exception $e) {
            return $this->jsonResponse(false, 'Failed to delete todo: ' . $e->getMessage(), null, 500);
        }
    }
}
