@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Available Tenders (Supplier)</h2>
    </div>

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="tenderTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="public-tab" data-bs-toggle="tab" data-bs-target="#public" type="button" role="tab" aria-controls="public" aria-selected="true">Public Tenders</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="private-tab" data-bs-toggle="tab" data-bs-target="#private" type="button" role="tab" aria-controls="private" aria-selected="false">Private Tenders</button>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content" id="tenderTabsContent">
        <!-- Public Tenders Tab -->
        <div class="tab-pane fade show active" id="public" role="tabpanel" aria-labelledby="public-tab">
            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    @if($publicTenders->isNotEmpty())
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
                                @foreach($publicTenders as $tender)
                                    <tr>
                                        <td>{{ $tender->title }}</td>
                                        <td>{{ $tender->description }}</td>
                                        <td>{{ $tender->visibility }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No public tenders available.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Private Tenders Tab -->
        <div class="tab-pane fade" id="private" role="tabpanel" aria-labelledby="private-tab">
            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    @if(!empty($privateTenders) && count($privateTenders) > 0)
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
                                @foreach($privateTenders as $tender)
                                    <tr>
                                        <td>{{ $tender->title }}</td>
                                        <td>{{ $tender->description }}</td>
                                        <td>{{ $tender->visibility }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No private tenders available.</p>
                    @endif
                </div>
            </div>
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
        fetch('http://localhost/tender/list_supplier', {
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