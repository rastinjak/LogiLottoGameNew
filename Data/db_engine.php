<?php
require_once '../Model/Bet.php';

class Baza 
{
    public $user;
    public $pass;
    public $host;
    public $ime_baze;
    const user = "root";
    const pass = "";
    const host = "localhost";
    const ime_baze = "logilotto_game";
    public $dbh;
    
    public function __construct() 
    {
        $db_data_json = file_get_contents("../Data/db_config.json");
        $db_data = json_decode($db_data_json, true);
        
        $user = $db_data["user"];
        $pass = $db_data["pass"];
        $host = $db_data["host"];
        $ime_baze = $db_data["ime_baze"];
                
        try
        {
            $string = "mysql:host=".$host.";dbname=".$ime_baze;
            $this->dbh = new PDO($string, $user, $pass);
        }
        catch (PDOException $e)
        {
            echo "GRESKA";
        }
    }
    
    public function __destruct() 
    {
        $this->dbh=NULL;
    }
    
    public function getAllBets()
    {
        $sql = "SELECT * FROM bets";
        $upit=$this->dbh->query($sql);
        $bets = $upit->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($bets);
    }

    public function BetsInLast3Minutes()
    {
        //$datetime_now = new DateTime(date("Y-m-d h:i:s"));
        //$interval3minuta = new DateInterval('PT3M');
        
        $sql = "SELECT * FROM bets WHERE status=0";
        $upit=$this->dbh->query($sql);
        $bets = $upit->fetchAll(PDO::FETCH_ASSOC);
        
        $bets_m = array();
        foreach ($bets as $bet) 
        {
            array_push($bets_m, new Bet($bet['betID'], $bet['placedDate'], $bet['clientID'], $bet['status'], $bet['stakeAmount'], $bet['numbers']));
        }
        
        return $bets_m;
    }
    
    public function getAllTransaction()
    {
        $sql = "SELECT * FROM transaction";
        $upit=$this->dbh->query($sql);
        $transactions = $upit->fetchAll(PDO::FETCH_ASSOC);
        
        $transactions_m = array();
        
        foreach ($transactions as $transaction) 
        {
            array_push($transactions_m, new Transaction($transaction['betID'], $transaction['drawID']));
        }
        
        return $transactions_m;
    }
    
    public function getClientWithID($id)
    {
        $sql = "SELECT * FROM client WHERE clientID = $id";
        $upit=$this->dbh->query($sql);
        $client = $upit->fetch(PDO::FETCH_ASSOC);
        
        return json_encode($client);
    }

    public function checkIfHaveEnough($id,$betAmount)
    {
        $sql = "SELECT * FROM client WHERE clientID = $id";
        $upit=$this->dbh->query($sql);
        $client = $upit->fetch(PDO::FETCH_ASSOC);
        
        if($client == false)
        {    
            return false;
        }
        if($client['balance'] >= $betAmount)
        {
            return true;
        }
        
        return false;
    }

    public function checkIfClientExist($id)
    {
        $sql = "SELECT * FROM client WHERE clientID = $id";
        $upit=$this->dbh->query($sql);
        $client = $upit->fetch(PDO::FETCH_ASSOC);
        
        if($client == false)
        {    
            return false;
        }
        
        return true;
    }

    public function updateClient($id,$amountChange)
    {
        $client = $this->getClientWithID($id);
        /*echo $client;
        return;*/
        
        $c = json_decode($client);
        $newAmount = $c->balance + $amountChange;
        try 
        {
            $sql = "UPDATE client SET balance=:balance WHERE clientID=:id";

            $pdo_izraz = $this->dbh->prepare($sql);
            $pdo_izraz->bindParam(':balance', $newAmount);
            $pdo_izraz->bindParam(':id', $id);
            $pdo_izraz->execute();
            return true;
        } 
        catch (Exception $ex) 
        {
            echo "GRESKA: ";
            echo $ex->getMessage();
        }
    }
    
    public function updateBet($id,$status,$winAmount)
    {
        $sql = "UPDATE bets SET status = $status, winAmount = '$winAmount' WHERE betID=$id";
        $pdo_izraz=$this->dbh->exec($sql);
    }
    
    public function addBet($bet)
    {        
        try 
        {
            $date = $bet->getPlacedDate();
            $clientID = $bet->getClientID();
            $stakeAmount = $bet->getStakeAmount();
            $numbers = $bet->getNumbers();
            
            $sql = "INSERT INTO bets(placedDate,clientID,stakeAmount,numbers)";
            $sql.= "VALUES('$date','$clientID','$stakeAmount','$numbers')";
            $pdo_izraz = $this->dbh->exec($sql);
           
            return $this->dbh->lastInsertId();
        } 
        catch (Exception $exc) 
        {
            echo "Greska: ";
            echo $exc->getMessage();
            return false;
        }
    }
    
    public function addTransaction($betID,$drawID)
    {        
        try 
        {
            $sql = "INSERT INTO transaction(betID,drawID)";
            $sql.= "VALUES('$betID','$drawID')";
            $pdo_izraz = $this->dbh->exec($sql);
            return true;
        } 
        catch (Exception $exc) 
        {
            echo "Greska: ";
            echo $exc->getMessage();
            return false;
        }
    }
    
    public function addDraw($draw)
    {        
        try 
        {
            $br1 = $draw->getNo1();
            $br2 = $draw->getNo2();
            $br3 = $draw->getNo3();
            $br4 = $draw->getNo4();
            $br5 = $draw->getNo5();
            $br6 = $draw->getNo6();
            $br7 = $draw->getNo7();
            
            $sql = "INSERT INTO draws(number_01,number_02,number_03,number_04,number_05,number_06,number_07)";
            $sql.= "VALUES('$br1','$br2','$br3','$br4','$br5','$br6','$br7')";
            $pdo_izraz = $this->dbh->exec($sql);
            return $this->dbh->lastInsertId();
        } 
        catch (Exception $exc) 
        {
            echo "Greska: ";
            echo $exc->getMessage();
            return false;
        }
    }   
}
?>