<?php

class Bet 
{
    private $betID;
    private $placedDate;
    private $clientID;
    private $status;
    private $stakeAmount;
    private $winAmount;
    private $numbers;
    
    public function __construct($betID,$placedDate,$clientID,$status,$stakeAmount,$numbers) 
    {
        $this->betID = $betID;
        $this->placedDate = $placedDate;
        $this->clientID = $clientID;
        $this->status = $status;
        $this->stakeAmount = $stakeAmount;
        $this->numbers = $numbers;
    }
    
    public function getBetID(){ return $this->betID; }
    public function getPlacedDate(){ return $this->placedDate; }
    public function getClientID(){ return $this->clientID; }
    public function getStatus(){ return $this->status; }
    public function getStakeAmount(){ return $this->stakeAmount; }
    public function getWinAmount(){ return $this->winAmount; }
    public function getNumbers(){ return $this->numbers; }
}
