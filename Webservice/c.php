<?php
error_reporting(E_ALL);
$ip='127.0.0.1';
$soap=new SoapClient( null , array( 
        'location'=>'http://'.$ip.'/t/Webservice/s.php',
        'uri'=>'abc')
    );
// echo $soap->Add(1,2);
// echo '<hr /><br />';
echo $soap->__soapCall('Add',array(1,2));//
$res = $soap->__soapCall('Hello',array());

$res = json_decode(json_encode(new SimpleXMLElement($res)),true);
print_r($res);

