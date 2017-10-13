<?php
namespace Message\Interf\Model;
interface Base
{
    
    public function connect();
    
    public function add();
    public function find();
    public function select();
    public function delete();
    public function save();
    
}

