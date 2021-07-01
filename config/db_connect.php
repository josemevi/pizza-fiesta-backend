<?php 

    //MYSQLi and PDO
    //connect db (mysqli)
    $conn = mysqli_connect('localhost','root','','pizza_fiesta');

    // check connection
    if(!$conn){
        echo 'Connection error: ' . mysqli_connect_error();
    }

?>