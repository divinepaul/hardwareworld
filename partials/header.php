<html>
    <head>
        <link rel="stylesheet" href="/static/css/defaults.css"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="/static/css/forms.css"> 
        <link rel="stylesheet" href="/static/css/sidebar.css"> 
        <link rel="stylesheet" href="/static/css/home.css"> 
        <base href="/">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <script src="/static/js/sidenav.js" defer></script>
        <title><?php echo $Title; ?></title>
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
                echo "<a href='/site/products'>Products</a>";
                echo "<a href='/site/products/brands'>Brands</a>";
                echo "<a href='/site/products/categories'>Categories</a>";
                echo "<a href='/auth/login.php'>Login</a>";
                echo "<a href='/auth/register.php'>Register</a>";
            } else {
                echo "<a href='/site/products'>Products</a>";
                echo "<a href='/site/products/brands'>Brands</a>";
                echo "<a href='/site/products/categories'>Categories</a>";
                echo "<a href='/user/cart.php'>Cart</a>";
                echo "<a href='/user/orders.php'>Orders</a>";
                echo "<a href='/auth/logout.php'>Logout</a>";
            }
        ?>
        </div>
        <!--<a href="/auth/register.php">Register</a> -->
    </div>
</div>
<main>
<div class="sidebar">
    <br>
    <br>

    <a href="/site/products">
        <div class="sidebar-item">
            <i class="fa-solid fa-basket-shopping"></i>
            Products
        </div>
    </a>

    <a href="/site/products/brands/">
        <div class="sidebar-item">
            <i class="fa-solid fa-trademark"></i>
            Brands 
        </div>
    </a>

    <a href="/site/products/categories/">
        <div class="sidebar-item">
            <i class="fa-solid fa-list"></i>
            Categories 
        </div>
    </a>

    <?php 
        if(!is_authenticated()) {
            echo '<a href="/auth/login.php/">
                <div class="sidebar-item">
                    <i class="fa-solid fa-user-lock"></i>
                    Login
                </div>
            </a>';
            echo '<a href="/auth/register.php/">
                <div class="sidebar-item">
                    <i class="fa-solid fa-user-plus"></i>
                    Register 
                </div>
            </a>';


        } else {
            echo '<a href="/dashboard/purchases/">
                <div class="sidebar-item">
                    <i class="fa-solid fa-cart-shopping"></i>
                    Cart
                </div>
            </a>';
            echo '<a href="/dashboard/purchases/">
                <div class="sidebar-item">
                    <i class="fa-solid fa-cart-arrow-down"></i>
                    Orders 
                </div>
            </a>';
            echo '<a href="/auth/logout.php">
                <div class="sidebar-item">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    Log out 
                </div>
            </a>';
        }
    ?>
</div>
