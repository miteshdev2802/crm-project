@extends('layouts.app')

@section('style')
<style type="text/css">
    .inputfield {
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<div class="col-md-9 container">
    <label for="">
        <h2>Add Contact User</h2>
    </label>
    <form id="addContactForm" method="POST" action="{{ route('contacts.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="form-group col-md-6">
                <label class="inputfield">Name</label>
                <input type="text" name="name" class="form-control" value="{{old('name')}}">
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label class="inputfield">Email</label>
                <input type="email" name="email" class="form-control" value="{{old('email')}}">
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label class="inputfield">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{old('phone')}}">
                @error('phone')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label class="inputfield">Gender</label>
                <div>
                    <input type="radio" name="gender" value="Male" {{ old("gender") == 'Male' ? 'checked' : '' }}> Male
                    <input type="radio" name="gender" value="Female" {{ old("gender") == 'Female' ? 'checked' : '' }}> Female
                    <input type="radio" name="gender" value="Other" {{ old("gender") == 'Other' ? 'checked' : '' }}> Other
                </div>
                @error('gender')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="formFile" class="form-label">Profile Image</label>
                <input type="file" name="profile_image" class="form-control">
                @error('profile_image')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="formFile" class="form-label">Additional File</label>
                <input type="file" name="additional_file" class="form-control">
                @error('additional_file')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Contact</button>
        <a href="{{ route('contacts.index') }}"><button class="btn btn-default btn-secondary" type="button">Cancel</button></a>
    </form>
</div>

@endsection