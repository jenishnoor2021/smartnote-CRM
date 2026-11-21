@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">{{ __('Website Settings & Company Profile') }}</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="/admin/dashboard"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li class="active">{{ __('Site Settings') }}</li>
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

    <div class="panel panel-flat">
        <div class="panel-body">
            <form action="{{ route('admin.setting.update') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                @csrf
                @method('PATCH')

                <div class="tabbable">
                    <ul class="nav nav-tabs nav-tabs-highlight">
                        <li class="active"><a href="#tab-general" data-toggle="tab"><i class="icon-gear position-left"></i> General Info</a></li>
                        <li><a href="#tab-contact" data-toggle="tab"><i class="icon-phone2 position-left"></i> Contact & Branches</a></li>
                        <li><a href="#tab-social" data-toggle="tab"><i class="icon-share3 position-left"></i> Social Media Links</a></li>
                        <li><a href="#tab-logos" data-toggle="tab"><i class="icon-images2 position-left"></i> Logos & Branding</a></li>
                    </ul>

                    <div class="tab-content" style="padding-top: 15px;">
                        <!-- Tab 1: General -->
                        <div class="tab-pane active" id="tab-general">
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-semibold">Site / Publication Name:</label>
                                <div class="col-lg-9">
                                    <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? 'SMART NOTES PUBLICATION PVT. LTD.' }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-semibold">Site Tagline / Subtitle:</label>
                                <div class="col-lg-9">
                                    <input type="text" name="site_tagline" class="form-control" value="{{ $settings['site_tagline'] ?? 'School Books Publisher | Nursery to Class 8' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-semibold">Copyright Footer Text:</label>
                                <div class="col-lg-9">
                                    <input type="text" name="copyright_text" class="form-control" value="{{ $settings['copyright_text'] ?? 'SMART NOTES PUBLICATION. All Rights Reserved.' }}">
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2: Contact & Branches -->
                        <div class="tab-pane" id="tab-contact">
                            <h6 class="text-semibold text-primary"><i class="icon-phone2 position-left"></i> Phone & Email</h6>
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-semibold">Primary Phone (Header/Call Us):</label>
                                <div class="col-lg-9">
                                    <input type="text" name="phone_primary" class="form-control" value="{{ $settings['phone_primary'] ?? '+91 99798-65666' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-semibold">Secondary Phone (Mumbai Office):</label>
                                <div class="col-lg-9">
                                    <input type="text" name="phone_secondary" class="form-control" value="{{ $settings['phone_secondary'] ?? '+91 92130-05642' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-semibold">WhatsApp Number (e.g. 919979865666):</label>
                                <div class="col-lg-9">
                                    <input type="text" name="whatsapp_number" class="form-control" value="{{ $settings['whatsapp_number'] ?? '919979865666' }}">
                                    <span class="help-block text-muted text-size-mini">Format with country code without plus, e.g. 919979865666</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-semibold">Primary Email (Surat):</label>
                                <div class="col-lg-9">
                                    <input type="email" name="email_primary" class="form-control" value="{{ $settings['email_primary'] ?? 'smartnotespublication@gmail.com' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-semibold">Secondary Email (Mumbai):</label>
                                <div class="col-lg-9">
                                    <input type="email" name="email_secondary" class="form-control" value="{{ $settings['email_secondary'] ?? 'Sevenhigheducationpvtltd@gmail.com' }}">
                                </div>
                            </div>

                            <hr>
                            <h6 class="text-semibold text-primary"><i class="icon-location4 position-left"></i> Branch Office Addresses</h6>
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-semibold">Surat Head Office Address:</label>
                                <div class="col-lg-9">
                                    <textarea name="office_surat_address" class="form-control" rows="2">{{ $settings['office_surat_address'] ?? '222 to 224, Prime Shoppers, Opp. Safal Square, Udhna-magdalla Road, Vesu, Surat - 395007' }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-semibold">Mumbai Regional Office Address:</label>
                                <div class="col-lg-9">
                                    <textarea name="office_mumbai_address" class="form-control" rows="2">{{ $settings['office_mumbai_address'] ?? '33, Pragati Icon, A. S. Gawade Marg, Pant Nagar, Mumbai, Maharashtra-400075' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 3: Social Media -->
                        <div class="tab-pane" id="tab-social">
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-semibold"><i class="icon-facebook2 position-left"></i> Facebook Page URL:</label>
                                <div class="col-lg-9">
                                    <input type="url" name="facebook_url" class="form-control" value="{{ $settings['facebook_url'] ?? 'https://www.facebook.com/SmartNotesPublication' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-semibold"><i class="icon-instagram position-left"></i> Instagram URL:</label>
                                <div class="col-lg-9">
                                    <input type="url" name="instagram_url" class="form-control" value="{{ $settings['instagram_url'] ?? 'https://www.instagram.com/smartnotes_publication' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-semibold"><i class="icon-youtube position-left"></i> YouTube Channel URL:</label>
                                <div class="col-lg-9">
                                    <input type="url" name="youtube_url" class="form-control" value="{{ $settings['youtube_url'] ?? 'https://www.youtube.com/@SmartNotesPublication07' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-semibold"><i class="icon-linkedin2 position-left"></i> LinkedIn URL:</label>
                                <div class="col-lg-9">
                                    <input type="url" name="linkedin_url" class="form-control" value="{{ $settings['linkedin_url'] ?? '#' }}">
                                </div>
                            </div>
                        </div>

                        <!-- Tab 4: Logos -->
                        <div class="tab-pane" id="tab-logos">
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-semibold">Header Logo (Desktop):</label>
                                <div class="col-lg-6">
                                    <input type="file" name="header_logo" class="form-control">
                                    <span class="help-block text-muted text-size-mini">Recommended: Transparent PNG, e.g. 250x65px</span>
                                </div>
                                <div class="col-lg-3">
                                    @if(!empty($settings['header_logo']))
                                        <div style="background: #f1f5f9; padding: 5px; border-radius: 4px; display: inline-block;">
                                            <img src="{{ asset($settings['header_logo']) }}" style="max-height: 45px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-semibold">Footer Logo:</label>
                                <div class="col-lg-6">
                                    <input type="file" name="footer_logo" class="form-control">
                                </div>
                                <div class="col-lg-3">
                                    @if(!empty($settings['footer_logo']))
                                        <div style="background: #0f172a; padding: 5px; border-radius: 4px; display: inline-block;">
                                            <img src="{{ asset($settings['footer_logo']) }}" style="max-height: 45px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-semibold">Mobile Logo:</label>
                                <div class="col-lg-6">
                                    <input type="file" name="mobile_logo" class="form-control">
                                </div>
                                <div class="col-lg-3">
                                    @if(!empty($settings['mobile_logo']))
                                        <div style="background: #f1f5f9; padding: 5px; border-radius: 4px; display: inline-block;">
                                            <img src="{{ asset($settings['mobile_logo']) }}" style="max-height: 45px;">
                                        </div>
                                    @endif
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
            </form>
        </div>
    </div>

</div>

@endsection

