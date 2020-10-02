<?php

include '../../tools.php';
$function = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['Full_Name']) &&
        !empty($_POST['Full_Name']) &&
        isset($_POST['User_Name']) &&
        !empty($_POST['User_Name']) &&
        isset($_POST['Pass_Word']) &&
        !empty($_POST['Pass_Word']) &&
        isset($_POST['Address']) &&
        !empty($_POST['Address']) &&
        isset($_POST['Tell']) &&
        !empty($_POST['Tell']) &&
        isset($_POST['Email']) &&
        !empty($_POST['Email']) &&
        isset($_POST['Lat']) &&
        !empty($_POST['Lat']) &&
        isset($_POST['Lng']) &&
        !empty($_POST['Lng']) &&
        isset($_POST['Postal_Code']) &&
        !empty($_POST['Postal_Code'])){
        
        $user_name = $function->real_escape($_POST['User_Name']);
        
        $check_username = mysqli_query($function->connection(),
            "SELECT * FROM users where username = '$user_name'");

        if (mysqli_num_rows($check_username)>=1){
            echo json_encode(array("Erorr"=>true,"MSG"=>"کاربری با این نام کاربری وجود دارد لظفا نام کاربری دیگری انتخاب کنید"));
            mysqli_close($function->connection());
            return;
        }else{

            $id = $function->id_gen();
            $full_name = $function->real_escape($_POST['Full_Name']);
            $pass_word = $function->hashing($_POST['Pass_Word']);
            $address = $function->real_escape($_POST['Address']);
            $tell = $function->real_escape($_POST['Tell']);
            $email = $function->real_escape($_POST['Email']);
            $postal_code = $function->real_escape($_POST['Postal_Code']);
            $lat = $function->real_escape($_POST['Lat']);
            $lng = $function->real_escape($_POST['Lng']);
            $reg_date = $function->date_gen();
            $reg_time = $function->time_gen();

            $insert_user = mysqli_query($function->connection(),
                "INSERT INTO users (id, name, username, password, address, tell,email, postal_code, Lat, Lng,pic, token, reg_date, reg_time) VALUES ('$id','$full_name','$user_name','$pass_word','$address','$tell','$email','$postal_code','$lat','$lng','-','-','$reg_date','$reg_time')");

            if ($insert_user){
                echo json_encode(array("Erorr"=>false,"MSG"=>"ثبت نام شما با موفقیت انجام شد"));
                mysqli_close($function->connection());
                return;
            }else{
                echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                mysqli_close($function->connection());
                return;
            }
        }
    }else{
        
    }
}else{

}