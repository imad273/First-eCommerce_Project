<?php
    session_start();
    // Title
    $title = "Detail";
    // import requied file 
    require "admin/config.php";
    include "func.php";
    include "includes/languages/english.php";
    include "includes/template/header.php";
    include "includes/template/navbar.php";


    $itemid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
    
    $stmt = $con->prepare("SELECT items.*, categories.Name AS Cat_Name FROM items INNER JOIN categories ON Cat_ID = ID WHERE ItemID = '$itemid'");
    $stmt->execute();
    $info = $stmt->fetch();

    if($stmt->rowCount() > 0){  ?>

    <div class="container detail">
        <div class="card mt-5 mb-5">
            <div class="card-header">
                Details
            </div>
            <div class="card-body">
                <img src="images/avatar.jpg" style="width: 200px;">
                <ul class="list-group list-group-flush" style="font-size: 18px;">
                        <li class="list-group-item">Name <span class="float-end fw-bold"><?php echo $info['Name'] ?></span></li>
                        <li class="list-group-item">Description <span class="float-end fw-bold"><?php echo $info['Description'] ?></span></li>  
                        <li class="list-group-item">Price <span class="float-end fw-bold"><?php echo $info['Price'] ?></span></li>  
                        <li class="list-group-item">Added date <span class="float-end fw-bold"><?php echo $info['Date'] ?></span></li>
                        <li class="list-group-item">Status <span class="float-end fw-bold"><?php if($info['Status'] == '1'){ 
                            echo "New";
                        } elseif ($info['Status'] == '2'){
                            echo "Like new"; 
                        } elseif ($info['Status'] == '3'){
                            echo "Used";
                        } elseif ($info['Status'] == '4'){
                            echo "Old";
                        } ?></span></li>
                        <li class="list-group-item">Category <span class="float-end fw-bold"><?php echo $info['Cat_Name'] ?></span></li>
                    </ul>
            </div>
        </div>
    </div>

<?php
    }
    include "includes/template/footer.php";
?>