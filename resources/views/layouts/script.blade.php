 <!--   Core JS Files   -->
 <script src="{{asset('admin/js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('admin/js/core/popper.min.js')}}"></script>
    <script src="{{asset('admin/js/core/bootstrap.min.js')}}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{asset('admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

    <!-- Chart JS -->
    <script src="{{asset('admin/js/plugin/chart.js/chart.min.js')}}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{asset('admin/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Chart Circle -->
    <script src="{{asset('admin/js/plugin/chart-circle/circles.min.js')}}"></script>

    <!-- Datatables -->
    <script src="{{asset('admin/js/plugin/datatables/datatables.min.js')}}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{asset('admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{asset('admin/js/plugin/jsvectormap/jsvectormap.min.js')}}"></script>
    <script src="{{asset('admin/js/plugin/jsvectormap/world.js')}}"></script>

    <!-- Sweet Alert -->
    <script src="{{asset('admin/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{asset('admin/js/kaiadmin.min.js')}}"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <!-- <script src="{{asset('admin/js/setting-demo.js')}}"></script>
    <script src="{{asset('admin/js/demo.js')}}"></script> -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <!-- <<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script> -->
    <!-- <script src="https://cdn.tiny.cloud/1/ec1esgrap7m9s6rxgnmqawgfljmwzvtoibiw92l38nc54om7/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/froala-editor/js/froala_editor.pkgd.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script> -->


    <script>
      $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
      });

      $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
      });

      $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
      });
    </script>

