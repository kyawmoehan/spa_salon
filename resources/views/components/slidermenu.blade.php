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
                                <li><a href="items.php">Add</a></li>
                                <li><a href="itemList.php">List</a></li>
                            </ul>
                        </li>
                        @endif
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-credit-card"></i><span>Sale &
                                    Service</span></a>
                            <ul class="collapse">
                                <li><a href="./sale&Service.php">Add</a></li>
                                <li><a href="./saleList.php">Sale List</a></li>
                                <li><a href="./servicesList.php">Service List</a></li>
                            </ul>
                        </li>
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
                                <li><a href="./purchase.php">Add</a></li>
                                <li><a href="./purchaseList.php">List</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-stats-up"></i><span>General
                                    Cost</span></a>
                            <ul class="collapse">
                                <li><a href="./gnCost.php">Add</a></li>
                                <li><a href="./gnCostList.php">List</a></li>
                            </ul>
                        </li>
                       
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-na"></i><span>Usage
                                    Items</span></a>
                            <ul class="collapse">
                                <li><a href="./usageItem.php">Add</a></li>
                                <li><a href="./usageItemList.php">List</a></li>
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
                                <li><a href="./salary.php">Add </a></li>
                                <li><a href="./salaryList.php">List</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i
                                    class="ti-home"></i><span>Counter</span></a>
                            <ul class="collapse">
                                <li><a href="./counter.php">Add</a></li>
                                <li><a href="./counterList.php">Counter List</a></li>
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