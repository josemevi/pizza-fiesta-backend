<?php 

    require('../../../config/db_connect.php');
    require('../../../config/env.php');
    require('../../../config/commonFunctions.php');


    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        
        if(isset($_GET['id'])){
            if(!empty($_GET['id'])){

                $id = mysqli_real_escape_string($conn, $_GET['id']);

                //sql
                $sql = "SELECT `pizzas`.`id`,
                `pizzas`.`name`,
                `pizzas`.`description`,
                `pizzas`.`ingredients`,
                `pizzas`.`value`,
                `pizzas`.`photo`,
                `pizzas`.`created_by`,
                `pizzas`.`created_at`,
                `pizzas`.`updated_at`,
                `users`.`username` as `created_by_username`
                FROM `pizzas` JOIN `users` WHERE `pizzas`.`created_by`=`users`.`id` AND `pizzas`.`id` = $id AND `pizzas`.`active` = 1  ORDER BY `created_at`";
        
                //get the result
                $result = mysqli_query($conn, $sql);
                //fetch the array
                $pizza = mysqli_fetch_assoc($result);
                //remove the result from memory
                mysqli_free_result($result);
                //close the connection
                mysqli_close($conn);

                sendResponse(200, "Pizzas", $pizza, "pizzaData");


            }else {

                sendResponse(404, "Pizza not found", null, "data");
                
            }
        
        

        }else {

            $sql = "SELECT `pizzas`.`id`,
            `pizzas`.`name`,
            `pizzas`.`description`,
            `pizzas`.`ingredients`,
            `pizzas`.`value`,
            `pizzas`.`photo`,
            `pizzas`.`created_by`,
            `pizzas`.`created_at`,
            `pizzas`.`updated_at`,
            `users`.`username` as `created_by_username`
            FROM `pizzas` JOIN `users` WHERE `pizzas`.`created_by`=`users`.`id` AND `pizzas`.`active` = 1 ORDER BY `created_at`";

            //get the result
            $result = mysqli_query($conn, $sql);
            //fetch the array
            $pizza = mysqli_fetch_all($result, MYSQLI_ASSOC);

            //remove the result from memory
            mysqli_free_result($result);
            //close the connection
            mysqli_close($conn);

            sendResponse(200, "Pizzas", $pizza, "pizzaData");
            
        }

    }

?>