<?php
class Transaction 
{
    private $betID;
    private $drawID;
    
    public function __construct($betID,$drawID)
    {
        $this->$betID = $betID;
        $this->$drawID = $drawID;
    }
    
    public function getBetID(){ return $this->betID; }
    public function getDrawID(){ return $this->drawID; }
}
