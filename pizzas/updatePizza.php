<?php 

    require('../config/db_connect.php');
    require('../config/env.php');
    require('../config/commonFunctions.php');

    //Recibir el json 
    $_PUT = json_decode(file_get_contents('php://input'), true);
  
    $pizza_id = $name = $ingredients = $value = $updated_by = $description =  "";
    $errors = array('pizza_id' => '', 'name' => '', 'ingredients' => '', 'value' => '', 'updated_by' => '', 'description' => '');

    //verificando si existen datos
    if(!empty($_PUT)){
 
        //Verificando errores en formularios

        if(empty($_PUT['pizza_id'])){
			$errors['pizza_id'] = 'Es requerido el id de la pizza';
		} else{
			$pizza_id = $_PUT['pizza_id'];
		}

        if(empty($_PUT['name'])){
			$errors['name'] = 'Es requerido un nombre de pizza';
		} else{
			$name = $_PUT['name'];
		}

        if(empty($_PUT['ingredients'])){
			$errors['ingredients'] = 'Es requerido al menos un ingrediente';
		} else{
		    $ingredients = implode("," , $_PUT['ingredients']);
        }

        if(empty($_PUT['value'])){
			$errors['value'] = 'Es requerido un valor de pizza';
		} else{
			$value = $_PUT['value'];
		}

	
		if(empty($_PUT['updated_by'])){
			$errors['updated_by'] = 'Es requerida el id del usuario';
		} else{
			$updated_by = $_PUT['updated_by'];
        }

        if(empty($_PUT['description'])){
			$description = "";
		} else{
			$description = $_PUT['description'];
		}

        //revisando si se encontro algun error
        if(array_filter($errors)){

            sendResponse(400, "Error en el formulario", $errors, "errors");

        }else {
            //Preprando el sql
            $pizza_id = strtolower(mysqli_real_escape_string($conn, $_PUT['pizza_id']));
            $name = strtolower(mysqli_real_escape_string($conn, $_PUT['name']));
            $ingredients = strtolower(mysqli_real_escape_string($conn, $ingredients));
            $value = strtolower(mysqli_real_escape_string($conn, $_PUT['value']));
            $updated_by = strtolower(mysqli_real_escape_string($conn, $_PUT['updated_by']));
            $description =  strtolower(mysqli_real_escape_string($conn, $_PUT['description']));;


            $sql = "UPDATE `pizzas` SET `name`='$name',`description`='$description',
            `ingredients`='$ingredients',`value`='$value',`updated_by`='$updated_by' WHERE id = $pizza_id";

            //ejecutando el sql
            if(mysqli_query($conn, $sql)){

                mysqli_close($conn);
                sendResponse(200, "Pizza editada con exito",null,"data");

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
