<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/sellpost.php';

$database = new Database();
$db = $database->getConnection();

$sellpost = new SellPost($db);

$data = json_decode(file_get_contents("php://input"));


$sellpost->id = $data->id;

if($sellpost->delete()){

    http_response_code(200);
    echo json_encode(array("message" => "Post Offer successfuly deleted and will no longer be visible to other users"));
}

else{

    http_response_code(503);
    echo json_encode(array("message" => "Error,Unable to delete Post order. Please Try Again"));

}


?>