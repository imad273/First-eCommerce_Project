<?php
    session_start(); 
    // Title of this page 
    $title = "Categories";

    // import required file
    require "config.php";
    include "func.php";
    include "includes/template/header.php";
    include "includes/template/navbar.php";

    // Check if user come from login page or External link
    if(isset($_SESSION['admin'])){
        $link = isset($_GET['action']) ? $_GET['action'] : "manage";

        if($link == "manage"){ // manage categories page
            $stmt = $con->prepare("SELECT * FROM categories");
            $stmt->execute();
            
            ?>
            <div class="container w-75">
                <h1 class="text-center" style="padding: 20px;">Manage Categories</h1>
                <div class="card categ">
                    <div class="card-header bg-dark">
                        Categories
                    </div>
                    <ul class="list-group list-group-flush categ-list"> <?php
                        while($row = $stmt->fetch()){ ?>
                            <li class="list-group-item"> <?php echo $row['Name'] ?>
                                <a href="categories.php?action=edit&id=<?php echo $row['ID'] ?>" class="btn btn-success float-end"><i class="bx bx-edit-alt"></i> Edit</a>
                                <a href="categories.php?action=delete&id=<?php echo $row['ID'] ?>" class="btn btn-danger confirm float-end"><i class="bx bxs-trash"></i> Delete</a>
                            </li>
                <?php  }
                        ?>
                    </ul>
                </div>
                <a href='?action=add' class="btn btn-primary float-end mt-3">Add New Category</a>
            </div>    

        <?php
        } elseif ($link == "edit"){ // edit category page
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : "id is not exist";
            $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");
            $stmt->execute(array($id));
            $ftc = $stmt->fetch();
            if($stmt->rowCount() == 1){ ?>
                <h1 class="text-center" style="padding: 20px;">Edit category</h1>
                <div class="container">
                    <form class="m-auto pt-2" method="POST" action="?action=update">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">Name</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?php echo $ftc['Name'] ?>" class="form-control" name="name" required="required" autocomplete="off" placeholder="Name">
                            </div>
                        </div>
                            <input type="hidden" name="id" value="<?php echo $ftc['ID'] ?>">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">Description</label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control" style="resize: none; height: 150px;" name="desc" placeholder="Description"><?php echo $ftc['Description'] ?></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-end mb-3" style="width: 80px;">Save</button>
                    </form>
                </div>
            <?php
            } else {
                echo "id is not exist";
            }
        } elseif ($link == "update"){ // update data category page
            echo "<h1 class='text-center m-4'>Category Update</h1>";
            echo "<div class='container'>";
                $value = $_POST['name'];
                $check = checkItems("Name", "categories", "$value");
                if($check == 1){
                    echo "<p class='alert alert-danger'>This Category is already exist</p>"; ?>
                    <a href='categories.php' class='btn btn-primary m-2 float-end'><i class='bx bx-arrow-back m-1'></i> Back To manage Categories page</a>
            <?php } else{
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $id     = $_POST['id'];
                    $name   = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                    $desc   = filter_var($_POST['desc'], FILTER_SANITIZE_STRING);

                    $stmt = $con->prepare("UPDATE categories SET Name = ?, Description = ? WHERE ID = '$id'");
                    $stmt->execute(array($name, $desc));

                    echo "<p class='alert alert-success'> Data Update Successful, " . $stmt->rowCount() . ' Record Update</p>'; ?>          
                    <a href="categories.php" class="btn btn-primary m-2 float-end"><i class='bx bx-arrow-back m-1'></i> Back To manage categories page</a>
                <?php
                } else {
                    echo "you can't brows this page directly";
                }
            }
            echo "</div>";
            
        } elseif ($link == "add"){ // add new categories page ?>
            <h1 class="text-center" style="padding: 20px;">Add New category</h1>
            <div class="container">
                <form class="m-auto pt-2" method="POST" action="?action=insert">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label fw-bold">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" required="required" autocomplete="off" placeholder="Name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label fw-bold">Description</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" name="desc" placeholder="Description"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-end mb-3" style="width: 80px;">Add</button>
                </form>
            </div>
        <?php
        } elseif ($link == "insert"){ // insert categories page 
            $value = $name = $_POST['name'];
            $check = checkItems("Name", "categories", "$value");
            if($check == 1){
                echo "<div class='container mt-4'>";
                    echo "<p class='alert alert-danger'>Name of category is already exist</p>";
                echo "</div>";
            } else {
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                    $desc = filter_var($_POST['desc'], FILTER_SANITIZE_STRING);
    
                    $stmt = $con->prepare("INSERT INTO categories (Name , Description) VALUE (?, ?)");
                    $stmt->execute(array($name, $desc));
                    
                    // echo Success Message
                    echo "<div class='container mt-4'>";
                        echo "<p class='alert alert-success'> Category is added Successful, " . $stmt->rowCount() . ' Record Update</p>';
                        echo "<a href='categories.php' class='btn btn-primary m-2 float-end'><i class='bx bx-arrow-back m-1'></i> Back To Categories</a>";
                    echo "</div>";
                } else {
                    $errorMsg = "You can't browse this page directly";
                    redirectHome($errorMsg);
                }
            }
        } elseif($link == "delete") { // delete categories page
            echo "<h1 class='text-center m-4'>Delete Catrgory</h1>";
            echo "<div class='container'>";
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");
            $stmt->execute(array($id));

            if($stmt->rowCount() == 1){
                $stmt = $con->prepare("DELETE FROM categories WHERE ID = ?");
                $stmt->execute(array($id));
                echo "<p class='alert alert-info'> Delete Successful, " . $stmt->rowCount() . ' Record Deleted</p>';
                echo '<a href="categories.php" class="btn btn-primary m-2 float-end"><i class="bx bx-arrow-back m-1"></i> Back To Manage categories page</a>';
            } else {
                echo "<p class='alert alert-danger m-5'>error: Page not exsit</p>";
            }
            echo "</div>";
        }
    } else {
        // if user not login go to the login form
        header('location: index.php');
        exit();
    }

    include "includes/template/footer.php";
?>