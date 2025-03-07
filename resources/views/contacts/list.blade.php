<table class="table table-bordered" id="contactsTable">
    <thead>
        <tr>
            <th>No.</th>
            <th>Merge</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Gender</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contacts as $index => $contact)
        <tr>
            <td>
                {{ $index + $contacts->firstItem()}}
            </td>
            <td>
                <div class="form-check"><input class="form-check-input mergeContactCheck" type="checkbox" data-id="{{ $contact->id }}"></div>
            </td>
            <td>{{ $contact->name }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->phone }}</td>
            <td>{{ $contact->gender }}</td>
            <td>
                <!-- <button class="btn btn-warning editContact" data-id="{{ $contact->id }}">Edit</button> -->
                <a href="{{ route('contacts.edit', $contact)}}"><button class="btn btn-warning">Edit</button></a>
                <button class="btn btn-danger deleteContact" data-id="{{ $contact->id }}">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div id="pagination" class="d-felx justify-content-center">{{{ $contacts->links() }}}</div>