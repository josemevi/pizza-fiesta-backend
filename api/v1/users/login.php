<?php 

    require('../../../config/db_connect.php');
    require('../../../config/env.php');
    require('../../../config/commonFunctions.php');

    //Recibir el json 
    $_POST = json_decode(file_get_contents('php://input'), true);
  
    $username = $password = "";
    $errors = array('username' => '', 'password' => '');

    //verificando si existen datos
    if(!empty($_POST)){
 
        //Verificando errores en formularios

        if(empty($_POST['username'])){
			$errors['username'] = 'Es requerido un nombre de usuario o email';
		} else{
			$username = $_POST['username'];
		}

	
		if(empty($_POST['password'])){
			$errors['password'] = 'Es requerida una contraseña';
		} else{
			$password = $_POST['password'];
        }

        //revisando si se encontro algun error
        if(array_filter($errors)){

            sendResponse(400, "Error en el formulario", $errors, "errors");

        }else {

            //Preprando el sql
            $username = strtolower(mysqli_real_escape_string($conn, $_POST['username']));
            $password = mysqli_real_escape_string($conn, $_POST['password']);

            $sql = "SELECT id, username, password, role FROM users WHERE username = '$username' OR email = '$username'";
            //get the result
            $result = mysqli_query($conn, $sql);

            //fetch the array
            $user = mysqli_fetch_assoc($result);
            //remove the result from memory
            mysqli_free_result($result);
            //close the connection
            mysqli_close($conn);

            if(!$user){

                sendResponse(400, "Nombre de usuario o email o contraseña incorrectos", null, "errors");

            }else if($user['password'] == $password){

                unset($user['password']);

                sendResponse(200, "Inicio de Sesion exitoso", $user, "userData");

            }else {

                sendResponse(400, "Nombre de usuario o email o contraseña incorrectos", null, "errors");
            }
    
        }

	}

?>
