<?php

include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    if (isset($_POST['Token']) && !empty($_POST['Token'])){

        $send_token = $functions->real_escape($_POST['Token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  Admins where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            if(isset($_POST['OFFset'])){

                $offset = $functions->real_escape($_POST['OFFset']);
                $select_users = mysqli_query($functions->connection(),
                    "SELECT * FROM users LIMIT 20 offset $offset");

                $user_num = mysqli_num_rows($select_users);

                while ($result = mysqli_fetch_assoc($select_users)){
                    $user_id = $result['id'];
                    $name = $result['name'];
                    $user_name = $result['username'];
                    $tell = $result['tell'];
                    $address = $result['address'];
                    $email = $result['email'];
                    $post_code = $result['postal_code'];
                    $pic = $result['pic'];
                    $lat = $result['Lat'];
                    $lng = $result['Lng'];

                    $arr[] = array(
                        'id'=>$user_id,
                        'full_name'=>$name,
                        'user_name'=>$user_name,
                        'tell'=>$tell,
                        'address'=>$address,
                        'email'=>$email,
                        'postal_code'=>$post_code,
                        'pic'=>$pic,
                        'lat'=>$lat,
                        'lng'=>$lng
                    );
                }

                if (!empty($arr) && isset($arr)) {
                    $data = array("Erorr" => false, "result" => $arr, "tottal_users"=>$user_num);
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
}else{

}