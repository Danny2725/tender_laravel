@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">{{ $tender['title'] }}</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Description</h5>
            <p class="card-text">{{ $tender['description'] }}</p>

            <h5 class="card-title">Details</h5>
            <p class="card-text">{{ $tender['details'] }}</p>

            <h5 class="card-title">Visibility</h5>
            <p class="card-text">{{ $tender['visibility'] }}</p>

            <h5 class="card-title">Created At</h5>
            <p class="card-text">{{ $tender['created_at'] }}</p>

            <a href="{{ route('tender.list_contractor') }}" class="btn btn-secondary mt-3">Back to List</a>
        </div>
    </div>
</div>
@endsection
