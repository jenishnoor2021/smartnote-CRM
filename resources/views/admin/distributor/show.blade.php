@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">{{ __('Distributor Application Details') }}: #{{ $application->id }}</span></h4>
        </div>
        <div class="heading-elements">
            <a href="{{ route('admin.distributor.index') }}" class="btn btn-default btn-sm"><i class="icon-arrow-left52 position-left"></i> Back to Applications</a>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('admin.distributor.index') }}">{{ __('Distributor Applications') }}</a></li>
            <li class="active">#{{ $application->id }}</li>
        </ul>
    </div>
</div>

<div class="content">

    @if(session('success'))
        <div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.distributor.update_status', $application->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-md-7">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title"><strong>Applicant / Firm Profile</strong></h5>
                    </div>
                    <div class="panel-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="35%">Trader / Contact Name:</th>
                                <td><strong>{{ $application->trader_name }}</strong></td>
                            </tr>
                            <tr>
                                <th>Firm / Shop Name:</th>
                                <td><strong>{{ $application->firm_name ?? '-' }}</strong></td>
                            </tr>
                            <tr>
                                <th>Phone Number:</th>
                                <td>
                                    <a href="tel:{{ $application->phone }}" class="text-semibold"><i class="icon-phone position-left"></i>{{ $application->phone }}</a>
                                    <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $application->phone) }}" target="_blank" class="btn btn-xs btn-success ml-10">
                                        <i class="icon-bubbles position-left"></i> WhatsApp
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Email Address:</th>
                                <td>
                                    @if($application->email)
                                        <a href="mailto:{{ $application->email }}"><i class="icon-mail5 position-left"></i>{{ $application->email }}</a>
                                    @else
                                        <span class="text-muted">Not provided</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>City / Location:</th>
                                <td><strong class="text-primary">{{ $application->city }}</strong></td>
                            </tr>
                            <tr>
                                <th>Full Address:</th>
                                <td>{{ $application->address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Business Type:</th>
                                <td>{{ $application->business_type ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Experience in Book Trading:</th>
                                <td>{{ $application->experience_years ? $application->experience_years . ' Years' : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Current Brands / Publishers:</th>
                                <td>{{ $application->current_brands ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>GST / Tax Number:</th>
                                <td>{{ $application->gst_number ?? 'Not provided' }}</td>
                            </tr>
                            <tr>
                                <th>Applied On:</th>
                                <td>{{ $application->created_at ? $application->created_at->format('d-m-Y h:i A') : '-' }}</td>
                            </tr>
                            @if($application->message)
                            <tr>
                                <th style="vertical-align: top;">Applicant Note:</th>
                                <td>
                                    <div class="well well-sm" style="white-space: pre-line; background-color: #f8fafc;">
                                        {{ $application->message }}
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title"><strong>Application Status & Admin Action</strong></h5>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="text-semibold">Status:</label>
                            <select name="status" class="form-control">
                                <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending (Under Review)</option>
                                <option value="contacted" {{ $application->status == 'contacted' ? 'selected' : '' }}>Contacted (Follow-up In Progress)</option>
                                <option value="approved" {{ $application->status == 'approved' ? 'selected' : '' }}>Approved (Appointed Distributor)</option>
                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="text-semibold">Admin Internal Notes:</label>
                            <textarea name="notes" rows="6" class="form-control" placeholder="Notes on terms, commission, territory, conversation details...">{{ old('notes', $application->notes) }}</textarea>
                        </div>

                        <div class="text-right">
                            <a href="javascript:delete_application({{ $application->id }});" class="btn btn-danger btn-xs">
                                <i class="icon-trash position-left"></i> Delete Application
                            </a>
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
function delete_application(id) {
    swal({
        title: "Are you sure you want to delete this application?",
        text: "You will not be able to recover this record after deletion.",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "No, Cancel It",
        confirmButtonText: "Yes, I am sure",
        confirmButtonColor: "#EF5350",
        closeOnConfirm: false
    },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: '/admin/distributor-application/' + id,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'DELETE'
                },
                success: function(response) {
                    if (response.status) {
                        swal({
                            title: "Application deleted successfully.",
                            type: "success",
                            closeOnConfirm: true
                        }, function() {
                            window.location.href = "{{ route('admin.distributor.index') }}";
                        });
                    } else {
                        swal({
                            title: "Error",
                            text: response.message || "Could not delete application",
                            type: "error",
                            closeOnConfirm: true
                        });
                    }
                },
                error: function() {
                    jGrowlAlert("An error occurred", 'error');
                }
            });
        }
    });
}
</script>
@endsection
