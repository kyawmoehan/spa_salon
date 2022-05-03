    <!-- footer area start-->
    <footer>
        <div class="footer-area">
            <p>© Copyright 2022. All right reserved. create by<a href=""> Sirier Tech</a>.
            </p>
        </div>
    </footer>
    <!-- footer area end-->
    <!-- page container area end -->
    <!-- jquery latest version -->
    <script src="{{asset('assets/js/vendor/jquery-2.2.4.min.js')}}"></script>
    <!-- bootstrap 4 js -->
    <script src="{{asset('assets/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/js/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.slicknav.min.js')}}"></script>

    <!-- start chart js -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script> -->
    <!-- start highcharts js -->
    <!-- <script src="https://code.highcharts.com/highcharts.js"></script> -->
    <!-- start zingchart js -->
    <!-- <script src="https://cdn.zingchart.com/zingchart.min.js"></script> -->
    <!-- <script>
zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script> -->
    <!-- all line chart activation -->
    <script src="{{asset('assets/js/line-chart.js')}}"></script>
    <!-- all pie chart -->
    <script src="{{asset('assets/js/pie-chart.js')}}"></script>
    <!-- others plugins -->
    <script src="{{asset('assets/js/plugins.js')}}"></script>
    <script src="{{asset('assets/js/scripts.js')}}"></script>
    <script src="{{asset('assets/js/script.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('assets/data-table/datatable.js')}}"></script>
    <script src="{{asset('assets/js/select2.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        
            $('.cus_check_btn').on('click', function() {
                var cus_id = $(this).data('cus_id');
                $('.sale_service_header').html(cus_id);
            })
            $('input[name="item_or_sevice"]').click(() => {
                let radiocheck = $('input[name="item_or_sevice"]:checked').val();
                if (radiocheck == 'item') {
                    $('.item-box').removeClass('d-none');
                    $('.service-box').addClass('d-none');
                } else {
        
                    $('.item-box').addClass('d-none');
                    $('.service-box').removeClass('d-none');
                }
            })
        });
            </script>
        
        
        <script>
            $(document).ready(function(){
         
         // Initialize select2
         $("#selItem").select2();
        
         // Read selected option
         $('#but_read').click(function(){
           var username = $('#selItem option:selected').text();
           var userid = $('#selItem').val();
        
           $('#result').html("id : " + userid + ", name : " + username);
        
         });
        });
        
        </script>
    </body>

    </html>