<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/sellpost.php';
 
$database = new Database();
$db = $database->getConnection();
$sellpost= new SellPost($db);


// get keyword

$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// query posts
$stmt = $sellpost->search($keywords);

$num = $stmt->rowCount();

if($num>0){
    $sellposts_arr=array();

    $sellposts_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        $sellpost_item=array(

            "id" => $id,
            "paymentmethod" => $paymentmethod,
            "currency" => $currency,
            "btcprice" => $btcprice,
            "minprice" => $minprice,
            "maxprice" => $maxprice,
            "duration" => $duration,
            "terms" => html_entity_decode($terms),
            "user_id" => $user_id,
            "user_username" => $user_username

        );
        array_push($sellposts_arr["records"], $sellpost_item);
    }

    http_response_code(200);
    echo json_encode($sellposts_arr);

}

else{

    http_response_code(404);
    echo json_encode(
        array("message" => "Sorry, No Such Offers at this moment.")
    );

}



?>