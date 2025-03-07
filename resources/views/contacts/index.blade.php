@extends('layouts.app')

@section('content')
<div class="container">
    <div for="">
        <h2>Contact List</h2>
        <div class='pull-right'>
            <a href="{{ URL::route('contacts.create') }}">
                <button type='submit' class='pull-right btn btn-primary'>Add Contact</button>
            </a>
            <button type='button' id="merge_button" disabled="disable" class='pull-right btn btn-info'>Merge Contact</button>
        </div>
    </div>
    <form method="GET" action="{{ route('contacts.index') }}" id="filterForm" class="mb-3">
        <div>
            <h3>Filter</h3>
        </div>
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="name" class="form-control" placeholder="Filter by Name" value="{{ request('name') }}">
            </div>
            <div class="col-md-3">
                <input type="email" name="email" class="form-control" placeholder="Filter by Email" value="{{ request('email') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="phone" class="form-control" placeholder="Filter by Phone" value="{{ request('phone') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="custom_fields" class="form-control" placeholder="Filter by custom_fields" value="{{ request('custom_fields') }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Filter</button>
        <button class="btn btn-default btn-secondary mt-2 listingAjax" type="button">Cancel</button>
    </form>
    <div class="mt-2">
        @if(session()->has('success'))
        <div class="col-xs-12">
            <div class="alert alert-success">
                <b>Success:</b>{{ session()->get('success') }}
            </div>
        </div>
        @endif
        <div id="contactList">

        </div>
    </div>
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this contact?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Contact Details Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Contact Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="contactDetails">
                <!-- Contact details will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">
    $('document').ready(function() {

        // ajax call list and search
        function fetchContacts(page = 1) {
            let formData = $('#filterForm').serialize();
            $.ajax({
                url: "{{ route('contacts.list') }}?page=" + page,
                method: "GET",
                data: formData,
                success: function(response) {
                    $('#contactList').html(response);
                }
            });
        }

        $(document).on("click", ".listingAjax", function() {
            $('#filterForm')[0].reset();
            fetchContacts();
        });

        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            fetchContacts();
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            fetchContacts(page);
        });

        fetchContacts();

        // Delete Contact with Modal Confirmation
        $(document).on('click', '.deleteContact', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });
            let contactId = $(this).data('id');
            $('#deleteModal').modal('show');
            $('.confirmDelete').click(function() {
                $.ajax({
                    url: '{{url("")}}' + `/contacts/${contactId}`,
                    method: 'DELETE',
                    success: function(response) {
                        location.reload();
                    },
                    error: function(error) {
                        console.log('Error occurred');
                    }
                });
                $('#deleteModal').modal('hide');
            });
        });

        var ids = [];
        $(document).on('click', '.mergeContactCheck', function() {
            var chk = $(this).prop("checked");
            if (chk) {
                ids.push($(this).data('id'));
                // console.log(ids);
            } else {
                const index = ids.indexOf($(this).data('id'));
                ids.splice(index, 1);
                // console.log(ids);
            }
            if ($('input[type="checkbox"]:checked').length == 2) {
                $('#merge_button').removeAttr('disabled');
            } else {
                alert("Please select exactly two contacts for merge.");
                // console.log(ids);
                $('#merge_button').attr('disabled', 'disabled');

            }
        });

        // on click of merge button get the detail of two contact
        $(document).on('click', "#merge_button", function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });
            //console.log(ids);
            $.ajax({
                url: "{{ route('contacts.showcontacts') }}",
                method: "POST",
                data: {
                    ids: ids
                },
                success: function(response) {
                    $('#contactDetails').html(response);
                    $('#contactModal').modal('show');
                }
            });
        });

        // on click of merge button get the detail of two contact
        $(document).on('click', "#mergeConfirm", function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });
            //console.log(ids);
            var finalMergeId = $('input[name="makeMaster"]:checked').data('id');
            $.ajax({
                url: "{{ route('contacts.mergecontacts') }}",
                method: "POST",
                data: {
                    ids: $("#sectedIds").val(),
                    finalMergeId: finalMergeId
                },
                success: function(response) {
                    location.reload();
                }
            });
        });

        $(document).on('click', '.makeMaster', function() {
            if ($('input[type="radio"]:checked').length == 1) {
                $('#mergeConfirm').removeAttr('disabled');
            }
        });
    });
</script>
@endsection