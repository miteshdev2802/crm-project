@extends('layouts.app')

@section('content')
<div class="col-md-9 container">
    <label for="">
        <h2>Edit Contact User</h2>
    </label>
    <form id="editContactForm" method="POST" action="{{ route('contacts.update', $contact->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" id="editContactId" name="contact_id">
        <div class="row">
            <div class="form-group col-md-6">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ $contact->name }}">
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $contact->email }}">
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $contact->phone }}">
                @error('phone')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label>Gender</label>
                <div>
                    <input type="radio" name="gender" value="Male" {{ $contact->gender == 'Male' ? 'checked' : '' }}> Male
                    <input type="radio" name="gender" value="Female" {{ $contact->gender == 'Female' ? 'checked' : '' }}> Female
                    <input type="radio" name="gender" value="Other" {{ $contact->gender == 'Other' ? 'checked' : '' }}> Other
                </div>
                @error('gender')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label>Profile Image</label>
                <input type="file" name="profile_image" class="form-control">
                @if($contact->profile_image)
                <img src="{{ asset('storage/' . $contact->profile_image) }}" width="100" alt="Profile Image">
                @endif
                @error('profile_image')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label>Additional File</label>
                <input type="file" name="additional_file" class="form-control">
                @if($contact->additional_file)
                <a href="{{ asset('storage/' . $contact->additional_file) }}" target="_blank">View File</a>
                @endif
                @error('additional_file')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <label>
            <h4>Edit Custom Fields</h4>
        </label>
        <hr />
        <div class="float-container" id="editCustomFieldsContainer">
            @if(!empty($contact->custom_fields))
            <?php $i = 0 ?>
            @foreach($contact->custom_fields as $key=>$value)
            <!-- <div class="form-group col-md-6 float-child">
                <label class="inputfield">{{@ucfirst($key)}}</label>
                <input type="text" name="custom_fields[{{$key}}]" class="form-control" value="{{$value}}">
            </div> -->
            <div class="input-group mb-2">
                <input type="text" name="custom_fields[{{ $i }}][name]" value="{{ ucfirst($key) }}" class="form-control mr-2" required>
                <input type="text" name="custom_fields[{{ $i++ }}][value]" value="{{ $value }}" class="form-control ml-2" required>
                <button type="button" class="btn btn-danger remove-field ml-2">-</button>
            </div>
            @endforeach
            @endif
        </div>
        <button type="button" class="btn btn-primary" id="addEditCustomField">+ Add Custom Field</button>
        <button type="submit" class="btn btn-success">Update Contact</button>
        <a href="{{ route('contacts.index') }}"><button class="btn btn-default btn-secondary" type="button">Cancel</button></a>
    </form>
    @endsection


    @section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            let fieldIndex = `{{!empty($contact->custom_fields) ? count($contact->custom_fields) : 0}}`;
            $('#addEditCustomField').click(function() {
                let html = `<div class="input-group mb-2">
                        <input type="text" name="custom_fields[${fieldIndex}][name]" class="form-control mr-2" placeholder="Field Name" required>
                        <input type="text" name="custom_fields[${fieldIndex}][value]" class="form-control ml-2" placeholder="Field Value" required>
                        <button type="button" class="btn btn-danger remove-field ml-2">-</button>
                    </div>`;
                $('#editCustomFieldsContainer').append(html);
                fieldIndex++;
            });

            $(document).on('click', '.remove-field', function() {
                $(this).closest('.input-group').remove();
            });
        });
    </script>
    @endsection