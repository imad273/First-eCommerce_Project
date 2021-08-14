<?php
    session_start();
    // Title
    $title = "Home";
    // import requied file 
    require "admin/config.php";
    include "func.php";
    include "includes/languages/english.php";
    include "includes/template/header.php";
    include "includes/template/navbar.php";

?>

<div class="container home">
    <h1 class="text-center m-3">Home page</h1>
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

<?php
    include "includes/template/footer.php";
?>