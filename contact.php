<?php
    session_start();
    // Title
    $title = "Contact";
    // import requied file 
    require "admin/config.php";
    include "func.php";
    include "includes/template/header.php";
    include "includes/template/navbar.php";

    if(isset($_POST['submit'])){
        $from = $_POST['email'];
        $subject = "Message from website";
        $message = $_POST['msg'];
        $headers = "From: " . $from . "\r\n";
        
        mail("abbadimad0123@gmail.com", $subject, $message, $headers);

    }
      
?>

    <div class="container">
        <h1 class="text-center p-5">Contact</h1>
        <form action="contact.php" method="POST" style="margin: 0px auto; margin-top: 10px">
            <input type="text" class="form-control" placeholder="Your Name">
            <input type="text" name="email" class="form-control" placeholder="Your Email">
            <textarea name="msg" class="form-control" cols="30" rows="6" placeholder="Message..."></textarea>
            <button type="submit" name="submit" class="btn btn-primary float-end mt-3">Send</button>
        </form>
    </div>

<?php
    include "includes/template/footer.php";
?>