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

    if(isset($_SESSION['username'])){
        $stmt = $con->prepare("SELECT * FROM users WHERE UserName = ?");
        $stmt->execute(array($_SESSION['username']));
        $info = $stmt->fetch();
        
?>
<div class="info">
    <div class="container">
        <h1 class="text-center m-5">Profile Info</h1>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-dark">
                        <span class="title">Profile Info</span> <a href="#" class="edit btn btn-primary float-end">Edit</a>
                    </div>
                    <ul class="list-group list-group-flush" style="font-size: 18px;">
                        <li class="list-group-item">User name <span class="float-end fw-bold"><?php echo $info['UserName'] ?></span></li>
                        <li class="list-group-item">Full name <span class="float-end fw-bold"><?php echo $info['FullName'] ?></span></li>  
                        <li class="list-group-item">Email <span class="float-end fw-bold"><?php echo $info['Email'] ?></span></li>  
                        <li class="list-group-item">registered date <span class="float-end fw-bold"><?php echo $info['Date'] ?></span></li>
                    </ul>
                </div>
            </div> 
        </div>
    </div>
</div>

<?php
    } else {
        header('location: index.php');
        exit();
    }
    include "includes/template/footer.php";
?>