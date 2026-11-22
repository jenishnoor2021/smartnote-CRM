@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
   <div class="page-header-content">
      <div class="page-title">
         <h4>
            <span class="text-semibold">{{ __('Edit Product') }}</span>
         </h4>
      </div>
   </div>
   <div class="breadcrumb-line">
      <ul class="breadcrumb">
         <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
         <li><a href="{{ route('admin.product.index') }}">{{ __('Products') }}</a></li>
         <li class="active">{{ __('Edit') }}</li>
      </ul>
   </div>
</div>

<div class="content">
   <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal" name="editproductform">
   @csrf
   @method('PATCH')
   <div class="row">
      <div class="col-md-10 col-md-offset-1">
         
         <!-- Single Unified Clean Panel -->
         <div class="panel panel-flat">
            <div class="panel-heading" style="border-bottom: 1px solid #eee; padding-bottom: 15px;">
               <h5 class="panel-title">
                  <strong>{{ __('Edit Product: ') }} {{ $product->product_name }}</strong>
               </h5>
            </div>

            <div class="panel-body" style="padding-top: 25px;">
               
               <!-- 1. Basic & Category Info -->
               <fieldset class="content-group" style="margin-bottom: 30px;">
                  <legend class="text-bold text-uppercase" style="font-size: 13px; letter-spacing: 0.5px; border-bottom: 1px solid #e0e0e0; padding-bottom: 8px; margin-bottom: 20px; color: #333;">
                     <i class="icon-info22 position-left text-teal" style="font-size: 15px;"></i> {{ __('1. Basic & Category Information') }}
                  </legend>

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 20px;">
                           <label class="text-semibold">{{ __('Category') }}: <span class="text-danger">*</span></label>
                           <select name="category_id" id="category_id" class="form-control select2" required onchange="loadSubcategories(this.value)">
                              <option value="">{{ __('-- Select Category --') }}</option>
                              @foreach($categories as $category)
                                 <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                 </option>
                              @endforeach
                           </select>
                           @error('category_id')
                           <div class="text-danger mt-1 mb-1">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 20px;">
                           <label class="text-semibold">{{ __('Sub Category') }}:</label>
                           <select name="subcategory_id" id="subcategory_id" class="form-control select2">
                              <option value="">{{ __('-- Select Sub Category (Optional) --') }}</option>
                              @foreach($subcategories as $sub)
                                 <option value="{{ $sub->id }}" {{ old('subcategory_id', $product->subcategory_id) == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->subcategory_name }}
                                 </option>
                              @endforeach
                           </select>
                           @error('subcategory_id')
                           <div class="text-danger mt-1 mb-1">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-8">
                        <div class="form-group" style="margin-bottom: 15px;">
                           <label class="text-semibold">{{ __('Product / Book Name') }}: <span class="text-danger">*</span></label>
                           <input type="text" class="form-control" placeholder="{{ __('Enter Product Name') }}" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
                           @error('product_name')
                           <div class="text-danger mt-1 mb-1">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>

                     <div class="col-md-4">
                        <div class="form-group" style="margin-bottom: 15px;">
                           <label class="text-semibold">{{ __('SKU / Product Code') }}:</label>
                           <input type="text" class="form-control" placeholder="{{ __('e.g. 03') }}" id="product_code" name="product_code" value="{{ old('product_code', $product->product_code) }}">
                           @error('product_code')
                           <div class="text-danger mt-1 mb-1">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>
                  </div>
               </fieldset>

               <!-- 2. Book Specifications -->
               <fieldset class="content-group" style="margin-bottom: 30px;">
                  <legend class="text-bold text-uppercase" style="font-size: 13px; letter-spacing: 0.5px; border-bottom: 1px solid #e0e0e0; padding-bottom: 8px; margin-bottom: 20px; color: #333;">
                     <i class="icon-book position-left text-teal" style="font-size: 15px;"></i> {{ __('2. Book Specifications') }}
                  </legend>

                  <div class="row">
                     <div class="col-md-3">
                        <div class="form-group" style="margin-bottom: 15px;">
                           <label class="text-semibold">{{ __('Stream / Medium') }}:</label>
                           <input type="text" class="form-control" placeholder="{{ __('e.g. English Medium') }}" id="medium" name="medium" value="{{ old('medium', $product->medium) }}">
                        </div>
                     </div>

                     <div class="col-md-3">
                        <div class="form-group" style="margin-bottom: 15px;">
                           <label class="text-semibold">{{ __('Subject') }}:</label>
                           <input type="text" class="form-control" placeholder="{{ __('e.g. English Alphabet') }}" id="subject" name="subject" value="{{ old('subject', $product->subject) }}">
                        </div>
                     </div>

                     <div class="col-md-3">
                        <div class="form-group" style="margin-bottom: 15px;">
                           <label class="text-semibold">{{ __('Class / Standard') }}:</label>
                           <input type="text" class="form-control" placeholder="{{ __('e.g. Nursery, Preschool') }}" id="standard_class" name="standard_class" value="{{ old('standard_class', $product->standard_class) }}">
                        </div>
                     </div>

                     <div class="col-md-3">
                        <div class="form-group" style="margin-bottom: 15px;">
                           <label class="text-semibold">{{ __('Author / Publisher') }}:</label>
                           <input type="text" class="form-control" placeholder="{{ __('e.g. SmartNotes Publication') }}" id="author_publisher" name="author_publisher" value="{{ old('author_publisher', $product->author_publisher) }}">
                        </div>
                     </div>
                  </div>
               </fieldset>

               <!-- 3. Pricing & Inventory -->
               <fieldset class="content-group" style="margin-bottom: 30px;">
                  <legend class="text-bold text-uppercase" style="font-size: 13px; letter-spacing: 0.5px; border-bottom: 1px solid #e0e0e0; padding-bottom: 8px; margin-bottom: 20px; color: #333;">
                     <i class="icon-price-tag2 position-left text-teal" style="font-size: 15px;"></i> {{ __('3. Pricing & Inventory') }}
                  </legend>

                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group" style="margin-bottom: 15px;">
                           <label class="text-semibold">{{ __('Selling Price (₹)') }}: <span class="text-danger">*</span></label>
                           <div class="input-group">
                              <span class="input-group-addon font-weight-bold">₹</span>
                              <input type="number" step="any" class="form-control" placeholder="{{ __('e.g. 260.00') }}" id="selling_price" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}" required>
                           </div>
                           @error('selling_price')
                           <div class="text-danger mt-1 mb-1">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>

                     <div class="col-md-4">
                        <div class="form-group" style="margin-bottom: 15px;">
                           <label class="text-semibold">{{ __('MRP Price (₹)') }}:</label>
                           <div class="input-group">
                              <span class="input-group-addon font-weight-bold">₹</span>
                              <input type="number" step="any" class="form-control" placeholder="{{ __('e.g. 300.00') }}" id="mrp_price" name="mrp_price" value="{{ old('mrp_price', $product->mrp_price) }}">
                           </div>
                           @error('mrp_price')
                           <div class="text-danger mt-1 mb-1">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>

                     <div class="col-md-4">
                        <div class="form-group" style="margin-bottom: 15px;">
                           <label class="text-semibold">{{ __('Unit') }}:</label>
                           <input type="text" class="form-control" placeholder="{{ __('e.g. pcs') }}" id="unit" name="unit" value="{{ old('unit', $product->unit) }}">
                        </div>
                     </div>
                  </div>

                  <div class="row" style="margin-top: 10px;">
                     <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 15px;">
                           <label class="text-semibold">{{ __('Stock Quantity') }}:</label>
                           <input type="number" class="form-control" placeholder="{{ __('e.g. 100') }}" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}">
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 15px;">
                           <label class="text-semibold display-block">{{ __('Stock Availability') }}:</label>
                           <div style="margin-top: 8px;">
                              <label style="cursor: pointer; font-weight: normal;">
                                 <input type="checkbox" class="switchery" name="is_in_stock" id="is_in_stock" value="1" {{ $product->is_in_stock ? 'checked' : '' }}>
                                 <span style="margin-left: 10px; font-weight: 500;">{{ __('In Stock') }}</span>
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>
               </fieldset>

               <!-- 4. Product Images -->
               <fieldset class="content-group" style="margin-bottom: 30px;">
                  <legend class="text-bold text-uppercase" style="font-size: 13px; letter-spacing: 0.5px; border-bottom: 1px solid #e0e0e0; padding-bottom: 8px; margin-bottom: 20px; color: #333;">
                     <i class="icon-images2 position-left text-teal" style="font-size: 15px;"></i> {{ __('4. Product Images') }}
                  </legend>

                  <div class="row">
                     <!-- Cover Image -->
                     <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 15px;">
                           <label class="text-semibold">
                              {{ __('Main Cover Image') }}:
                              @if(empty($product->cover_image))
                                 <span class="text-danger">*</span>
                              @endif
                           </label>
                           
                           <div style="border: 2px dashed #b2dfdb; border-radius: 6px; padding: 20px; background: #fafdfd; text-align: center; min-height: 230px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                              
                              <input type="file" id="cover_image" name="cover_image" accept="image/*" onchange="handleCoverSelect(this);" style="display: none;">

                              <!-- If already has cover image -->
                              @if(!empty($product->cover_image))
                                 <div id="current_cover_box" style="text-align: center;">
                                    <div style="position: relative; display: inline-block; width: 120px; height: 160px; border-radius: 6px; border: 1px solid #ddd; background: #fff; padding: 3px; box-shadow: 0 2px 6px rgba(0,0,0,0.12);">
                                       <img src="{{ asset($product->cover_image) }}" alt="Current Cover" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;" onerror="this.onerror=null;this.src='{{ asset('assets/img/book/pg-6.png') }}';">
                                       <span class="label label-success" style="position: absolute; bottom: 5px; left: 5px; right: 5px; font-size: 9px; padding: 2px 0;">Current Cover</span>
                                    </div>
                                    <div style="margin-top: 8px;">
                                       <button type="button" class="btn btn-default btn-xs" onclick="document.getElementById('cover_image').click();">
                                          <i class="icon-pencil7 position-left"></i>{{ __('Change Cover') }}
                                       </button>
                                    </div>
                                 </div>
                              @else
                                 <div id="cover_upload_placeholder" style="cursor: pointer;" onclick="document.getElementById('cover_image').click();">
                                    <i class="icon-camera text-teal" style="font-size: 36px; display: block; margin-bottom: 8px;"></i>
                                    <span class="btn btn-default btn-sm" style="margin-bottom: 6px;"><i class="icon-upload position-left"></i>{{ __('Choose Cover Image') }}</span>
                                    <p class="text-muted" style="margin: 0; font-size: 11px;">Recommended: JPG, PNG, WEBP (Max 2MB)</p>
                                 </div>
                              @endif

                              <!-- Preview when user chooses a new cover image -->
                              <div id="new_cover_preview_wrapper" style="display: none; text-align: center; margin-top: 10px;">
                                 <div style="position: relative; display: inline-block; width: 120px; height: 160px; border-radius: 6px; border: 2px solid #26a69a; background: #fff; padding: 3px; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                                    <img id="new_cover_preview_img" src="" alt="New Cover" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                                    <button type="button" onclick="cancelNewCover();" style="position: absolute; top: -8px; right: -8px; width: 24px; height: 24px; background: #e53935; color: #fff; border-radius: 50%; border: 2px solid #fff; font-size: 14px; font-weight: bold; line-height: 1; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 4px rgba(0,0,0,0.3);" title="Cancel New Cover">&times;</button>
                                    <span class="label label-teal" style="position: absolute; bottom: 5px; left: 5px; right: 5px; font-size: 9px; padding: 2px 0;">New Selected</span>
                                 </div>
                              </div>

                           </div>

                           <div id="cover_image_error_box"></div>

                           @error('cover_image')
                           <div class="text-danger mt-1 mb-1">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>

                     <!-- Gallery Images -->
                     <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 15px;">
                           <label class="text-semibold">{{ __('Gallery Images') }}:</label>
                           
                           <div style="border: 2px dashed #b2dfdb; border-radius: 6px; padding: 20px; background: #fafdfd; min-height: 230px; text-align: center;">
                              
                              <!-- Existing Gallery from DB -->
                              @if($product->images && $product->images->count() > 0)
                                 <div style="margin-bottom: 16px;">
                                    <p class="text-semibold text-muted" style="margin-bottom: 8px; font-size: 12px; text-align: left;">
                                       <i class="icon-database position-left"></i>{{ __('Saved Gallery Images (Click × to delete):') }}
                                    </p>
                                    <div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: flex-start;">
                                       @foreach($product->images as $galleryImg)
                                          <div id="gallery-box-{{ $galleryImg->id }}" style="position: relative; width: 80px; height: 105px; border-radius: 6px; border: 1px solid #ddd; background: #fff; padding: 2px; box-shadow: 0 1px 4px rgba(0,0,0,0.1);">
                                             <img src="{{ asset($galleryImg->image) }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                                             <button type="button" onclick="deleteGalleryImage({{ $galleryImg->id }});" style="position: absolute; top: -7px; right: -7px; width: 22px; height: 22px; background: #e53935; color: #fff; border-radius: 50%; border: 2px solid #fff; font-size: 13px; font-weight: bold; line-height: 1; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 4px rgba(0,0,0,0.3);" title="Delete Image from Server">&times;</button>
                                          </div>
                                       @endforeach
                                    </div>
                                 </div>
                              @endif

                              <!-- Actual input for new files -->
                              <input type="file" id="gallery_images" name="gallery_images[]" accept="image/*" multiple style="display: none;">
                              
                              <!-- Picker trigger input -->
                              <input type="file" id="gallery_picker" accept="image/*" multiple onchange="handleGallerySelect(this);" style="display: none;">

                              <div style="margin-bottom: 12px; border-top: 1px solid #e0e0e0; padding-top: 14px;">
                                 <button type="button" class="btn btn-teal btn-sm" onclick="document.getElementById('gallery_picker').click();">
                                    <i class="icon-plus22 position-left"></i>{{ __('Add More Gallery Images') }}
                                 </button>
                                 <p class="text-muted" style="margin: 6px 0 0 0; font-size: 11px;">
                                    {{ __('Click multiple times to queue more images. Click × on any card to remove.') }}
                                 </p>
                              </div>

                              <!-- Preview container for newly selected files -->
                              <div id="gallery_preview_container" style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; align-items: center;">
                                 <div id="gallery_empty_text" class="text-muted" style="font-size: 11px; font-style: italic; padding: 10px 0;">
                                    {{ __('No new gallery images queued.') }}
                                 </div>
                              </div>

                              <div id="gallery_count_badge" style="display: none; margin-top: 10px;">
                                 <span class="label label-info" id="gallery_count_text">0 images queued</span>
                              </div>
                           </div>

                           @error('gallery_images')
                           <div class="text-danger mt-1 mb-1">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>
                  </div>
               </fieldset>

               <!-- 5. Descriptions & Details -->
               <fieldset class="content-group" style="margin-bottom: 25px;">
                  <legend class="text-bold text-uppercase" style="font-size: 13px; letter-spacing: 0.5px; border-bottom: 1px solid #e0e0e0; padding-bottom: 8px; margin-bottom: 20px; color: #333;">
                     <i class="icon-file-text2 position-left text-teal" style="font-size: 15px;"></i> {{ __('5. Descriptions & Learning Content') }}
                  </legend>

                  <div class="form-group" style="margin-bottom: 20px;">
                     <label class="text-semibold">{{ __('Short Description (Summary)') }}:</label>
                     <textarea rows="3" class="form-control" placeholder="Enter brief summary of the book..." id="short_description" name="short_description">{{ old('short_description', $product->short_description) }}</textarea>
                  </div>

                  <div class="form-group" style="margin-bottom: 20px;">
                     <label class="text-semibold">{{ __('Full Description') }}:</label>
                     <textarea rows="5" class="form-control" placeholder="Enter complete detailed description of the book..." id="description" name="description">{{ old('description', $product->description) }}</textarea>
                  </div>

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 20px;">
                           <label class="text-semibold">{{ __('Key Features') }}:</label>
                           <textarea rows="4" class="form-control" placeholder="• A to Z Alphabet Learning&#10;• Colourful Illustrations&#10;• Early Vocabulary Development" id="key_features" name="key_features">{{ old('key_features', $product->key_features) }}</textarea>
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 20px;">
                           <label class="text-semibold">{{ __('Learning Benefits') }}:</label>
                           <textarea rows="4" class="form-control" placeholder="• Recognise English letters A to Z&#10;• Improve alphabet identification skills&#10;• Build confidence in early language" id="learning_benefits" name="learning_benefits">{{ old('learning_benefits', $product->learning_benefits) }}</textarea>
                        </div>
                     </div>
                  </div>
               </fieldset>

               <!-- 6. Publishing Status -->
               <fieldset class="content-group" style="margin-bottom: 15px;">
                  <legend class="text-bold text-uppercase" style="font-size: 13px; letter-spacing: 0.5px; border-bottom: 1px solid #e0e0e0; padding-bottom: 8px; margin-bottom: 20px; color: #333;">
                     <i class="icon-cog position-left text-teal" style="font-size: 15px;"></i> {{ __('6. Status') }}
                  </legend>

                  <div class="form-group" style="margin-bottom: 10px;">
                     <label class="text-semibold display-block">{{ __('Active Status') }}:</label>
                     <div style="margin-top: 8px;">
                        <label style="cursor: pointer; font-weight: normal;">
                           <input type="checkbox" class="switchery" name="is_active" id="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
                           <span style="margin-left: 10px; font-weight: 500;">{{ __('Active (Visible in Store)') }}</span>
                        </label>
                     </div>
                  </div>
               </fieldset>

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
   /* ========================================================
    * 1. COVER IMAGE HANDLING (Change + Cancel New Cover)
    * ======================================================== */
   function handleCoverSelect(input) {
      if (input.files && input.files[0]) {
         $('#cover_image_error_box').empty();
         var reader = new FileReader();
         reader.onload = function(e) {
            $('#new_cover_preview_img').attr('src', e.target.result);
            $('#current_cover_box').hide();
            $('#cover_upload_placeholder').hide();
            $('#new_cover_preview_wrapper').fadeIn(200);
         }
         reader.readAsDataURL(input.files[0]);
      }
   }

   function cancelNewCover() {
      var input = document.getElementById('cover_image');
      input.value = '';
      $('#new_cover_preview_img').attr('src', '');
      $('#new_cover_preview_wrapper').hide();
      $('#current_cover_box').fadeIn(200);
      $('#cover_upload_placeholder').fadeIn(200);
      @if(empty($product->cover_image))
         $('#cover_image_error_box').html('<label class="validation-error-label text-danger" style="display: block; margin-top: 6px;"><i class="icon-cancel-circle2 position-left"></i>{{ __("Cover image is required.") }}</label>');
      @endif
   }

   /* ========================================================
    * 2. NEW GALLERY IMAGES QUEUE (Accumulative + Remove)
    * ======================================================== */
   var galleryDataTransfer = new DataTransfer();

   function handleGallerySelect(input) {
      if (input.files && input.files.length > 0) {
         Array.from(input.files).forEach(function(file) {
            var isDuplicate = false;
            for (var i = 0; i < galleryDataTransfer.files.length; i++) {
               if (galleryDataTransfer.files[i].name === file.name && galleryDataTransfer.files[i].size === file.size) {
                  isDuplicate = true;
                  break;
               }
            }
            if (!isDuplicate) {
               galleryDataTransfer.items.add(file);
            }
         });

         input.value = '';
         syncGalleryAndRender();
      }
   }

   function removeGalleryItem(index) {
      var newDt = new DataTransfer();
      var files = galleryDataTransfer.files;
      for (var i = 0; i < files.length; i++) {
         if (i !== index) {
            newDt.items.add(files[i]);
         }
      }
      galleryDataTransfer = newDt;
      syncGalleryAndRender();
   }

   function syncGalleryAndRender() {
      var actualInput = document.getElementById('gallery_images');
      actualInput.files = galleryDataTransfer.files;

      var container = document.getElementById('gallery_preview_container');
      var countBadge = document.getElementById('gallery_count_badge');
      var countText = document.getElementById('gallery_count_text');

      container.innerHTML = '';

      var files = galleryDataTransfer.files;
      if (files.length === 0) {
         container.innerHTML = '<div id="gallery_empty_text" class="text-muted" style="font-size: 11px; font-style: italic; padding: 10px 0;">No new gallery images queued.</div>';
         countBadge.style.display = 'none';
         return;
      }

      countBadge.style.display = 'block';
      countText.innerText = files.length + ' new image(s) queued for upload';

      Array.from(files).forEach(function(file, index) {
         var reader = new FileReader();
         reader.onload = function(e) {
            var card = document.createElement('div');
            card.style.cssText = 'position: relative; width: 80px; height: 105px; border-radius: 6px; border: 1px solid #ddd; background: #fff; padding: 2px; box-shadow: 0 1px 4px rgba(0,0,0,0.1);';
            card.innerHTML = 
               '<img src="' + e.target.result + '" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;" alt="preview">' +
               '<button type="button" onclick="removeGalleryItem(' + index + ')" style="position: absolute; top: -7px; right: -7px; width: 22px; height: 22px; background: #e53935; color: #fff; border-radius: 50%; border: 2px solid #fff; font-size: 13px; font-weight: bold; line-height: 1; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 4px rgba(0,0,0,0.3);" title="Remove this new image">&times;</button>' +
               '<div style="position: absolute; bottom: 2px; left: 2px; right: 2px; background: rgba(0,0,0,0.65); color: #fff; font-size: 8px; padding: 1px 2px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; border-radius: 2px; text-align: center;">' +
                  file.name +
               '</div>';
            container.appendChild(card);
         };
         reader.readAsDataURL(file);
      });
   }

   /* ========================================================
    * 3. DELETE EXISTING GALLERY IMAGE (from DB & Storage)
    * ======================================================== */
   function deleteGalleryImage(id) {
      swal({
         title: "Delete this image?",
         text: "This image will be permanently removed from the server.",
         type: "warning",
         showCancelButton: true,
         confirmButtonText: "Yes, delete it",
         confirmButtonColor: "#DD6B55",
         closeOnConfirm: true
      }, function(isConfirm) {
         if (isConfirm === false) return;

         if (typeof swal.close === 'function') {
            swal.close();
         }

         $.ajax({
            url: '/admin/product/delete-gallery-image/' + id,
            type: 'POST',
            data: {
               _token: $('meta[name="csrf-token"]').attr('content'),
               _method: 'DELETE'
            },
            success: function(response) {
               if (typeof swal.close === 'function') {
                  swal.close();
               }
               if (response.status) {
                  $('#gallery-box-' + id).fadeOut(300, function() {
                     $(this).remove();
                  });
                  jGrowlAlert(response.message, 'success');
               } else {
                  jGrowlAlert(response.message, 'danger');
               }
            },
            error: function() {
               if (typeof swal.close === 'function') {
                  swal.close();
               }
               jGrowlAlert("Error deleting image", 'danger');
            }
         });
      });
   }

   /* ========================================================
    * 4. CATEGORY & SUBCATEGORY DEPENDENT DROPDOWN
    * ======================================================== */
   function loadSubcategories(categoryId) {
      var subcategorySelect = $('#subcategory_id');
      subcategorySelect.empty().append('<option value="">-- Loading... --</option>');

      if (!categoryId) {
         subcategorySelect.empty().append('<option value="">-- Select Sub Category (Optional) --</option>');
         return;
      }

      $.ajax({
         url: '{{ route("admin.product.get_subcategories") }}',
         type: 'GET',
         data: { category_id: categoryId },
         success: function(response) {
            subcategorySelect.empty().append('<option value="">-- Select Sub Category (Optional) --</option>');
            if (response.status && response.data.length > 0) {
               $.each(response.data, function(index, sub) {
                  subcategorySelect.append('<option value="' + sub.id + '">' + sub.subcategory_name + '</option>');
               });
            }
            if ($.fn.select2) {
               subcategorySelect.trigger('change');
            }
         },
         error: function() {
            subcategorySelect.empty().append('<option value="">-- Select Sub Category (Optional) --</option>');
         }
      });
   }

   $(function() {
      if ($.fn.select2) {
         $('.select2').select2();
      }

      $("form[name='editproductform']").validate({
         rules: {
            category_id: { required: true },
            product_name: { required: true },
            selling_price: { required: true, number: true, min: 0 },
            mrp_price: { number: true, min: 0 }
         },
         submitHandler: function(form) {
            var hasExistingCover = {{ !empty($product->cover_image) ? 'true' : 'false' }};
            var coverInput = document.getElementById('cover_image');
            if (!hasExistingCover && (!coverInput.files || coverInput.files.length === 0)) {
               $('#cover_image_error_box').html('<label class="validation-error-label text-danger" style="display: block; margin-top: 6px;"><i class="icon-cancel-circle2 position-left"></i>{{ __("Cover image is required because this product currently has no cover image.") }}</label>');
               var scrollTarget = $("#cover_upload_placeholder").length && $("#cover_upload_placeholder").is(":visible") 
                  ? $("#cover_upload_placeholder").offset().top 
                  : ($("#cover_image_error_box").length ? $("#cover_image_error_box").offset().top : $("#cover_image").offset().top);
               $('html, body').animate({
                  scrollTop: scrollTarget - 120
               }, 300);
               return false;
            }
            form.submit();
         }
      });
   });
</script>
@endsection
