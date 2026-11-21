@extends('layouts.admin')

@section('content')
    <style>
        .sn-stat-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 18px 20px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }
        .sn-stat-card:hover {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }
        .sn-stat-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
        }
        .sn-stat-primary::before { background: #084b87; }
        .sn-stat-teal::before { background: #009688; }
        .sn-stat-success::before { background: #4caf50; }
        .sn-stat-warning::before { background: #ff9800; }
        .sn-stat-danger::before { background: #f44336; }
        .sn-stat-purple::before { background: #7c4dff; }

        .sn-stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            float: right;
        }
        .sn-icon-primary { background: #e8f0fe; color: #084b87; }
        .sn-icon-teal { background: #e0f2f1; color: #00897b; }
        .sn-icon-success { background: #e8f5e9; color: #2e7d32; }
        .sn-icon-warning { background: #fff3e0; color: #ef6c00; }
        .sn-icon-danger { background: #ffebee; color: #c62828; }
        .sn-icon-purple { background: #ede7f6; color: #5e35b1; }

        .sn-stat-value {
            font-size: 26px;
            font-weight: 700;
            color: #1e293b;
            margin-top: 4px;
            margin-bottom: 2px;
            letter-spacing: -0.5px;
        }
        .sn-stat-label {
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .sn-stat-sub {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px dashed #f1f5f9;
        }

        .sn-quick-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.2s ease;
            text-decoration: none !important;
            margin-left: 6px;
            margin-bottom: 6px;
        }
        .sn-quick-btn:hover {
            box-shadow: 0 3px 8px rgba(0,0,0,0.12);
            transform: translateY(-1px);
        }

        .sn-pipeline-pill {
            padding: 8px 12px;
            border-radius: 6px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .sn-badge-soft-primary { background: #e8f0fe; color: #084b87; font-weight: 600; }
        .sn-badge-soft-warning { background: #fff3e0; color: #ef6c00; font-weight: 600; }
        .sn-badge-soft-info { background: #e0f7fa; color: #00838f; font-weight: 600; }
        .sn-badge-soft-success { background: #e8f5e9; color: #2e7d32; font-weight: 600; }
        .sn-badge-soft-danger { background: #ffebee; color: #c62828; font-weight: 600; }

        .sn-table th {
            background-color: #f8fafc !important;
            color: #475569 !important;
            font-weight: 600 !important;
            font-size: 12px !important;
            text-transform: uppercase !important;
            border-bottom: 2px solid #e2e8f0 !important;
        }
        .sn-table td {
            vertical-align: middle !important;
            font-size: 13px !important;
        }
    </style>

    <!-- Page Header -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title" style="padding: 16px 0;">
                <div class="pull-right">
                    <a href="{{ route('admin.inquiry.create') }}" class="btn btn-primary sn-quick-btn">
                        <i class="icon-plus22 position-left"></i> {{ __('New Inquiry') }}
                    </a>
                    @if($isSuperAdmin)
                        <a href="{{ route('admin.product.create') }}" class="btn btn-default sn-quick-btn" style="border: 1px solid #cbd5e1;">
                            <i class="icon-books position-left"></i> {{ __('Add Book') }}
                        </a>
                    @endif
                    <a href="{{ url('/') }}" target="_blank" class="btn btn-default sn-quick-btn" style="border: 1px solid #cbd5e1;" title="Preview Storefront">
                        <i class="icon-eye position-left"></i> {{ __('View Website') }}
                    </a>
                </div>
                <h4>
                    <span class="text-semibold">{{ __('Dashboard') }}</span>
                    <small class="display-block" style="margin-top: 4px; color: #64748b;">
                        {{ __('Welcome back') }}, <strong>{{ Auth::user()->name ?? 'User' }}</strong> &nbsp;|&nbsp; 
                        <i class="icon-calendar52 position-left" style="font-size: 12px;"></i>{{ \Carbon\Carbon::now()->format('l, d F Y') }}
                    </small>
                </h4>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a>
                </li>
            </ul>
            <ul class="breadcrumb-elements">
                <li>
                    <span class="text-muted" style="padding: 8px 15px; display: inline-block;">
                        Role: <span class="label {{ $isSuperAdmin ? 'label-danger' : 'label-success' }}">{{ $isSuperAdmin ? 'Super Admin' : 'Seller' }}</span>
                    </span>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Page Header -->

    <!-- Content Area -->
    <div class="content">

        @if (\Session::has('alert'))
            <div class="alert alert-danger alert-styled-left alert-arrow-left alert-bordered">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                {!! \Session::get('alert') !!}
            </div>
        @endif

        @if (\Session::has('success'))
            <div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                {!! \Session::get('success') !!}
            </div>
        @endif

        <!-- TOP 4 KPI METRIC CARDS -->
        <div class="row">
            
            <!-- Card 1: Total Orders -->
            <div class="col-sm-6 col-md-3">
                <div class="sn-stat-card sn-stat-primary">
                    <div class="sn-stat-icon sn-icon-primary">
                        <i class="icon-cart5"></i>
                    </div>
                    <div class="sn-stat-label">{{ __('Total Orders') }}</div>
                    <div class="sn-stat-value">{{ number_format($totalOrders) }}</div>
                    <div class="sn-stat-sub">
                        <span class="text-semibold text-primary">₹{{ number_format($totalOrderValue, 2) }}</span> Total Value
                        <div class="text-muted" style="margin-top: 3px;">
                            Today: <strong>{{ $ordersToday }}</strong> &bull; Pending: <strong>{{ $orderStatusCounts['pending'] }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Product Inquiries -->
            <div class="col-sm-6 col-md-3">
                <div class="sn-stat-card sn-stat-teal">
                    <div class="sn-stat-icon sn-icon-teal">
                        <i class="icon-bubbles4"></i>
                    </div>
                    <div class="sn-stat-label">{{ __('Inquiries Pipeline') }}</div>
                    <div class="sn-stat-value">{{ number_format($totalInquiries) }}</div>
                    <div class="sn-stat-sub">
                        <span class="text-semibold text-teal-700">{{ $inquiryStatusCounts['pending'] }} Pending Follow-up</span>
                        <div class="text-muted" style="margin-top: 3px;">
                            Today: <strong>{{ $inquiriesToday }}</strong> &bull; Converted: <strong>{{ $inquiryStatusCounts['converted'] }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Paid Revenue -->
            <div class="col-sm-6 col-md-3">
                <div class="sn-stat-card sn-stat-success">
                    <div class="sn-stat-icon sn-icon-success">
                        <i class="icon-cash3"></i>
                    </div>
                    <div class="sn-stat-label">{{ __('Paid Revenue') }}</div>
                    <div class="sn-stat-value">₹{{ number_format($totalRevenue, 2) }}</div>
                    <div class="sn-stat-sub">
                        <span class="text-semibold text-success-700">{{ $orderStatusCounts['delivered'] }} Delivered</span>
                        <div class="text-muted" style="margin-top: 3px;">
                            Processing: <strong>{{ $orderStatusCounts['processing'] + $orderStatusCounts['confirmed'] }}</strong> &bull; In-Transit
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Catalog & Inventory or Seller Stats -->
            <div class="col-sm-6 col-md-3">
                @if($isSuperAdmin)
                    <div class="sn-stat-card sn-stat-warning">
                        <div class="sn-stat-icon sn-icon-warning">
                            <i class="icon-books"></i>
                        </div>
                        <div class="sn-stat-label">{{ __('Book Catalog') }}</div>
                        <div class="sn-stat-value">{{ number_format($totalProducts) }} <small style="font-size: 14px; font-weight: normal; color: #64748b;">Books</small></div>
                        <div class="sn-stat-sub">
                            <span>{{ $totalCategories }} Categories &bull; {{ $totalSubcategories }} Subcategories</span>
                            <div class="text-muted" style="margin-top: 3px;">
                                @if($lowStockProducts > 0)
                                    <span class="text-danger text-semibold"><i class="icon-warning22 position-left"></i>{{ $lowStockProducts }} Low Stock</span>
                                @else
                                    <span class="text-success"><i class="icon-checkmark4 position-left"></i>Stock Healthy</span>
                                @endif
                                &bull; Coupons: <strong>{{ $activeCoupons }}</strong>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="sn-stat-card sn-stat-purple">
                        <div class="sn-stat-icon sn-icon-purple">
                            <i class="icon-user-check"></i>
                        </div>
                        <div class="sn-stat-label">{{ __('Conversion Rate') }}</div>
                        @php
                            $convRate = $totalInquiries > 0 ? round(($inquiryStatusCounts['converted'] / $totalInquiries) * 100, 1) : 0;
                        @endphp
                        <div class="sn-stat-value">{{ $convRate }}%</div>
                        <div class="sn-stat-sub">
                            <span><strong>{{ $inquiryStatusCounts['converted'] }}</strong> Converted Orders</span>
                            <div class="text-muted" style="margin-top: 3px;">
                                Out of <strong>{{ $totalInquiries }}</strong> assigned inquiries
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
        <!-- /TOP 4 KPI METRIC CARDS -->

        <!-- SUPERADMIN LEADS BAR -->
        @if($isSuperAdmin)
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-flat" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div class="panel-body" style="padding: 14px 20px;">
                            <div class="row">
                                <div class="col-sm-3 col-xs-6 text-center" style="border-right: 1px solid #f1f5f9;">
                                    <a href="{{ route('admin.contact-lead.index') }}" style="color: inherit; text-decoration: none;">
                                        <div class="text-muted text-size-small"><i class="icon-envelop5 position-left text-primary"></i>Website Contact Leads</div>
                                        <h4 class="no-margin text-semibold" style="margin-top: 4px;">{{ $totalContactLeads }}</h4>
                                        <span class="badge badge-primary" style="margin-top: 3px;">{{ $newContactLeads }} New</span>
                                    </a>
                                </div>
                                <div class="col-sm-3 col-xs-6 text-center" style="border-right: 1px solid #f1f5f9;">
                                    <a href="{{ route('admin.distributor.index') }}" style="color: inherit; text-decoration: none;">
                                        <div class="text-muted text-size-small"><i class="icon-address-book position-left text-warning"></i>Distributor Applications</div>
                                        <h4 class="no-margin text-semibold" style="margin-top: 4px;">{{ $totalDistributorApps }}</h4>
                                        <span class="badge badge-warning" style="margin-top: 3px;">{{ $pendingDistributorApps }} Pending Review</span>
                                    </a>
                                </div>
                                <div class="col-sm-3 col-xs-6 text-center" style="border-right: 1px solid #f1f5f9;">
                                    <a href="{{ route('admin.newsletter.index') }}" style="color: inherit; text-decoration: none;">
                                        <div class="text-muted text-size-small"><i class="icon-mail-read position-left text-teal"></i>Newsletter Subscribers</div>
                                        <h4 class="no-margin text-semibold" style="margin-top: 4px;">{{ $totalNewsletterSubs }}</h4>
                                        <span class="badge badge-teal" style="margin-top: 3px;">Active Readers</span>
                                    </a>
                                </div>
                                <div class="col-sm-3 col-xs-6 text-center">
                                    <a href="{{ route('admin.seller.index') }}" style="color: inherit; text-decoration: none;">
                                        <div class="text-muted text-size-small"><i class="icon-users4 position-left text-indigo"></i>Sales Reps / Sellers</div>
                                        <h4 class="no-margin text-semibold" style="margin-top: 4px;">{{ $totalSellers }}</h4>
                                        <span class="badge badge-default" style="margin-top: 3px;">Active Team</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- /SUPERADMIN LEADS BAR -->

        <!-- PIPELINE STATUS BREAKDOWN (2 Columns) -->
        <div class="row">
            
            <!-- Inquiries Funnel -->
            <div class="col-md-6">
                <div class="panel panel-flat" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                    <div class="panel-heading" style="border-bottom: 1px solid #f1f5f9; padding: 14px 20px;">
                        <div class="pull-right">
                            <a href="{{ route('admin.inquiry.index') }}" class="text-semibold text-primary text-size-small">
                                {{ __('View All Inquiries') }} <i class="icon-arrow-right14 position-right"></i>
                            </a>
                        </div>
                        <h6 class="panel-title text-semibold">
                            <i class="icon-filter4 position-left text-teal"></i> {{ __('Inquiry Pipeline Overview') }}
                        </h6>
                    </div>
                    <div class="panel-body" style="padding: 16px 20px;">
                        <div class="sn-pipeline-pill">
                            <span><span class="badge badge-warning" style="margin-right: 8px;">Pending</span> New inquiries awaiting initial contact</span>
                            <strong class="text-warning-800" style="font-size: 15px;">{{ $inquiryStatusCounts['pending'] }}</strong>
                        </div>
                        <div class="sn-pipeline-pill">
                            <span><span class="badge badge-info" style="margin-right: 8px;">Contacted</span> Customer contacted, discussion active</span>
                            <strong class="text-info-800" style="font-size: 15px;">{{ $inquiryStatusCounts['contacted'] }}</strong>
                        </div>
                        <div class="sn-pipeline-pill">
                            <span><span class="badge badge-primary" style="margin-right: 8px;">Confirmed</span> Requirements &amp; quotation agreed</span>
                            <strong class="text-primary-800" style="font-size: 15px;">{{ $inquiryStatusCounts['confirmed'] }}</strong>
                        </div>
                        <div class="sn-pipeline-pill">
                            <span><span class="badge badge-success" style="margin-right: 8px;">Converted</span> Successfully converted to Customer Order</span>
                            <strong class="text-success-800" style="font-size: 15px;">{{ $inquiryStatusCounts['converted'] }}</strong>
                        </div>
                        <div class="sn-pipeline-pill" style="margin-bottom: 0;">
                            <span><span class="badge badge-danger" style="margin-right: 8px;">Cancelled</span> Inquiries closed or dropped</span>
                            <strong class="text-danger-800" style="font-size: 15px;">{{ $inquiryStatusCounts['cancelled'] }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Fulfillment Funnel -->
            <div class="col-md-6">
                <div class="panel panel-flat" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                    <div class="panel-heading" style="border-bottom: 1px solid #f1f5f9; padding: 14px 20px;">
                        <div class="pull-right">
                            <a href="{{ route('admin.order.index') }}" class="text-semibold text-primary text-size-small">
                                {{ __('View All Orders') }} <i class="icon-arrow-right14 position-right"></i>
                            </a>
                        </div>
                        <h6 class="panel-title text-semibold">
                            <i class="icon-truck position-left text-primary"></i> {{ __('Order Fulfillment Status') }}
                        </h6>
                    </div>
                    <div class="panel-body" style="padding: 16px 20px;">
                        <div class="sn-pipeline-pill">
                            <span><span class="badge badge-warning" style="margin-right: 8px;">Pending</span> New orders awaiting warehouse dispatch</span>
                            <strong class="text-warning-800" style="font-size: 15px;">{{ $orderStatusCounts['pending'] }}</strong>
                        </div>
                        <div class="sn-pipeline-pill">
                            <span><span class="badge badge-info" style="margin-right: 8px;">Confirmed</span> Confirmed by customer &amp; validated</span>
                            <strong class="text-info-800" style="font-size: 15px;">{{ $orderStatusCounts['confirmed'] }}</strong>
                        </div>
                        <div class="sn-pipeline-pill">
                            <span><span class="badge badge-primary" style="margin-right: 8px;">Processing</span> Packing &amp; shipping preparation</span>
                            <strong class="text-primary-800" style="font-size: 15px;">{{ $orderStatusCounts['processing'] }}</strong>
                        </div>
                        <div class="sn-pipeline-pill">
                            <span><span class="badge badge-success" style="margin-right: 8px;">Delivered</span> Completed and received by customer</span>
                            <strong class="text-success-800" style="font-size: 15px;">{{ $orderStatusCounts['delivered'] }}</strong>
                        </div>
                        <div class="sn-pipeline-pill" style="margin-bottom: 0;">
                            <span><span class="badge badge-danger" style="margin-right: 8px;">Cancelled</span> Orders cancelled or returned</span>
                            <strong class="text-danger-800" style="font-size: 15px;">{{ $orderStatusCounts['cancelled'] }}</strong>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /PIPELINE STATUS BREAKDOWN -->

        <!-- RECENT ACTIVITY TABLES (2 Columns) -->
        <div class="row">
            
            <!-- Recent Orders Table -->
            <div class="col-md-6">
                <div class="panel panel-flat" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                    <div class="panel-heading" style="border-bottom: 1px solid #f1f5f9; padding: 14px 20px;">
                        <div class="pull-right">
                            <a href="{{ route('admin.order.index') }}" class="btn btn-default btn-xs">
                                {{ __('View All') }} ({{ $totalOrders }})
                            </a>
                        </div>
                        <h6 class="panel-title text-semibold">
                            <i class="icon-cart5 position-left text-primary"></i> {{ __('Recent Orders') }}
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover sn-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Order No') }}</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="text-center">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.order.show', $order->id) }}" class="text-semibold text-primary">
                                                #{{ $order->order_no }}
                                            </a>
                                            <div class="text-muted text-size-mini">
                                                {{ $order->created_at->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-semibold">{{ $order->customer_name }}</div>
                                            <div class="text-muted text-size-mini">
                                                {{ $order->customer_phone }} {{ $order->city ? '· ' . $order->city : '' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-semibold text-slate-800">₹{{ number_format($order->total_amount, 2) }}</div>
                                            @if($order->payment_status === 'paid')
                                                <span class="badge badge-success text-size-mini">Paid</span>
                                            @elseif($order->payment_status === 'link_sent')
                                                <span class="badge badge-info text-size-mini">Link Sent</span>
                                            @else
                                                <span class="badge badge-warning text-size-mini">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'label-warning',
                                                    'confirmed' => 'label-info',
                                                    'processing' => 'label-primary',
                                                    'delivered' => 'label-success',
                                                    'cancelled' => 'label-danger',
                                                ];
                                                $lblClass = $statusClasses[$order->order_status] ?? 'label-default';
                                            @endphp
                                            <span class="label {{ $lblClass }}">{{ ucfirst($order->order_status) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-default btn-xs" title="View Order">
                                                <i class="icon-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4" style="padding: 25px;">
                                            <i class="icon-cart-empty text-muted" style="font-size: 32px; display: block; margin-bottom: 6px;"></i>
                                            {{ __('No orders placed yet.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Inquiries Table -->
            <div class="col-md-6">
                <div class="panel panel-flat" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                    <div class="panel-heading" style="border-bottom: 1px solid #f1f5f9; padding: 14px 20px;">
                        <div class="pull-right">
                            <a href="{{ route('admin.inquiry.index') }}" class="btn btn-default btn-xs">
                                {{ __('View All') }} ({{ $totalInquiries }})
                            </a>
                        </div>
                        <h6 class="panel-title text-semibold">
                            <i class="icon-bubbles4 position-left text-teal"></i> {{ __('Recent Inquiries') }}
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover sn-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Inquiry No') }}</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Assigned To') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="text-center">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentInquiries as $inq)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.inquiry.show', $inq->id) }}" class="text-semibold text-teal-700">
                                                #{{ $inq->inquiry_no }}
                                            </a>
                                            <div class="text-muted text-size-mini">
                                                {{ $inq->created_at->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-semibold">{{ $inq->customer_name }}</div>
                                            <div class="text-muted text-size-mini">
                                                {{ $inq->customer_phone }} {{ $inq->city ? '· ' . $inq->city : '' }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($inq->assignedSeller)
                                                <span class="label label-default"><i class="icon-user position-left text-size-mini"></i>{{ $inq->assignedSeller->name }}</span>
                                            @else
                                                <span class="text-muted text-size-small"><i class="icon-warning22 text-warning position-left"></i>Unassigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $inqClasses = [
                                                    'pending' => 'label-warning',
                                                    'contacted' => 'label-info',
                                                    'confirmed' => 'label-primary',
                                                    'converted' => 'label-success',
                                                    'cancelled' => 'label-danger',
                                                ];
                                                $inqLbl = $inqClasses[$inq->status] ?? 'label-default';
                                            @endphp
                                            <span class="label {{ $inqLbl }}">{{ ucfirst($inq->status) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.inquiry.show', $inq->id) }}" class="btn btn-default btn-xs" title="View Inquiry">
                                                <i class="icon-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4" style="padding: 25px;">
                                            <i class="icon-bubble-empty text-muted" style="font-size: 32px; display: block; margin-bottom: 6px;"></i>
                                            {{ __('No inquiries received yet.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /RECENT ACTIVITY TABLES -->

        <!-- SUPERADMIN EXTRA SECTION (Leads & Low Stock Alerts) -->
        @if($isSuperAdmin)
            <div class="row">
                
                <!-- Website Contact Leads & Distributor Apps -->
                <div class="col-md-6">
                    <div class="panel panel-flat" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div class="panel-heading" style="border-bottom: 1px solid #f1f5f9; padding: 14px 20px;">
                            <div class="pull-right">
                                <a href="{{ route('admin.contact-lead.index') }}" class="btn btn-default btn-xs" style="margin-right: 4px;">Leads</a>
                                <a href="{{ route('admin.distributor.index') }}" class="btn btn-default btn-xs">Distributors</a>
                            </div>
                            <h6 class="panel-title text-semibold">
                                <i class="icon-envelop5 position-left text-primary"></i> {{ __('Recent Website Leads & Applications') }}
                            </h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover sn-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Sender') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Subject / Firm') }}</th>
                                        <th>{{ __('Date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $combinedLeads = collect();
                                        foreach($recentLeads as $l) {
                                            $combinedLeads->push([
                                                'id' => $l->id,
                                                'name' => $l->name,
                                                'phone' => $l->phone,
                                                'type' => 'Contact Lead',
                                                'detail' => $l->subject ?: 'General Inquiry',
                                                'created_at' => $l->created_at,
                                                'link' => route('admin.contact-lead.index'),
                                                'badge' => 'label-primary'
                                            ]);
                                        }
                                        foreach($recentDistributorApps as $d) {
                                            $combinedLeads->push([
                                                'id' => $d->id,
                                                'name' => $d->trader_name,
                                                'phone' => $d->phone,
                                                'type' => 'Distributor',
                                                'detail' => $d->firm_name ?: $d->city,
                                                'created_at' => $d->created_at,
                                                'link' => route('admin.distributor.index'),
                                                'badge' => 'label-warning'
                                            ]);
                                        }
                                        $combinedLeads = $combinedLeads->sortByDesc('created_at')->take(5);
                                    @endphp

                                    @forelse($combinedLeads as $cLead)
                                        <tr>
                                            <td>
                                                <a href="{{ $cLead['link'] }}" class="text-semibold text-slate-800">
                                                    {{ $cLead['name'] }}
                                                </a>
                                                <div class="text-muted text-size-mini">{{ $cLead['phone'] }}</div>
                                            </td>
                                            <td>
                                                <span class="label {{ $cLead['badge'] }}">{{ $cLead['type'] }}</span>
                                            </td>
                                            <td>
                                                <span class="text-size-small">{{ \Illuminate\Support\Str::limit($cLead['detail'], 30) }}</span>
                                            </td>
                                            <td class="text-muted text-size-mini">
                                                {{ $cLead['created_at']->diffForHumans() }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted" style="padding: 20px;">
                                                {{ __('No recent leads or applications.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Inventory Alert -->
                <div class="col-md-6">
                    <div class="panel panel-flat" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div class="panel-heading" style="border-bottom: 1px solid #f1f5f9; padding: 14px 20px;">
                            <div class="pull-right">
                                <a href="{{ route('admin.product.index') }}" class="btn btn-default btn-xs">
                                    {{ __('Manage Products') }}
                                </a>
                            </div>
                            <h6 class="panel-title text-semibold">
                                <i class="icon-alert position-left text-danger"></i> {{ __('Inventory & Low Stock Alerts') }}
                            </h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover sn-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Book Name') }}</th>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Stock Status') }}</th>
                                        <th class="text-center">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($stockAlertProducts as $prod)
                                        <tr>
                                            <td>
                                                <div class="text-semibold text-slate-800">
                                                    {{ \Illuminate\Support\Str::limit($prod->product_name, 35) }}
                                                </div>
                                                <div class="text-muted text-size-mini">
                                                    Class: {{ $prod->standard_class ?? 'N/A' }} · {{ $prod->medium ?? 'English' }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted text-size-small">{{ $prod->category->category_name ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <strong>₹{{ number_format($prod->selling_price, 2) }}</strong>
                                            </td>
                                            <td>
                                                @if(!$prod->is_in_stock || $prod->stock_quantity <= 0)
                                                    <span class="label label-danger">Out of Stock</span>
                                                @else
                                                    <span class="label label-warning">Only {{ $prod->stock_quantity }} left</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.product.edit', $prod->id) }}" class="btn btn-default btn-xs" title="Edit Product">
                                                    <i class="icon-pencil5"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted" style="padding: 20px;">
                                                <i class="icon-checkmark4 text-success" style="font-size: 24px; display: block; margin-bottom: 4px;"></i>
                                                {{ __('All active products have healthy stock levels.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        @endif
        <!-- /SUPERADMIN EXTRA SECTION -->

    </div>
    <!-- /Content Area -->
@endsection
