@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
   <div class="page-header-content">
      <div class="page-title">
         <h4>
            <span class="text-semibold">{{ __('ADD Sub Category') }}</span>
         </h4>
      </div>
   </div>
   <div class="breadcrumb-line">
      <ul class="breadcrumb">
         <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a>
         </li>
         <li><a href="{{ route('admin.subcategory.index') }}">{{ __('Sub Category') }}</a></li>
         <li class="active">{{ __('ADD') }}</li>
      </ul>
   </div>
</div>

<div class="content">
   <form action="{{ route('admin.subcategory.store') }}" method="POST" enctype="multipart/form-data" class="form-horizontal" name="addsubcategoryform">
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
                        <strong>{{ __('Sub Category') }}</strong>
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
                        <label>{{ __('Category') }}:</label>
                        <select name="category_id" id="category_id" class="form-control select2" required>
                           <option value="">{{ __('-- Select Category --') }}</option>
                           @foreach($categories as $category)
                              <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                 {{ $category->category_name }}
                              </option>
                           @endforeach
                        </select>
                        @error('category_id')
                        <div class="text-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                     </div>

                     <div class="form-group">
                        <small class="req text-danger">*</small>
                        <label>{{ __('Sub Category Name') }}:</label>
                        <input type="text" class="form-control" placeholder="{{ __('Enter Sub Category Name') }}" id="subcategory_name" name="subcategory_name" value="{{ old('subcategory_name') }}">
                        @error('subcategory_name')
                        <div class="text-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                     </div>

                     <div class="form-group">
                        <label>{{ __('Image') }}:</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(this);">
                        <div id="image_preview_box" style="margin-top: 10px; display: none;">
                           <img id="image_preview" src="" alt="Preview" style="max-width: 150px; max-height: 150px; border-radius: 4px; border: 1px solid #ddd; padding: 4px;">
                        </div>
                        @error('image')
                        <div class="text-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                     </div>

                     <div class="form-group">
                        <label>{{ __('Status') }}:</label>
                        <input type="checkbox" class="switchery" name="is_active" id="is_active" value="1" checked>
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
   function previewImage(input) {
      if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function(e) {
            $('#image_preview').attr('src', e.target.result);
            $('#image_preview_box').show();
         }
         reader.readAsDataURL(input.files[0]);
      } else {
         $('#image_preview_box').hide();
      }
   }

   $(function() {
      // Initialize select2 if available
      if ($.fn.select2) {
         $('.select2').select2();
      }

      $("form[name='addsubcategoryform']").validate({
         rules: {
            category_id: {
               required: true,
            },
            subcategory_name: {
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

