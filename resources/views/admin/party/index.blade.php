@extends('layouts.admin')
@section('content')
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">{{ __('Party') }}</span>
            </h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li>
                <a href="/admin/dashboard"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a>
            </li>
            <li class="active">{{ __('Party') }}</li>
        </ul>
    </div>
</div>

<div class="content">

    <div class="panel panel-flat">

        <div class="panel-heading">
            <a href="{{route('admin.party.create')}}" class="btn btn-primary btn-sm">Add New <i class="icon-plus-circle2 position-right"></i></a>
            <a href="javascript:delete_selected();" class="btn btn-danger" id="delete_selected">Delete Selected<i class=" icon-trash position-right"></i></a>
        </div>

        <div class="panel-body table-responsive">
            <table id="party_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="2%">
                            <input type="checkbox" name="select_all" id="select_all" class="styled" onclick="select_all(this);">
                        </th>
                        <th>Actions</th>
                        <th>Party id</th>
                        <th>First name</th>
                        <th>Last Name</th>
                        <th>Party code</th>
                        <th>Address</th>
                        <th>Mobile no</th>
                        <th>GST no</th>
                        <th>Active/De-active</th>
                        {{-- <th width="82%">{{ __('Name') }}</th>
                        <th width="8%" class="text-center">{{ __('Status') }}</th>
                        <th width="8%" class="text-center">{{ __('Actions') }}</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($partys as $party)
                    <tr>
                        <td>
                            <input type="checkbox" class="checkbox styled" name="delete" id="{{ $party->id }}">
                        </td>
                        <td class="text-center">
                            <a data-popup="tooltip" data-placement="top" title="Edit'" href="{{route('admin.party.edit', $party->id)}}" id="{{$party->id}}" class="text-info">
                                <i class="icon-pencil7"></i>
                            </a>
                            <a data-popup="tooltip" data-placement="top" title="Delete" href="javascript:delete_record(<?php echo $party->id; ?>);" class="text-danger delete" id="{{$party->id}}">
                                <i class=" icon-trash"></i>
                            </a>
                        </td>
                        <td>{{$party->id}}</td>
                        <td>{{$party->fname}}</td>
                        <td>{{$party->lname}}</td>
                        <td>{{$party->party_code}}</td>
                        <td>@if(strlen($party->address) > 40)
                            {!!substr($party->address,0,40)!!}
                            <span class="read-more-show hide_content">More<i class="fa fa-angle-down"></i></span>
                            <span class="read-more-content"> {{substr($party->address,40,strlen($party->address))}}
                                <span class="read-more-hide hide_content">Less <i class="fa fa-angle-up"></i></span> </span>
                            @else
                            {{$party->address}}
                            @endif
                        </td>
                        <td>{{$party->mobile}}</td>
                        <td>{{$party->gst_no}}</td>
                        <td class="text-center switchery-sm">
                            <input type="checkbox" onchange="change_status(this);" class="switchery"
                                id="{{ $party->id }}" {{ $party->is_active == 1 ? 'checked' : '' }}>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if(method_exists($partys, 'links'))
                {{ $partys->links() }}
            @endif
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $(function() {

        $('#party_table').DataTable({
            'columnDefs': [{
                'targets': [0, 1],
                /* column index */
                'orderable': false,
                /* disable sorting */
            }],

        });

        //add class to style datatable select box
        $('div.dataTables_length select').addClass('datatable-select');
    });

    /**
     * Change status when clicked on the status switch
     *
     * @param {obj}  obj  The object
     */
    function change_status(obj) {
        var checked = 0;

        if (obj.checked) {
            checked = 1;
        }

        $.ajax({
            url: '/admin/party/update_status',
            type: 'POST',
            data: {
                party_id: obj.id,
                is_active: checked,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status) {
                    swal({
                        title: response.message,
                        type: "success",
                    });
                } else {
                    swal({
                        title: "Failed to update status",
                        type: "error",
                    });
                }
            },
            error: function(xhr) {
                jGrowlAlert("An error occurred", 'error');
            }
        });
    }

    /**
     * Deletes a single record when clicked on delete icon
     *
     * @param {int}  id  The identifier
     */
    function delete_record(id) {
        swal({
                title: "Are you sure you want to delete this record?",
                text: "You will not be able to recover this record after deletion.",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "No, Cancel It",
                confirmButtonText: "Yes, I am sure",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    url: '/admin/party/destroy/' + id,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if (response.status) {
                            $("#" + id).closest("tr").remove();
                            swal({
                                title: "Party deleted successfully.",
                                type: "success",
                                closeOnConfirm: true
                            }, function() {
                                swal.close();
                            });
                        } else {
                            swal({
                                title: response.message || "You do not have enough permissions to access this page. Please contact to your Administrator.",
                                type: "error",
                                closeOnConfirm: true
                            });
                        }
                    },
                    error: function(xhr) {
                        jGrowlAlert("An error occurred", 'error');
                    },
                });
            });
    }

    /**
     * Deletes all the selected records when clicked on DELETE SELECTED button
     */
    function delete_selected() {
        var party_ids = [];

        $(".checkbox:checked").each(function() {
            var id = $(this).attr('id');
            party_ids.push(id);
        });
        if (party_ids.length === 0) {
            jGrowlAlert("Please select some records to delete.", 'danger');
            return;
        }
        swal({
                title: "Are you sure you want to delete selected records?",
                text: "You will not be able to recover these records after deletion.",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "No, Cancel It",
                confirmButtonText: "Yes, I am sure",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    url: '/admin/party/delete_selected',
                    type: 'POST',
                    data: {
                        ids: party_ids,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status) {
                            $(party_ids).each(function(index, element) {
                                $("#" + element).closest("tr").remove();
                            });
                            swal({
                                title: "Party deleted successfully.",
                                type: "success",
                                closeOnConfirm: true
                            }, function() {
                                swal.close();
                            });
                        } else {
                            swal({
                                title: response.message || "You do not have enough permissions to access this page. Please contact to your Administrator.",
                                type: "error",
                                closeOnConfirm: true
                            });
                        }
                    },
                    error: function(xhr) {
                        jGrowlAlert("An error occurred", 'error');
                    }
                });
            });
    }
</script>
@endsection