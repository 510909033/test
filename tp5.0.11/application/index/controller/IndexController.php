<?php
namespace app\index\controller;

use think\Build;

class IndexController
{
    public function indexAction()
    {
        Build::module('pdfapi');
        
        $build =     ['pdfapi'     => [
        '__file__'   => ['common.php'],
        '__dir__'    => ['behavior', 'controller', 'model', 'view'],
        'controller' => ['IndexController', 'TestController', 'UserTypeController'],
        'model'      => ['User', 'UserType'],
        'view'       => ['index/index'],
    ]];
        Build::run($build);
    }
}
