<?php


// required headers
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../objects/sellpost.php';
 
$database = new Database();
$db = $database->getConnection();
$buyoffer= new SellPost($db);

$sellpost->id = isset($_GET['id']) ? $_GET['id'] : die();

// view and edit details of existing product


$sellpost->readOne();

if($sellpost->paymentmethod!=null){
    $sellpost_arr = array(

        "id" => $sellpost->id,
        "paymentmethod" => $sellpost->paymentmethod,
        "btcprice" => $sellpost->btcprice,
        "minprice" => $sellpost->minprice,
        "maxprice" => $sellpost->maxprice,
        "currency" => $sellpost->currency,
        "duration" => $sellpost->duration,
        "terms" => $sellpost->terms,
        "user_id" => $sellpost->user_id,
        "user_username" => $sellpost->user_username



    );
    http_response_code(200);
    echo json_encode($sellpost_arr);
}

else{
    http_response_code(404);
    echo json_encode(array("message" => "Error. There are currently no such offers."));

}



?>