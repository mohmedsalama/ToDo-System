@extends('layouts.app')

@section('content')

@php
    $totalTodos = \App\Models\Todo::count();
    $pendingTodos = \App\Models\Todo::where('is_completed', false)->count();
    $completedTodos = \App\Models\Todo::where('is_completed', true)->count();
    $completionPercent = $totalTodos > 0 ? round(($completedTodos / $totalTodos) * 100) : 0;
@endphp

<!-- Page Header & Greeting -->
<div class="row align-items-center mb-4 g-3 animate-fade-in">
    <div class="col-md-7">
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-2.5 py-1.5 rounded-pill" style="font-size: 0.75rem;">
                <i class="bi bi-stars me-1"></i> Productive Workspace
            </span>
            <span class="text-muted small">• {{ now()->format('l, M d') }}</span>
        </div>
        <h1 class="h2 fw-bold text-dark mb-1 brand-font">Task Overview</h1>
        <p class="text-muted mb-0">Stay organized, focused, and achieve your daily goals.</p>
    </div>
    
    <!-- Overall Progress Mini Card -->
    <div class="col-md-5">
        <div class="glass-card p-3 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-semibold text-dark small brand-font">Productivity Score</span>
                <span class="fw-bold text-primary small">{{ $completionPercent }}%</span>
            </div>
            <div class="progress-slim mb-1">
                <div class="progress-bar-gradient h-100" style="width: {{ $completionPercent }}%;"></div>
            </div>
            <div class="d-flex justify-content-between text-muted" style="font-size: 0.7rem;">
                <span>{{ $completedTodos }} of {{ $totalTodos }} tasks done</span>
                <span>{{ $pendingTodos }} remaining</span>
            </div>
        </div>
    </div>
</div>

<!-- Stats Metric Cards -->
<div class="row g-3 g-xl-4 mb-4 mb-lg-5 animate-fade-in">
    <!-- Total Tasks -->
    <div class="col-12 col-md-4">
        <div class="glass-card glass-card-hover p-4 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-uppercase fw-semibold d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.05em;">Total Tasks</span>
                    <h2 class="display-6 fw-bold text-dark mb-0 brand-font">{{ $totalTodos }}</h2>
                </div>
                <div class="stat-icon stat-icon-primary">
                    <i class="bi bi-layers-half"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-top border-light-subtle d-flex align-items-center text-muted small">
                <i class="bi bi-check2-circle text-primary me-1.5"></i>
                <span>All active workspace tasks</span>
            </div>
        </div>
    </div>
    
    <!-- Pending Tasks -->
    <div class="col-12 col-md-4">
        <div class="glass-card glass-card-hover p-4 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-uppercase fw-semibold d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.05em;">In Progress</span>
                    <h2 class="display-6 fw-bold text-dark mb-0 brand-font">{{ $pendingTodos }}</h2>
                </div>
                <div class="stat-icon stat-icon-warning">
                    <i class="bi bi-hourglass-split"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-top border-light-subtle d-flex align-items-center text-muted small">
                <i class="bi bi-clock-history text-warning me-1.5"></i>
                <span>Tasks waiting for completion</span>
            </div>
        </div>
    </div>

    <!-- Completed Tasks -->
    <div class="col-12 col-md-4">
        <div class="glass-card glass-card-hover p-4 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-uppercase fw-semibold d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.05em;">Completed</span>
                    <h2 class="display-6 fw-bold text-dark mb-0 brand-font">{{ $completedTodos }}</h2>
                </div>
                <div class="stat-icon stat-icon-success">
                    <i class="bi bi-patch-check-fill"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-top border-light-subtle d-flex align-items-center text-muted small">
                <i class="bi bi-arrow-up-right text-success me-1.5"></i>
                <span>Completed successfully</span>
            </div>
        </div>
    </div>
</div>

