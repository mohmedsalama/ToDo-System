@extends('layouts.app')

@section('content')
<div class="row justify-content-center animate-fade-in">
    <div class="col-lg-8 col-xl-7">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-2.5 py-1 rounded-pill" style="font-size: 0.725rem;">
                        <i class="bi bi-pencil-fill me-1"></i> New Item
                    </span>
                </div>
                <h1 class="h3 fw-bold text-dark mb-1 brand-font">Create New Task</h1>
                <p class="text-muted mb-0 small">Capture and schedule your next objective.</p>
            </div>
            <a href="{{ route('todos.index') }}" class="btn btn-glass d-inline-flex align-items-center gap-1.5 text-decoration-none">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Tasks</span>
            </a>
        </div>

        <div class="glass-card p-4 p-md-5 shadow-sm">
            <form action="{{ route('todos.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="title" class="form-label fw-bold text-dark small brand-font text-uppercase" style="letter-spacing: 0.04em;">
                        Task Title <span class="text-danger">*</span>
                    </label>
                    <div class="position-relative">
                        <input type="text" class="glass-input form-control form-control-lg @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. Prepare financial forecast deck" autofocus>
                    </div>
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
                    <textarea class="glass-input form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Add key points, context, or links related to this task...">{{ old('description') }}</textarea>
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
                        <input type="datetime-local" class="glass-input form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date') }}">
                        @error('due_date')
                            <div class="text-danger mt-1.5 small d-flex align-items-center gap-1">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="p-3 mb-4 rounded-3 border bg-light-subtle d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-white border d-flex align-items-center justify-content-center text-primary" style="width: 38px; height: 38px;">
                            <i class="bi bi-check2-circle fs-5"></i>
                        </div>
                        <div>
                            <label class="form-check-label fw-bold text-dark d-block mb-0 small" for="is_completed" style="cursor: pointer;">
                                Mark Completed Immediately
                            </label>
                            <span class="text-muted" style="font-size: 0.775rem;">Set this task as done right away</span>
                        </div>
                    </div>
                    <div class="form-check form-switch m-0">
                        <input type="hidden" name="is_completed" value="0">
                        <input class="form-check-input fs-4 m-0 shadow-none" type="checkbox" role="switch" id="is_completed" name="is_completed" value="1" {{ old('is_completed') ? 'checked' : '' }} style="cursor: pointer;">
                    </div>
                </div>

                <hr class="border-light-subtle mb-4">

                <div class="d-flex justify-content-end align-items-center gap-2">
                    <a href="{{ route('todos.index') }}" class="btn btn-glass px-4">Cancel</a>
                    <button type="submit" class="btn btn-gradient-primary px-4 py-2 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-check2 fs-5"></i>
                        <span>Save Task</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
