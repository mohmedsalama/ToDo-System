@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Edit Task</h2>
                <p class="text-muted mb-0">Update the details of your task.</p>
            </div>
            <a href="{{ route('todos.index') }}" class="btn btn-light border text-muted fw-medium rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="card border-0 p-2 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('todos.update', $todo->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold text-main">Task Title <span class="text-danger">*</span></label>
                        <div class="input-group input-group-lg shadow-sm rounded-3">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-card-heading"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0 @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $todo->title) }}" required>
                        </div>
                        @error('title')
                            <div class="text-danger mt-1 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold text-main">Description</label>
                        <textarea class="form-control shadow-sm @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $todo->description) }}</textarea>
                        @error('description')
                            <div class="text-danger mt-1 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-7">
                            <label for="due_date" class="form-label fw-semibold text-main">Due Date</label>
                            <div class="input-group shadow-sm rounded-3">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-calendar-event"></i></span>
                                <input type="datetime-local" class="form-control border-start-0 ps-0 @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date', $todo->due_date ? \Carbon\Carbon::parse($todo->due_date)->format('Y-m-d\TH:i') : '') }}">
                            </div>
                            @error('due_date')
                                <div class="text-danger mt-1 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-5 {{ $todo->is_completed ? 'bg-success bg-opacity-10' : 'bg-light' }} p-3 rounded-3 border transition-all" id="status-container" style="transition: all 0.3s ease;">
                        <div class="form-check form-switch d-flex align-items-center">
                            <input type="hidden" name="is_completed" value="0">
                            <input class="form-check-input fs-4 mt-0 me-3 shadow-none" type="checkbox" role="switch" id="is_completed" name="is_completed" value="1" {{ old('is_completed', $todo->is_completed) ? 'checked' : '' }} onchange="toggleStatusBg(this)">
                            <label class="form-check-label fw-medium {{ $todo->is_completed ? 'text-success' : 'text-main' }}" for="is_completed" id="status-label" style="cursor: pointer;">
                                {{ $todo->is_completed ? 'Task Completed!' : 'Mark this task as completed' }}
                            </label>
                        </div>
                    </div>

                    <hr class="text-muted opacity-25 mb-4">

                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('todos.index') }}" class="btn btn-light border px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bi bi-arrow-repeat me-1"></i> Update Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleStatusBg(checkbox) {
        const container = document.getElementById('status-container');
        const label = document.getElementById('status-label');
        if (checkbox.checked) {
            container.classList.replace('bg-light', 'bg-success');
            container.classList.add('bg-opacity-10');
            label.classList.replace('text-main', 'text-success');
            label.innerText = 'Task Completed!';
        } else {
            container.classList.replace('bg-success', 'bg-light');
            container.classList.remove('bg-opacity-10');
            label.classList.replace('text-success', 'text-main');
            label.innerText = 'Mark this task as completed';
        }
    }
</script>
@endsection
