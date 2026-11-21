@extends('layouts.front')

@section('title', 'My Wishlist - SMART NOTES PUBLICATION PVT. LTD.')

@section('content')
<style>
    /* Keep the theme's wishlist table layout at every screen width. */
    #sn-wishlist-form .sn-wishlist-table-scroll {
      max-width: 100%;
      overflow-x: auto;
      margin-bottom: 20px;
      border: 1px solid var(--border-color);
      border-radius: 5px;
    }

    #sn-wishlist-form .sn-wishlist-table-scroll:focus-visible {
      outline: 2px solid var(--theme-color);
      outline-offset: 3px;
    }

    #sn-wishlist-form table.tinvwl-table-manage-list {
      width: 100%;
      min-width: 960px;
      margin: 0;
      table-layout: auto;
      border-collapse: collapse;
    }

    #sn-wishlist-form table.tinvwl-table-manage-list th,
    #sn-wishlist-form table.tinvwl-table-manage-list td {
      display: table-cell;
      width: auto !important;
      padding: 14px 12px;
      vertical-align: middle;
      border: 1px solid var(--border-color);
    }

    #sn-wishlist-form table thead th {
      background-color: var(--theme-color);
      color: var(--white-color);
      white-space: nowrap;
    }

    #sn-wishlist-form table tbody {
      border-bottom: 0;
    }

    #sn-wishlist-form table .product-name {
      min-width: 190px;
      text-align: left;
    }

    #sn-wishlist-form table .product-thumbnail img {
      width: 70px;
      height: 80px;
      max-width: none;
      object-fit: contain;
    }

    #sn-wishlist-form table .product-price,
    #sn-wishlist-form table .product-date,
    #sn-wishlist-form table .product-stock,
    #sn-wishlist-form table .product-action {
      white-space: nowrap;
    }

    #sn-wishlist-form table .product-remove button {
      width: 36px;
      height: 36px;
      line-height: 36px;
    }

    #sn-wishlist-form table .tinvwl-full {
      display: inline;
    }

    #sn-wishlist-form table .tinvwl-mobile {
      display: none;
    }

    #sn-wishlist-form table .tinvwl-txt {
      display: inline-block;
    }

    #sn-wishlist-status {
      margin: 12px 0 0;
    }
  </style>
  
  <!--==============================
    Breadcrumb
