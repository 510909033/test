<?php
namespace http\server;
set_time_limit(0);
define('SYS_CHARSET', $argv[1]?$argv[1]:'GBK');

class S{
    private $ip;
    private $port;
    private $i=0;
    private $requestString;
    private $responseString;
    private $responseLength;
    private $docuentRoot = 'c:';
    private $requestMethod ;//大写GET POST
    private $requestQueryString;
    private $ext;
    private $filename;// 以/结尾，根目录为/
    private $trueFilename;//硬盘目录
    private $host;//127.0.0.1:8888
    private $httpMethod;//http https
    private $httpType;// http/1.1
    
    private $headerArr;
    private $rootUrl;//http://.....:8088
    
    private $SYS_CHARSET = 'UTF-8';
    private $current_is_dir = '';
    private $mineTypes=[];
    private $httpMineType='';
    
    private $config=[
        'mine.types'=>'mine.types.php',  
    ];
    
    private $stdout;
    
    public function __construct($ip,$port){
        $this->ip = $ip;
        $this->port = $port;
        
        $this->parseConfig();
        $this->stdout = fopen('php://stdout', 'w');
    }
    
    private $useTime=0;
    
    public function listen(){
        
        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($sock < 0) {
            $this->throwException(__LINE__,  "Error:" . socket_strerror(socket_last_error()) );
        }
        
        $ret = socket_bind($sock, $this->ip, $this->port);
        if (! $ret) {
            $this->throwException(__LINE__, "BIND FAILED:" . socket_strerror(socket_last_error()) );
        }
        
        $ret = socket_listen($sock);
        if ($ret < 0) {
            $this->throwException(__LINE__, "LISTEN FAILED:" . socket_strerror(socket_last_error()) );
        }
        
        
        do {
            $starttime = microtime(true);
            $this->beforeAcceptInitAttr();
            $new_sock = null;
            try {
                echo 'socket_accept ... '.PHP_EOL;
                
                $new_sock = socket_accept($sock);
//                 socket_set_nonblock($new_sock);
            } catch (\Exception $e) {
                $this->log(__LINE__, "ACCEPT FAILED:" . socket_strerror(socket_last_error()) );
                continue;
            }
            
            try {
                $this->requestString = socket_read($new_sock, 1024);
                
                
                $this->parseClientSocket();
                socket_write($new_sock, $this->responseString);
                
            } catch (\Exception $e) {
                $this->log(__LINE__, "WRITE OR READ FAIL".socket_strerror(socket_last_error()) );
                continue;
            }
        
            $this->useTime = microtime(true) - $starttime;
            $this->debug();
            
            socket_close($new_sock);
        } while (TRUE);
    }
    
    private function setHeaderStatus($code=200){
        switch ($code){
            case 200:
                $this->headerArr['status'] = 'HTTP/1.1 200 OK';
                break;
            case 404:
                $this->headerArr['status'] = 'HTTP/1.1 404 File Not Found';
                break;
            default:
                $this->headerArr['status'] = 'HTTP/1.1 404 File Not Found';
                break;
        }
    }
    
    private function setHeaderContentType($contentType='text/html; charset=UTF-8'){
        $this->headerArr['content_type'] = 'Content-type: '.$contentType;
    }
    
    private function setHeaderContentLength(){
        $this->headerArr['Content_length'] = 'Content-Length: '.$this->responseLength;
    }
    
    
    private function throwException($__LINE__,$msg){
        throw new \Exception($msg);
    }
    
    private function log($__LINE__,$msg){
        echo $__LINE__.',msg='.($msg).PHP_EOL;
    }
    
    private function iconv_out($str){
        if (SYS_CHARSET != 'UTF-8'){
            return iconv('GBK', 'UTF-8', $str);
        }
        return $str;
    }
    
    private function iconv_in($str){
        
        if (SYS_CHARSET != 'UTF-8' && $str){
//             $this->out($str);
            return mb_convert_encoding($str, 'GBK','UTF-8');
//             return iconv( 'UTF-8' , 'GBK', $str);
        }
        return $str;
    }
    
    
   
