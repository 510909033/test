<?php
error_reporting(E_ALL);
$ip='127.0.0.1';
// ini_set('soap.wsdl_cache_enabled','0');//
// $soap=new SoapClient('http://'.$ip.'/Webservice/service.php?wsdl');
$soap=new SoapClient( null , array( 
        'location'=>'http://'.$ip.'/t/Webservice/service.php',
        'uri'=>'abc')
    );
// echo $soap->Add(1,2);
// echo '<hr /><br />';
echo $soap->_soapCall('Add',array(1,2));//
// $soap->__soapCall('Hello',array());