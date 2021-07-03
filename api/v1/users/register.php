<?php 

    require('../../../config/db_connect.php');
    require('../../../config/env.php');
    require('../../../config/commonFunctions.php');

    //Recibir el json 
    $_POST = json_decode(file_get_contents('php://input'), true);
  
    $username = $email = $password = "";
    $errors = array('username' => '', 'email' => '', 'password' => '');

    //verificando si existen datos
    if(!empty($_POST)){
 
        //Verificando errores en formularios

        if(empty($_POST['email'])){
            $errors['email'] = "Es requerido un email";
        } else {
            $email = $_POST['email'];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Email invalido';
            }
        }

        if(empty($_POST['username'])){
			$errors['username'] = 'Es requerido un nombre de usuario';
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
            $email = strtolower(mysqli_real_escape_string($conn, $_POST['email']));
            $username = strtolower(mysqli_real_escape_string($conn, $_POST['username']));
            $password = mysqli_real_escape_string($conn, $_POST['password']);

            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        
            //ejecutando el sql
            if(mysqli_query($conn, $sql)){
                mysqli_close($conn);
                sendResponse(200, "Usuario creado con exito",null,"data");

            }else {

                //verificando el error y enviando respuesta segun sea necesario
                if(str_contains(strtolower(mysqli_error($conn)), "duplicate")){
                    sendResponse(400, "El nombre de usuario $username o email $email ya esta en uso", null, "errors");
                }else {
                    $error = [mysqli_error($conn)];
                    sendResponse(500, "Error inesperado", $error, "errors");
                }

            }
    
        }

	}

?>
