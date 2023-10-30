<?php

include "config.php";
    $userid = $_GET['id'];

    $sql = "DELETE FROM user WHERE user_id=%d";   
    $sql = sprintf($sql,$userid);
    // die();


    // $result = mysqli_query($conn, $sql) or die("Query unsuccessful.");
    if(mysqli_query($conn, $sql)){

        header("Location: {$hostname}/admin/users.php");
    }else{
        echo "<p style='color:red; margin: 10px 0;'>Can\'t Delete the User Record.</p>";
    }

    mysqli_close($conn);

    ?>