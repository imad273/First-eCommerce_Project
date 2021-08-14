<?php
    session_start();
    // Title of this page  
    $title = "Items";

    // import required file
    require "config.php";
    include "func.php";
    include "includes/languages/english.php";
    include "includes/template/header.php";
    include "includes/template/navbar.php";

    // Check if user come from login page or External link
    if(isset($_SESSION['admin'])){
        $link = isset($_GET['action']) ? $_GET['action'] : "manage";

        if($link == "manage"){ // manage items page
            $stmt = $con->prepare("SELECT items.*, categories.Name AS cat_name FROM items INNER JOIN categories ON items.Cat_ID = categories.ID");
            $stmt->execute();
            $rows = $stmt->fetchAll();
        ?>
            <h1 class="text-center" style="padding: 20px;">Manage Items</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="table text-center table-bordered" style="border-color: #eee;">
                        <tr class="main-row">
                            <td class="fw-bold">#ID</td>
                            <td class="fw-bold">Name</td>
                            <td class="fw-bold">Description</td>
                            <td class="fw-bold">Price</td>
                            <td class="fw-bold">Status</td>
                            <td class="fw-bold">Category</td>
                            <td class="fw-bold">Adding Date</td>
                            <td class="fw-bold">Control</td>
                        </tr>
                    <?php 
                        foreach($rows as $row){ ?>
                            <tr class="data-table">
                                <td><?php echo $row['ItemID']; ?></td>
                                <td><?php echo $row['Name']; ?></td>
                                <td><?php echo $row['Description']; ?></td>
                                <td><?php echo $row['Price']; ?></td>
                                <td><?php if($row['Status'] == 1){
                                    echo "New";
                                } elseif($row['Status'] == 2){
                                    echo "Like New";
                                } elseif($row['Status'] == 3){
                                    echo "Used";
                                } elseif($row['Status'] == 4){
                                    echo "old";
                                }
                                ?></td>  
                                <td><?php echo $row['cat_name'];?></td>
                                <td><?php echo $row['Date']; ?></td>
                                <td>
                                    <a href="?action=edit&id=<?php echo $row['ItemID'] ?>" class="btn btn-success"><i class='bx bx-edit-alt'></i> Edit</a>
                                    <a href="?action=delete&id=<?php echo $row['ItemID'] ?>" class="btn btn-danger confirm"><i class='bx bxs-trash'></i> Delete</a>
                                </td>
                            </tr>
                        <?php
                        } 
                        ?>
                    </table>
                </div>
            <?php
            echo "<a href='?action=add' class='btn btn-primary float-end mt-3'><i class='bx bxs-add-to-queue'></i> Add New items</a>";

        } elseif ($link == "add"){ // Add new item?>
            <h1 class="text-center" style="padding: 20px;">Add New Item</h1>
            <div class="container">
                <form class="m-auto pt-2" method="POST" action="?action=insert" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label fw-bold">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" required="required" autocomplete="off" placeholder="Name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label fw-bold">Description</label>
                        <div class="col-sm-10">
                        <textarea class="form-control" style="height: 130px;" name="desc" placeholder="Description"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label fw-bold">Price</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="price" required="required" autocomplete="off" placeholder="Price">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label fw-bold">Image</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" name="img" required="required">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label fw-bold">Status</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="status">
                                    <option value="0">...</option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>
                                    <option value="3">Used</option>
                                    <option value="4">Old</option>
                                </option>
                            </select>    
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label fw-bold">Category</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="cat">
                                <option value='0'>...</option>
                                <?php
                                    $stmt = $con->prepare("SELECT * FROM categories");
                                    $stmt->execute();
                                    while($rows = $stmt->fetch()){
                                        echo "<option value='" . $rows['ID'] . "'> ". $rows['Name'] ." </option>";
                                    }
                        ?>  </select>    
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-end mb-3" style="width: 80px;">Save</button>
                </form>
            </div>
        <?php
        } elseif ($link == "insert"){ // insert the new item
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $name       = $_POST['name'];
                $desc       = $_POST['desc'];
                $price      = $_POST['price'];
                $status     = $_POST['status'];
                $category   = $_POST['cat'];
                // images
                $imageName = $_FILES['img']['name'];
                $imageTmp  = $_FILES['img']['tmp_name'];
                $imagesAllowdExtension = array("jpeg", "jpg", "png", "gif");
                $imagepath = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
                
                

                $formErrors = array();
                if($status == 0){
                    $formErrors[] = "You Most be choose Status"; 
                }
                if($category == 0){
                    $formErrors[] = "You Most be choose Category"; 
                }
                if(! empty($imageName) && ! in_array($imagepath, $imagesAllowdExtension)){
                    $formErrors[] = "This extension is not Allowed";
                }
                if(empty($imageName)){
                    $formErrors[] = "Image is required";
                }
                foreach($formErrors as $error){
                    echo "<div class='container mt-4'>";
                        echo "<p class='alert alert-danger'>" . $error . "</p>";
                    echo "</div>";
                }
                if(empty($formErrors)){
                    //image 
                    $image = rand(0, 1000000) . "_" . $imageName;
                    move_uploaded_file($imageTmp, "uploads\images\\" . $image);
                    
                    $stmt = $con->prepare("INSERT INTO items (Name, Description, Price, Date, Status, cat_ID, images) VALUE (?, ?, ?, now(), ?, ?, ?)");
                    $stmt->execute(array($name, $desc, $price, $status, $category, $image));
                
                    // echo Success Message
                    echo "<div class='container mt-4'>";
                        echo "<p class='alert alert-success'> Item is added Successful, " . $stmt->rowCount() . ' Record Update</p>';
                        echo "<a href='items.php' class='btn btn-primary m-2 float-end'><i class='bx bx-arrow-back m-1'></i> Back To Items</a>";
                    echo "</div>";
                }
            } else {
                $errorMsg = "You can't browse this page directly";
                redirectHome($errorMsg);
            }

        } elseif ($link == "edit"){ // edit the item
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : "Id is not exist";
            $stmt = $con->prepare("SELECT * FROM items WHERE ItemID = ?");
            $stmt->execute(array($id));
            $ftc = $stmt->fetch();

            if($stmt->rowCount() == 1){ ?>

                <h1 class="text-center" style="padding: 20px;">Edit Item</h1>
                <div class="container">
                    <form class="m-auto pt-2" method="POST" action="?action=update" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">Name</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo $ftc['Name'] ?>" class="form-control" name="name" required="required" autocomplete="off" placeholder="Name">
                            </div>
                        </div>

                            <input type="hidden" name="id" value="<?php echo $ftc['ItemID'] ?>">
                        
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" style="height: 130px;" name="desc" placeholder="Description"><?php echo $ftc['Description'] ?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">Price</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo $ftc['Price'] ?>" class="form-control" name="price" placeholder="Price">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">Image</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="new-img">
                                <input type="hidden" name="old-img" value="<?php echo $ftc['images'] ?>">
                                <strong>Notice*: </strong> If you want to keep the current image, leave it blank
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">Status</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="status">
                                    <option value="1" <?php if($ftc['Status'] == 1){ echo 'selected';} ?>>New</option>
                                    <option value="2" <?php if($ftc['Status'] == 2){ echo 'selected';} ?>>Like New</option>
                                    <option value="3" <?php if($ftc['Status'] == 3){ echo 'selected';} ?>>Used</option>
                                    <option value="4" <?php if($ftc['Status'] == 4){ echo 'selected';} ?>>Old</option>    
                                </select>    
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">Category</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="cat">
                                <?php
                                        $stmt = $con->prepare("SELECT * FROM categories");
                                        $stmt->execute();    
                                        while($rows = $stmt->fetch()){ ?>
                                            <option value="<?php echo $rows['ID'] ?>" <?php if($ftc['Cat_ID'] == $rows['ID']){ echo 'selected';} ?>> <?php echo $rows['Name'] ?> </option>
                                <?php   }
                            ?>  </select>    
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-end mb-3" style="width: 80px;">Save</button>
                    </form>
                </div>
        <?php
            } else {
                echo "<p class='alert alert-danger m-5'>error: Page not exsit</p>";
            }
            echo "</div>";
        
        }elseif ($link == "update"){ // update the item
            
            echo "<h1 class='text-center m-4'>Item Update</h1>";
            echo "<div class='container'>";
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $id         = $_POST['id'];
                    $name       = $_POST['name'];
                    $desc       = $_POST['desc'];
                    $price      = $_POST['price'];
                    $status     = $_POST['status'];
                    $category   = $_POST['cat'];
                    // image 
                    $imageName = $_FILES['new-img']['name'];
                    $imageTmp  = $_FILES['new-img']['tmp_name'];
                    $imagesAllowdExtension = array("jpeg", "jpg", "png", "gif");
                    $imagepath = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
                    
                    if($_FILES['new-img']['error'] == 0){
                        $image = rand(0, 1000000) . "_" . $imageName;
                        move_uploaded_file($imageTmp, "uploads\images\\" . $image);
                    } else {
                        $image = $_POST['old-img'];
                    }
                    /*
                    $image = rand(0, 1000000) . "_" . $imageName;
                    move_uploaded_file($imageTmp, "uploads\images\\" . $image);
*/
                    $stmt = $con->prepare("UPDATE items SET Name = ?, Description = ?, Price = ?, Status = ?, Cat_ID = ?, images = ? WHERE ItemID = '$id'");
                    $stmt->execute(array($name, $desc, $price, $status, $category, $image));

                    echo "<p class='alert alert-success'> Data Update Successful, " . $stmt->rowCount() . ' Record Update</p>'; ?>          
                    <a href="items.php" class="btn btn-primary m-2 float-end"><i class='bx bx-arrow-back m-1'></i> Back To manage Items page</a>
                <?php
                } else {
                    echo "you can't brows this page directly";
                }
            
            echo "</div>";

        }elseif ($link == "delete"){ // delete the item
            echo "<h1 class='text-center m-4'>Delete Item</h1>";
            echo "<div class='container'>";
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : "Id is not exist";
            $stmt = $con->prepare("SELECT * FROM items WHERE ItemID = ?");
            $stmt->execute(array($id));

            if($stmt->rowCount() == 1){
                $stmt = $con->prepare("DELETE FROM items WHERE ItemID = ?");
                $stmt->execute(array($id));
                echo "<div class='container'>";
                echo "<p class='alert alert-info'> Delete Successful, " . $stmt->rowCount() . ' Record Deleted</p>';
                echo '<a href="categories.php" class="btn btn-primary m-2 float-end"><i class="bx bx-arrow-back m-1"></i> Back To Manage categories page</a>';
            } else {
                echo "<p class='alert alert-danger m-5'>error: Page not exsit</p>";
            }
            echo "<div>";
        } 
    }
?>




<?php
    include "includes/template/footer.php";  
?>