@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">{{ __('ADD Client Review / Testimonial') }}</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('admin.testimonial.index') }}">{{ __('Reviews') }}</a></li>
            <li class="active">{{ __('ADD') }}</li>
        </ul>
    </div>
</div>

<div class="content">

    @if(isset($errors) && $errors->any())
        <div class="alert alert-danger alert-styled-left alert-bordered">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            <ul style="margin-bottom: 0;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.testimonial.store') }}" method="POST" enctype="multipart/form-data" class="form-horizontal" name="addtestimonialform">
        @csrf
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">
                            <strong>{{ __('Review Details') }}</strong>
                        </h5>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <small class="req text-danger">*</small>
                            <label>{{ __('Person Name') }}:</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Dr. Ramesh Patel" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Designation / Role') }}:</label>
                                    <input type="text" name="designation" class="form-control" value="{{ old('designation') }}" placeholder="e.g. Principal / Senior Educator">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('School / Organization Name') }}:</label>
                                    <input type="text" name="school_name" class="form-control" value="{{ old('school_name') }}" placeholder="e.g. Bright Public School, Surat">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Rating (1 to 5 Stars)') }}:</label>
                                    <select name="rating" class="form-control">
                                        <option value="5" {{ old('rating', 5) == 5 ? 'selected' : '' }}>5 Stars - Excellent</option>
                                        <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 Stars - Very Good</option>
                                        <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 Stars - Good</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Sort Order') }}:</label>
                                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Person / Principal Avatar Photo') }}:</label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this);">
                            <div id="image_preview_box" style="margin-top: 10px; display: none;">
                                <img id="image_preview" src="" alt="Preview" style="max-height: 90px; border-radius: 50%; border: 1px solid #ddd; padding: 2px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <small class="req text-danger">*</small>
                            <label>{{ __('Review Quote / Content') }}:</label>
                            <textarea name="review" rows="4" class="form-control" placeholder="What the client or educator said about Smart Notes Publication..." required>{{ old('review') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Status') }}:</label>
                            <div>
                                <input type="checkbox" class="switchery" name="is_active" id="is_active" value="1" checked>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Floating Bottom Toolbar -->
            <div class="btn-bottom-toolbar text-right btn-toolbar-container-out">
                <button type="submit" class="btn btn-success"><i class="icon-check position-left"></i>{{ __('Save') }}</button>
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
</script>
@endsection
