<?php
    session_start();
    // Title
    $title = "Home";
    // import requied file 
    require "admin/config.php";
    include "func.php";
    include "includes/template/header.php";
    include "includes/template/navbar.php";

    if(isset($_SESSION['username'])){
        $stmt = $con->prepare("SELECT * FROM users WHERE UserName = ?");
        $stmt->execute(array($_SESSION['username']));
        $info = $stmt->fetch();
        $link = isset($_GET['action']) ? $_GET['action'] : "profile";
        if($link == "profile"){ ?>
            <div class="info">
                <div class="container">
                    <h1 class="text-center m-5">Profile Info</h1>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header bg-dark">
                                    <span class="title">Profile Info</span> <a href="profile.php?action=edit&id=<?php echo $info['UserID'] ?>" class="edit btn btn-primary float-end">Edit</a>
                                </div>
                                <ul class="list-group list-group-flush" style="font-size: 18px;">
                                    <li class="list-group-item">User name <span class="float-end fw-bold"><?php echo $info['UserName'] ?></span></li>
                                    <li class="list-group-item">Full name <span class="float-end fw-bold"><?php echo $info['FullName'] ?></span></li>  
                                    <li class="list-group-item">Email <span class="float-end fw-bold"><?php echo $info['Email'] ?></span></li>  
                                    <li class="list-group-item">registered date <span class="float-end fw-bold">
                                        <?php
                                        $df_date = $info['Date'];
                                        $date_stmt = $con->prepare("SELECT DATE_FORMAT('$df_date', '%b %D, %Y') AS date");
                                        $date_stmt->execute();
                                        $date = $date_stmt->fetch();
                                        echo $date['date'];?>
                                    </span></li>
                                </ul>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
<?php
        } elseif ($link == "edit"){
            // check if Get request 'id' is numeric 
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            // Select date 'UserID' from database
            $stmt = $con->prepare("SELECT * FROM users WHERE UserID = '$id'");
            $stmt->execute();
            $ftc = $stmt->fetch();
    
            // Make sure id is exist in database 
            if($stmt->rowCount() === 1){ ?>
                <h1 class="text-center" style="padding: 20px;">Edit Member</h1>
                <div class="container">
                    <form class="m-auto pt-2" method="POST" action="?action=update">
                        <input type="hidden" name="userid" value="<?php echo $id ?>">
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label fw-bold">Username</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" id="inputEmail3" required="required" autocomplete="off" value="<?php echo $ftc['UserName'] ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPassword3" class="col-sm-2 col-form-label fw-bold">Password</label>
                            <div class="col-sm-10">
                            <input type="hidden" name="oldpassword" value="<?php echo $ftc['Password'] ?>">
                            <input type="password" class="form-control" name="newpassword" id="inputPassword3" placeholder="New Password" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPassword3" class="col-sm-2 col-form-label fw-bold">Email</label>
                            <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="inputPassword3" required="required" value="<?php echo $ftc['Email'] ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPassword3" class="col-sm-2 col-form-label fw-bold">Full Name</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="inputPassword3" required="required" value="<?php echo $ftc['FullName'] ?>"">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-end mb-3" style="width: 80px;">Save</button>
                    </form>
                </div>
            <?php 
            // Else Show error message
            } else {
                $errorMsg ="error: No such Id";
            }
        } elseif ($link == "update") { // Update member page
            echo "<h1 class='text-center m-4'>Member Update</h1>";
            echo "<div class='container'>";
            
            // check if username exist in database or not
            $value = $_POST['username'];
            $check = checkItems("users", "UserName", "$value");
            if($check == 1){
                echo "<p class='alert alert-danger'>UserName is already taken</p>"; ?>
                <a href='members.php?action=edit&id=<?php echo $_SESSION['userid'] ?>' class='btn btn-primary m-2 float-end'><i class='bx bx-arrow-back m-1'></i> Back To edit page</a>
            <?php
            } else {
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $userid   = $_POST['userid'];
                    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
                    $email    = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
                    $name     = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    
                    // Password trick
                    if(empty($_POST['newpassword'])){
                        $pass = $_POST['oldpassword'];
                    } else {
                        $pass = sha1($_POST['newpassword']);
                    }
                    // Validate The form
                    $formError = array();
                    if(empty($username)){
                        $formError[] = "<p class='alert alert-danger m-3'>UserName cant be <strong>empty</strong></p>";
                    }
                    if(empty($email)){
                        $formError[] = "<p class='alert alert-danger m-3'>Email cant be <strong>empty</strong></p>";
                    }
                    if(empty($name)){
                        $formError[] = "<p class='alert alert-danger m-3'>Full Name cant be <strong>empty</strong></p>";
                    } 
    
                    if(strlen($username) < 4){
                        $formError[] = "<p class='alert alert-danger m-3'>User Name cant be less than <strong>4 characters</strong></p>";
                    }
                    if(strlen($username) > 20){
                        $formError[] = "<p class='alert alert-danger m-3'>UserName cant be More than <strong>20 characters</strong></p>";
                    }
                    foreach($formError as $error){
                        echo $error;
                    }
                    // check if there's no error 
                    if(empty($formError)){
                        // Update data to Database with this info
                        $stmt = $con->prepare("UPDATE users SET UserName = '$username', Password = '$pass', Email = '$email', FullName = '$name' WHERE UserID = '$userid'");
                        $stmt->execute();
                        // echo Success Message
                        echo "<p class='alert alert-success'> Data Update Successful, " . $stmt->rowCount() . ' Record Update</p>';
                    ?>
                        <a href="profile.php?action=edit&id=<?php echo $_SESSION['userid']; ?>" class="btn btn-primary m-2 float-end"><i class='bx bx-arrow-back m-1'></i> Back To edit page</a>
                <?php 
                    }  
                } else {
                    $errorMsg = "You can't Browse this Page directly";
                } 
            }
        }
    } else {
        header('location: login.php');
        exit();
    }
    include "includes/template/footer.php";
?>