<?php
    session_start(); 
    // Title of this page 
    $title = "Admins";

    // import required file
    require "config.php";
    include "func.php";
    include "includes/template/header.php";
    include "includes/template/navbar.php";

    // Check if user come from login page or External link
    if(isset($_SESSION['admin'])){
        $link = isset($_GET['action']) ? $_GET['action'] : "manage";
        if($link == "manage"){ // manage admins page 
            $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 0");
            $stmt->execute();
            $rows = $stmt->fetchAll();
        ?>
            <h1 class="text-center" style="padding: 15px;">Admins</h1>
            <div class="container admins">
                <div class="table-responsive mt-5">
                    <table class="table text-center table-bordered" style="border-color: #eee;">
                        <tr class="main-row">
                            <td class="fw-bold">#ID</td>
                            <td class="fw-bold">UserName</td>
                            <td class="fw-bold">Email</td>
                            <td class="fw-bold">FullName</td>
                            <td class="fw-bold">Register Date</td>
                        </tr>
                    <?php 
                        foreach($rows as $row){ ?>
                            <tr class="data-table">
                                <td><?php echo $row['UserID']; ?></td>
                                <td><?php echo $row['UserName']; ?></td>
                                <td><?php echo $row['Email']; ?></td>
                                <td><?php echo $row['FullName']; ?></td>
                                <td><?php echo $row['Date']; ?></td>
                            </tr>
                        <?php
                        } 
                        ?>
                    </table>
                </div>
            </div>
<?php
        }
    } else {
        // if user not login go to the login form
        header('location: index.php');
        exit();
    }
    include "includes/template/footer.php";
?>