<?php 

    require('../../../config/db_connect.php');
    require('../../../config/env.php');
    require('../../../config/commonFunctions.php');

    //Recibir el json 
    $_POST = json_decode(file_get_contents('php://input'), true);
  
    $name = $ingredients = $value = $created_by = $description = $photo =  "";
    $errors = array('name' => '', 'ingredients' => '', 'value' => '', 'created_by' => '', 'description' => '');

    //verificando si existen datos
    if(!empty($_POST)){
 
        //Verificando errores en formularios

        if(empty($_POST['name'])){
			$errors['name'] = 'Es requerido un nombre de pizza';
		} else{
			$name = $_POST['name'];
		}


        if(empty($_POST['ingredients'])){
			$errors['ingredients'] = 'Es requerido al menos un ingrediente';
		} else{
		    $ingredients = implode("," , $_POST['ingredients']);
        }

        if(empty($_POST['value'])){
			$errors['value'] = 'Es requerido un valor para la pizza';
		} else{
			$value = $_POST['value'];
		}

	
		if(empty($_POST['created_by'])){
			$errors['created_by'] = 'Es requerida el id del usuario';
		} else{
			$created_by = $_POST['created_by'];
        }

        if(empty($_POST['description'])){
			$description = null;
		} else{
			$description = strtolower(mysqli_real_escape_string($conn, $_POST['description']));
		}

        if(empty($_POST['photo'])){
			$photo = null;
		} else{
			$photo = mysqli_real_escape_string($conn, $_POST['photo']);
		}

        //revisando si se encontro algun error
        if(array_filter($errors)){

            sendResponse(400, "Error en el formulario", $errors, "errors");

        }else {
            //Preprando el sql
            $name = strtolower(mysqli_real_escape_string($conn, $_POST['name']));
            $ingredients = strtolower(mysqli_real_escape_string($conn, $ingredients));
            $value = mysqli_real_escape_string($conn, $_POST['value']);
            $created_by = mysqli_real_escape_string($conn, $_POST['created_by']);


            $sql = "INSERT INTO `pizzas`(`name`, `description`, `ingredients`, `value`, `created_by`, `updated_by`, `photo`) 
            VALUES ('$name','$description','$ingredients','$value','$created_by','$created_by', '$photo')";
        
            //ejecutando el sql
            if(mysqli_query($conn, $sql)){

                mysqli_close($conn);
                sendResponse(201, "Pizza creada con exito",null,"data");

            }else {

                //verificando el error y enviando respuesta segun sea necesario
                if(str_contains(strtolower(mysqli_error($conn)), "duplicate")){
                    sendResponse(400, "El nombre de la pizza $name ya esta en uso", null, "errors");
                }else {
                    $error = [mysqli_error($conn)];
                    sendResponse(500, "Error inesperado", $error, "errors");
                }

            }
    
        }

	}

?>
