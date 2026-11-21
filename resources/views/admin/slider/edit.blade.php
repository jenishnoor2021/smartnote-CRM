@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">{{ __('Edit Slide') }}</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('admin.slider.index') }}">{{ __('Sliders') }}</a></li>
            <li class="active">{{ __('Edit') }}</li>
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

    <form action="{{ route('admin.slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal" name="editsliderform">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">
                            <strong>{{ __('Slide Details') }}</strong>
                        </h5>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <small class="req text-danger">*</small>
                            <label>{{ __('Slide Title') }}:</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $slider->title) }}" required>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Highlight Text / Badge') }}:</label>
                            <input type="text" name="highlight_text" class="form-control" value="{{ old('highlight_text', $slider->highlight_text) }}" placeholder="e.g. 50% Off">
                        </div>

                        <div class="form-group">
                            <label>{{ __('Subtitle / Tagline') }}:</label>
                            <textarea name="subtitle" rows="3" class="form-control">{{ old('subtitle', $slider->subtitle) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Book / Hero Image') }}:</label>
                                    @if($slider->book_image && file_exists(public_path($slider->book_image)))
                                        <div style="margin-bottom: 8px;">
                                            <p class="text-muted" style="margin-bottom: 3px;">Current Image:</p>
                                            <img src="{{ asset($slider->book_image) }}" alt="Preview" style="max-height: 80px; border-radius: 4px; border: 1px solid #ddd; padding: 2px;">
                                        </div>
                                    @endif
                                    <input type="file" name="book_image" class="form-control" accept="image/*" onchange="previewBookImage(this);">
                                    <div id="book_preview_box" style="margin-top: 10px; display: none;">
                                        <p class="text-muted" style="margin-bottom: 3px;">New Image Preview:</p>
                                        <img id="book_preview" src="" alt="Preview" style="max-height: 80px; border-radius: 4px; border: 1px solid #ddd; padding: 2px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Background Banner Image') }}:</label>
                                    @if($slider->bg_image && file_exists(public_path($slider->bg_image)))
                                        <div style="margin-bottom: 8px;">
                                            <p class="text-muted" style="margin-bottom: 3px;">Current Image:</p>
                                            <img src="{{ asset($slider->bg_image) }}" alt="Preview" style="max-height: 80px; border-radius: 4px; border: 1px solid #ddd; padding: 2px;">
                                        </div>
                                    @endif
                                    <input type="file" name="bg_image" class="form-control" accept="image/*" onchange="previewBgImage(this);">
                                    <div id="bg_preview_box" style="margin-top: 10px; display: none;">
                                        <p class="text-muted" style="margin-bottom: 3px;">New Image Preview:</p>
                                        <img id="bg_preview" src="" alt="Preview" style="max-height: 80px; border-radius: 4px; border: 1px solid #ddd; padding: 2px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Button Text') }}:</label>
                                    <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $slider->button_text) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Button URL Link') }}:</label>
                                    <input type="text" name="button_link" class="form-control" value="{{ old('button_link', $slider->button_link) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Sort Order') }}:</label>
                                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $slider->sort_order) }}" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Slider Placement') }}:</label>
                                    <select name="slider_type" class="form-control">
                                        <option value="hero" {{ old('slider_type', $slider->slider_type) == 'hero' ? 'selected' : '' }}>Hero Carousel (Home top)</option>
                                        <option value="banner" {{ old('slider_type', $slider->slider_type) == 'banner' ? 'selected' : '' }}>Promo Banner (Mid page)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Status') }}:</label>
                            <div>
                                <input type="checkbox" class="switchery" name="is_active" id="is_active" value="1" {{ $slider->is_active ? 'checked' : '' }}>
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
function previewBookImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#book_preview').attr('src', e.target.result);
            $('#book_preview_box').show();
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        $('#book_preview_box').hide();
    }
}

function previewBgImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#bg_preview').attr('src', e.target.result);
            $('#bg_preview_box').show();
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        $('#bg_preview_box').hide();
    }
}
</script>
@endsection
