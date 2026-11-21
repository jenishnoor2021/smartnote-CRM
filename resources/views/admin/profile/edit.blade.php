@extends('layouts.admin')

@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">{{ __('Change Password') }}</span>
            </h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="icon-home2 position-left"></i>
                    {{ __('Dashboard') }}
                </a>
            </li>
            <li class="active">{{ __('Change Password') }}</li>
        </ul>
    </div>
</div>

<div class="content">

    {!! Form::model($user, [
    'method' => 'PATCH',
    'action' => ['AdminController@profileUpdate'],
    'files' => true,
    'class' => 'form-horizontal',
    'name' => 'editprofileform'
    ]) !!}

    @csrf

    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-flat">

                <div class="panel-heading">
                    <h5 class="panel-title">
                        <strong>{{ __('Change Password') }}</strong>
                    </h5>
                </div>

                {{-- Error Message --}}
                @if (session('error'))
                <div class="alert text-white pl-3 pt-2 pb-2"
                    style="background-color:red;color:white">
                    {{ session('error') }}
                </div>
                @endif

                {{-- Success Message --}}
                @if (session('success'))
                <div class="alert text-white pl-3 pt-2 pb-2"
                    style="background-color:green;color:white">
                    {{ session('success') }}
                </div>
                @endif

                <div class="panel-body">

                    {{-- Current Password --}}
                    <div class="form-group">
                        <small class="req text-danger">*</small>
                        <label>{{ __('Current Password') }}:</label>

                        <input type="password"
                            class="form-control"
                            placeholder="{{ __('Enter Current Password') }}"
                            id="current_password"
                            name="current_password">

                        @error('current_password')
                        <div class="text-danger mt-1 mb-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div class="form-group">
                        <small class="req text-danger">*</small>
                        <label>{{ __('New Password') }}:</label>

                        <input type="password"
                            class="form-control"
                            placeholder="{{ __('Enter New Password') }}"
                            id="new_password"
                            name="new_password">

                        @error('new_password')
                        <div class="text-danger mt-1 mb-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Confirm New Password --}}
                    <div class="form-group">
                        <small class="req text-danger">*</small>
                        <label>{{ __('Confirm New Password') }}:</label>

                        <input type="password"
                            class="form-control"
                            placeholder="{{ __('Confirm New Password') }}"
                            id="new_password_confirmation"
                            name="new_password_confirmation">

                        @error('new_password_confirmation')
                        <div class="text-danger mt-1 mb-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>
            </div>

        </div>

        <div class="btn-bottom-toolbar text-right btn-toolbar-container-out">
            <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
            <a class="btn btn-default" href="{{route('admin.dashboard')}}">{{ __('Back') }}</a>
        </div>

    </div>

    {!! Form::close() !!}

</div>

@endsection


@section('script')

<script>
    $(document).ready(function() {

        $("form[name='editprofileform']").validate({

            rules: {

                current_password: {
                    required: true
                },

                new_password: {
                    required: true,
                    minlength: 6
                },

                new_password_confirmation: {
                    required: true,
                    equalTo: "#new_password"
                }

            },

            messages: {

                current_password: {
                    required: "Please enter your current password."
                },

                new_password: {
                    required: "Please enter a new password.",
                    minlength: "Password must be at least 6 characters."
                },

                new_password_confirmation: {
                    required: "Please confirm your new password.",
                    equalTo: "New password and confirm password must match."
                }

            },

            submitHandler: function(form) {
                form.submit();
            }

        });

    });
</script>

@endsection