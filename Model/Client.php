<?php

class Client 
{
    private $id;
    private $name;
    private $balance;
    
    public function __construct($id, $name, $balance) 
    {
        $this->id = $id;
        $this->name = $name;
        $this->balance = $balance;
    }
}

?>