============================== -->
  <div class="breadcumb-wrapper" data-bg-src="assets/img/bg/breadcumb-bg-4.png">
    <div class="container z-index-common">
      <div class="breadcumb-content">
        <h1 class="breadcumb-title">Wishlist</h1>
        <div class="breadcumb-menu-wrap">
          <div class="breadcumb-menu">
            <span><a href="{{ url('/') }}">Home</a></span>
            <span>Wishlist</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!--======== Wishlist Section ========-->
    <div class="wishlist-area space">
        <div class="container">
            <div class="tinv-wishlist woocommerce tinv-wishlist-clear">
                <div class="tinv-header">
                    <h2 class="mb-30">Wishlist</h2>
                </div>
                <form id="sn-wishlist-form" action="#" method="post" autocomplete="off">
                    <div class="sn-wishlist-table-scroll" role="region" aria-label="Wishlist products, scroll horizontally to view all columns" tabindex="0">
                    <table class="tinvwl-table-manage-list" aria-label="Wishlist products">
                        <thead>
                            <tr>
                                <th class="product-cb">
                                    <input type="checkbox" class="global-cb" title="Select all for bulk action">
                                </th>
                                <th class="product-remove"><span class="visually-hidden">Remove</span></th>
                                <th class="product-thumbnail">Images</th>
                                <th class="product-name">
                                    <span class="tinvwl-full">Product Name</span><span class="tinvwl-mobile">Product</span>
                                </th>
                                <th class="product-price">Unit Price</th>
                                <th class="product-date">Date Added</th>
                                <th class="product-stock">Stock Status</th>
                                <th class="product-action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="wishlist_item">
                                <td class="product-cb">
                                    <input type="checkbox" name="wishlist_pr[]" value="58" title="Select for bulk action">
                                </td>
                                <td class="product-remove">
                                    <button type="submit" name="tinvwl-remove" value="58" title="Remove"><i class="fal fa-trash-alt"></i>
                                    </button>
                                </td>
                                <td class="product-thumbnail">
                                    <a href="shop-details.html"><img src="assets/img/book/pg-6.png" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="image"></a>
                                </td>
                                <td class="product-name">
                                    <a href="shop-details.html">Vqirk Teur Mocgkcup</a>
                                </td>
                                <td class="product-price">
                                    <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">₹</span>45.00</bdi></span>
                                </td>
                                <td class="product-date">
                                    <time class="entry-date" datetime="2024-11-21 03:54:24">November 21, 2024</time>
                                </td>
                                <td class="product-stock">
                                    <p class="stock in-stock">
                                        <span><i class="fas fa-check"></i></span><span class="tinvwl-txt">In stock</span>
                                    </p>
                                </td>
                                <td class="product-action">
                                    <button class="button vs-btn alt" name="tinvwl-add-to-cart" value="58" title="Add to Cart">
                                        <i class="fal fa-shopping-cart"></i><span class="tinvwl-txt">Add to Cart</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="wishlist_item">
                                <td class="product-cb">
                                    <input type="checkbox" name="wishlist_pr[]" value="60" title="Select for bulk action">
                                </td>
                                <td class="product-remove">
                                    <button type="submit" name="tinvwl-remove" value="60" title="Remove"><i class="fal fa-trash-alt"></i>
                                    </button>
                                </td>
                                <td class="product-thumbnail">
                                    <a href="shop-details.html"><img src="assets/img/book/pg-1.png" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="image"></a>
                                </td>
                                <td class="product-name">
                                    <a href="shop-details.html">Hd Pry Balir Ptonnrnle</a>
                                </td>
                                <td class="product-price">
                                    <ins><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">₹</span>18.00</bdi></span></ins>
                                    <!--<del><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">₹</span>20.00</bdi></span></del>-->
                                </td>
                                <td class="product-date">
                                    <time class="entry-date" datetime="2024-11-21 03:54:24">November 21, 2024</time>
                                </td>
                                <td class="product-stock">
                                    <p class="stock in-stock"><span><i class="fas fa-check"></i></span><span class="tinvwl-txt">In stock</span></p>
                                </td>
                                <td class="product-action">
                                    <button class="button vs-btn alt" name="tinvwl-add-to-cart" value="60" title="Add to Cart">
                                        <i class="fal fa-shopping-cart"></i><span class="tinvwl-txt">Add to Cart</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="wishlist_item">
                                <td class="product-cb">
                                    <input type="checkbox" name="wishlist_pr[]" value="60" title="Select for bulk action">
                                </td>
                                <td class="product-remove">
                                    <button type="submit" name="tinvwl-remove" value="60" title="Remove"><i class="fal fa-trash-alt"></i>
                                    </button>
                                </td>
                                <td class="product-thumbnail">
                                    <a href="shop-details.html"><img src="assets/img/book/pg-2.png" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="image"></a>
                                </td>
                                <td class="product-name">
                                    <a href="shop-details.html">Beuto minimal Cork</a>
                                </td>
                                <td class="product-price">
                                    <ins><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">₹</span>18.00</bdi></span></ins>
                                    <!--<del><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">₹</span>20.00</bdi></span></del>-->
                                </td>
                                <td class="product-date">
                                    <time class="entry-date" datetime="2024-11-21 03:54:24">November 21, 2024</time>
                                </td>
                                <td class="product-stock">
                                    <p class="stock in-stock"><span><i class="fas fa-check"></i></span><span class="tinvwl-txt">In stock</span></p>
                                </td>
                                <td class="product-action">
                                    <button class="button vs-btn alt" name="tinvwl-add-to-cart" value="60" title="Add to Cart">
                                        <i class="fal fa-shopping-cart"></i><span class="tinvwl-txt">Add to Cart</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <button type="button" class="button vs-btn alt" id="sn-wishlist-delete" aria-label="Delete selected wishlist products">
                      <i class="fal fa-trash-alt" aria-hidden="true"></i> DELETE
                    </button>
                    <p id="sn-wishlist-status" role="status" aria-live="polite"></p>
                </form>
               

            </div>
        </div>
    </div>
    <!--======== / Wishlist Section ========-->
  
   

  <script src="assets/js/sn-wishlist.js"></script>
@endsection

@section('page_script')
@endsection
