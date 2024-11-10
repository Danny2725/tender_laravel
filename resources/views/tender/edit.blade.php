@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h2 class="h4 mb-4">Edit Tender</h2>
    
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('tender.update', $tender->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $tender->title }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" required>{{ $tender->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="visibility" class="form-label">Visibility</label>
                    <select name="visibility" id="visibility" class="form-control">
                        <option value="public" {{ $tender->visibility == 'public' ? 'selected' : '' }}>Public</option>
                        <option value="private" {{ $tender->visibility == 'private' ? 'selected' : '' }}>Private</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('tender.list_contractor') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection