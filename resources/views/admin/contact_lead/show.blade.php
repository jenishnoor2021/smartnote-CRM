@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">{{ __('Contact Lead Details') }}: #{{ $lead->id }}</span></h4>
        </div>
        <div class="heading-elements">
            <a href="{{ route('admin.contact-lead.index') }}" class="btn btn-default btn-sm"><i class="icon-arrow-left52 position-left"></i> Back to Contact Leads</a>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('admin.contact-lead.index') }}">{{ __('Contact Leads') }}</a></li>
            <li class="active">#{{ $lead->id }}</li>
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

    <form action="{{ route('admin.contact-lead.update_status', $lead->id) }}" method="POST" id="lead_status_form">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-md-7">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title"><strong>Message Details</strong></h5>
                    </div>
                    <div class="panel-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Sender Name:</th>
                                <td><strong>{{ $lead->name }}</strong></td>
                            </tr>
                            <tr>
                                <th>Phone Number:</th>
                                <td>
                                    <a href="tel:{{ $lead->phone }}" class="text-semibold"><i class="icon-phone position-left"></i>{{ $lead->phone }}</a>
                                    <a href="https://wa.me/91{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" target="_blank" class="btn btn-xs btn-success ml-10">
                                        <i class="icon-bubbles position-left"></i> WhatsApp
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Email Address:</th>
                                <td>
                                    @if($lead->email)
                                        <a href="mailto:{{ $lead->email }}"><i class="icon-mail5 position-left"></i>{{ $lead->email }}</a>
                                    @else
                                        <span class="text-muted">Not provided</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Subject:</th>
                                <td>{{ $lead->subject ?? 'General Inquiry' }}</td>
                            </tr>
                            <tr>
                                <th>Source Page:</th>
                                <td><span class="label label-default">{{ $lead->source_page ?? 'Website' }}</span></td>
                            </tr>
                            <tr>
                                <th>Received At:</th>
                                <td>{{ $lead->created_at ? $lead->created_at->format('d-m-Y h:i A') : '-' }}</td>
                            </tr>
                            <tr>
                                <th style="vertical-align: top;">Message:</th>
                                <td>
                                    <div class="well well-sm" style="white-space: pre-line; background-color: #f8fafc;">
                                        {{ $lead->message }}
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title"><strong>Follow-up & Status</strong></h5>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="text-semibold">Lead Status:</label>
                            <select name="status" class="form-control">
                                <option value="new" {{ $lead->status == 'new' ? 'selected' : '' }}>New (Unread / Needs Contact)</option>
                                <option value="contacted" {{ $lead->status == 'contacted' ? 'selected' : '' }}>Contacted (Follow-up done)</option>
                                <option value="closed" {{ $lead->status == 'closed' ? 'selected' : '' }}>Closed / Resolved</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="text-semibold">Internal Notes / Follow-up remarks:</label>
                            <textarea name="notes" rows="6" class="form-control" placeholder="Add remarks about call, discussion, books discussed, etc...">{{ old('notes', $lead->notes) }}</textarea>
                        </div>

                        <div class="text-right">
                            <a href="javascript:delete_lead({{ $lead->id }});" class="btn btn-danger btn-xs">
                                <i class="icon-trash position-left"></i> Delete Lead
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
function delete_lead(id) {
    swal({
        title: "Are you sure you want to delete this lead?",
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
                url: '/admin/contact-lead/' + id,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'DELETE'
                },
                success: function(response) {
                    if (response.status) {
                        swal({
                            title: "Lead deleted successfully.",
                            type: "success",
                            closeOnConfirm: true
                        }, function() {
                            window.location.href = "{{ route('admin.contact-lead.index') }}";
                        });
                    } else {
                        swal({
                            title: "Error",
                            text: response.message || "Could not delete lead",
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
