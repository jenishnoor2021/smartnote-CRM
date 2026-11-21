@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
   <div class="page-header-content">
      <div class="page-title">
         <h4>
            <span class="text-semibold">{{ __('ADD Party') }}</span>
         </h4>
      </div>
   </div>
   <div class="breadcrumb-line">
      <ul class="breadcrumb">
         <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a>
         </li>
         <li><a href="{{ route('admin.party.index') }}">{{ __('Party') }}</a></li>
         <li class="active">{{ __('ADD') }}</li>
      </ul>
   </div>
</div>

<div class="content">
   {!! Form::open(['method'=>'POST', 'action'=> 'AdminPartyController@store','files'=>true,'class'=>'form-horizontal','name'=>'addpartyform']) !!}
   @csrf
   <div class="row">
      <div class="col-md-8 col-md-offset-2">
         <!-- Panel -->
         <div class="panel panel-flat">
            <!-- Panel heading -->
            <div class="panel-heading">
               <div class="row">
                  <div class="col-md-10">
                     <h5 class="panel-title">
                        <strong>{{ __('Party') }}</strong>
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
                        <label>{{ __('First Name') }}:</label>
                        <input type="text" class="form-control" placeholder="{{ __('Enter First Name') }}" id="fname" onkeypress='return (event.charCode != 32)' name="fname" value="">
                        @error('fname')
                        <div class="text-danger mt-1 mb-1">Please Enter First Name</div>
                        @enderror
                     </div>

                     <div class="form-group">
                        <small class="req text-danger">*</small>
                        <label>{{ __('Last Name') }}:</label>
                        <input type="text" class="form-control" placeholder="{{ __('Enter Last Name') }}" id="lname" onkeypress='return (event.charCode != 32)' name="lname" value="">
                        @error('lname')
                        <div class="text-danger mt-1 mb-1">Please Enter Last Name</div>
                        @enderror
                     </div>

                     <div class="form-group">
                        <small class="req text-danger">*</small>
                        <label>{{ __('Party Code') }}:</label>
                        <input type="text" class="form-control" placeholder="{{ __('Enter Party Code') }}" id="party_code" name="party_code" value="">
                        @error('party_code')
                        <div class="text-danger mt-1 mb-1">Please Enter party code</div>
                        @enderror
                     </div>

                     <div class="form-group">
                        <label>{{ __('Status') }}:</label>
                        <input type="checkbox" class="switchery" name="is_active" id="is_active" value="1">
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

      $("form[name='addpartyform']").validate({
         rules: {
            fname: {
               required: true,
            },
            lname: {
               required: true,
            },
            //address: {
            //   required: true,
            //},
            //mobile: {
            //   required: true,
            //},
            party_code: {
               required: true,
            }
         },
         submitHandler: function(form) {
            form.submit();
         }
      });
   });
</script>
@endsection