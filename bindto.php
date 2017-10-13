<?php
$arr = [];
$arr['socket-bindto'] = function(){
// connect to the internet using the '192.168.0.100' IP
$opts = array(
    'socket' => array(
        'bindto' => '192.168.0.100:0',
    ),
);


// connect to the internet using the '192.168.0.100' IP and port '7000'
$opts = array(
    'socket' => array(
        'bindto' => '192.168.0.100:7000',
    ),
);


// connect to the internet using port '7000'
$opts = array(
    'socket' => array(
        'bindto' => '0:7000',
    ),
);


// create the context...
$context = stream_context_create($opts);

// ...and use it to fetch the data
echo file_get_contents('http://localhost/t/post.php', false, $context);
};

$arr['file_get_content-options'] = function(){
    $postdata = http_build_query(
       
            array(
                'var1' => 'some content',
                'var2' => 'doh'
            )
    );
    
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );
    
    $context = stream_context_create($opts);
    
    
    
    $result = file_get_contents('http://localhost/t/post.php', false, $context);
    
    echo $result;
};
$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
//         'content' => $postdata
    )
);
var_dump(stream_context_set_default($opts));

foreach ($arr as $k=>$v){
    echo '<pre>';
    $arr[$k]();
    echo '</pre>';
    echo '<hr />';
}



