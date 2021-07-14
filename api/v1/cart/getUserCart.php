<?php 

    require('../../../config/db_connect.php');
    require('../../../config/env.php');
    require('../../../config/commonFunctions.php');


    if($_SERVER['REQUEST_METHOD'] === 'GET'){

        if(isset($_GET['id'])){
            if(!empty($_GET['id'])){

            $id = mysqli_real_escape_string($conn, $_GET['id']);

            $sql = "SELECT `users_cart`.`id`, 
            `users_cart`.`quantity`,
            `pizzas`.`name`,
            `pizzas`.`value`,
            `pizzas`.`photo`,
            `users_cart`.`created_at` FROM `users_cart` JOIN `pizzas`
            WHERE `users_cart`.`pizza_id` = `pizzas`.`id` AND `users_cart`.`user_id` = $id ORDER BY `users_cart`.`created_at` DESC";

            //get the result
            $result = mysqli_query($conn, $sql);
            //fetch the array
            $pizza = mysqli_fetch_all($result, MYSQLI_ASSOC);

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