<div class="inner-wrapper">
    <!-- start: sidebar -->
    <aside id="sidebar-left" class="sidebar-left">

        <div class="sidebar-header">
            <div class="sidebar-title">
                Navigation
            </div>
            <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html"
                data-fire-event="sidebar-left-toggle">
                <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>

        <div class="nano">
            <div class="nano-content">
                <nav id="menu" class="nav-main" role="navigation">

                    <ul class="nav nav-main">
                        <li @if($title=='Dashboard' ) class="nav-active" @endif>
                            <a class="nav-link" href="/admin">
                                <i class="fas fa-home" aria-hidden="true"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li @if($title=='Category' ) class="nav-active" @endif>
                            <a class="nav-link" href="{{Route('category')}}">
                                <i class="fas fa-list-alt" aria-hidden="true"></i>
                                <span>Category</span>
                            </a>
                        </li>
                        <li @if($title=='Product' ) class="nav-active" @endif>
                            <a class="nav-link" href="{{Route('product')}}">
                                <i class="fas fa-table" aria-hidden="true"></i>
                                <span>Product</span>
                            </a>
                        </li>
                        <li @if($title=='Couriers' ) class="nav-active" @endif>
                            <a class="nav-link" href="{{Route('couriers')}}">
                                <i class="fas fa-truck" aria-hidden="true"></i>
                                <span>Couriers</span>
                            </a>
                        </li>
                        @if ($admin->role == 'super admin')

                        <li @if($title=='Transaction' ) class="nav-active" @endif>
                            <a class="nav-link" href="{{Route('transaksi-admin')}}">
                                <i class="fa fa-file" aria-hidden="true"></i>
                                <span>Transaksi</span>
                            </a>
                        </li>
                        <li @if($title=='User' ) class="nav-active" @endif>
                            <a class="nav-link" href="{{Route('admin.add')}}">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span>User</span>
                            </a>
                        </li>   
                        @endif

                    </ul>
                </nav>



            </div>

            <script>
                // Maintain Scroll Position
                if (typeof localStorage !== 'undefined') {
                    if (localStorage.getItem('sidebar-left-position') !== null) {
                        var initialPosition = localStorage.getItem('sidebar-left-position'),
                            sidebarLeft = document.querySelector('#sidebar-left .nano-content');
                        
                        sidebarLeft.scrollTop = initialPosition;
                    }
                }
            </script>


        </div>

    </aside>
    <!-- end: sidebar -->
</div>