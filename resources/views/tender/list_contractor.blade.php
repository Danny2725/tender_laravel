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
                        <!-- <th>Actions</th> -->
                    </tr>
                </thead>
                @foreach ($tenders as $tender)
                        <tr>
                            <td>{{ $tender['title'] }}</td>
                            <td>{{ $tender['description'] }}</td>
                            <td>{{ $tender['visibility'] }}</td>
                            <!-- <td>
                                <a href="/tender/edit/{{ $tender['id'] }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="/tender/delete/{{ $tender['id'] }}" class="btn btn-sm btn-danger">Delete</a>
                            </td> -->
                        </tr>
                    @endforeach
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Hàm để lấy giá trị cookie theo tên
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Lấy access_token từ cookies
        const accessToken = getCookie('access_token');

        // Kiểm tra nếu access_token tồn tại
        if (!accessToken) {
            console.error('Access token không tìm thấy trong cookies');
            return;
        }

        // Thực hiện AJAX request đến API
        fetch('http://localhost/tender/list_contractor', {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + accessToken,
                'Content-Type': 'application/json'
            },
            credentials: 'include' // Bao gồm cookies trong request
        })
        .then(response => response.json())
        .then(data => {
            // Giả sử data là một mảng các tender
            const tbody = document.querySelector('#tender-table tbody');

            data.forEach(tender => {
                const tr = document.createElement('tr');

                const tdTitle = document.createElement('td');
                tdTitle.textContent = tender.title;
                tr.appendChild(tdTitle);

                const tdDescription = document.createElement('td');
                tdDescription.textContent = tender.description;
                tr.appendChild(tdDescription);

                const tdVisibility = document.createElement('td');
                tdVisibility.textContent = tender.visibility;
                tr.appendChild(tdVisibility);

                const tdActions = document.createElement('td');
                // Thêm các nút hành động ở đây
                tdActions.innerHTML = `
                    <a href="/tender/edit/${tender.id}" class="btn btn-sm btn-primary">Edit</a>
                    <a href="/tender/delete/${tender.id}" class="btn btn-sm btn-danger">Delete</a>
                `;
                tr.appendChild(tdActions);

                tbody.appendChild(tr);
            });
        })
        .catch(error => {
            console.error('Lỗi khi lấy danh sách tenders:', error);
        });
    });
</script>
@endsection
