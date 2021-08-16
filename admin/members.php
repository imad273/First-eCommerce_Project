<?php
    session_start();
    // Title of this page  
    $title = "Members";

    // import required file
    require "config.php";
    include "func.php";
    include "includes/template/header.php";
    include "includes/template/navbar.php";
    
    // Check if user come from login page or External link
    if(isset($_SESSION['admin'])){
        $link = isset($_GET['action']) ? $_GET['action'] : "manage";
    
        if($link == "manage"){ // manage members page 
            $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1");
            $stmt->execute();
            $rows = $stmt->fetchAll();
        ?> 
            <h1 class="text-center" style="padding: 15px;">Manage Member</h1>
            <div class="container member">
                <div class="add-btn">
                    <a href='members.php?action=add' class="btn btn-primary float-end"><i class='bx bxs-add-to-queue'></i> Add new members</a>
                </div>
                <div class="table-responsive">
                    <table class="table text-center table-bordered" style="border-color: #eee;">
                        <tr class="main-row">
                            <td class="fw-bold">#ID</td>
                            <td class="fw-bold">UserName</td>
                            <td class="fw-bold">Email</td>
                            <td class="fw-bold">FullName</td>
                            <td class="fw-bold">Register Date</td>
                            <td class="fw-bold">Control</td>
                        </tr>
                    <?php 
                        foreach($rows as $row){ ?>
                            <tr class="data-table">
                                <td><?php echo $row['UserID']; ?></td>
                                <td><?php echo $row['UserName']; ?></td>
                                <td><?php echo $row['Email']; ?></td>
                                <td><?php echo $row['FullName']; ?></td>
                                <td><?php echo $row['Date']; ?></td>
                                <td>
                                    <a href="members.php?action=edit&id=<?php echo $row['UserID'] ?>" class="btn btn-success"><i class='bx bx-edit-alt'></i> Edit</a>
                                    <a href="members.php?action=delete&id=<?php echo $row['UserID'] ?> " class="btn btn-danger confirm"><i class='bx bxs-trash'></i> Delete</a>
                                </td>
                            </tr>
                        <?php
                        } 
                        ?>
                    </table>
                </div>
            </div>
        <?php 
        } elseif($link == "add"){ // add members page ?>
            <h1 class="text-center" style="padding: 20px;">Add New Member</h1>
            <div class="container">
                <form class="m-auto pt-2" method="POST" action="?action=insert">
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label fw-bold">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" id="inputEmail3" required="required" autocomplete="off" placeholder="UserName">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-2 col-form-label fw-bold">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" id="inputPassword3" placeholder="Password" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-2 col-form-label fw-bold">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="inputPassword3" required="required" autocomplete="off" placeholder="Email">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-2 col-form-label fw-bold">Full Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="inputPassword3" required="required" autocomplete="off" placeholder="Full name">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-end mb-3" style="width: 80px;">Save</button>
                </form>
            </div>
        <?php
        } elseif($link == "insert"){ // insert memeber page 
            echo "<h1 class='text-center m-4'>Add New Member</h1>";
            echo "<div class='container'>";

            $value = $_POST['username'];
            $check = checkItems("UserName", "users", "$value");
            if($check == 1){
                echo "<p class='alert alert-danger'>UserName is already Taken</p>";
                echo "<a href='members.php?action=add' class='btn btn-primary m-2 float-end'><i class='bx bx-arrow-back m-1'></i> Back To Add member page</a>";
            } else {
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
                    $password = filter_var(sha1($_POST['password']), FILTER_SANITIZE_STRING);
                    $email    = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
                    $name     = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    
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
                        // Insert data in Database with this info
                        $stmt = $con->prepare("INSERT INTO users (UserName, Password, Email, FullName, Date) VALUE ('$username','$hashPass', '$email', '$name', now())");
                        $stmt->execute();
                        // echo Success Message
                        echo "<p class='alert alert-success'> Data Inserted Successful, " . $stmt->rowCount() . ' Record Update</p>';
                        ?>
                        <a href="members.php?action=add" class="btn btn-primary m-2 float-end"><i class='bx bx-arrow-back m-1'></i> Back To Add page</a>
            <?php 
                    }
                } else{
                    $errorMsg = "You can't Browse this Page directly";
                    redirectHome($errorMsg);
                }
            }
            echo "</div>";
        } elseif ($link == "edit") { // Edit memeber page 
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
                redirectHome($errorMsg);
            } 
        } elseif ($link == "update") { // Update member page
            echo "<h1 class='text-center m-4'>Member Update</h1>";
            echo "<div class='container'>";
            
            // check if username exist in database or not
            $value = $_POST['username'];
            $check = checkItems("UserName", "users", "$value");
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
                        <a href="members.php?action=edit&id=<?php echo $_SESSION['ID']; ?>" class="btn btn-primary m-2 float-end"><i class='bx bx-arrow-back m-1'></i> Back To edit page</a>
                <?php 
                    }  
                } else {
                    $errorMsg = "You can't Browse this Page directly";
                    redirectHome($errorMsg);
                } 
            }
            echo "</div>";
        } elseif($link == "delete"){ // delete member page
            echo "<h1 class='text-center m-4'>Delete Member</h1>";
            echo "<div class='container'>";
            // check if Get request 'id' is numeric 
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : "sory";
            // Select 'UserID' from database
            $stmt = $con->prepare("SELECT * FROM users WHERE UserID = '$id'");
            $stmt->execute();
    
            // Make sure id is exist in database 
            if($stmt->rowCount() === 1){
                $stmt = $con->prepare("DELETE FROM users WHERE UserID = '$id'");
                $stmt->execute();
                echo "<p class='alert alert-info'> Data Update Successful, " . $stmt->rowCount() . ' Record Deleted</p>';
                echo '<a href="members.php" class="btn btn-primary m-2 float-end"><i class="bx bx-arrow-back m-1"></i> Back To Manage Members page</a>';
            }
            echo "</div>";
        }
         else {
            echo "<div class='container'>";
                echo "<p class='alert alert-danger m-5'>error: Page not exsit</p>";
            echo "<div>";
        }
    } else {
        // if user not login go to the login form
        header('location: index.php');
        exit();
    }

    include "includes/template/footer.php";  
?>