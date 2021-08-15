<?php
    session_start();
    // Title
    $title = "Create Account";
    // import required file 
    require "admin/config.php";
    include "func.php";
    include "includes/template/header.php";
    include "includes/template/navbar.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $password = sha1($_POST['password']);
        $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $name     = $_POST['name'];
               
        $value = $username;
        $check = checkItem("users", "UserName", $value);

        if($check == 1){
            echo "<div class='container'>";
                echo "<p class='alert alert-danger'>Username is already taken</p>";
            echo "</div>";
        } else {
            $stmt = $con->prepare("INSERT INTO users(UserName, Password, Email, FullName, Date) VALUE(?, ?, ?, ?, now())");
            $stmt->execute(array($username, $password, $email, $name));
            if($stmt->rowCount() > 0){
                $_SESSION['username'] = $username;
                echo "<div class='container'>";
                    echo "<p class='alert alert-success'>Account has been successfully registered</p>";
                    echo "<p class='alert alert-info'>You will go to the home page after 5 seconds</p>";
                echo "</div>";
                header("refresh: 5; url=index.php");
            }   
        }
    }
?>
    <h1 class="text-center" style="padding: 20px;">Create Account</h1>
        <div class="container">
            <form class="m-auto pt-2" method="POST" action="singUp.php">
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
                <button type="submit" class="btn btn-primary float-end mb-3" style="width: 80px;">SingUp</button>
            </form>
        </div>

<?php
    include "includes/template/footer.php";
?>