<?php
class SellPost{
    private $conn;
    private $table_name = "sellpost";
    public $id;
    public $users_id;
    public $username;
    public $paymentmethod;
    public $currency;
    public $price;
    public $maxprice;
    public $minprice;
    public $duration;
    public $terms;
    public $created;
    public function __construct($db){
        $this->conn = $db;
    }
    function post(){
        $query = "SELECT
        u.name as username, s.id, s.paymentmethod, s.currency, s.price, s.maxprice, s.minprice, s.duration, s.terms, s.users_id, s.created
        FROM
        " . $this->table_name . " as s
        JOIN as users u
        ON s.users_id = u.id
        ORDER BY
        s.created DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
}
?>