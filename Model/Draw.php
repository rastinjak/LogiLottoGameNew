<?php


class Draw 
{
    private $id;
    private $numbers;
    
    public function __construct($no_1, $no_2, $no_3, $no_4, $no_5, $no_6, $no_7, $id = 0) 
    {
        $this->numbers = [$no_1, $no_2, $no_3, $no_4, $no_5, $no_6, $no_7];
    }
    
    public function getNo1() { $this->numbers[0]; }
    public function getNo2() { $this->numbers[1]; }
    public function getNo3() { $this->numbers[2]; }
    public function getNo4() { $this->numbers[3]; }
    public function getNo5() { $this->numbers[4]; }
    public function getNo6() { $this->numbers[5]; }
    public function getNo7() { $this->numbers[6]; }
}


?>
