<?php

require_once 'bot-api-config.php';
require_once 'bot-api-fungsi.php';
require_once 'kucing.php';

function myloop()
{
    global $debug;

    $idfile = 'botprosesid.text';
    $update_id = 0;

    if (file_exists($idfile)){
        $update_id = (int) file_get_contents($idfile);
        echo'-';
    }
    $updates = getApiUpdate($update_id);

    foreach ($updates as $message){
        $update_id = prosesApiMessage($message);
        echo'+';
    }
    file_put_contents($idfile, $update_id + 1);
}
while(true){
    myloop();
}