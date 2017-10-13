<?php
namespace Message\Interf\Model;
interface User{
    /**
     * @return \Message\Struct\User
     */
    public function getInfo( \Message\Struct\User $user );
    /**
     * @return \Message\Struct\User
     */
    public function addUser(\Message\Struct\User $user);
    
    public function saveUser(\Message\Struct\User $user);
    
    
    public function getList();
    
    
}