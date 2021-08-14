<?php
    session_start();    
    // Title of this page  
    $title = "Login"; 

    // Check if admin already login
    if(isset($_SESSION['admin'])){
        // if login go to dashboard directly
        header("location: dashboard.php");
    }

    // import requied file 
    require "config.php";
    include "func.php";
    include "includes/languages/english.php";
    include "includes/template/header.php";
    
    // check if admin account exist in Database    
    if(isset($_POST['submit'])){
        $user = $_POST['user'];
        $password = $_POST['password'];
        $hashed = sha1($password); // sha1 is function for hashing password
        // SQL statement 
        $stmt = $con->prepare("SELECT UserID, UserName, Password, Email, FullName FROM users WHERE UserName = '$user' AND Password = '$hashed' AND GroupID = 1");
        $stmt->execute();
        $ftc = $stmt->fetch();

        if($stmt->rowCount() === 1){
            $_SESSION['admin'] = $user;
            $_SESSION['ID'] = $ftc['UserID'];
            $_SESSION['email'] = $ftc['Email'];
            $_SESSION['name'] = $ftc['FullName'];
    

            header("location: dashboard.php"); // if user exist go to Dashboard page
        } else {
            echo "sorry you are not admin";
        }
    }
?>

    <section class="login">
        <form action="index.php" method="POST">
            <h2 class="text-center">Admin Login</h2>
            <input type="text" class="form-control" name="user" placeholder="Username" autocomplete="off">
            <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
            <button type="submit" name="submit" class="btn btn-primary w-100">LOGIN</button>
        </form>
    </section>

<?php
    include "includes/template/footer.php";
?>