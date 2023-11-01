<?php

include "config.php";

    $post_id = mysqli_real_escape_string($conn,addslashes((htmlentities($_GET['id']))));
    $cat_id = mysqli_real_escape_string($conn,addslashes((htmlentities($_GET['catid']))));

    $sql = "DELETE FROM post WHERE post_id = '%s';";   
    $sql .= "UPDATE category SET post = post-1 WHERE category_id = '%s';"; 

  $sql = sprintf($sql, $post_id,$cat_id);


    if(mysqli_multi_query($conn, $sql)){

        header("Location: {$hostname}/admin/users.php");
    }else{
        echo "<p style='color:red; margin: 10px 0;'>Can\'t Delete the User Record.</p>";
    }

    mysqli_close($conn);

    ?>