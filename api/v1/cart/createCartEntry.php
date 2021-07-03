<?php 

    require('../../../config/db_connect.php');
    require('../../../config/env.php');
    require('../../../config/commonFunctions.php');

    //Recibir el json 
    $_POST = json_decode(file_get_contents('php://input'), true);
  
    $user_id = $pizza_id =  "";
    $errors = array('user_id' => '', 'pizza_id' => '');

    //verificando si existen datos
    if(!empty($_POST)){
 
        //Verificando errores en formularios

        if(empty($_POST['user_id'])){
			$errors['user_id'] = 'Es requerido el id del usuario';
		} else{
			$user_id = $_POST['user_id'];
		}


        if(empty($_POST['pizza_id'])){
			$errors['pizza_id'] = 'Es requerido el id de la pizza';
		} else{
			$pizza_id = $_POST['pizza_id'];
		}

        //revisando si se encontro algun error
        if(array_filter($errors)){

            sendResponse(400, "Error en el formulario", $errors, "errors");

        }else {

            //Preprando el sql
            $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
            $pizza_id = mysqli_real_escape_string($conn, $_POST['pizza_id']);


            $quantity = verifyQuantity($user_id, $pizza_id);
    
            if($quantity > 0){

                $quantity++;
                $sql = "UPDATE `users_cart` SET quantity = $quantity WHERE 
                user_id= $user_id AND pizza_id = $pizza_id";

            }else {

                $sql = "INSERT INTO `users_cart`( `user_id`, `pizza_id`) VALUES 
                ($user_id,$pizza_id)";
            }
        
            
            if(mysqli_query($conn, $sql)){

                mysqli_close($conn);
                sendResponse(200, "Agregado al carro con exito",null,"data");

            }else {
                
                $error = [mysqli_error($conn)];
                sendResponse(500, "Error inesperado", $error, "errors");

            }
    
        }

	}


    function verifyQuantity($user, $pizza){

        global $conn;

        $sql = "SELECT quantity FROM users_cart WHERE 
        user_id= $user AND pizza_id= $pizza";

        //get the result
        $result = mysqli_query($conn, $sql);
        //fetch the array
        $data = mysqli_fetch_assoc($result);
        //remove the result from memory
        mysqli_free_result($result);
        //close the connection

        if(!$data){
            $data["quantity"] = 0;
        }

        return $data["quantity"];

    }

?>
