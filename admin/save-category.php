<?php include "header.php"; 

if(isset($_POST['save'])){
    include "config.php";
    $catName = mysqli_real_escape_string($conn,addslashes((htmlentities($_POST['cat']))));
    
    $sql = "SELECT * FROM category WHERE category_name='%s'" ;
    $sql = sprintf($sql, $catName);

    $result = mysqli_query($conn, $sql) or die("Query Failed.");
    
    if(mysqli_num_rows($result) > 0){
        echo "<p style='color:red;text-align:center;margin:10px 0;'>Category already Exsits.</p>";
    }else{
        $sql1 = "INSERT INTO category(category_name) VALUES ('%s');";
        $sql1 = sprintf($sql1, $catName);
        $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");
        if($result1){
            header("Location: {$hostname}/admin/category.php");

        }
    }
    
}

?>


<!-- $catName = mysqli_real_escape_string($conn,$_POST['cat']);
    

    $sql = "SELECT username FROM user WHERE  username = '{$user}' ";
    $sql = "INSERT INTO category(category_name)
    VALUES('%s');";
    $sql = sprintf($sql, $catName);

    $result = mysqli_query($conn, $sql) or die("Query Failed.");
    
    if(mysqli_num_rows($result) > 0){
        echo "<p style='color:red;text-align:center;margin:10px 0;'>Username already Exsits.</p>";
    }else{
        if($result){
            header("Location: {$hostname}/admin/users.php");

        }
    } -->