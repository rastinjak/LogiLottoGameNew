<?php  
    require_once '../Tools/Utils.php';
    require_once 'DB_Control.php';

    if(isset($_GET['id']) && isset($_GET['bet']) && isset($_GET['numbers']))
    {
        $id = htmlspecialchars($_GET['id']);
        $betAmount = htmlspecialchars($_GET['bet']);
        $combination = htmlspecialchars($_GET['numbers']);
                
        $db_control = new DB_Control();
//        $db = new Baza("../Data/db_config.json");
        
        if($db_control->checkIfClientExist($id) == true)
        {
            if($db_control->checkIfHaveEnough($id, $betAmount))
            {
            }
            else
            {
                echo "*Nemate dovoljno sredstava";
                return;
            }
        }
        else 
        {
            echo "*Pogresan ID";
            return;
        }
          
        if(is_numeric($betAmount))
        {
            $bet = Utils::StringToArrayNumber($combination);

            if($bet != false)
            {
                echo "Successful!<br>";
                
                $date = date("Y-m-d h:i:s");
                
                $bet = new Bet(0, $date, $id, 0, $betAmount, implode(" ", $bet));
                $betID = $db_control->addBet($bet);
                //$betID = $db_control->addBet($date, $id, $betAmount, implode(" ", $bet));
                $db_control->updateClient($id, -$betAmount);      
            }
            else
            {
                echo "*Pogresna kombinacija";
            }
        }
        else
        {
            echo "*Iznos mora biti broj";
        }
    }
    else
    {
        echo "*Morate uneti sve parametre!!!";
    }    
?>