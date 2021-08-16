<?php
    session_start();
    // Title
    $title = "Login";
    // import requied file 
    require "admin/config.php";
    include "func.php";
    include "includes/template/header.php";
    include "includes/template/navbar.php";


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $username = $_POST['user'];
        $password = sha1($_POST['password']);

        $stmt = $con->prepare("SELECT * FROM users WHERE UserName = ? AND Password = ?");
        $stmt->execute(array($username, $password));
        $info = $stmt->fetch();
        
        if($stmt->rowCount() > 0){
            $_SESSION['username'] = $username;
            $_SESSION['userid']   =  $info["UserID"];

            header('location: index.php');
        } else {
            echo "<div class='container'>";
                echo "<p class='alert alert-danger'>Your Username or password wrong</p>";
            echo "</div>";
        }  
    }
?>
    <section class="login">
        <form action="login.php" method="POST">
            <h2 class="text-center">Login</h2>
            <input type="text" class="form-control" name="user" placeholder="Username" autocomplete="off">
            <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
            <button type="submit" name="submit" class="btn btn-primary w-100">LOGIN</button>
        </form>
    </section>

<?php
    include "includes/template/footer.php";
?>