<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="/static/css/defaults.css"> 
        <link rel="stylesheet" href="/static/css/forms.css"> 
        <link rel="stylesheet" href="/static/css/admin.css"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <base href="/">
        <title><?php echo $Title; ?></title>
        <script src="/static/js/sidenav.js" defer></script>
        <script src="/static/js/admin.js" defer></script>
        </script>
    </head>
<body>
<div class="top-nav">
        <a class="top-nav-heading" href="/">
        <i class="fa-solid fa-microchip"></i>
        <h1 >HARDWARE <br> WORLD</h1>
        </a>
    <div class="top-nav-right">
        <input class="side-menu" type="checkbox" id="side-menu"/>
        <label class="hamb" for="side-menu"><span class="hamb-line"></span></label>
        <div class="top-nav-links">
            <?php 
                if(!is_authenticated()) {
                    echo "<a href='/auth/login.php'>Login</a>";
                } else {
                    echo "<a href='/auth/logout.php'>Logout</a>";
                }
            ?>
        </div>
    </div>
</div>

<main>

<div class="sidebar">
    <h1 class="sidebar-header">DASHBOARD</h1>
    <a href="/admin/users/">
        <div class="sidebar-item">
            <i class="fa-solid fa-user"></i>
            Users
        </div>
        <a href="/admin/customers/">
            <div class="sidebar-sub-item">
                <i class="fa-solid fa-bag-shopping"></i>
                Customers
            </div>
        </a>
        <a href="/admin/staff/">
            <div class="sidebar-sub-item">
                <i class="fa-solid fa-chalkboard-user"></i>
                Staff
            </div>
        </a>
        <a href="/admin/couriers/">
            <div class="sidebar-sub-item">
                <i class="fa-solid fa-box"></i>
                Couriers
            </div>
        </a>
    </a>
    <a href="/admin/vendor/">
        <div class="sidebar-item">
            <i class="fa-solid fa-briefcase"></i>
            Vendors
        </div>
    </a>
    <a href="/admin/products">
        <div class="sidebar-item">
            Products 
        </div>
        <a href="/admin/category/">
            <div class="sidebar-sub-item">
                <i class="fa-solid fa-list"></i>
                Categories
            </div>
        </a>
        <a href="/admin/subcategory/">
            <div class="sidebar-sub-item">
                <i class="fa-solid fa-bars-staggered"></i>
                Subcategories
            </div>
        </a>
        <a href="/admin/brands/">
            <div class="sidebar-sub-item">
                <i class="fa-solid fa-trademark"></i>
                Brand
            </div>
        </a>
        <a href="/admin/products/">
            <div class="sidebar-sub-item">
                <i class="fa-solid fa-tags"></i>
                Products
            </div>
        </a>
    </a>

    <a href="/admin/purchase/">
        <div class="sidebar-item">
            <i class="fa-solid fa-basket-shopping"></i>
            Purchases
        </div>
    </a>

    <a href="/dashboard/purchases/">
        <div class="sidebar-item">
            <i class="fa-solid fa-cart-shopping"></i>
            User Carts
        </div>
    </a>

    <a href="/admin/orders">
        <div class="sidebar-item">
            Sales 
        </div>
        <a href="/admin/categories/">
            <div class="sidebar-sub-item">
                <i class="fa-solid fa-cart-arrow-down"></i>
                Orders
            </div>
        </a>
        <a href="/admin/subcategories/">
            <div class="sidebar-sub-item">
            <i class="fa-solid fa-credit-card"></i>
                Cards
            </div>
        </a>
        <a href="/admin/subcategories/">
            <div class="sidebar-sub-item">
                <i class="fa-solid fa-dollar-sign"></i>
                Payments
            </div>
        </a>
        <a href="/admin/products/">
            <div class="sidebar-sub-item">
                <i class="fa-solid fa-truck"></i>
                Deliveries
            </div>
        </a>
    </a>
    <a href="/auth/logout.php">
        <div class="sidebar-item">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            Log out 
        </div>
    </a>

</div>
<div class="content">
