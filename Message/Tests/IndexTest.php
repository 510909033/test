<?php
namespace Message\Test;
use Message\Controller\Index;

require_once '../Controller/Index.php';

class IndexTest extends \PHPUnit_Framework_TestCase{
    
    public function testIndex(){
        
        $index = new \Message\Controller\Index();
        $index->indexPage();
        
        
        $this->assertEquals($expected, $actual);
        
    }
    
    
    
}