    private function parseClientSocket(){
        /*
//         GET /aaa.php?ab=%E4%B8%AD%E5%9B%BD HTTP/1.1
//         Host: 127.0.0.1:8888
//         User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:55.0) Gecko/20100101 Firefox/55.0
//         Accept: text/html,application/xhtml+xml,application/xml
//         Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3
//         Accept-Encoding: gzip, deflate
//         Connection: keep-alive
//         Upgrade-Insecure-Requests: 1
//         Cache-Control: max-age=0
         */
        $arr = explode("\n", $this->requestString);
        
        foreach ($arr as $k=>$line){
            $lineArr = explode(' ', $line);
            $lineArr[0] = strtoupper($lineArr[0]);
            
            switch ($lineArr[0]){
                case 'GET':
                case 'POST':
                    $this->requestMethod = $lineArr[0];
                    $this->requestQueryString = urldecode($lineArr[1]);
                    $this->httpType = $lineArr[2];
                    
                    $lineArr[2] = strtoupper($lineArr[2]);
                    if (strpos($lineArr[2], 'HTTP/') !== false){
                        $this->httpMethod = 'HTTP';
                    }else if (strpos($lineArr[2], 'HTTPS/') !== false){
                        $this->httpMethod = 'HTTPS';
                    } else{
                        $this->throwException(__LINE__, '位置的httpMethod：'.$lineArr[2]);
                    }
                    break;
                case 'HOST:':
                    $this->host = $lineArr[1];
                    break;
            }
            
        }
        
        if (!$this->requestMethod){
            $this->_disResponsString404();
            return;
        }
        
        
        /*
         * /?a=c   
         * /
         * /index.html
         * /index.html/
         * /aaa/index.html?a=c
         */ 
        
//         $this->filename = basename($this->requestQueryString);
        
        /**
         * ?前面的部分
         * @var Ambiguous $before
         */
        $before = $this->requestQueryString;
        if (strpos($this->requestQueryString, '?') !== false){
            $before = strstr($this->filename ,'?', true);
        }
        
        if ( $this->is_dir($this->docuentRoot.$before)  ){
            $this->ext = '';
            $this->filename = rtrim($before,'/').'/';
            $this->current_is_dir = 'dir';
        }else{
            $this->filename = $this->requestQueryString;
            if (strpos($this->requestQueryString, '?')){
                $this->filename = strstr($this->filename ,'?', true);
            }
            $this->ext = strtoupper( pathinfo($this->filename , PATHINFO_EXTENSION));
            $this->current_is_dir = 'file';
        }
        
        
        
        $this->trueFilename = $this->docuentRoot.$this->filename;
        $this->rootUrl = strtolower($this->httpMethod).'://'.$this->host;
        
        $this->_afterParseClientSocket();
        $this->disResponsString();
        
    }
    
    private function is_dir($dir){
//         if($this->SYS_CHARSET ==)
        if (SYS_CHARSET != 'UTF-8' ){
            $dir = iconv('UTF-8', SYS_CHARSET, $dir);
        }
        return is_dir($dir) ;
    }
    
    private function _afterParseClientSocket(){
        
    }
    
    private function disResponsString(){
        
        $this->setHeaderStatus();
        $this->setHeaderContentType();
        
        if ( $this->is_dir($this->trueFilename) ){
            $this->_disResponsStringDir();
        }else if ( is_file( $this->iconv_in($this->trueFilename) ) ){
            if (isset($this->mineTypes[$this->ext])){
                $this->setHeaderContentType($this->mineTypes[$this->ext]);
                $this->httpMineType = $this->mineTypes[$this->ext];
            }else{
                $this->setHeaderContentType();
                $this->_disResponsString404('不支持的扩展文件，扩展类型：'.$this->ext);
            }
            
            $this->responseString = file_get_contents($this->iconv_in($this->trueFilename));
        }else{
            $this->_disResponsString404();
        }
        
        
        
        
        
        
        $this->_afterDisResponsString();
    }
    
