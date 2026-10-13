@extends('layouts.app')

@section('content')
<div class="row justify-content-center animate-fade-in">
    <div class="col-lg-8 col-xl-7">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-2.5 py-1 rounded-pill" style="font-size: 0.725rem;">
                        <i class="bi bi-pencil-square me-1"></i> Update Item
                    </span>
                    <span class="text-muted small">• Task #{{ $todo->id }}</span>
                </div>
                <h1 class="h3 fw-bold text-dark mb-1 brand-font">Edit Task</h1>
                <p class="text-muted mb-0 small">Modify task parameters and track execution.</p>
            </div>
            <a href="{{ route('todos.index') }}" class="btn btn-glass d-inline-flex align-items-center gap-1.5 text-decoration-none">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Tasks</span>
            </a>
        </div>

        <div class="glass-card p-4 p-md-5 shadow-sm">
            <form action="{{ route('todos.update', $todo->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="title" class="form-label fw-bold text-dark small brand-font text-uppercase" style="letter-spacing: 0.04em;">
                        Task Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="glass-input form-control form-control-lg @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $todo->title) }}" required>
                    @error('title')
                        <div class="text-danger mt-1.5 small d-flex align-items-center gap-1">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-bold text-dark small brand-font text-uppercase" style="letter-spacing: 0.04em;">
                        Description <span class="text-muted fw-normal text-capitalize">(Optional)</span>
                    </label>
                    <textarea class="glass-input form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $todo->description) }}</textarea>
                    @error('description')
                        <div class="text-danger mt-1.5 small d-flex align-items-center gap-1">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="row mb-4">
                    <div class="col-md-7">
                        <label for="due_date" class="form-label fw-bold text-dark small brand-font text-uppercase" style="letter-spacing: 0.04em;">
                            Due Date
                        </label>
                        <input type="datetime-local" class="glass-input form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date', $todo->due_date ? \Carbon\Carbon::parse($todo->due_date)->format('Y-m-d\TH:i') : '') }}">
                        @error('due_date')
                            <div class="text-danger mt-1.5 small d-flex align-items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Interactive Completion Status Box -->
                <div class="p-3 mb-4 rounded-3 border d-flex align-items-center justify-content-between {{ $todo->is_completed ? 'bg-success bg-opacity-10 border-success-subtle' : 'bg-light-subtle' }}" id="status-container" style="transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-white border d-flex align-items-center justify-content-center {{ $todo->is_completed ? 'text-success' : 'text-muted' }}" id="status-icon-box" style="width: 38px; height: 38px;">
                            <i class="bi {{ $todo->is_completed ? 'bi-check2-circle' : 'bi-circle' }} fs-5"></i>
                        </div>
                        <div>
                            <label class="form-check-label fw-bold d-block mb-0 small {{ $todo->is_completed ? 'text-success' : 'text-dark' }}" for="is_completed" id="status-label" style="cursor: pointer;">
                                {{ $todo->is_completed ? 'Completed' : 'Pending Completion' }}
                            </label>
                            <span class="text-muted" id="status-subtext" style="font-size: 0.775rem;">
                                {{ $todo->is_completed ? 'This task is marked as finished' : 'Toggle switch to mark as completed' }}
                            </span>
                        </div>
                    </div>
                    <div class="form-check form-switch m-0">
                        <input type="hidden" name="is_completed" value="0">
                        <input class="form-check-input fs-4 m-0 shadow-none" type="checkbox" role="switch" id="is_completed" name="is_completed" value="1" {{ old('is_completed', $todo->is_completed) ? 'checked' : '' }} onchange="toggleStatusBg(this)" style="cursor: pointer;">
                    </div>
                </div>

                <hr class="border-light-subtle mb-4">

                <div class="d-flex justify-content-end align-items-center gap-2">
                    <a href="{{ route('todos.index') }}" class="btn btn-glass px-4">Cancel</a>
                    <button type="submit" class="btn btn-gradient-primary px-4 py-2 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-arrow-repeat fs-5"></i>
                        <span>Update Task</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleStatusBg(checkbox) {
        const container = document.getElementById('status-container');
        const label = document.getElementById('status-label');
        const subtext = document.getElementById('status-subtext');
        const iconBox = document.getElementById('status-icon-box');

        if (checkbox.checked) {
            container.className = 'p-3 mb-4 rounded-3 border d-flex align-items-center justify-content-between bg-success bg-opacity-10 border-success-subtle';
            label.className = 'form-check-label fw-bold d-block mb-0 small text-success';
            label.innerText = 'Completed';
            subtext.innerText = 'This task is marked as finished';
            iconBox.className = 'rounded-circle bg-white border d-flex align-items-center justify-content-center text-success';
            iconBox.innerHTML = '<i class="bi bi-check2-circle fs-5"></i>';
        } else {
            container.className = 'p-3 mb-4 rounded-3 border d-flex align-items-center justify-content-between bg-light-subtle';
            label.className = 'form-check-label fw-bold d-block mb-0 small text-dark';
            label.innerText = 'Pending Completion';
            subtext.innerText = 'Toggle switch to mark as completed';
            iconBox.className = 'rounded-circle bg-white border d-flex align-items-center justify-content-center text-muted';
            iconBox.innerHTML = '<i class="bi bi-circle fs-5"></i>';
        }
    }
</script>
@endsection
