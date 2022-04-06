<div class="header-area py-1">
    <div class="row align-items-center">
        <!-- nav and search button -->
        <div class="col-sm-6">

            <div class="breadcrumbs-area clearfix d-flex justify-content-start align-items-center">
                <div class="nav-btn pull-left my-auto">
                    <i class="fa fa-bars fw-bolder" style="color:#7801ff;"></i>
                </div>
                <script>
                </script>
                <h4 class="page-title pull-left">Dashboard</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="index.php">Home</a></li>
                    <li><span>Dashboard</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix row d-flex justify-content-end align-items-center">
            <div class="user-profile  pull-right col-sm-11 d-flex justify-content-end pr-2">
                <img class="avatar user-thumb" src="{{asset('assets/images/author/avatar.png')}}" alt="avatar">
                <h4 class="user-name text-dark dropdown-toggle" data-toggle="dropdown">{{Auth::user()->name}} <i
                        class="fa fa-angle-down"></i></h4>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a class="dropdown-item" href="{{route('logout')}}"  onclick="event.preventDefault();
                        this.closest('form').submit();">Log Out</a>
                    </form>                    
                </div>
            </div>
            <ul class="notification-area pull-right col-sm-1 pr-0">
                <li id="full-view"><i class="fa fa-expand"></i></li>
                <li id="full-view-exit"><i class="fa fa-compress"></i></li>
            </ul>
        </div>
    </div>
</div>