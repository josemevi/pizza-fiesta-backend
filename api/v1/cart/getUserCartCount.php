<?php 

    require('../../../config/db_connect.php');
    require('../../../config/env.php');
    require('../../../config/commonFunctions.php');


    if($_SERVER['REQUEST_METHOD'] === 'GET'){

        if(isset($_GET['id'])){
            if(!empty($_GET['id'])){

            $id = mysqli_real_escape_string($conn, $_GET['id']);

            $sql = "SELECT SUM(`quantity`) as `num_items` FROM `users_cart` WHERE `user_id`=$id";

            //get the result
            $result = mysqli_query($conn, $sql);
            //fetch the array
            $pizza = mysqli_fetch_assoc($result);

            //remove the result from memory
            mysqli_free_result($result);
            //close the connection
            mysqli_close($conn);

            sendResponse(200, "Cart", $pizza, "cartData");

            }else {

                sendResponse(404, "User cart not found", null, "data");
                
            }
        }    

    }

?>