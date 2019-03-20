<?php
    require_once 'DB_Control.php';
    require_once '../Tools/Utils.php';

    $db_control = new DB_Control();
    
    while(true)
    {
        $draw = Utils::GetDraw();
        $drawID = $db_control->addDraw($draw);
        
        $bets_to_check  = $db_control->BetsInLast3Minutes();
        
        
        //$bets_to_check = json_decode($bets_to_check);
        //print_r($bets_to_check);
                
        foreach($bets_to_check as $bet)
        {            
            $numbers = $bet->getBetID();
            $numbers_array = Utils::StringToArrayNumber($numbers);
            $betAmount = $bet->getStakeAmount();
            $win = Utils::WinPrice($numbers_array, $draw, $betAmount);
            
            $status = -1;
            if($win > 0)
            {
                $status = 1;
                $id = $bet->getClientID();
                $db_control->updateClient($id, $win);
            }

            $betID = $bet->getBetID();
            $db_control->updateBet($betID, $status, $win);
            $db_control->addTransaction($betID, $drawID); // moze da bude transakcija i ako samo isplacuje novac
        }
        
        sleep(180); 
    } // beskonacna petlja
    

?>