<!-- Toolbar: Filter Pills & Search -->
<form method="GET" action="{{ route('todos.index') }}" class="glass-card p-3 mb-4 animate-fade-in shadow-sm">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3">
        <!-- Filter Tabs -->
        <div class="d-inline-flex p-1 bg-light rounded-3 border">
            <button type="submit" name="status" value="" class="btn btn-sm px-3 rounded-2 fw-semibold {{ request('status') == '' ? 'btn-gradient-primary' : 'btn-link text-muted text-decoration-none' }}">
                All <span class="badge bg-white bg-opacity-25 ms-1">{{ $totalTodos }}</span>
            </button>
            <button type="submit" name="status" value="pending" class="btn btn-sm px-3 rounded-2 fw-semibold {{ request('status') == 'pending' ? 'btn-gradient-primary' : 'btn-link text-muted text-decoration-none' }}">
                Pending <span class="badge {{ request('status') == 'pending' ? 'bg-white bg-opacity-25' : 'bg-secondary bg-opacity-10 text-secondary' }} ms-1">{{ $pendingTodos }}</span>
            </button>
            <button type="submit" name="status" value="completed" class="btn btn-sm px-3 rounded-2 fw-semibold {{ request('status') == 'completed' ? 'btn-gradient-primary' : 'btn-link text-muted text-decoration-none' }}">
                Completed <span class="badge {{ request('status') == 'completed' ? 'bg-white bg-opacity-25' : 'bg-secondary bg-opacity-10 text-secondary' }} ms-1">{{ $completedTodos }}</span>
            </button>
        </div>
        
        <!-- Search Input -->
        <div class="position-relative" style="min-width: 280px;">
            <i class="bi bi-search position-absolute text-muted" style="top: 50%; left: 1rem; transform: translateY(-50%); font-size: 0.9rem;"></i>
            <input type="text" name="search" value="{{ request('search') }}" class="glass-input form-control w-100 ps-5" placeholder="Search by title..." onchange="this.form.submit()">
            @if(request('search'))
                <a href="{{ route('todos.index') }}" class="position-absolute text-muted text-decoration-none" style="top: 50%; right: 1rem; transform: translateY(-50%);" title="Clear search">
                    <i class="bi bi-x-circle-fill"></i>
                </a>
            @endif
        </div>
    </div>
</form>

<!-- Data Table Card -->
<div class="glass-card overflow-hidden shadow-sm animate-fade-in">
    <div class="table-responsive">
        <table class="table table-glass w-100">
            <thead>
                <tr>
                    <th width="45%">Task Details</th>
                    <th width="18%">Status</th>
                    <th width="20%">Due Date</th>
                    <th width="17%" class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($todos as $todo)
                    <tr>
                        <td>
                            <div class="d-flex align-items-start gap-3">
                                <div class="mt-1">
                                    @if($todo->is_completed)
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-success bg-success bg-opacity-10" style="width: 28px; height: 28px;">
                                            <i class="bi bi-check-lg fw-bold"></i>
                                        </div>
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-muted bg-light border" style="width: 28px; height: 28px;">
                                            <i class="bi bi-circle" style="font-size: 0.65rem;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold fs-6 brand-font {{ $todo->is_completed ? 'text-decoration-line-through text-muted' : 'text-dark' }}">
                                        {{ $todo->title }}
                                    </span>
                                    @if($todo->description)
                                        <small class="text-muted text-truncate d-inline-block mt-0.5" style="max-width: 380px; font-size: 0.825rem;">
                                            {{ $todo->description }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($todo->is_completed)
                                <span class="status-pill status-pill-success">
                                    <span class="pulse-dot"></span>
                                    Done
                                </span>
                            @else
                                <span class="status-pill status-pill-warning">
                                    <span class="pulse-dot"></span>
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="bi bi-calendar-event me-2 text-primary opacity-75"></i>
                                <span>{{ $todo->due_date ? \Carbon\Carbon::parse($todo->due_date)->format('M d, Y') : 'No Due Date' }}</span>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-inline-flex gap-1.5">
                                <a href="{{ route('todos.edit', $todo->id) }}" class="btn-action btn-action-edit" title="Edit Task">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn-action btn-action-delete" title="Delete Task" onclick="confirmDelete({{ $todo->id }})">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
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
                                <div class="stat-icon stat-icon-primary mb-3" style="width: 72px; height: 72px; font-size: 2rem;">
                                    <i class="bi bi-clipboard2-check"></i>
                                </div>
                                <h4 class="fw-bold text-dark brand-font mb-1">No Tasks Found</h4>
                                <p class="text-muted mb-4 small" style="max-width: 320px;">You are completely caught up! Add your next priority to get started.</p>
                                <a href="{{ route('todos.create') }}" class="btn btn-gradient-primary d-inline-flex align-items-center gap-2">
                                    <i class="bi bi-plus-lg"></i>
                                    Create New Task
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
