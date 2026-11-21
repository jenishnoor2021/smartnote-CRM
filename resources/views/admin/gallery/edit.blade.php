@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">{{ __('Edit Gallery Photo') }}</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('admin.gallery.index') }}">{{ __('Gallery') }}</a></li>
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

    <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal" name="editgalleryform">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">
                            <strong>{{ __('Photo Details') }}</strong>
                        </h5>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>{{ __('Photo Image') }}:</label>
                            @if($gallery->image && file_exists(public_path($gallery->image)))
                                <div style="margin-bottom: 8px;">
                                    <p class="text-muted" style="margin-bottom: 3px;">Current Image:</p>
                                    <img src="{{ asset($gallery->image) }}" alt="{{ $gallery->title }}" style="max-height: 90px; border-radius: 4px; border: 1px solid #ddd; padding: 2px;">
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this);">
                            <div id="image_preview_box" style="margin-top: 10px; display: none;">
                                <p class="text-muted" style="margin-bottom: 3px;">New Image Preview:</p>
                                <img id="image_preview" src="" alt="Preview" style="max-height: 90px; border-radius: 4px; border: 1px solid #ddd; padding: 2px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Photo Title / Caption') }}:</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $gallery->title) }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Album / Category') }}:</label>
                                    <input type="text" name="category" class="form-control" value="{{ old('category', $gallery->category) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Sort Order') }}:</label>
                                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $gallery->sort_order) }}" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Status') }}:</label>
                            <div>
                                <input type="checkbox" class="switchery" name="is_active" id="is_active" value="1" {{ $gallery->is_active ? 'checked' : '' }}>
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
