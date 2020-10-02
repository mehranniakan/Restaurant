<?php

class tools
{

    /**
     * tools constructor.
     */
    public function __construct()
    {
        date_default_timezone_set("Asia/Tehran");
    }

    public function connection(){

    $link = mysqli_connect("localhost",
        "test_user",
        "Ab3a0oI23atjPfOY",
        "Resturant");
    mysqli_set_charset($link,"utf8");
    return $link;
}

public function real_escape($data){
    $real = mysqli_real_escape_string($this->connection(),$data);
    return $real;
}
public function hashing($data){
    $ha = hash("SHA256",$data);
    $ha = hash("SHA512",$ha);
    return $ha;
}

public function date_gen(){
    return date("Y/m/d");
}

public function time_gen(){
    return date("H:i:s");
}

public function email_valid($data){
    if (filter_var($data, FILTER_VALIDATE_EMAIL)) {
        return true;
    }else{
        return false;
    }
}

public function id_gen(){
        return $id = date("YmdHis").rand(1000,9999);
}

public function savecover($base64img,$url,$name){
        $base64img = str_replace('data:image/jpeg;base64,', '', $base64img);
        $data = base64_decode($base64img);
        $file = $url.$name.'.jpg';
        file_put_contents($file, $data);
        return  $name;
}

public function random_char($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

public function check_holiday($date){
        if ($date=="12/01/1399"||
            $date=="13/01/1399" ||
            $date=="21/01/1399" ||
            $date=="04/03/1399" ||
            $date=="05/03/1399" ||
            $date=="14/03/1399" ||
            $date=="15/03/1399" ||
            $date=="18/05/1399" ||
            $date=="08/06/1399" ||
            $date=="09/06/1399" ||
            $date=="26/07/1399" ||
            $date=="17/07/1399" ||
            $date=="04/08/1399" ||
            $date=="13/08/1399" ||
            $date=="28/10/1399" ||
            $date=="22/11/1399" ||
            $date=="07/12/1399" ||
            $date=="21/12/1399"
        ){
            return true;
        }else{
            return false;
        }
    }

    public function upload_img_multipart ($Image_File,$directory,$file_name){

        $target_dir = $directory;

//        $file_name = basename($Image_File["name"]);
        $target_file = $target_dir . basename($file_name);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $upload_img = move_uploaded_file($Image_File["tmp_name"], $target_file);

        if ($upload_img){
            return true;
        }else{
            return false;
        }
    }

    public function make_transaction($amount,$order_id,$user_name,$tell){

        $params = array(
            'order_id' => $order_id,
            'amount' => $amount,
            'name' => $user_name,
            'phone' => $tell,
//    'mail' => 'my@site.com',
//        'desc' => 'توضیحات پرداخت کننده',
            'callback' => 'http://rashphotography.com/rash_photographi/done_payment.php',
            'reseller' => null,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.idpay.ir/v1.1/payment');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-API-KEY: 442ab4c3-2381-4a7d-942a-f4284a1f099d',
            'X-SANDBOX: 0'
        ));

        $result = curl_exec($ch);
        curl_close($ch);

        $ans = json_decode($result,true);
        return $ans;

    }

}