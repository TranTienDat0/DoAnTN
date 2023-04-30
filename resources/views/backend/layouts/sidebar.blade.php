<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    @if (Auth()->user()->role == 1)
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Banner
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-image"></i>
                <span>Banners</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Banner Options:</h6>
                    <a class="collapse-item" href="{{ route('banner') }}">Banners</a>
                    <a class="collapse-item" href="{{ route('banner.create') }}">Add Banners</a>
                </div>
            </div>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            Shop
        </div>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#shippingCollapse"
                aria-expanded="true" aria-controls="shippingCollapse">
                <i class="fas fa-fw fa-folder"></i>
                <span>Blog</span>
            </a>
            <div id="shippingCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">blog Options:</h6>
                    <a class="collapse-item" href="{{ route('blog') }}">Blog</a>
                    <a class="collapse-item" href="{{ route('blog.create') }}">Add Blog</a>
                </div>
            </div>
        </li>
        <!-- Categories -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categoryCollapse"
                aria-expanded="true" aria-controls="categoryCollapse">
                <i class="fas fa-sitemap"></i>
                <span>Category</span>
            </a>
            <div id="categoryCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Category Options:</h6>
                    <a class="collapse-item" href="{{ route('category') }}">Category</a>
                    <a class="collapse-item" href="{{ route('category.create') }}">Add Category</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#brandCollapse"
                aria-expanded="true" aria-controls="brandCollapse">
                <i class="fas fa-table"></i>
                <span>Sub Category</span>
            </a>
            <div id="brandCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Sub Category Options:</h6>
                    <a class="collapse-item" href="{{ route('subcategory') }}">Sub Category</a>
                    <a class="collapse-item" href="{{ route('subcategory.create') }}">Sub Add Category</a>
                </div>
            </div>
        </li>
        {{-- Products --}}
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productCollapse"
                aria-expanded="true" aria-controls="productCollapse">
                <i class="fas fa-cubes"></i>
                <span>Products</span>
            </a>
            <div id="productCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Product Options:</h6>
                    <a class="collapse-item" href="{{ route('products') }}">Products</a>
                    <a class="collapse-item" href="{{ route('products.create') }}">Add Product</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('message.index') }}">
                <i class="fas fa-comments"></i>
                <span>Message</span>
            </a>
        </li>

        <!--Orders -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('order.index') }}">
                <i class="fas fa-hammer fa-chart-area"></i>
                <span>Orders</span>
            </a>
        </li>

        <!-- Reviews -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.review') }}">
                <i class="fas fa-comments"></i>
                <span>Reviews</span>
            </a>
        </li>


        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Posts
        </div>
        <!-- Comments -->
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="fas fa-comments fa-chart-area"></i>
                <span>Comments</span>
            </a>
        </li>
    @endif


    <!-- Divider -->

    <!-- Users -->
    @if (Auth()->user()->role == 2)
        <hr class="sidebar-divider d-none d-md-block">
        <!-- Heading -->
        <div class="sidebar-heading">
            General Settings
        </div>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('users') }}">
                <i class="fas fa-users"></i>
                <span>Users</span></a>
        </li>
    @endif
    <!-- General settings -->
    {{-- <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-cog"></i>
            <span>Settings</span></a>
    </li> --}}

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
