<?php
class RsaPrivateKeyEncryptionAndDecryption{
    private $a=['PKCS1_PADDING','PKCS1_OAEP_PADDING','SSLV23_PADDING'];
    private $public_key_PKCS_1='-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCECI3YDEqWO+gxDKmFud0D/bfP
Ewg+wudt5pSG8ROyKVPAe6cBiV5DbcUFfXApcdoCVM3z314ggN12Bt5JdtuxysKO
NbgLmp/fSL8h9PTFOz8SIq0cYlRE3OCWUmIXBxiPf1WOVrZM+FnHsIcmVGxRDkX1
+kUyhfdtfkxLHm/ZHQIDAQAB
-----END PUBLIC KEY-----
';
    private $private_key_PKCS_1='-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQCECI3YDEqWO+gxDKmFud0D/bfPEwg+wudt5pSG8ROyKVPAe6cB
iV5DbcUFfXApcdoCVM3z314ggN12Bt5JdtuxysKONbgLmp/fSL8h9PTFOz8SIq0c
YlRE3OCWUmIXBxiPf1WOVrZM+FnHsIcmVGxRDkX1+kUyhfdtfkxLHm/ZHQIDAQAB
AoGAO6ph7zAexKVt2DyQnw3PAu61Ea7YGwSY8OEyXYi0Dd7/Kgy2+8rH/lCsqD53
YUNB8avBJmPadXXGnn+cFDbSMG+9l8Cxvx5/QLvpc6iUCm9szDR6ktMbgJ4Xh4YK
8zDUO1JozVHTRlhZ/a1b5LNp/630GGjoPvkUXaJTeRqW00ECQQDBlbTh882fXeUl
9J75BkNvmXhVhHdLKWDGeSyPT6ji/ParcVd0d9TAuK1j1PvzVdWm1CQUIZJz7KUb
4KgG9hS7AkEArpp1fJ9RELV3nnwY4z9AEkHr8VXyAeIcbrWk+hhvj4Fr9b194UVQ
bHVYv9H1I2pn1aPUsOL4KI6HL4PhNO9YBwJAJUxF3J8PyBvcMbLvCkXlqlPkdn2e
SnH/fl4MctRDUvCwShn9YqhP6o3qgmif3qN0Fb+b7/ED+afnq/ZeCXFSTwJBAKtH
R9MNcfdjHEmy0LMzm8WNN0fSGInyZhPQSlsv11g+DErPLQnr9d2/K2VYMBIi0mMH
yKAQtoEKd+CLjUNhOscCQQCKrToTt/l90DQuLkcA9QHLSyugv7oi70WxAKObhwsw
ckZkewYNnaa3LsnhffJg0z9md4MBZKOxwItEAYeGySWD
-----END RSA PRIVATE KEY-----';
    
    private $public_key_PKCS_8='-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCndJ3zOK6kX5uYeTvphwt8U0bM
W0gkBl44EW3noBWxAY4o5u1yxDXf6JyMqw9XOokF3p6bXeMMIK24ehgKfC/fq0lX
47MBhb1T3cM5os5iguCL0vcHxHFScou1Ql+ogEDv3MZ7sWioqJNArUCm/UI8ErXk
B2lxQwgghJdrRTSdiwIDAQAB
-----END PUBLIC KEY-----';
    private $private_key_PKCS_8='-----BEGIN PRIVATE KEY-----
MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBAKd0nfM4rqRfm5h5
O+mHC3xTRsxbSCQGXjgRbeegFbEBjijm7XLENd/onIyrD1c6iQXenptd4wwgrbh6
GAp8L9+rSVfjswGFvVPdwzmizmKC4IvS9wfEcVJyi7VCX6iAQO/cxnuxaKiok0Ct
QKb9QjwSteQHaXFDCCCEl2tFNJ2LAgMBAAECgYA0YVIXBp/6Yr21EBchkVCSbyoy
OktymVtXhnwue/DNEYN6X+HeiGmhxI1Tox6FVpYN8/kA+HlRDdfJYMesX/RJLS3y
De/3MtHreYOs+wpx3HDPZki2o1RrxrOq7KqHxr59DTnjct7kY3K/Xxuykn6ggLQg
w8uogHVyGYInFBPvgQJBANDZ85EULb0lruIHuZ7tAl+2AgfkWzMsiV8qBe7xz6WX
SQ27xqZesJWnwDGWpf3M+SBGVLX0VA/1Go5skWNHlDsCQQDNQkul9rosexf6ZPQR
X9c8KIrNuA0Smqmq1zMkm0wTYQZrQKVmHuho8lwlNcvfUw601op5UDJHB81hQnh/
7xbxAkEAhDwreoVTPHqakySfA6A/K4ibGpIcqHcfd3CtFxBmEAuMxrRI39f+aJMx
HnSrHtpkNmoxgo9zljLzoI/fMgQFNwJBAI2FQidBwAdfL58i7+zyybHeuiUw20KS
hJ0YF1kMAh3ybbyRK/kHInMJd2LofpKR77fbnEoccy3qQT7n17FNpeECQQCFBP3n
IVjsPke5yv9h9rh7iQrcvLIqcvVAO1XxheI0tR1GLm9mzimVQG68kl4GddLBCdHS
ZPp668HT3JSFfee0
-----END PRIVATE KEY-----';
    
