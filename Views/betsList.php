<?php
    require_once '../Controller/DB_Control.php';

    $db_control = new DB_Control();
 
    $allBets = $db_control->getAllBets();
    
    echo "<table cellpadding=5 border=1>";
    echo "<tr><th>Bet ID</th><th>Date</th><th>Client ID</th><th>Status</th><th>Stake Amount</th><th>Win Amount</th><th>Choosen numbers</th></tr>";
    foreach (json_decode($allBets) as $bet) 
    {
        //$status = $bet['status'];
        $status = $bet->status;
        if($status == -1)
        {
            $statusString = "Lose";
            $win = "";
        }
        else if($status == 0)
        {
            $statusString = "Waiting...";
            $win = "";
        }
        else
        {
            $statusString = "Win";
            $win = $bet['winAmount'];
        }

        //$date = date_create($bet['placedDate']);
        $date = date_create($bet->placedDate);

        echo "<tr><td><b>" . $bet->betID . "</b></td>";
        echo "<td>" . date_format($date, 'Y-m-d H:i:s') . "</td>";
        echo "<td>" . $bet->clientID . "</td>";
        echo "<td>" . $statusString . "</td>";
        echo "<td>" . $bet->stakeAmount . "</td>";
        echo "<td>" . $win . "</td>";
        echo "<td>" . $bet->numbers . "</td>";
   }
    echo "</table>";
?>