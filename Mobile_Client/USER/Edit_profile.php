<?php

include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['token']) && !empty($_POST['token'])){

        $send_token = $functions->real_escape($_POST['token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  users where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            if (isset($_POST['nAme']) &&
                !empty($_POST['nAme']) &&
                isset($_POST['adDress']) &&
                !empty($_POST['adDress']) &&
                isset($_POST['Tell']) &&
                !empty($_POST['Tell']) &&
                isset($_POST['Lat']) &&
                !empty($_POST['Lat']) &&
                isset($_POST['Lng']) &&
                !empty($_POST['Lng']) &&
                isset($_POST['Email']) &&
                !empty($_POST['Email']) &&
                isset($_POST['PostalCode']) &&
                !empty($_POST['PostalCode'])){

                $name = $functions->real_escape($_POST['nAme']);
                $address = $functions->real_escape($_POST['adDress']);
                $tell = $functions->real_escape($_POST['Tell']);
                $lat = $functions->real_escape($_POST['Lat']);
                $lng = $functions->real_escape($_POST['Lng']);
                $Email = $functions->real_escape($_POST['Email']);
                $PostalCode = $functions->real_escape($_POST['PostalCode']);

                $select_user_id = mysqli_query($functions->connection(),
                    "SELECT id FROM users where token = '$send_token'");
                $user_id0 = mysqli_fetch_assoc($select_user_id);
                $user_id = implode(":",$user_id0);


                $update_user = mysqli_query($functions->connection(),
                    "UPDATE users SET name = '$name' , address = '$address' , tell = '$tell' , Lat = '$lat', Lng = '$lng' ,email = '$Email' , postal_code = '$PostalCode' where id = '$user_id'");
                if ($update_user){
                    echo json_encode(array("Erorr"=>false,"MSG"=>"مشخصات شما با موفقیت اصلاح شد !"));
                    mysqli_close($functions->connection());
                    return;
                }else{
                    echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                    mysqli_close($functions->connection());
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