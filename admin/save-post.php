<?php include "config.php"; 

    if(isset($_FILES['fileToUpload'])){
        $errors = array();

        $file_name = $_FILES['fileToUpload']['name'];
        $file_size = $_FILES['fileToUpload']['size'];
        $file_tmp = $_FILES['fileToUpload']['tmp_name'];
        $file_type = $_FILES['fileToUpload']['type'];
        $file_ext = strtolower(end(explode('.', $file_name)));
        $extensions = array("jpeg", "jpg", "png");
        $finalName=time()."_".$file_name;
        if(in_array($file_ext, $extensions) === false){
            $errors[] = "This extension file is not alllowed, Please choose a JPG or PNG file.";
        }
        if($file_size > 2097152){
            $errors[] = "File size must be 2mb or lower.";
        }
        if(empty($errors) == true){
            move_uploaded_file($file_tmp, "upload/".$finalName); 
        }else{
            print_r($errors);
            die();
        }
    }

    session_start();
    $title =  mysqli_real_escape_string($conn,addslashes((htmlentities($_POST['post_title']))));      
    $description =  mysqli_real_escape_string($conn,addslashes((htmlentities($_POST['postdesc']))));     
    // $category = mysqli_real_escape_string($conn,$_POST['category']);

    $category = mysqli_real_escape_string($conn,addslashes((htmlentities($_POST['category']))));

    $date = date("d M, Y");
    $author = $_SESSION['user_id'];         

    $sql = "INSERT INTO post(title, description, category, post_date, author, post_img)
            VALUES('%s', '%s', '%s', '{$date}', '{$author}', '{$finalName}');";
    // $sql = sprintf($sql,$category);
    $sql .= "UPDATE category SET post = post+1 WHERE category_id = '%s'";            
    $sql = sprintf($sql,  $title,$description,$category,$category);
    // die;


    if(mysqli_multi_query($conn, $sql)){
        header("Location: {$hostname}/admin/post.php");
    }else{
        echo '<div class="alert alert-danger">Query Failed.</div>';
    }
 ?>