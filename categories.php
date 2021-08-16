<?php
    // Title
    $title = "Categories | " . str_replace("-", " ", $_GET['catname']);
    // import requied file 
    require "admin/config.php";
    include "func.php";
    include "includes/template/header.php";
    include "includes/template/navbar.php";
?>

<div class="container">
    <h1 class="text-center m-3"><?php echo str_replace("-", " ", $_GET['catname']) ?></h1>
    <?php
        $id = $_GET['catid'];
        $items = showItem("items", $id);
        echo "<div class='row'>";
        foreach($items as $item){ ?>
                <div class="col-sm-6 col-md-3">
                    <div class="card">
                    <img src="admin/uploads/images/<?php echo $item['images'] ?>" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $item['Name'] ?></h5>
                            <p class="card-text"><?php echo $item['Description'] ?></p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item float-end">Price: <span class="fw-bold float-end"><?php echo $item['Price'] ?></span></li>
                                <li class="list-group-item"></li>
                                
                            </ul>
                            <a href="#" class="btn btn-primary float-end">More Details</a>
                        </div>
                    </div>
                </div>
        <?php
        }
        echo "</div>";
    ?>
</div>


<?php
    include "includes/template/footer.php";
?>