<?php
include 'koneksi.php';

function prosesApiMessage($sumber)
{
    $updateid = $sumber['update_id'];
    // if ($GLOBALS['debug']) mypre($sumber);

    if (isset($sumber['message'])) {
        $message = $sumber['message'];

        if (isset($message['text'])){
            prosesPesanTeks($message);
        }elseif (isset($message['stiker'])){
            prosesPesanStiker($message);
        }else{
            // tidak diproses silhkan dikembangkan sendiri
        }
    }
    if(isset($sumber['callback_query'])){
        prosesCallBackQuery($sumber['callback_query']);
    }
    return $updateid;
}
function prosesPesanStiker($message)
{
    //if ($GLOBALS['debug']) mypre($message);
}
function prosesCallBackQuery($message)
{
    //if ($GLOBALS['debug']) mypre($message);

    $message_id = $message['message']['message_id'];
    $chatid = $message['message']['chat']['id'];
    $data = $message['data'];

    $inkeyboard = [
        [
            ['text' => 'update 1', 'callback_data' => 'data update 1'],
            ['text' => 'update 2', 'callback_data' => 'data update 2'],
        ],
        [
            ['text' => 'keyboard on', 'callback_data' => '!keyboard'],
            ['text' => 'keyboard inline', 'callback_data' => '!inline'],
        ],
        [
            ['text' => 'keyboard off', 'callback_data' => '!hide'],
        ],
    ];
    $text = '*'.date('H:i:s').'* data baru : '.$data;

    editMessageText($chatid, $message_id, $text, $inkeyboard, true);
    $messageupdate = $message['message'];
    $messageupdate['text'] = $data;

    prosesPesanTeks($messageupdate);
}
function  prosesPesanTeks($message)
{
    //if ($GLOBALS['debug']) mypre($message);

    $pesan = $message['text'];
    $chatid = $message['chat']['id'];
    $fromid = $message['from']['id'];

    switch (true){
        case $pesan == '/id':
            sendApiAction($chatid);
            $text = 'ID Kamu adalah: '.$fromid;
            sendApiMsg($chatid, $text);
            break;
        case $pesan == '!keyboard':
            sendApiAction($chatid);
            $keyboard = [
                ['tombol 1', 'tombol 2'],
                ['!keyboard', '!inline1'],
                ['!hide'],
            ];
            sendApiKeyboard($chatid, 'tombol pilihan', $keyboard);
            break;
        case $pesan == '!inline1':
            sendApiAction($chatid);
            $inkeyboard = [
                [
                    ['text' => 'update 1', 'callback_data' => 'data update 1'],
                    ['text' => 'update 2', 'callback_data' => 'data update 2'],
                ],
                [
                    ['text' => 'keyboard on', 'callback_data' => '!keyboard'],
                    ['text' => 'keyboard inline', 'callback_data' => '!inline'],
                ],
                [
                    ['text' => 'keyboard off', 'callback_data' => '!hide'],
                ],
            ];
            sendApiKeyboard($chatid, 'Tampilan Inline', $inkeyboard, true);
            break;

            case $pesan == '!hide':
                sendApiAction($chatid);
                sendApiHideKeybord($chatid, 'keyboard off');
                break;
                
            case preg_match("/\/eccho (.*)", $pesan, $hasil);
                sendApiAction($chatid);

                $text = '*Echo:* '.$hasil[1];
                sendApiMsg($chatid, $text, false, 'Markdown');
                break;
            
            default:
            sendApiAction($chatid);
            $text ='Echo: '.$pesan;
            sendApiMsg($chatid, $text, false, 'Markdown');
            break;
    }

}