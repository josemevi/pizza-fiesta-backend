<?php 

  function sendResponse($status, $mensaje, $data, $dataKey){

    header("Content-Type:application/json");
    header("HTTP/1.1 $status $mensaje");
    $response['status'] = $status;
    $response['msg'] = $mensaje;
    $response[$dataKey] = $data;
    $json_response = json_encode($response);
    echo $json_response;

}

?>