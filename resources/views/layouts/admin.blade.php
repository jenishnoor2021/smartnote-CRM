<!DOCTYPE html>
<html lang="en">

<head>
  @include('includes.head')
</head>

<body>

  @include('includes.topbar')

<!-- Page container -->
<div class="page-container">
  <!-- Page content -->
  <div class="page-content">

    @include('includes.sidebar')

    <div class="content-wrapper">
  
        @yield('content')

        @include('includes.footer')

    </div>
    <!-- /Main content -->

  </div>
  <!-- /Page content -->
</div>
<!-- /Page container -->


@yield('script')

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'csrftoken': '{{ csrf_token() }}'
    }
  });
</script>

<!-- read more button in database -->
<script type="text/javascript">
  $('.read-more-content').addClass('hide_content')
  $('.read-more-show, .read-more-hide').removeClass('hide_content')

  // Set up the toggle effect:
  $('.read-more-show').on('click', function(e) {
    $(this).next('.read-more-content').removeClass('hide_content');
    $(this).addClass('hide_content');
    e.preventDefault();
  });

  // Changes contributed by @diego-rzg
  $('.read-more-hide').on('click', function(e) {
    var p = $(this).parent('.read-more-content');
    p.addClass('hide_content');
    p.prev('.read-more-show').removeClass('hide_content'); // Hide only the preceding "Read More"
    e.preventDefault();
  });
</script>
<!-- read more button end in database -->

<script>
  // $(document).ready(function() {
  //   $("#partytable").DataTable();
  // });
</script>

</body>

</html>