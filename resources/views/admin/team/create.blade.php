@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">{{ __('ADD Team Member') }}</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('admin.team.index') }}">{{ __('Team Members') }}</a></li>
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

    <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data" class="form-horizontal" name="addteamform">
        @csrf
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">
                            <strong>{{ __('Member Details') }}</strong>
                        </h5>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <small class="req text-danger">*</small>
                            <label>{{ __('Full Name') }}:</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Mr. Sanjaybhai Baldaniya" required>
                        </div>

                        <div class="form-group">
                            <small class="req text-danger">*</small>
                            <label>{{ __('Designation / Role') }}:</label>
                            <input type="text" name="designation" class="form-control" value="{{ old('designation') }}" placeholder="e.g. Chairman & Managing Director" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Phone Number') }}:</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="e.g. (+91) 98241-45453">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Email Address') }}:</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="e.g. info@smartnotes.com">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Profile Photo') }}:</label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this);">
                            <div id="image_preview_box" style="margin-top: 10px; display: none;">
                                <img id="image_preview" src="" alt="Preview" style="max-height: 100px; border-radius: 4px; border: 1px solid #ddd; padding: 4px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Bio / Description / Perspective') }}:</label>
                            <textarea name="bio" rows="4" class="form-control" placeholder="Short biography or perspective quote...">{{ old('bio') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Sort Order') }}:</label>
                                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('LinkedIn URL') }}:</label>
                                    <input type="text" name="linkedin" class="form-control" value="{{ old('linkedin') }}" placeholder="https://linkedin.com/in/...">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Leadership Member (Chairman / Executive Desk)') }}:</label>
                                    <div>
                                        <input type="checkbox" class="switchery" name="is_leadership" id="is_leadership" value="1" {{ old('is_leadership') ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Status') }}:</label>
                                    <div>
                                        <input type="checkbox" class="switchery" name="is_active" id="is_active" value="1" checked>
                                    </div>
                                </div>
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
