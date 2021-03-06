<?php
//  headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/sellpost.php';

$database = new Database();
$db = $database->getConnection();
$sellpost = new SellPost($db);

// to view sell posts
$stmt = $sell->post();
$num = $stmt->rowCount();


if($num>0){
    $sellposts_arr=array();
    $sellposts_arr["records"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row); 
        $sellpost_item=array(
            "id" => $id,
            "username" => $username,
            "paymentmethod" => $paymentmethod,
            "currency" => $currency,
            "price" => $price,
            "maxprice" => $maxprice,
            "minprice" => $minprice,
            "duration" => $duration,
            "users_id" => $users_id,
            "terms" =>  html_entity_decode($terms),
        );
  
        array_push($sellposts_arr["records"], $sellpost_item);
    }

    http_response_code(200);
    echo json_encode($sellposts_arr);
}
  
else{
    http_response_code(404);
    echo json_encode(
        array("message" => "Please complete all fields")
    );
}