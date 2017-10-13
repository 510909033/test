<?php
namespace Unit;
class FlockTest extends \PHPUnit_Framework_TestCase
{
    
    private $filename;
    private $dir;
    
    /**
     * {@inheritDoc}
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->dir = '../File/FlockTest/'.uniqid(true).'/';
        if (!is_dir($this->dir)){
            mkdir($this->dir,755,true);
        }
        
        $this->filename = 'flock.test';

        \PHPUnit_Framework_Assert::anything();
        $this->assertArrayHasKey($key, $array);
    
    }

    /**
     * {@inheritDoc}
     * @see PHPUnit_Framework_TestCase::tearDown()
     */
    protected function tearDown()
    {
        unlink($this->dir.$this->filename);
        //unlink($this->dir);
    }

    
    public function testFunc(){
        
        fopen($this->dir.$this->filename, 'r+b');
        
    }
    
    
    
    
}

