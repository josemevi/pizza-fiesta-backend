<?php 

    require('../../../config/db_connect.php');
    require('../../../config/env.php');
    require('../../../config/commonFunctions.php');

    //Recibir el json 
    $_POST = json_decode(file_get_contents('php://input'), true);
  
    $user_id =  "";
    $errors = array('user_id' => '');

    //verificando si existen datos
    if(!empty($_POST)){
 
        //Verificando errores en formularios

        if(empty($_POST['user_id'])){
			$errors['user_id'] = 'Es requerido el id del usuario';
		} else{
			$user_id = $_POST['user_id'];
		}

        //revisando si se encontro algun error
        if(array_filter($errors)){

            sendResponse(400, "Error en el formulario", $errors, "errors");

        }else {

            //Preprando el sql
            $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

            $userCart  = getUserCart($user_id);

            $total = calculateTotal($userCart);

            $sql = "INSERT INTO `orders`( `user_id`, `total`) VALUES 
            ($user_id, $total);";

            if(mysqli_query($conn, $sql)){

                $last_id = mysqli_insert_id($conn);

                if(insertOrderItems($userCart, $last_id)){

                    removeItemsFromCart($user_id);

                }else {
                   rollback($last_id);
                }             

            }else {
                
                $error = [mysqli_error($conn)];
                sendResponse(500, "Error inesperado", $error, "errors");

            }
    
        }

	}

    function getUserCart($user){

        global $conn;

        $sql = "SELECT pizza_id, quantity FROM users_cart WHERE user_id= $user";

        //get the result
        $result = mysqli_query($conn, $sql);
        //fetch the array
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        //remove the result from memory
        mysqli_free_result($result);

        return $data;
}

    function calculateTotal($orderItems){

        global $conn;
        $total = 0;

        for($i = 0; $i < count($orderItems); $i++){

            $pizzaId = $orderItems[$i]["pizza_id"];
            $sql = "SELECT value FROM pizzas WHERE id = $pizzaId";

            //get the result
            $result = mysqli_query($conn, $sql);
            //fetch the array
            $price = mysqli_fetch_assoc($result);
            //remove the result from memory
            mysqli_free_result($result);

            $total += $price["value"] * $orderItems[$i]["quantity"];

        }

        return $total;
        
    }


    function insertOrderItems($orderItems, $orderId){

        global $conn;
        $success = true;

        for($i = 0; $i < count($orderItems); $i++){

            $pizzaId = $orderItems[$i]["pizza_id"];
            $quantity = $orderItems[$i]["quantity"];
            $sql = "INSERT INTO `orders_items`(`pizza_id`, `quantity`, `order_id`)
             VALUES ($pizzaId, $quantity, $orderId)";

            //get the result
            if(!mysqli_query($conn, $sql)){
                $success = false; 
                break;
            }

        }

        return $success;
    }

    function rollback($orderId){

        global $conn;

        $sql = "DELETE FROM orders WHERE id = $orderId";

        if(mysqli_query($conn, $sql)){
            mysqli_close($conn);
    
            sendResponse(500, "Error agregando las entradas de la orden", null, "errors");

        }else {

            $error = [mysqli_error($conn)];
            sendResponse(500, "Error inesperado en rollback", $error, "errors");

        }
    }

    function removeItemsFromCart($userId){

        global $conn;

        $sql = "DELETE FROM `users_cart` WHERE `user_id`= $userId";

        if(mysqli_query($conn, $sql)){
            mysqli_close($conn);
            sendResponse(200, "Orden registrada con exito",null,"data");
        }else {
            sendResponse(500, "Orden registrada, Fallo en vaciar carro",null,"data");
        }

    }

?>
