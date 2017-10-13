<?php
error_reporting(0);
class Service
{

    public function Hello()
    {
        $key = '122222';
        $k = 'aaaaaaaa';
        $v = 'username';
        $xmlString = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $xmlString .= "<Data>\n";
        $xmlString .= "<Rec ID=\"UU{$key}\">\n";
        $xmlString .= " <UU{$k}>$v</UU{$k}>\n";
        $xmlString .= "</Rec>\n";
        $xmlString .= "</Data>";
        return $xmlString;
        return 'hello good';
    }

    public function Add($a, $b)
    {
//         return $this->Hello();
        return $a + $b;
    }
}
// $server= new SoapServer('service.php',array('soap_version'=>SOAP_1_2));
// $server= new SoapServer( null ,array('uri'=>'http://127.0.0.1/t/Webservice/service.php'));
// $server= new SoapServer( null ,array('uri'=>'http://127.0.0.1/t/Webservice/'));
$server = new SoapServer(null, array(
    'uri' => 'abc',
    'soap_version' => SOAP_1_2
));
$server->setClass('Service'); //

$server->handle(); //
