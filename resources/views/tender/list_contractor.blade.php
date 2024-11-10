@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">My Tenders (Contractor)</h2>
        <a href="{{ route('tender.create') }}" class="btn btn-primary">Create New Tender</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-borderless align-middle" id="tender-table">
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
                        <tr data-id="{{ $tender['id'] }}">
                            <td>{{ $tender['title'] }}</td>
                            <td>{{ $tender['description'] }}</td>
                            <td>{{ $tender['visibility'] }}</td>
                            <td>
                                <a href="{{ route('tender.edit', $tender['id']) }}" class="btn btn-sm btn-primary">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        const accessToken = getCookie('access_token');

        if (!accessToken) {
            console.error('Access token không tìm thấy trong cookies');
            return;
        }

    });
</script>
@endsection