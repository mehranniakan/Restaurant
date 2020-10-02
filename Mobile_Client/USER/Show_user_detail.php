<?php
include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['token']) && !empty($_POST['token'])){

        $send_token = $functions->real_escape($_POST['token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  users where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            $select_user_detail = mysqli_query($functions->connection(),
                "SELECT * FROM users where token = '$send_token'");

            while ($result = mysqli_fetch_assoc($select_user_detail)){
                $full_name = $result['name'];
                $user_name = $result['username'];
                $address = $result['address'];
                $tell = $result['tell'];
                $lat = $result['Lat'];
                $lng = $result['Lng'];
                $email = $result['email'];
                $postal_code = $result['postal_code'];
                $pic = $result['pic'];

                $arr[] = array(
                    'FullName'=>$full_name,
                    'UserName'=>$user_name,
                    'Address'=>$address,
                    'Tell'=>$tell,
                    'Lat'=>$lat,
                    'Lng'=>$lng,
                    'Email'=>$email,
                    'PostalCode'=>$postal_code,
                    'Pic'=>$pic,
                );
            }
            if (!empty($arr) && isset($arr)) {
                $data = array("Erorr" => false, "result" => $arr);
                echo json_encode($data);
                mysqli_close($function->connection());
                return;
            } else {
                $data = array("Erorr" => true, "result" => "موردی برای نمایش یافت نشد");
                echo json_encode($data);
                mysqli_close($function->connection());
                return;
            }
        }else{

        }
    }else{
        echo json_encode(array("Erorr"=>true,"MSG"=>"لطفا مجددا وارد شوید !","Login"=>false));
        mysqli_close($functions->connection());
        return;
    }
}else{

}