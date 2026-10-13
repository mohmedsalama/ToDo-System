<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\TodoService;
use App\Http\Requests\Todo\StoreTodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TodoController extends Controller
{
    /**
     * Inject the TodoService.
     */
    public function __construct(
        protected TodoService $todoService
    ) {}

    /**
     * Display a listing of the todos.
     */
    public function index(\Illuminate\Http\Request $request): View
    {
        $userId = auth()->id() ?? 1;
        
        $filters = $request->only(['search', 'status']);
        
        $todos = $this->todoService->getTodosForUser($userId, 15, $filters);
        
        return view('todos.index', compact('todos'));
    }

    /**
     * Show the form for creating a new todo.
     */
    public function create(): View
    {
        return view('todos.create');
    }

  
    public function store(StoreTodoRequest $request): RedirectResponse
    {
        $userId = auth()->id() ?? 1;
        $this->todoService->createTodo($userId, $request->validated());
        return redirect()->route('todos.index')->with('success', 'Todo created successfully!');
    }

    
    public function edit(int $id): View
    {
        $userId = auth()->id() ?? 1;
        $todo = $this->todoService->getTodoForUser($userId, $id);
        return view('todos.edit', compact('todo'));
    }

   
    public function update(UpdateTodoRequest $request, int $id): RedirectResponse
    {
        $userId = auth()->id() ?? 1;
        $this->todoService->updateTodo($userId, $id, $request->validated());
        return redirect()->route('todos.index')->with('success', 'Todo updated successfully!');
    }

 
    public function destroy(int $id): RedirectResponse
    {
        $userId = auth()->id() ?? 1;
        $this->todoService->deleteTodo($userId, $id);
        return redirect()->route('todos.index')->with('success', 'Todo deleted successfully!');
    }
}
