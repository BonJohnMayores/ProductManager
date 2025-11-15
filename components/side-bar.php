    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="sidebar-sticky pt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?=$title=='Dashboard'?'active':''?>" href="dashboard.php">
                        <span data-feather="home"></span>
                        Dashboard <span class="sr-only">(current)</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?=$title=='Products'?'active':''?>" href="products.php">
                        <span data-feather="shopping-cart"></span>
                        Products
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?=$title=='Orders'?'active':''?>" href="orders.php">
                        <span data-feather="file-text"></span>
                        Orders
                    </a>
                </li>

            </ul>
        </div>
    </nav>