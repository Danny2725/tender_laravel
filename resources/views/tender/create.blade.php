@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Create Tender</h2>

    <!-- Bootstrap Alert -->
    <div id="message" class="alert d-none" role="alert"></div>

    <form id="tenderForm">
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
            <label for="supplierEmail" class="form-label">Invited Supplier Email:</label>
            <div class="input-group">
                <input type="text" class="form-control" id="supplierEmail" placeholder="Enter supplier email">
                <button type="button" class="btn btn-secondary" id="addSupplier">Add Supplier</button>
            </div>
            <small class="form-text text-muted">Click "Add Supplier" to include multiple email addresses.</small>
        </div>

        <ul id="suppliersList" class="list-group mb-3"></ul>

        <button type="button" class="btn btn-primary" id="openConfirmModal">Create Tender</button>
    </form>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Create Tender</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to create this tender?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmSubmit">Yes, Create</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        const suppliers = [];

        // Add supplier email to list
        $('#addSupplier').on('click', function() {
            const email = $('#supplierEmail').val().trim();
            if (email && !suppliers.includes(email)) {
                suppliers.push(email);
                $('#suppliersList').append(`<li class="list-group-item">${email}</li>`);
                $('#supplierEmail').val(''); // Clear input after adding
            }
        });

        // Open confirmation modal on form submit
        $('#openConfirmModal').on('click', function() {
            $('#confirmModal').modal('show');
        });

        // Confirm form submission in modal
        $('#confirmSubmit').on('click', function() {
            $('#confirmModal').modal('hide');

            const accessToken = document.cookie.split('; ').find(row => row.startsWith('access_token=')).split('=')[1];

            const formData = {
                title: $('#title').val(),
                description: $('#description').val(),
                visibility: $('#visibility').val(),
                suppliers: suppliers
            };

            $.ajax({
                url: '{{ route("tender.store") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': `Bearer ${accessToken}`
                },
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function(response) {
                    $('#message').removeClass('d-none alert-danger').addClass('alert-success').text('Tender created successfully!');
                    $('#tenderForm')[0].reset();
                    $('#suppliersList').empty();
                },
                error: function(error) {
                    $('#message').removeClass('d-none alert-success').addClass('alert-danger').text('Failed to create tender. Please try again.');
                }
            });
        });
    });
</script>
@endsection