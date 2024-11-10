@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Create Tender</h2>
    <form action="{{ route('tender.store') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" class="form-control" id="title" name="title" required placeholder="Enter tender title">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4" required placeholder="Provide a description for the tender"></textarea>
        </div>

        <div class="mb-3">
            <label for="visibility" class="form-label">Visibility:</label>
            <select class="form-select" id="visibility" name="visibility">
                <option value="public">Public</option>
                <option value="private">Private</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="suppliers" class="form-label">Invited Suppliers (for Private):</label>
            <input type="email" class="form-control" id="suppliers" name="suppliers[]" multiple placeholder="Enter supplier email addresses">
            <small class="form-text text-muted">Separate multiple emails with commas.</small>
        </div>

        <button type="submit" class="btn btn-primary">Create Tender</button>
    </form>
</div>
@endsection