    private $public_key_PKCS_8_PASSWORD_123='-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDirqIlublCiovvUret1ZtcAFo3
iVFUiYkcVaEBUKo/rJlC/lY7dFCKJmVFWqK/fHTMhCrEEJVGH8dH4FF00ZKXVbit
Q1/V5Yjh5aJaAcca8aiY/Tw7FL+EKYjx7fRzUI2hfO0ZA0xG4PFivKdzKbvgf/DQ
w3TqYyzUY1kImxvZSQIDAQAB
-----END PUBLIC KEY-----
';
    private $private_key_PKCS_8_PASSWORD_123='-----BEGIN ENCRYPTED PRIVATE KEY-----
MIICxjBABgkqhkiG9w0BBQ0wMzAbBgkqhkiG9w0BBQwwDgQIzasMeKL+kkMCAggA
MBQGCCqGSIb3DQMHBAjBazIpV47K4QSCAoBAfYEbQpAoJl3DXiie9ipzy7vnpa+T
vuKPUIuaALCTxGp20Ev2eSF5pWCJPEL/TTruh3hdlScGXNbo1nVionAuCzrkCiBO
7hsjwTcaiCwGxFqqmr5PGAOShHpmzhz6tXM8Zai8Gh6nInftYc5Fd6+astHYnIS1
b6IX8C4yUmUlBHFbc7LVEbOQta+MUUE7U+f0GA1grSPuhaArZqv0P2pADSuxQcDJ
sre3TRWL8WEiG8LMmcxz3bb9Wdn+qlQxrrsWuzR+n2Fv7Uy1QDWeJK1w1sxoUBip
YXDvNiHs+KVmaQeJYm17QZ3JLLo9KjIJ9WhD7sVVDVaDfFfybna2Wz5ea1Cu0dKW
RsPXhzBdFahyAquw6UzOh53ut5egsriNIX+IgAQ6Ssie/JovlG/433jqUcXl7+PD
dTmMKVtSLI9aaH2+BOBZ/nghcENTogIjKN5F3p4PVchVz8IggEc4Q+oYGa3O/3zm
4wNKUz8wFdNBfMbF62M98FGeEIiswtUNIpbGbjq6SUygbs3hBMrn0i8T1M6qKSA7
94E8PIA3nyh0/FF8lN8WBAIEf7/1UrO3BNK3/zX+okSPXb3aBC/JHMYbLtHatL3x
4zjlNmRGaIMUqqRBsWT7hBfkMFiqxaYfdKqzXI5fXyBZnMc5ob3bMM/RAQc5TtBj
PR83JJN9Zso2Eifolcl9rFQuqIzR4irPhECzIcgGiYeAHcl+5R04xXAgefIyOAh0
U9RAoQKm7mkxaeTuOWdZQOJ+wRAqB3XFNyf0oqy0kYznjY5+YUFOkNCYoXvJlJ/c
r68Tov54SqTQG3850eo1et8b/2LUzr3AFaxH5OmLRV5s2iNyWg7KbFdQ
-----END ENCRYPTED PRIVATE KEY-----
';
    
    private $data=[
            'abc',
            '中文简体',
            '中文繁體',
        '长字符串dlakfjaldskfajl&*&)_87967823%&^()_aljk拉克丝待发奖拉丝粉开发】】fa/][alsf,/s.df,中文繁體',
//             false,
//             null
        ];
    private $key;
    private $padding ;
    private $private_key;
    private $public_key;
    public function start(){
        $this->padding = OPENSSL_PKCS1_PADDING;
//         $this->padding = OPENSSL_NO_PADDING;
//         $this->padding=null;
//         $this->private_key = $this->private_key_PKCS_8;
//         $this->public_key = $this->public_key_PKCS_8;
        
        $this->private_key = $this->private_key_PKCS_8_PASSWORD_123;
        $this->public_key = $this->public_key_PKCS_8_PASSWORD_123;
        
        var_dump($source = openssl_pkey_get_private($this->private_key_PKCS_8_PASSWORD_123,'abc'));
        
        echo '<pre>';
        print_r(openssl_pkey_get_details($source));
        echo '</pre>';
        exit;
        
        for ($i=0;$i<10;$i++){
            $this->data[] = uniqid(true);
        }
        
        foreach ($this->data as $v){
            $crypted='';
            $decrypted='';
            
            if (!openssl_private_encrypt($v, $crypted, $this->private_key ,$this->padding)){
                exit('数据加密失败'.$v);
            }else{
                if ( 172 != mb_strlen(base64_encode($crypted))){
                    exit($v.'加密后base64后，长度不是172位');
                }
//                 var_dump('crypted长度：'.mb_strlen($crypted));
//                 echo '<br />';
//                 var_dump('crypted长度：'.mb_strlen(base64_encode($crypted)));
//                 echo '<br />';
                if (!openssl_public_decrypt($crypted, $decrypted, $this->public_key ,$this->padding)){
                    exit('数据解密失败，加密数据为：'.$v);
                }else{
                    if ($decrypted !== $v){
                        exit('解密出的数据和原始数据不同。原始数据='.$v.'，解密后数据为：'.$decrypted);
                    }
                }
            }
        }
        
        
        echo '<br />over';
        
    }
    
