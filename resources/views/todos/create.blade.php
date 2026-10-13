@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Create Task</h2>
                <p class="text-muted mb-0">Add a new task to your dashboard.</p>
            </div>
            <a href="{{ route('todos.index') }}" class="btn btn-light border text-muted fw-medium rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="card border-0 p-2 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('todos.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold text-main">Task Title <span class="text-danger">*</span></label>
                        <div class="input-group input-group-lg shadow-sm rounded-3">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-card-heading"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0 @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required placeholder="E.g., Complete the Q3 quarterly report">
                        </div>
                        @error('title')
                            <div class="text-danger mt-1 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold text-main">Description</label>
                        <textarea class="form-control shadow-sm @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Provide any additional details or context...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger mt-1 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-7">
                            <label for="due_date" class="form-label fw-semibold text-main">Due Date</label>
                            <div class="input-group shadow-sm rounded-3">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-calendar-event"></i></span>
                                <input type="datetime-local" class="form-control border-start-0 ps-0 @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date') }}">
                            </div>
                            @error('due_date')
                                <div class="text-danger mt-1 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-5 bg-light p-3 rounded-3 border">
                        <div class="form-check form-switch d-flex align-items-center">
                            <input type="hidden" name="is_completed" value="0">
                            <input class="form-check-input fs-4 mt-0 me-3 shadow-none" type="checkbox" role="switch" id="is_completed" name="is_completed" value="1" {{ old('is_completed') ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium text-main" for="is_completed" style="cursor: pointer;">
                                Mark this task as already completed
                            </label>
                        </div>
                    </div>

                    <hr class="text-muted opacity-25 mb-4">

                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('todos.index') }}" class="btn btn-light border px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bi bi-check-lg me-1"></i> Save Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
