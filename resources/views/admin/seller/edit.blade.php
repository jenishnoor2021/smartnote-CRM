@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
   <div class="page-header-content">
      <div class="page-title">
         <h4>
            <span class="text-semibold">{{ __('Edit Seller') }}</span>
         </h4>
      </div>
   </div>
   <div class="breadcrumb-line">
      <ul class="breadcrumb">
         <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a>
         </li>
         <li><a href="{{ route('admin.seller.index') }}">{{ __('Seller') }}</a></li>
         <li class="active">{{ __('Edit') }}</li>
      </ul>
   </div>
</div>

<div class="content">
   <form action="{{ route('admin.seller.update', $seller->id) }}" method="POST" class="form-horizontal" name="editsellerform">
   @csrf
   @method('PATCH')
   <div class="row">
      <div class="col-md-8 col-md-offset-2">
         <!-- Panel -->
         <div class="panel panel-flat">
            <!-- Panel heading -->
            <div class="panel-heading">
               <div class="row">
                  <div class="col-md-10">
                     <h5 class="panel-title">
                        <strong>{{ __('Seller') }}</strong>
                     </h5>
                  </div>
               </div>
            </div>
            <!-- /Panel heading -->
            <!-- Panel body -->
            <div class="panel-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <small class="req text-danger">*</small>
                        <label>{{ __('Full Name') }}:</label>
                        <input type="text" class="form-control" placeholder="{{ __('Enter Full Name') }}" id="name" name="name" value="{{ old('name', $seller->name) }}">
                        @error('name')
                        <div class="text-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                     </div>

                     <div class="form-group">
                        <small class="req text-danger">*</small>
                        <label>{{ __('Username') }}:</label>
                        <input type="text" class="form-control" placeholder="{{ __('Enter Username') }}" id="username" name="username" value="{{ old('username', $seller->username) }}" onkeypress='return (event.charCode != 32)'>
                        @error('username')
                        <div class="text-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                     </div>

                     <div class="form-group">
                        <small class="req text-danger">*</small>
                        <label>{{ __('Email') }}:</label>
                        <input type="email" class="form-control" placeholder="{{ __('Enter Email') }}" id="email" name="email" value="{{ old('email', $seller->email) }}">
                        @error('email')
                        <div class="text-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                     </div>

                     <div class="form-group">
                        <label>{{ __('Mobile no') }}:</label>
                        <input type="tel" class="form-control" placeholder="{{ __('Enter Mobile no') }}" id="phone" name="phone" value="{{ old('phone', $seller->phone) }}">
                        @error('phone')
                        <div class="text-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                     </div>

                     <div class="form-group">
                        <label>{{ __('Password') }} (Optional):</label>
                        <input type="password" class="form-control" placeholder="{{ __('Enter New Password if you want to change') }}" id="password" name="password">
                        @error('password')
                        <div class="text-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                     </div>

                     <div class="form-group">
                        <label>{{ __('Status') }}:</label>
                        <input type="checkbox" class="switchery" name="is_active" id="is_active" value="1" {{ $seller->is_active ? 'checked' : '' }}>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /Panel body -->
            <!-- /Panel -->
         </div>
      </div>
      <div class="btn-bottom-toolbar text-right btn-toolbar-container-out">
         <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
         <a class="btn btn-default" onclick="window.history.back();">{{ __('Back') }}</a>
      </div>
   </div>
   </form>
</div>
@endsection

@section('script')
<script>
   $(function() {
      $("form[name='editsellerform']").validate({
         rules: {
            name: {
               required: true,
            },
            username: {
               required: true,
            },
            email: {
               required: true,
               email: true,
            },
            password: {
               minlength: 6,
            }
         },
         submitHandler: function(form) {
            form.submit();
         }
      });
   });
</script>
@endsection
