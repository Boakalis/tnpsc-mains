@extends('layouts.master')
@section('content')
<div class="">
    <div class="row">

        <h4 class="fw-bold py-3 mb-4 ">Settings&nbsp;&nbsp;</h4>

    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{route('settings.post')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col col-12 mb-3">
                    <label for="name" class="form-label">Website Name</label>
                    <input type="name"  required id="name" name="name" class="form-control"
                        placeholder="Enter Name" value="{{@$data->name}}" >
                    @error('name')
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @enderror
                </div>
                <div class="col col-12 mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="text" required id="email" name="email" class="form-control"
                        placeholder="Enter Email Address" value="{{@$data->email}}">
                    @error('email')
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @enderror
                </div>
                <div class="col col-12 mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" required class="form-control tinymce-editor" placeholder="Please Enter Address"> {{ @$data->address}}</textarea>
                </div>
                <div class="col col-12 mb-3">
                    <label for="about" class="form-label">About us</label>
                    <textarea name="about" required  class="form-control tinymce-editor" placeholder="Please Enter Content"> {{ @$data->about}}</textarea>
                </div>
                <div class="col col-12 mb-3">
                    <label for="address" class="form-label">Privacy Policy</label>
                    <textarea name="privacy" required  class="form-control tinymce-editor"  Content"> {{ @$data->privacy}}</textarea>
                </div>
                <div class="col col-12 mb-3">
                    <label for="toc" class="form-label">Terms and Conditions</label>
                    <textarea name="toc" required class="form-control tinymce-editor" > {{ @$data->toc}}</textarea>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Update</button>
        </form>
    </div>
</div>
@endsection
