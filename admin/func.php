<?php
    // Function To Set Title of Pages
    function getTitle(){
        global $title;

        if(isset($title)){
            echo $title;
        } else {
            echo "default";
        }
    }

    // Redirect Function To Home Page
    function redirectHome( $errorMsg, $seconds = 5){
        echo "<div class='container mt-4'>";
        
            echo "<p class='alert alert-danger'>$errorMsg</p>";
            echo "<p class='alert alert-info'>You will be Redirect to Home Page after $seconds seconds</p>";
            
            header("refresh:$seconds; url=index.php");
            exit();

        echo "</div>";
    }

    // Check Items Function
    function checkItems( $select, $from, $value){
        global $con;

        $statement = $con->prepare("SELECT $select FROM $from WHERE $select = '$value'");
        $statement->execute();
        $count = $statement->rowCount();
        return $count;
    }

    // Count number of items function 
    function countItems($item, $table){
        global $con;

        $stmt = $con->prepare("SELECT COUNT($item) FROM $table");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Get latest records Function
    function getLatest($select, $table, $order, $limit = 5){
        global $con;

        $stmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }