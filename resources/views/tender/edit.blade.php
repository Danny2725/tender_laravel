@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Tender</h2>
    <form action="{{ route('tender.update', $tender['id']) }}" method="post">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" class="form-control" id="title" name="title" required value="{{ $tender['title'] }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4" required>{{ $tender['description'] }}</textarea>
        </div>

        <div class="mb-3">
            <label for="visibility" class="form-label">Visibility:</label>
            <select class="form-select" id="visibility" name="visibility">
                <option value="public" {{ $tender['visibility'] == 'Public' ? 'selected' : '' }}>Public</option>
                <option value="private" {{ $tender['visibility'] == 'Private' ? 'selected' : '' }}>Private</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Tender</button>
    </form>
</div>
@endsection
