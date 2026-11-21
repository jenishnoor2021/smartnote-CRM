@extends('layouts.admin')

@section('content')
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4></i> <span class="text-semibold">{{ __('Dashboard') }}</span></h4>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li>
                    <a href="/admin/dashboard"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Page header -->
    <!-- Content area -->
    <div class="content">
      @if (\Session::has('alert'))
        <div class="alert alert-danger p-2">
          {!! \Session::get('alert') !!}
        </div>
      @endif

    </div>
    <!-- /Content area -->
@endsection