@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">My Tenders (Contractor)</h2>
        <a href="{{ route('tender.create') }}" class="btn btn-primary">Create New Tender</a>
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
                                <!-- Link tới trang chi tiết -->
                                <a href="{{ route('tender.detail', $tender['id']) }}" class="btn btn-sm btn-outline-info me-2">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                
                                <!-- Link tới trang chỉnh sửa -->
                                <a href="{{ route('tender.edit', $tender['id']) }}" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                
                                <!-- Link tới trang xóa -->
                                <form action="{{ route('tender.delete', $tender['id']) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
