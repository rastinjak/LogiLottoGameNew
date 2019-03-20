<?php
    require_once '../Controller/DB_Control.php';
    require_once '../Model/Draw.php';

class Utils 
{
    private static $odds = array(-1,1,2,4,10,25,50,100);
    
    public static function CheckNumber($n)
    {  
        if (is_numeric($n) && $n >= 1 && $n <= 60)
        {
            return true;
        }

        return false;
    }
    
    public static function StringToArrayNumber($s)
    {
        $a = explode(" ", $s);
        
        if (sizeof($a) != 7) 
        {
            return false;
        }
        
        for($i = 0; $i < 7; $i++)
        {
            if(!self::CheckNumber($a[$i]))
            {
                return false;
            }
        }

        $a = array_unique($a);

        if (sizeof($a) != 7) 
        {
            return false;
        }
        
        sort($a);
        
        return $a;
    }
    
    public static function CheckBet($bet,$draw_)
    {       
        $n = 0;
        
        $draw = [$draw_->getNo1(), $draw_->getNo2(), $draw_->getNo3(), $draw_->getNo4(), $draw_->getNo5(), $draw_->getNo6(), $draw_->getNo7()];
        for($i = 0; $i <7; $i++)
        {
            for($j = 0; $j <7; $j++)
            {
                if($bet[$i] == $draw[$j])
                {
                    $n++;
                }
            }
        }
        
        return $n;
    }
    
    public static function WinPrice($bet,$draw,$stakeAmount)
    {
         $n = self::CheckBet($bet,$draw);     
        
         return self::$odds[$n] * $stakeAmount;
    }
    
    public static function GetDraw()
    {
        $brojevi = array();
        while(sizeof($brojevi) < 7)
        {
            $r = rand(1, 60);
            if(array_search($r, $brojevi) == false)
                array_push ($brojevi, $r);
        }    
        
        $draw = new Draw($brojevi[0], $brojevi[1], $brojevi[2], $brojevi[3], $brojevi[4], $brojevi[5], $brojevi[6]);
        
        return $draw;
    }
}
