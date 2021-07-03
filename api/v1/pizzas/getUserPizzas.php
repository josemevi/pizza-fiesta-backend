<?php 

    require('../../../config/db_connect.php');
    require('../../../config/env.php');
    require('../../../config/commonFunctions.php');


    if($_SERVER['REQUEST_METHOD'] === 'GET'){

        if(isset($_GET['id'])){
            if(!empty($_GET['id'])){

            $id = mysqli_real_escape_string($conn, $_GET['id']);

            $sql = "SELECT * FROM pizzas WHERE created_by=$id ORDER BY created_at";

            //get the result
            $result = mysqli_query($conn, $sql);
            //fetch the array
            $pizza = mysqli_fetch_all($result, MYSQLI_ASSOC);

            //remove the result from memory
            mysqli_free_result($result);
            //close the connection
            mysqli_close($conn);

            sendResponse(200, "Pizzas", $pizza, "pizzaData");

            }else {

                sendResponse(404, "User pizzas not found", null, "data");
                
            }
        }    

    }

?>