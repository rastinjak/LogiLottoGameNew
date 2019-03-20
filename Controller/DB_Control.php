<?php

require_once '../Data/db_engine.php';

class DB_Control 
{
    private $db_connection;
    
    public function __construct() 
    {
        $this->db_connection = new Baza("../Data/db_config.json");
    }
    
    public function getAllBets()
    {
        return $this->db_connection->getAllBets();
    }
    
    public function checkIfClientExist($id)
    {
        return $this->db_connection->checkIfClientExist($id);
    }
    
    public function updateClient($id,$amountChange)
    {
        $this->db_connection->updateClient($id, $amountChange);
    }
    
    public function addBet($bet)
    {
        return $this->db_connection->addBet($bet);
    }
    
    public function checkIfHaveEnough($id,$betAmount)
    {
        return $this->db_connection->checkIfHaveEnough($id, $betAmount);
    }
    
    public function addDraw($draw)
    {
        return $this->db_connection->addDraw($draw);
    }
    
    public function updateBet($betID, $status, $win)
    {
        $this->db_connection->updateBet($betID, $status, $win);
    }
    
    public function addTransaction($betID, $drawID)
    {
        $this->db_connection->addTransaction($betID, $drawID);
    }
    
    public function BetsInLast3Minutes()
    {
        $sranje = $this->db_connection->BetsInLast3Minutes();
        //$sranje = json_decode($sranje);
        print_r($sranje);
        return $this->db_connection->BetsInLast3Minutes();
    }
}

?>