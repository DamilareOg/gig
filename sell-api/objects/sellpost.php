<?php

class SellPost{


    private $conn;
    private $table_name = "sellposts";


    public $id;
    public $paymentmethod;
    public $currency;
    public $btcprice;
    public $minprice;
    public $maxprice;
    public $duration;
    public $terms;
    public $user_id;
    public $user_username;
    public $created;


    // Making $db the database connection

    public function __construct($db){
        $this->conn = $db;

    }

    // create sell post

function create(){

    $query = "INSERT INTO

                " . $this->table_name . "
            SET
                paymentmethod=:paymentmethod, currency=:currency, btcprice=:btcprice,minprice=:minprice,maxprice=:maxprice,
                duration=:duration,terms=:terms, user_id=:user_id, created=:created";

    $stmt = $this->conn->prepare($query);


    $this->paymentmethod=htmlspecialchars(strip_tags($this->paymentmethod));
    $this->currency=htmlspecialchars(strip_tags($this->currency));
    $this->btcprice=htmlspecialchars(strip_tags($this->btcprice));
    $this->minprice=htmlspecialchars(strip_tags($this->minprice));
    $this->maxprice=htmlspecialchars(strip_tags($this->maxprice));
    $this->duration=htmlspecialchars(strip_tags($this->duration));
    $this->terms=htmlspecialchars(strip_tags($this->terms));
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
    $this->created=htmlspecialchars(strip_tags($this->created));

    $stmt->bindParam(":paymentmethod", $this->paymentmethod);
    $stmt->bindParam(":currency", $this->currency);
    $stmt->bindParam(":btcprice", $this->btcprice);
    $stmt->bindParam(":minprice", $this->minprice);
    $stmt->bindParam(":maxprice", $this->maxprice);
    $stmt->bindParam(":duration", $this->duration);
    $stmt->bindParam(":terms", $this->terms);
    $stmt->bindParam(":user_id", $this->user_id);
    $stmt->bindParam(":created", $this->created);

    if($stmt->execute()){

        return true;

    }

    return false;  

}

    // posting sell offers

function post(){

    $query = "SELECT
                u.username as user_username, s.id, s.paymentmethod, s.currency, s.btcprice, s.minprice ,s.maxprice,
                s.duration, s.terms, s.maxprice,  s.user_id, s.created
            FROM
                " . $this->table_name . " s
                LEFT JOIN
                    users u
                        ON s.user_id = u.id
            ORDER BY
                s.created DESC";

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt;
}

//read a particular order

function post_view(){

    $query = "SELECT
                u.username as user_username, s.id, s.paymentmethod, s.currency, s.btcprice, s.minprice , s.maxprice,
                s.duration, s.terms, s.maxprice,  s.user_id, s.created
            
            FROM
                
                " . $this->table_name . " s
                
                LEFT JOIN
                    users u
                        ON s.user_id = u.id
            WHERE
                s.id = ?
            LIMIT
                0,1";

    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set values to object properties

    $this->paymentmethod = $row['paymentmethod'];
    $this->currency = $row['currency'];
    $this->btcprice = $row['btcprice'];
    $this->minprice = $row['minprice'];
    $this->maxprice = $row['maxprice'];
    $this->duration = $row['duration'];
    $this->terms = $row['terms'];
    $this->user_id = $row['user_id'];
    $this->user_username = $row['user_username'];
}

// search post function

function search($keywords){
    $query = "SELECT
                u.username as user_username, s.id, s.paymentmethod, s.currency, s.btcprice, s.minprice ,s.maxprice,
                s.duration, s.terms, s.maxprice,  s.user_id, s.created

            FROM

                " . $this->table_name . " s
                LEFT JOIN
                users u
                ON s.user_id = u.id

            WHERE
            s.paymentmethod LIKE ? OR s.terms LIKE ? OR s.currency LIKE ? OR u.username LIKE ?
            ORDER BY
                s.created DESC";

    $stmt = $this->conn->prepare($query);
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    $stmt->bindParam(3, $keywords);
    $stmt->bindParam(4, $keywords);
    $stmt->execute();
    return $stmt;
    
}

// delete sell post

function delete(){

    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

    $stmt = $this->conn->prepare($query);
    
    $this->id=htmlspecialchars(strip_tags($this->id));
    
    $stmt->bindParam(1, $this->id);
    
    if($stmt->execute()){
        return true;
    }

    return false;

}

}
?>