    public function demo(){
        $config = array(
        //"config" =>"D:/phpserver/Lighttpd/openssl.cnf",
        //'config' =>'D:/phpStudy/Lighttpd/OpenSSL.cnf',
            'private_key_bits' => 1024,  // Size of Key.
            'private_key_type' => OPENSSL_KEYTYPE_RSA
        );
        //$res = openssl_pkey_new();
        $res = openssl_pkey_new($config);
        // Get private key
        // openssl_pkey_export($res, $privkey, "PassPhrase number 1" );
        openssl_pkey_export($res, $privkey);
        var_dump($privkey);
        // Get public key
        $pubkey=openssl_pkey_get_details($res);
        // echo "------------><br />";
        // print_r($pubkey["rsa"]);
        // $bin_str=$pubkey["rsa"]["n"];
        // print_r($bin_str);
        // echo "<br />";
        // //echo $bin_hex_str = pack("H*" , bin2hex($bin_str));
        // echo $bin_hex_str = bin2hex($bin_str);
        // echo "<br />------------<<br />";
        $pubkey=$pubkey["key"];
        // var_dump($privkey);
        // var_dump($pubkey);
        echo $privkey."<br /><br />";
        echo $pubkey."<br /><br />";
    }
    
    public function demo2(){
        $config = array(
//             "digest_alg" => "sha512",
            "private_key_bits" => 4096,
//             "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
         
        // Create the private and public key
        $res = openssl_pkey_new($config);
        var_dump($res);
        var_dump(openssl_error_string());
        
        // Extract the private key from $res to $privKey
        openssl_pkey_export($res, $privKey);
        
        // Extract the public key from $res to $pubKey
        $pubKey = openssl_pkey_get_details($res);
        $pubKey = $pubKey["key"];
        
        $data = 'plaintext data goes here';
        
        // Encrypt the data to $encrypted using the public key
        openssl_public_encrypt($data, $encrypted, $pubKey);
        
        // Decrypt the data using the private key and store the results in $decrypted
        openssl_private_decrypt($encrypted, $decrypted, $privKey);
        
        echo $decrypted;
    }
    
    public function exec(){
        header('content-type:text/html;charset=gbk');
        $command="c: && cd c:/go/bin && go.exe --help";
//         $command = "dir";
        $res = exec($command , $output,$return_var);
        
        var_dump($res);
        var_dump($output);
        var_dump($return_var);
        
    }
    
    
    
}

class myData implements arrayaccess  {
    public $property1 = "Public property one";
    protected  $property2 = "Public property two";
    private  $property3 = "Public property three";

    public function __construct() {
        $this->property4 = "last property";
    }

    public function getIterator() {
        return new ArrayIterator($this);
    }
    /**
     * {@inheritDoc}
     * @see ArrayAccess::offsetExists()
     */
    public function offsetExists($offset)
    {
        // TODO Auto-generated method stub
        
    }

    /**
     * {@inheritDoc}
     * @see ArrayAccess::offsetGet()
     */
    public function offsetGet($offset)
    {
        // TODO Auto-generated method stub
        
    }

    /**
     * {@inheritDoc}
     * @see ArrayAccess::offsetSet()
     */
    public function offsetSet($offset, $value)
    {
        // TODO Auto-generated method stub
        
    }

    /**
     * {@inheritDoc}
     * @see ArrayAccess::offsetUnset()
     */
    public function offsetUnset($offset)
    {
        // TODO Auto-generated method stub
        
    }

}

function dump($arr,$a2){
    echo '<pre>';
    var_dump($arr,$a2);
    echo '</pre>';
}
$obj = new myData;

// $s = new ArrayObject($_SERVER);

// foreach($s as $key => $value) {
//     dump($key, $value);
// }

foreach($obj as $key => $value) {
    dump($key, $value);
}

// $rsa = new RsaPrivateKeyEncryptionAndDecryption();
// $rsa->start();
// $rsa->demo2();
// $rsa->exec();
$deleteDirectory = null;
// $aa=null;
// $aa = function ($name){
//     echo 1;
// };

// $b = function($user) use ($aa){
//     $aa($user);
// };

// var_dump($aa);
// $b('buser');
// return ;

$deleteDirectory = function($path) use (&$deleteDirectory) {

   
    if (!is_dir($path)){
        return ;
    }
    $resource = opendir($path);
    while (($item = readdir($resource)) !== false) {
        if ($item !== "." && $item !== "..") {
            if (is_dir($path . "/" . $item)) {
                $deleteDirectory($path . "/" . $item);
            } else {
                unlink($path . "/" . $item);
            }
        }
    }
    closedir($resource);
    rmdir($path);
};
$deleteDirectory("c:\\a\\bin\\b");
