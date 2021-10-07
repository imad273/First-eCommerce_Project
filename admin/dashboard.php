<?php
session_start();
// Title of this page  
$title = "Dashboard";

// import requied file 
require "config.php";
include "func.php";
include "includes/template/header.php";
include "includes/template/navbar.php";


// Check if user come from login page or External link
if (isset($_SESSION['admin'])) { ?>

   <div class="container home-stats text-center">
      <h1 class="m-4">Dashboard</h1>
      <div class="row">
         <div class="col-md-3 mt-2">
            <div class="stat">
               <i class='bx bx-user'></i>
               <p>Total Members</p>
               <span><a href="members.php"><?php echo countItems('UserID', 'users') ?></a></span>
            </div>
         </div>
         <div class="col-md-3 mt-2">
            <div class="stat">
               <i class='bx bxs-cart-download'></i>
               <p>Sales</p>
               <span>40</span>
            </div>
         </div>
         <div class="col-md-3 mt-2">
            <div class="stat">
               <i class='bx bx-purchase-tag-alt'></i>
               <p>Total Items</p>
               <span><a href="items.php"><?php echo countItems("itemID", "items") ?> </a></span>
            </div>
         </div>
         <div class="col-md-3 mt-2">
            <div class="stat">
               <i class='bx bx-dollar-circle'></i>
               <p>Earnings</p>
               <span>$2120</span>
            </div>
         </div>
      </div>
   </div>
   <div class="container latest">
      <div class="row">
         <div class="col-sm-6">
            <?php $limit = 5 ?>
            <div class="card">
               <div class="card-header">
                  <i class='bx bx-user-plus'></i> Latest <?php echo $limit ?> registerd users
               </div>

               <ul class="list-group list-group-flush">
                  <?php
                  $theLatest = getLatest('*', 'users', 'UserID', $limit);
                  foreach ($theLatest as $user) { ?>
                     <li class="list-group-item"> <?php echo $user['UserName'] ?> <a href="members.php?action=edit&id=<?php echo $user['UserID'] ?>" class="btn btn-success float-end"><i class='bx bx-edit-alt'></i> Edit</a></li>
                  <?php }
                  ?>
               </ul>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="card">
               <div class="card-header">
                  <?php $limit = 5 ?>
                  <i class='bx bx-purchase-tag-alt'></i> Latest <?php echo $limit ?> items
               </div>
               <ul class="list-group list-group-flush">
                  <?php
                  $theLatest = getLatest("*", "items", "ItemID", $limit);
                  foreach ($theLatest as $last) { ?>
                     <li class='list-group-item'><?php echo $last['Name']; ?><a href="items.php?action=edit&id=<?php echo $last['ItemID'] ?>" class="btn btn-success float-end"><i class='bx bx-edit-alt'></i> Edit</a></li>
                  <?php } ?>
               </ul>
            </div>
         </div>
      </div>
   </div>

<?php
} else {
   // if user not login go to the login form
   header('location: index.php');
   exit();
}
?>





<?php
include "includes/template/footer.php";
?>