@include('partials/heading')
<div class="page-container">
    <!-- slidermenu -->
    
    @include('components/slidermenu')
    <div class="main-content">
        <!-- header area -->
        
        @include('components/headerArea')
       @yield('content')
    </div>
  
    @include('partials/footer')

   @yield('script')