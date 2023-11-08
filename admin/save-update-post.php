<?php
    include "config.php";
    
    $id =  mysqli_real_escape_string($conn,addslashes((htmlentities($_POST['post_id']))));      
    $title =  mysqli_real_escape_string($conn,addslashes((htmlentities($_POST['post_title']))));      
    $description =  mysqli_real_escape_string($conn,addslashes((htmlentities($_POST['postdesc']))));     
    $category = mysqli_real_escape_string($conn,addslashes((htmlentities($_POST['category']))));
    $old_category = mysqli_real_escape_string($conn,addslashes((htmlentities($_POST['old_category']))));


    if(empty($_FILES['new-image']['name'])){
        $finalName = $_POST['old-image'];
    }else{
        $errors = array();

        echo $file_name = $_FILES['new-image']['name'];
        $file_size = $_FILES['new-image']['size'];
        $file_tmp = $_FILES['new-image']['tmp_name'];
        $file_type = $_FILES['new-image']['type'];
        $fileName = explode('.', $file_name);
        $file_ext = strtolower(end($fileName));
        $extensions = array("jpeg", "jpg", "png");
        $finalName=time()."_".$file_name;
        // $finalName=mysqli_real_escape_string($conn,addslashes((htmlentities( $finalName ))));
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



    $sql = "UPDATE post SET title='%s', description='%s', category='%s', 
            post_img='{$finalName}'
            WHERE post_id='%s';";
    if($_POST['old_category'] != $_POST['category']){
        $sql .= "UPDATE category SET post = post-1 WHERE category_id = '%s';";         
        $sql .= "UPDATE category SET post = post+1 WHERE category_id = '%s';";         

    }        

    $sql = sprintf($sql, $title,$description,$category,$id,$old_category,$category);
    // echo $sql;
    // die;
    $result = mysqli_multi_query($conn,$sql);
    if($result){
        header("Location: {$hostname}/admin/post.php");

    }else{
        echo "Query Failed.";
    }
?>                