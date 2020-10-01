<?php


header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/sellpost.php';

$database = new Database();
$db = $database->getConnection();

$sellpost = new SellPost($db);

$data = json_decode(file_get_contents("php://input"));


// to ensure all fields are inputted
if(
    !empty($data->paymentmethod) &&
    !empty($data->currency) &&
    !empty($data->btcprice) &&
    !empty($data->minprice) &&
    !empty($data->maxprice) &&
    !empty($data->duration) &&
    !empty($data->terms) &&
    !empty($data->user_id)
){

    $sellpost->paymentmethod = $data->paymentmethod;
    $sellpost->currency = $data->currency;
    $sellpost->btcprice = $data->btcprice;
    $sellpost->minprice = $data->minprice;
    $sellpost->maxprice = $data->maxprice;
    $sellpost->duration = $data->duration;
    $sellpost->terms = $data->terms;
    $sellpost->user_id = $data->user_id;
    $sellpost->created = date('Y-m-d H:i:s');

    // creating an offer


    if($sellpost->create()){
        http_response_code(201);
        echo json_encode(array("message" => "Your offer has been posted. Users can now see it"));
    }
    else{
        http_response_code(503);
        echo json_encode(array("message" => "Error!! Something went wrong.Check your input and Try Again"));
    }
}
else{
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create offer. Please make sure fill all fields."));
}
?>