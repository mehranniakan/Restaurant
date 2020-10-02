<?php

include '../../tools.php';
$function = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['Full/Name']) &&
        !empty($_POST['Full/Name']) &&
        isset($_POST['User/Name']) &&
        !empty($_POST['User/Name']) &&
        isset($_POST['Pass/Word']) &&
        !empty($_POST['Pass/Word'])){

        $user_name = $function->real_escape($_POST['User/Name']);

        $check_username = mysqli_query($function->connection(),
            "SELECT * FROM Admins where username = '$user_name'");

        if (mysqli_num_rows($check_username)>=1){

            echo json_encode(array("Erorr"=>true,"MSG"=>"ادمینی با این نام کاربری وجود دارد لظفا نام کاربری دیگری انتخاب کنید"));
            mysqli_close($function->connection());
            return;

        }else{

            $id = $function->id_gen();
            $full_name = $function->real_escape($_POST['Full/Name']);
            $pass_word = $function->hashing($_POST['Pass/Word']);
            $reg_date = $function->date_gen();
            $reg_time = $function->time_gen();

            $insert_admin = mysqli_query($function->connection(),
                "INSERT INTO Admins (id, name, username, password, token, reg_date, reg_time) VALUES ('$id','$full_name','$user_name','$pass_word','-','$reg_date','$reg_time')");
            if ($insert_admin){
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