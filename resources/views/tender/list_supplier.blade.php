@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Available Tenders (Supplier)</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-borderless align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Visibility</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tenders as $tender)
                    <tr>
                        <td>{{ $tender['title'] }}</td>
                        <td>{{ $tender['description'] }}</td>
                        <td>{{ $tender['visibility'] }}</td>
                        <td>
                            <a href="{{ route('tender.detail', $tender['id']) }}" class="btn btn-sm btn-outline-info me-2">
                                <i class="bi bi-eye"></i> View
                            </a>
                            @if ($tender['visibility'] == 'private' && in_array($supplier_email, $tender['invited_suppliers']))
                            <a href="{{ route('tender.apply', $tender['title']) }}" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-check-circle"></i> Apply
                            </a>
                            @elseif ($tender['visibility'] == 'public')
                            <a href="{{ route('tender.apply', $tender['title']) }}" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-check-circle"></i> Apply
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection