<?php

    require('../../../config/db_connect.php');
    require('../../../config/env.php');
    require('../../../config/commonFunctions.php');
    


    $_DELETE = $_GET;
    
    if(isset($_DELETE['id'])){
        $id_to_delete = mysqli_real_escape_string($conn, $_DELETE['id']);
        
        $sql = "UPDATE pizzas SET active = 0 WHERE id=$id_to_delete";

        if(mysqli_query($conn, $sql)){
            mysqli_close($conn);
            sendResponse(200, "Pizza eliminada con exito",null,"data");
        }else {
            $error = [mysqli_error($conn)];
            sendResponse(500, "Error inesperado", $error, "errors");
        }
    }

?>

