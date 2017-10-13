<?php
if (isset($_POST)){
    echo 'post<br />';
    var_export($_POST);
}else {
    echo 'get';
}

// 