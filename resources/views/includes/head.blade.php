  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Auto Logout after 15 mins (15*60=900 seconds) of inactivity -->
  <meta http-equiv="refresh" content="900" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>NISL Demo | Admin Panel | Dashboard</title>

  <!-- Global stylesheets -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
  <link href="{{ asset('assets/admin/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('assets/admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('assets/admin/css/core.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('assets/admin/css/components.css') }}" rel="stylesheet" type="text/css">
  <style type="text/css">
      .datatable-select {
          border: 1px solid #ccc;
          padding: 5px;
          height: 35px;
          border-radius: 3px;
      }

      .btn-bottom-toolbar {
          position: fixed;
          bottom: 0;
          padding: 15px;
          padding-right: 41px;
          margin: 0 0 0 -46px;
          -webkit-box-shadow: 0 -4px 1px -4px rgba(0, 0, 0, .1);
          box-shadow: 0 -4px 1px -4px rgba(0, 0, 0, .1);
          background: #fff;
          width: calc(100% - 211px);
          z-index: 5;
          border-top: 1px solid #ededed;
      }

      @media (max-width: 767px) {
          .btn-bottom-toolbar {
              left: 0;
              margin-left: 0;
              padding: 10px 15px;
              width: 100%;
              text-align: right;
          }

          .btn-bottom-toolbar .btn {
              float: none;
          }
      }

      /* Drag & Drop Reordering Styles */
      .drag-handle {
          cursor: grab;
          cursor: -webkit-grab;
          color: #94a3b8;
          transition: color 0.2s ease;
      }
      .drag-handle:hover {
          color: #2196F3;
      }
      .drag-handle:active {
          cursor: grabbing;
          cursor: -webkit-grabbing;
      }
      tr.ui-sortable-helper {
          display: table !important;
          background-color: #ffffff !important;
          box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18) !important;
          border: 1px solid #2196F3 !important;
      }
      tr.ui-sortable-placeholder {
          display: table-row !important;
          background-color: #f1f5f9 !important;
          visibility: visible !important;
          height: 48px !important;
      }
      .pagination svg, nav svg {
          max-width: 20px !important;
          max-height: 20px !important;
      }
  </style>

  <!-- Core JS files -->
  <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/loaders/pace.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/admin/js/core/libraries/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/admin/js/core/libraries/bootstrap.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/loaders/blockui.min.js') }}"></script>
  <!-- /core JS files -->

  <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/forms/styling/switchery.min.js') }}"></script>

  <!-- Theme JS files -->
  <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/forms/validation/validate.min.js') }}"></script>

  <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/notifications/sweet_alert.min.js') }}"></script>

  <!-- date picker -->
  <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/ui/moment/moment.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/pickers/daterangepicker.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/pickers/anytime.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/pickers/pickadate/picker.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/pickers/pickadate/picker.time.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/pickers/pickadate/legacy.js') }}"></script>
  <!-- /date picker -->

  <!-- select box -->
  <script type="text/javascript" src="{{ asset('assets/admin/js/core/libraries/jquery_ui/interactions.min.js') }}">
  </script>
  <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/forms/selects/select2.min.js') }}"></script>
  <!-- /select box -->

  <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/notifications/jgrowl.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/editors/summernote/summernote.min.js') }}">
  </script>
  <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/forms/styling/uniform.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/admin/js/plugins/tables/datatables/datatables.min.js') }}">
  </script>
  <script type="text/javascript"
      src="{{ asset('assets/admin/js/plugins/tables/datatables/extensions/buttons.min.js') }}"></script>
  <script type="text/javascript"
      src="{{ asset('assets/admin/js/plugins/tables/datatables/extensions/jszip/jszip.min.js') }}"></script>
  <script type="text/javascript"
      src="{{ asset('assets/admin/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js') }}"></script>
  <script type="text/javascript"
      src="{{ asset('assets/admin/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js') }}"></script>

  <script type="text/javascript" src="{{ asset('assets/admin/js/core/app.js') }}"></script>

  <script type="text/javascript" src="{{ asset('assets/admin/js/common.js') }}"></script>

  <script type="text/javascript">
      // Default Settings for jQuery Validator
      $.validator.setDefaults({
          ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
          errorClass: 'validation-error-label',
          successClass: 'validation-valid-label',
          highlight: function(element, errorClass) {
              $(element).removeClass(errorClass);
          },
          unhighlight: function(element, errorClass) {
              $(element).removeClass(errorClass);
          },

          // Different components require proper error label placement
          errorPlacement: function(error, element) {

              // Styled checkboxes, radios, bootstrap switch
              if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") ||
                  element.parent().hasClass('bootstrap-switch-container')) {
                  if (element.parents('label').hasClass('checkbox-inline') || element.parents('label')
                      .hasClass('radio-inline')) {
                      error.appendTo(element.parent().parent().parent().parent());
                  } else {
                      error.appendTo(element.parent().parent().parent().parent().parent());
                  }
              }

              // Unstyled checkboxes, radios
              else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass(
                      'radio')) {
                  error.appendTo(element.parent().parent().parent());
              }

              // Input with icons and Select2
              else if (element.parents('div').hasClass('has-feedback') || element.hasClass(
                      'select2-hidden-accessible')) {
                  error.appendTo(element.parent());
              }

              // Inline checkboxes, radios
              else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label')
                  .hasClass('radio-inline')) {
                  error.appendTo(element.parent().parent());
              }

              // Input group, styled file input
              else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                  error.appendTo(element.parent().parent());
              } else {
                  error.insertAfter(element);
              }
          },
          validClass: "validation-valid-label",
          success: function(label) {
              label.addClass("validation-valid-label").text("")
          },
      });

      $(function() {
          // Default initialization for dropdown select
          $('.select').select2({
              minimumResultsForSearch: Infinity
          });

          //datatables default settings
          $.extend($.fn.dataTable.defaults, {
              autoWidth: false,
              order: [],
              dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
              language: {
                  search: '<span>Filter:</span> _INPUT_',
                  lengthMenu: '<span>Show:</span> _MENU_',
                  paginate: {
                      'first': '&lt;%lt;',
                      'last': '&gt;%gt;',
                      'next': '&gt;',
                      'previous': '&lt;'
                  }
              },
              buttons: {
                  dom: {
                      button: {
                          className: 'btn btn-default'
                      }
                  },
                  buttons: [
                      'copyHtml5',
                      'csvHtml5',
                      'pdfHtml5'
                  ]
              },
              "pageLength": 25,
              "lengthMenu": [
                  [10, 25, 50, 100, -1],
                  [10, 25, 50, 100, "All"]
              ],
              drawCallback: function() {
                  $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                  $(this).find(".styled, .checkbox").uniform({
                      radioClass: 'choice'
                  });
                  var switches = Array.prototype.slice.call(this.find('.switchery'));
                  switches.forEach(function(html) {
                      if (!html.nextSibling || !html.nextSibling.classList || !html.nextSibling.classList.contains('switchery')) {
                          new Switchery(html);
                      }
                  });
              }
          });

          //styled radio & checkboxes
          $(".styled").uniform({
              radioClass: 'choice'
          });

          /* Set Default options to all Sweet Alerts */
          swal.setDefaults({
              confirmButtonColor: "#2196F3",
              closeOnConfirm: true,
          });

          // Ensure OK button closes SweetAlert on success/info/error modals (where Cancel is hidden)
          $(document).on('click', '.sweet-alert button.confirm', function() {
              var $modal = $(this).closest('.sweet-alert');
              if (!$modal.find('button.cancel').is(':visible')) {
                  if (typeof swal !== 'undefined' && typeof swal.close === 'function') {
                      swal.close();
                  }
                  setTimeout(function() {
                      $('.sweet-alert, .sweet-overlay').removeClass('visible showSweetAlert').addClass('hideSweetAlert').hide();
                      $('body').removeClass('stop-scrolling');
                  }, 150);
              }
          });

          /* jQuery switch */
          var switches = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
          switches.forEach(function(html) {
              var switchery = new Switchery(html);
          });

          /*End of Jquery for checkbox switch */

          @if(session('success'))
          jGrowlAlert("{{ session('success') }}", 'success');
          @elseif(session('warning'))
          jGrowlAlert("{{ session('warning') }}", 'warning');
          @elseif(session('danger'))
          jGrowlAlert("{{ session('danger') }}", 'danger');
          @elseif(session('info'))
          jGrowlAlert("{{ session('info') }}", 'info');
          @endif
      });
  </script>