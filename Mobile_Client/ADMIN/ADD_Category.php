<?php

include '../../tools.php';
$functions = new tools();
$target_dir = "../../Images/";
if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['Token']) && !empty($_POST['Token'])){

        $send_token = $functions->real_escape($_POST['Token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  Admins where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            if (isset($_POST["Cat-Name"]) &&
                !empty($_POST["Cat-Name"]) &&
                isset($_FILES['Image_Up']) &&
                !empty($_FILES['Image_Up'])){


                $cat_id = $functions->id_gen();
                $cat_name = $functions->real_escape($_POST["Cat-Name"]);
                $pic_name = $functions->random_char(18);
                $reg_date = $functions->date_gen();
                $reg_time = $functions->time_gen();
                $upload_img = $functions->upload_img_multipart($_FILES['Image_Up'],'../../Images/',$pic_name);


                if ($upload_img){

                    $insert_cat = mysqli_query($functions->connection(),
                        "INSERT INTO food_category (id, name, pic, reg_date, reg_time) VALUES ('$cat_id','$cat_name','$pic_name','$reg_date','$reg_time')");

                    if ($insert_cat){
                        echo json_encode(array("Erorr"=>false,"MSG"=>"دسته بندی مورد نظر با موفقیت ثبت شد !"));
                        mysqli_close($function->connection());
                        return;
                    }else{
                        echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
                        mysqli_close($function->connection());
                        return;
                    }
                }else{
                    echo json_encode(array("Erorr"=>true,"MSG"=>"مشکلی پیش آمده لطفا مجددا تلاش کنید !"));
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