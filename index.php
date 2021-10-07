<?php
    session_start();
    // Title
    $title = "Home";
    // import requied file 
    require "admin/config.php";
    include "func.php";
    include "includes/template/header.php";
    include "includes/template/navbar.php";
?>

<section class="hero">
    <div class="container">
        <div class="content">
            <h1>Welcome To The World Of TRUC<span>TRY</span></h1>
            <p>You can sell anything you don't use or don't need in our store. <br> Electronic Devices, Home furnishings...</p>
            <a href="#" class="btn btn-primary">Explore</a>
        </div>
    </div>
</section>

<section class="last-prod pb-5">
    <div class="container home">
        <h1 class="text-center">Latest offers</h1>
        <?php
            $stmt = $con->prepare("SELECT * FROM items ORDER BY ItemID DESC");
            $stmt->execute();
            $items = $stmt->fetchAll();
            echo "<div class='row'>";
            foreach($items as $item){ ?>
                <div class="col-sm-6 col-md-3">
                    <div class="card mt-3">
                        <img src="admin/uploads/images/<?php echo $item['images'] ?>" class="card-img-top">
                        <div class="card-body">
                            <p class="card-title title"><?php echo $item['Name'] ?></p>
                            <p class="card-text desc"><?php echo $item['Description'] ?></p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item float-end">Price: <span class="fw-bold float-end"><?php echo $item['Price'] ?></span></li>
                                <li class="list-group-item"></li>
                            </ul>
                            <a href="showItem.php?id=<?php echo $item['ItemID'] ?>" class="btn btn-primary float-end">More Details</a>
                        </div>
                    </div>
                </div>
            <?php
            }
            echo "</div>";
        ?>
    </div>
</section>
<!-- Footer -->
<footer class="page-footer font-small pt-4">
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-6 mt-md-0 mt-3 text-center">
                <h3 class="text-uppercase lgoo">TRUC<span>TRY</span></h3>
                <h5>Location</h5>
                <p>Some Where In The World</p>
            
            </div>
            <div class="col-md-3 mb-md-0 mb-3">
                <h5>Social Media</h5>
                <ul class="list-unstyled">
                    <li><a href="#!">Facebook</a></li>
                    <li><a href="#!">Instagram</a></li>
                    <li><a href="#!">Twitter</a></li>
                    <li><a href="#!">Linkedln</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-md-0 mb-3">
                <h5>Help</h5>
                <ul class="list-unstyled">
                    <li><a href="#!">Help Center</a></li>
                    <li><a href="#!">Contact Us</a></li>
                    <li><a href="#!">Privacy Palicy</a></li>
                    <li><a href="#!">Terms</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright text-center py-3">
        ©2021 Copyright, All Right Reserved.
    </div>
</footer>

<?php
    include "includes/template/footer.php";
?>