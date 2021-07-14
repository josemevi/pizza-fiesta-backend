<?php 

    require('../../../config/db_connect.php');
    require('../../../config/env.php');
    require('../../../config/commonFunctions.php');


    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        
        if(isset($_GET['id'])){
            if(!empty($_GET['id'])){

                $id = mysqli_real_escape_string($conn, $_GET['id']);

                //sql
                $sql = "SELECT * FROM orders WHERE id=$id ORDER BY created_at DESC";
        
                //get the result
                $result = mysqli_query($conn, $sql);
                //fetch the array
                $orders = mysqli_fetch_assoc($result);
                //remove the result from memory
                mysqli_free_result($result);
                //close the connection
                mysqli_close($conn);

                sendResponse(200, "orders", $orders, "orderData");


            }else {

                sendResponse(404, "Order not found", null, "data");
                
            }
        
        

        }else {

            $sql = "SELECT * FROM orders ORDER BY created_at DESC";

            //get the result
            $result = mysqli_query($conn, $sql);
            //fetch the array
            $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

            //remove the result from memory
            mysqli_free_result($result);
            //close the connection
            mysqli_close($conn);

            sendResponse(200, "orders", $orders, "orderData");
            
        }

    }

?>