    private function _afterDisResponsString(){
        
        $this->responseLength = strlen($this->responseString);
        if ( strtolower($this->httpMineType) == 'text/html'){
            $this->headerArr['content_type'] = 'Content-type: text/html;charset=UTF-8';
        }
        $this->setHeaderContentLength();
        
        $this->responseString = implode("\r\n", $this->headerArr )."\r\n\r\n".$this->responseString;
    }
    
    private function _disResponsString404($content=''){
        $this->setHeaderStatus(404);
        if (!$content){
            $content = "<h1>File Not Found </h1>";
            $content .= "<h2>filename:{$this->trueFilename} </h2>";
        }else{
            $content = "<h1>{$content}</h1>";
        }
        //Content-Length
        $this->responseString = implode("\r\n", $this->headerArr )."\r\n\r\n".$content;
        
    }
    
    
    
    private function _disResponsStringDir(){
        
        $fp = opendir($this->iconv_in($this->trueFilename));
        if (!$fp){
            $this->_disResponsString404('打开目录'.$this->trueFilename.'失败');
            return ;
        }
        $filenameArr = [];
        $prefix = '';
        while ( ($filename = readdir($fp)) !==false ){
//             $filename = $this->iconv_in($filename);
            if( $this->is_dir( $this->iconv_in($this->trueFilename.$filename) ) ){
                $prefix = '【目录】';
            }else{
                $prefix = '【文件】';
            }
            $filenameArr[] = $prefix.'<a href="'.$this->rootUrl.$this->filename.$this->iconv_out($filename).'">'.$this->iconv_out($filename).'</a>';
        }
        
        $this->responseString = implode('<br />', $filenameArr);
    }
    
    private function beforeAcceptInitAttr(){
        $this->ext = '';
        $this->requestMethod = '';
        $this->requestString='';
        $this->responseString = '';
        $this->headerArr = [];
        $this->httpMethod='';
        $this->httpMineType='';
        $this->httpType='';
        $this->current_is_dir='';
        $this->filename='';
        $this->host='';
        $this->responseLength=0;
        $this->rootUrl='';
        $this->trueFilename='';
    }
    private function out($str){
        fwrite($this->stdout, $str.PHP_EOL);
    }
    private function debug(){
        
        
        echo 'requestQueryString:'.$this->iconv_in($this->requestQueryString).PHP_EOL;
        echo 'filename:'.$this->iconv_in($this->filename).PHP_EOL;
        echo 'ext:'.$this->ext.PHP_EOL;
        echo 'requestMethod:'.$this->requestMethod.PHP_EOL;
        echo 'trueFilename:'.$this->iconv_in($this->trueFilename).PHP_EOL;
        echo 'host:'.$this->host.PHP_EOL;
        echo 'httpType:'.$this->httpType.PHP_EOL;
        echo 'rootUrl:'.$this->rootUrl.PHP_EOL;
        echo 'current_is_dir:'.$this->iconv_in($this->current_is_dir).PHP_EOL;
        echo 'responseLength:'.$this->responseLength.PHP_EOL;
        $this->out('httpMineType:'.$this->httpMineType);
        $this->out('useTime:'.$this->useTime);
        
        
        echo PHP_EOL.PHP_EOL;
    }
    
    /**
     * 解析配置文件
     */
    private function parseConfig(){
        if (!is_file($this->config['mine.types'])){
            $this->throwException(__LINE__, 'mine.types file not exists');
        }
        $arr = file($this->config['mine.types']);
        $pattern = '#^([0-9a-z\-\_\.\+\/]{1,})\s+([0-9a-z]+.*)$#Ui';
        foreach ($arr as $k=>$v){
            $v = trim($v);
            if (strpos($v,'#') === 0){
                continue;
            }
            $matches=[];
            preg_match($pattern, $v,$matches);
            if ($matches[1]){
                foreach ( explode(' ', $matches[2]) as $v ){
                    $v = trim($v);
                    if ($v){
                        $this->mineTypes[strtoupper(($v))] = trim($matches[1]);
                    }
                }
            }
        }
        //end mine.types
        
        
    }
    
}

// var_dump(is_dir('c:/'.iconv('UTF-8', 'GBK', '新版_高速项目-2017-08-29')));

(new \http\server\S('127.0.0.1', 8888))->listen();