<?php

use function PHPSTORM_META\map;

include 'koneksi.php';
$TOKEN = "2121377550:AAHXoQ86L-nNSXCDBXh33IgwfUva4U9QUus";
$usernamebot="@drkucingbot";//sesuaikan besar kecilnya, bermanfaat jika bot dimasukkan grub.
//aktifkan ini jika perlu debuging
$debug = false;

function prosesApiMessage($sumber)
{
    $updateid = $sumber['update_id'];

    //if ($GLOBALS['debug']) mypre($sumber)
    
    if (isset($sumber['message'])){
        $message = $sumber['message'];

        if (isset($message['text'])){
            prosesPesanTeks($message);
        }elseif (isset($message['stiker'])){
            prosesPesanStiker($message);
        }else {
            // tidak di proses silahkan dikembangkan
        }
    }
    if(isset($sumber['callback_query'])){
        prosesCallBackQuery($sumber['callback_query']);
    }
    return $updateid;
}

function prosesCallBackQuery($message)
{
    $message_id = $message['message']['message_id'];
    $chatid = $message ['message']['chat']['id'];
    $data = $message['data'];

    $messageupdate = $message['message'];
    $messageupdate['text'] = $data;

    prosesPesanTeks($messageupdate);
}
// fungsi mengolah  pesan, menyiapkan pesan unruk dikirimkan 
function prosesPesanTeks($message)
{
    include 'koneksi.php';
    global $usernamebot;
    // inisialisasi variabel hasil yang mna merupakan hasil olahan pesan

    $fromid = $message["from"]["id"];//variable penampung id user
    $chatid = $message["chat"]["id"];//variable penampung id chat
    $pesanid = $message["message_id"];//variable penampung id message
    $pesan = strtolower($message["text"]);//variable penampung text user

    //variable penampung usernamae user
    isset($message["from"]["username"])
        ?$chatuser = $message["from"]["username"]
        :$chatuser = '';
    
    isset($message["from"]["last_name"])
        ?$namakedua = $message["from"]["last_name"]
        :$namakedua = '';
    $namauser = $message["from"]["first_name"]. ' ' .$namakedua;
    
    $pecah = explode('',$pesan, 2);
    $katapertama = strtolower($pecah[0]);

    switch ($katapertama) {
        case '/id':
            sendApiAction($chatid);
            $hasil = "$namauser, ID kamu adalah $fromid";
            sendApiMsg($chatid, $hasil);
            break;

        case '/start':
            sendApiAction($chatid);
            $hasil = "Hi $namauser, saya adalah dr.kucing.. \nSalam Kenal.. \n Apakah Anda ingin bertanya? (jawaban 'ok' atau 'cancel')";
            sendApiMsg($chatid, $hasil);
            break;
        case 'ok':
            awal :
            sendApiAction($chatid);
            $hasil = "$namauser, Silahkan menuliskan gejala kucing anda dengan cara: \n1. mulailah dengan mengetikan perintah 'kucingku' (tanpa petik) \n2. Pisahkan setiap keluhan dengan tanda koma dengan spasi setelah koma, seperti contoh berikut. Contoh: kucingku muntah, demam, diare";
            sendApiMsg($chatid, $hasil);
            break;
        case 'cancel':
            sendApiAction($chatid);
            $hasil = "$namauser, sampai jumpa. Terima kasih telah berkonsultasi pada dr.kucing. Semoga anabulnya lekas sembuh";
            sendApiMsg($chatid, $hasil);
            break;
        case 'keluhanku':
            sendApiAction($chatid);
            $keluhanku = $pecah[1];
            $pisah = explode(', ', $keluhanku);
            $gejala = '';
            //Array data gejala
            $datagejala = array('dehidrasi','diare','badan kurus','tidak mau makan','Pembengkakan mata','luka/radang pada kornea','muntah warna putih','muntah cacing','gusi pucat','mata berair','Kotoran bau busuk','lesu','demam','bau mulut busuk','bersin-bersin','perut membesar','tulang punggung belakang teraba','bulu kusam','keluar liur bening sampai kuning kehijauan dari hidung terus-menerus','belekan pada mata','keluar liur berlebihan','sariawan di lidah','diare kadang berlendir','bulu berdiri dan kasar','luka-luka pada mulut, hidung, telinga','pembengkakan di bawah perut','sesak napas','batuk-batuk');

            $sql = "DELETE FROM `jawaban_user` WHERE `jawaban_user`.`id_pasien` = $fromid";
            $query = mysqli_query($conn,$sql);
            $sql = "DELETE FROM `hasil_diagnosa` WHERE `hasi_diagnosa.`id_pasien` = $fromid";
            $query = mysqli_query($conn,$sql);
            $sql = "INSERT INTO jawaban_user (`id`, `id_pasien`, `0`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`,  `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`,  `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`) VALUES (NULL, `id_pasien`, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, )";
            $query = mysqli_query($conn,$sql);
            $sql = "INSERT INTO hasil_diagnosa (`id`, `id_pasien`, `0`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`,  `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`,  `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`) VALUES (NULL, `id_pasien`, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, ``, )";
            $query = mysqli_query($conn,$sql);
        //bagian ini untuk membandingkan gejala inputan pasiien dengan database
        for($i=0; $i<count($pisah); $i++){
            for($j=0; $j<count($datagejala);$j++){
                if(stripos($datagejala[$j], $pisah[$i]) !== false)
                {
                    $sql = "UPDATE `jawaban_user` SET `$j` = `1` WHERE `jawaban_user`.`id_pasien`=$fromid";
                    $query = mysqli_query($conn,$sql);
                    if($j<(count($datagejala)-1)){
                        $gejala .= $datagejala[$j].`,`;
                    }else{
                        $gejala .= $datagejala[$j].'.';
                    }
                }
            }
        }
        if($gejala !== ''){
            $hasil = "Keluhan anda saya terima. \nJadi, gejala yang kucing alami dan terdeteksi sebagai gejala penyakit kucing ialah $gejala";
            sendApiMsg($chatid, $hasil);
        }else{
            $hasil = "Keluhan anda saya terima. \nJadi, saya tidak menemukan gejala penyakit pada kucing Anda";
            sendApiMsg($chatid, $hasil);
        }

        //bagian ini untuk mulai menghitung bobot
        for($i=1; $i<=7; $i++){
            $sql="UPDATE `hasil_diagnosa`SET `$i` = (SELECT(
            (SELECT `jawaban_user`.`0` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`0` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`1` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`1` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`2` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`2` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`3` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`3` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`4` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`4` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`5` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`5` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`6` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`6` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`7` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`7` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`8` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`8` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`9` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`9` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`10` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`10` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`11` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`11` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`12` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`12` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`13` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`13` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`14` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`14` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`15` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`15` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`16` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`16` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`17` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`17` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`18` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`18` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`19` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`19` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`20` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`20` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`21` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`21` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`22` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`22` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`23` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`23` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`24` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`24` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`25` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`25` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`26` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`26` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`27` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`27` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i))/
            ((SELECT `jawaban_user`.`0` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`0` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`1` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`1` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`2` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`2` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`3` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`3` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`4` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`4` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`5` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`5` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`6` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`6` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`7` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`7` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`8` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`8` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`9` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`9` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`10` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`10` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`11` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`11` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`12` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`12` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`13` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`13` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`14` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`14` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`15` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`15` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`16` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`16` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`17` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`17` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`18` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`18` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`19` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`19` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`20` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`20` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`21` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`21` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`22` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`22` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`23` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`23` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`24` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`24` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`25` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`25` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`26` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`26` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i)+
            (SELECT `jawaban_user`.`27` FROM `jawaban_user`)*(SELECT `penyakit_kucing`.`27` FROM `penyakit_kucing` WHERE `penyakit_kucing`.`id`=$i))) WHERE `hasil_diagnosa`.`id_pasien`=$fromid";
            $query = mysqli_query($conn,$sql);
        }
        //menampilkan hasil diagnosa
        $sql="SELECT * FROM `hasil_diagnosa` WHERE `hasil_diagnosa`.`id_pasien`=$fromid";
        $show = mysqli_query($conn,$sql);
        $row= mysqli_fetch_array($show);
        $p1= round($row[1]*100);
        $p2= round($row[2]*100);
        $p3= round($row[3]*100);
        $p4= round($row[4]*100);
        $p5= round($row[5]*100);
        $text = "Berikut ini adalah persentase kemungkinan penyakit:"."\np1 =  ".$p1."%\np2 = ".$p2."%\np3 = ".$p3."%\np4 = ".$p4."%\np5 = ".$p5."%";
        sendApiMsg($chatid, $text, false, 'Markdown');

        //menampilkan penyakit
        GLOBAL $angka;
        $hasilAngka = 0;
        $sql = "SELECT * FROM 'penyakit_kucing'";
        $result = mysqli_query($conn, $sql);
        $jumlahbaris = mysqli_num_rows($result);
        $row = mysqli_fetch_array($result);

        //mencari angka besar
        for($i=1;$i<=$jumlahbaris;$i++){
            $sql = "SELECT * FROM hasil_diagnosa";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_array($result);
            if($hasilAngka < $row[0]){
                $hasilAngka =$row[0];
            }
        }
        //mencari nama field dari angka terbesar
        for($i=1;$i<=$jumlahbaris;$i++){
            $sql = "SELECT * FROM hasil_diagnosa WHERE '$i' = $hasilAngka";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_array($result);
            if($row != NULL and $row !=0){
                $angka = $i+1;
                break;
            }
        }
        $colObj = mysqli_fetch_field_direct($result,$angka);
        $col = $colObj->name;
        $sql = "SELECT nama_penykit,solusi FROM penyakit_kucing where 'id'=$col";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        if ($hasilAngka !=0){

            $text = 'Menurut diagnosa dr.kucing, kucing anda terkena penyakit '.$row[0]. "\nSolusi yang saya tawarkan ialah".$row[1]."\n\nAnda puas dengan hasil pemeriksaan dan solusi saya? (Jika puas, ketikan 'ya'. Jika belum, Anda dapat melihat solusi lain dengan mengetikkan beberapa pilihan solusi dibawah ini: \n/p1: untuk solusi penyakit p1\n/p2: untuk solusi penyakit p2\n/p3: untuk solusi penyakit p3\n/p4: untuk solusi penyakit p4\n/p5: untuk solusi penyakit p5)";
        }
        else {
            $text = "Selamat, Kucing tidak terkena penyakit Pencernaan . \n Anda puas dengan hasil pemeriksaan dan solusi saya? (Jika puas, ketikan 'ya'. Jika belum, ketikan 'tidak')";
        }
        sendApiMsg($chatid, $text, false, 'Markdown');
        break;

        case 'ya':
            sendApiAction($chatid);
            $hasil = "$namauser, sampai jumpa. Terima kasih telah berkonsultasi pada dr.kucing. Semoga cepat sembuh dan jaga kesehatan Anda.";
            sendApiMsg($chatid, $hasil);
        break;
        case 'tidak':
            goto awal;
        break;      
        case '/p1':
            sendApiAction($chatid);
            $sql = "SELECT solusi FROM penyakit_kucing where 'penyakit_kucing'.'nama_penyakit'='p1'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $text = $row[0]."\nJika Anda sudah puas dengan solusi ini, ketikan 'ya'. Jika belum, Anda dapat melihat solusi lain dengan mengetikan beberapa pilihan solusi di bawah ini: \n/p1: untuk solusi penyakit p1\n/p2: untuk solusi penyakit p2\n/p3: untuk solusi penyakit p3\n/p4: untuk solusi penyakit p4\n/p5: untuk solusi penyakit p5)";
            sendApiMsg($chatid, $text, false, 'Markdown');
        break;

        case '/p1':
            sendApiAction($chatid);
            $sql = "SELECT solusi FROM penyakit_kucing where 'penyakit_kucing'.'nama_penyakit'='p1'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $text = $row[0]."\nJika Anda sudah puas dengan solusi ini, ketikan 'ya'. Jika belum, Anda dapat melihat solusi lain dengan mengetikan beberapa pilihan solusi di bawah ini: \n/p1: untuk solusi penyakit p1\n/p2: untuk solusi penyakit p2\n/p3: untuk solusi penyakit p3\n/p4: untuk solusi penyakit p4\n/p5: untuk solusi penyakit p5)";
            sendApiMsg($chatid, $text, false, 'Markdown');
        break;

        case '/p2':
            sendApiAction($chatid);
            $sql = "SELECT solusi FROM penyakit_kucing where 'penyakit_kucing'.'nama_penyakit'='p2'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $text = $row[0]."\nJika Anda sudah puas dengan solusi ini, ketikan 'ya'. Jika belum, Anda dapat melihat solusi lain dengan mengetikan beberapa pilihan solusi di bawah ini: \n/p1: untuk solusi penyakit p1\n/p2: untuk solusi penyakit p2\n/p3: untuk solusi penyakit p3\n/p4: untuk solusi penyakit p4\n/p5: untuk solusi penyakit p5)";
            sendApiMsg($chatid, $text, false, 'Markdown');
        break;

        case '/p3':
            sendApiAction($chatid);
            $sql = "SELECT solusi FROM penyakit_kucing where 'penyakit_kucing'.'nama_penyakit'='p3'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $text = $row[0]."\nJika Anda sudah puas dengan solusi ini, ketikan 'ya'. Jika belum, Anda dapat melihat solusi lain dengan mengetikan beberapa pilihan solusi di bawah ini: \n/p1: untuk solusi penyakit p1\n/p2: untuk solusi penyakit p2\n/p3: untuk solusi penyakit p3\n/p4: untuk solusi penyakit p4\n/p5: untuk solusi penyakit p5)";
            sendApiMsg($chatid, $text, false, 'Markdown');
        break;

        case '/p4':
            sendApiAction($chatid);
            $sql = "SELECT solusi FROM penyakit_kucing where 'penyakit_kucing'.'nama_penyakit'='p4'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $text = $row[0]."\nJika Anda sudah puas dengan solusi ini, ketikan 'ya'. Jika belum, Anda dapat melihat solusi lain dengan mengetikan beberapa pilihan solusi di bawah ini: \n/p1: untuk solusi penyakit p1\n/p2: untuk solusi penyakit p2\n/p3: untuk solusi penyakit p3\n/p4: untuk solusi penyakit p4\n/p5: untuk solusi penyakit p5)";
            sendApiMsg($chatid, $text, false, 'Markdown');
        break;

        case '/p5':
            sendApiAction($chatid);
            $sql = "SELECT solusi FROM penyakit_kucing where 'penyakit_kucing'.'nama_penyakit'='p5'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $text = $row[0]."\nJika Anda sudah puas dengan solusi ini, ketikan 'ya'. Jika belum, Anda dapat melihat solusi lain dengan mengetikan beberapa pilihan solusi di bawah ini: \n/p1: untuk solusi penyakit p1\n/p2: untuk solusi penyakit p2\n/p3: untuk solusi penyakit p3\n/p4: untuk solusi penyakit p4\n/p5: untuk solusi penyakit p5)";
            sendApiMsg($chatid, $text, false, 'Markdown');
        break;

        case preg_match("/\/echo (.*)/", $pesan, $hasil):
            sendApiAction($chatid);
            $text = 'Saya tidak paham maksud Anda, silahkan menjawab dengan format yang benar';
            sendApiMsg($chatid, $text, false, 'Markdown');
        break;

        default :
            sendApiAction($chatid);
            $text = 'Saya tidak mengerti perkataan Anda. Namun saya tetap berusaha mendengarkan Anda';
            sendApiMsg($chatid, $text, false, 'MArkdown');
        break;
    }
}

if (strlen($TOKEN)<20)
    die("Token mohon diisi dengan benar!\n");