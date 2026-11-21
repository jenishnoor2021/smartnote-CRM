@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">{{ __('Edit Service') }}</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('admin.service.index') }}">{{ __('Services') }}</a></li>
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

    <form action="{{ route('admin.service.update', $service->id) }}" method="POST" class="form-horizontal" name="editserviceform">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">
                            <strong>{{ __('Service Details') }}</strong>
                        </h5>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <small class="req text-danger">*</small>
                            <label>{{ __('Service Title') }}:</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $service->title) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Icon Class (Icomoon / FontAwesome)') }}:</label>
                                    <input type="text" name="icon" class="form-control" value="{{ old('icon', $service->icon) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Sort Order') }}:</label>
                                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $service->sort_order) }}" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Short Description') }}:</label>
                            <textarea name="short_description" rows="3" class="form-control">{{ old('short_description', $service->short_description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Full Content / Details') }}:</label>
                            <textarea name="content" rows="5" class="form-control">{{ old('content', $service->content) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Key Features / Offerings (One per line)') }}:</label>
                            <textarea name="features" rows="4" class="form-control">{{ old('features', is_array($service->features) ? implode("\n", $service->features) : $service->features) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Status') }}:</label>
                            <div>
                                <input type="checkbox" class="switchery" name="is_active" id="is_active" value="1" {{ $service->is_active ? 'checked' : '' }}>
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
