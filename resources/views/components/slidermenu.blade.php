<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <h1>
                <a href="{{route('home')}}" class="navbar-brand text-light">Dashboard</a>
            </h1>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <ul class="metismenu" id="menu">
                        @if(Auth::user()->hasRole('admin'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i
                                    class="fa fa-shopping-basket"></i><span>Items</span></a>
                            <ul class="collapse">
                                <li><a href="{{route('item.create')}}">Add</a></li>
                                <li><a href="{{route('item.index')}}">List</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i
                                    class="fa fa-tags"></i><span>Item Type</span></a>
                            <ul class="collapse">
                                <li><a href="{{route('type.create')}}">Add</a></li>
                                <li><a href="{{route('type.index')}}">List</a></li>
                            </ul>
                        </li>
                        @endif
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-credit-card"></i><span>Sale &
                                    Service</span></a>
                            <ul class="collapse">
                                <li><a href="{{route('voucher.create')}}">Add</a></li>
                                <li><a href="{{route('voucher.index')}}">Voucher List</a></li>
                                <li><a href="{{route('salelist')}}">Sale List</a></li>
                                <li><a href="./servicesList.php">Service List</a></li>
                            </ul>
                        </li>
                        @if(Auth::user()->hasRole('admin'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i
                                    class="ti-dashboard"></i><span>Service</span></a>
                            <ul class="collapse">
                                <li><a href="{{route('service.create')}}">Add</a></li>
                                <li><a href="{{route('service.index')}}">Service List</a></li>
                            </ul>
                        </li>
                        @endif
                        <!-- <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i
                                    class="ti-credit-card"></i><span>Sale</span></a>
                            <ul class="collapse">
                                <li><a href="./Sale.php">Add</a></li>
                                <li><a href="./saleList.php">List</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i
                                    class="ti-dashboard"></i><span>Service</span></a>
                            <ul class="collapse">
                                <li><a href="./services.php">Add</a></li>
                                <li><a href="./servicesList.php">List</a></li>
                            </ul>
                        </li> -->
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i
                                    class="ti-user"></i><span>Customer</span></a>
                            <ul class="collapse">
                                <li><a href="{{route('customer.create')}}">Add</a></li>
                                <li><a href="{{route('customer.index')}}">List</a></li>
                            </ul>
                        </li>
                         @if(Auth::user()->hasRole('admin'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i
                                    class="ti-shopping-cart-full"></i><span>Purchase</span></a>
                            <ul class="collapse">
                                <li><a href="{{route('purchase.create')}}">Add</a></li>
                                <li><a href="{{route('purchase.index')}}">List</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-stats-up"></i><span>General
                                    Cost</span></a>
                            <ul class="collapse">
                                <li><a href="{{route('generalcost.create')}}">Add</a></li>
                                <li><a href="{{route('generalcost.index')}}">List</a></li>
                            </ul>
                        </li>
                       
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-na"></i><span>Usage
                                    Items</span></a>
                            <ul class="collapse">
                                <li><a href="{{route('usage.create')}}">Add</a></li>
                                <li><a href="{{route('usage.index')}}">List</a></li>
                            </ul>
                        </li>
                        
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i
                                    class="ti-id-badge"></i><span>User</span></a>
                            <ul class="collapse">
                                <li><a href="{{route('user.create')}}">Add</a></li>
                                <li><a href="{{route('user.index')}}">List</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i
                                    class="ti-face-smile"></i><span>Staff</span></a>
                            <ul class="collapse">
                                <li><a href="{{route('staff.create')}}">Add </a></li>
                                <li><a href="{{route('staff.index')}}">List</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i
                                    class="ti-money"></i><span>Salary</span></a>
                            <ul class="collapse">
                                <li><a href="{{route('salary.create')}}">Add </a></li>
                                <li><a href="{{route('salary.index')}}">List</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i
                                    class="ti-home"></i><span>Counter</span></a>
                            <ul class="collapse">
                                <li><a href="{{route('counter.create')}}">Add</a></li>
                                <li><a href="{{route('counter.index')}}">Counter List</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i
                                    class="ti-home"></i><span>Reports</span></a>
                            <ul class="collapse">
                                <!-- <li><a href="./purchase-report.php">Purchase Report</a></li> -->
                                <li><a href="./inventory.php">Inventory</a></li>
                            </ul>
                        </li>
                        @endif
                    </ul>
            </nav>
        </div>
    </div>
</div>