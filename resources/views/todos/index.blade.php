@extends('layouts.app')

@section('content')

@php
    // Calculating stats purely in the view since modifying the Controller is forbidden.
    $totalTodos = \App\Models\Todo::count();
    $pendingTodos = \App\Models\Todo::where('is_completed', false)->count();
    $completedTodos = \App\Models\Todo::where('is_completed', true)->count();
@endphp

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Overview Dashboard</h2>
        <p class="text-muted mb-0">Track and manage your tasks effectively.</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card card-hover h-100 border-0 p-3">
            <div class="card-body d-flex align-items-center">
                <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-card-checklist text-primary fs-3"></i>
                </div>
                <div class="ms-4">
                    <h6 class="text-muted mb-1 text-uppercase fw-semibold" style="font-size: 0.8rem;">Total Tasks</h6>
                    <h3 class="mb-0 fw-bold">{{ $totalTodos }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card card-hover h-100 border-0 p-3">
            <div class="card-body d-flex align-items-center">
                <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-hourglass-split text-warning fs-3"></i>
                </div>
                <div class="ms-4">
                    <h6 class="text-muted mb-1 text-uppercase fw-semibold" style="font-size: 0.8rem;">Pending</h6>
                    <h3 class="mb-0 fw-bold">{{ $pendingTodos }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-hover h-100 border-0 p-3">
            <div class="card-body d-flex align-items-center">
                <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded-3">
                    <i class="bi bi-check-circle text-success fs-3"></i>
                </div>
                <div class="ms-4">
                    <h6 class="text-muted mb-1 text-uppercase fw-semibold" style="font-size: 0.8rem;">Completed</h6>
                    <h3 class="mb-0 fw-bold">{{ $completedTodos }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toolbar (Search & Filters) -->
<form method="GET" action="{{ route('todos.index') }}" class="card border-0 mb-4 p-2">
    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <!-- Visual UI Filters (Now Functional) -->
        <div class="d-flex gap-2">
            <button type="submit" name="status" value="" class="btn btn-sm px-3 rounded-pill fw-medium border {{ request('status') == '' ? 'btn-primary' : 'btn-light text-muted' }}">All</button>
            <button type="submit" name="status" value="pending" class="btn btn-sm px-3 rounded-pill fw-medium border {{ request('status') == 'pending' ? 'btn-primary' : 'btn-light text-muted' }}">Pending</button>
            <button type="submit" name="status" value="completed" class="btn btn-sm px-3 rounded-pill fw-medium border {{ request('status') == 'completed' ? 'btn-primary' : 'btn-light text-muted' }}">Completed</button>
        </div>
        
        <div class="input-group" style="max-width: 300px;">
            <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="bi bi-search"></i></span>
            <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 ps-0 shadow-none" placeholder="Search tasks..." onblur="this.form.submit()">
            <button type="submit" class="d-none">Search</button>
        </div>
    </div>
</form>

<!-- Data Table -->
<div class="card border-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-custom mb-0 w-100">
            <thead>
                <tr>
                    <th width="40%">Task Details</th>
                    <th width="15%">Status</th>
                    <th width="20%">Due Date</th>
                    <th width="25%" class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($todos as $todo)
                    <tr>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold {{ $todo->is_completed ? 'text-decoration-line-through text-muted' : 'text-main' }}">
                                    {{ $todo->title }}
                                </span>
                                @if($todo->description)
                                    <small class="text-muted text-truncate d-inline-block mt-1" style="max-width: 300px;">
                                        {{ Str::limit($todo->description, 60) }}
                                    </small>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($todo->is_completed)
                                <span class="badge badge-success-soft"><i class="bi bi-check-circle me-1"></i> Done</span>
                            @else
                                <span class="badge badge-warning-soft"><i class="bi bi-clock me-1"></i> Pending</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center text-muted">
                                <i class="bi bi-calendar3 me-2"></i>
                                {{ $todo->due_date ? \Carbon\Carbon::parse($todo->due_date)->format('M d, Y') : 'No Due Date' }}
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-icon btn-light text-primary border me-2" title="Edit Task">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-icon btn-light text-danger border" title="Delete Task" onclick="confirmDelete({{ $todo->id }})">
                                <i class="bi bi-trash3"></i>
                            </button>
                            <!-- Hidden form for deletion -->
                            <form id="delete-form-{{ $todo->id }}" action="{{ route('todos.destroy', $todo->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center justify-content-center text-muted my-4">
                                <div class="bg-light p-4 rounded-circle mb-3 shadow-sm">
                                    <i class="bi bi-clipboard-x fs-1 opacity-50"></i>
                                </div>
                                <h5 class="fw-bold">No tasks found</h5>
                                <p class="mb-4">You have a clean slate! Start by creating a new task.</p>
                                <a href="{{ route('todos.create') }}" class="btn btn-primary px-4 rounded-pill">
                                    <i class="bi bi-plus-lg me-1"></i> Add Task
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($todos->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $todos->links('pagination::bootstrap-5') }}
    </div>
@endif

@endsection
