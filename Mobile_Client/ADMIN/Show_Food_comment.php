<?php
include '../../tools.php';
$functions = new tools();

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['Token']) && !empty($_POST['Token'])){

        $send_token = $functions->real_escape($_POST['Token']);

        $select_token = mysqli_query($functions->connection(),
            "SELECT * FROM  Admins where token = '$send_token'");

        if (mysqli_num_rows($select_token)==1){

            if (isset($_POST['Food_id']) &&
                !empty($_POST['Food_id']) &&
                isset($_POST['OFFset'])){

                $food_id = $functions->real_escape($_POST['Food_id']);
                $offset = $functions->real_escape($_POST['OFFset']);

                $select_cms = mysqli_query($functions->connection(),
                    "SELECT * FROM comment_food where food_id = '$food_id' LIMIT 20 OFFSET $offset");


                while ($result = mysqli_fetch_assoc($select_cms)){

                    $cm_id = $result['id'];
                    $cm_txt = $result['txt'];
                    $user_id = $result['user_id'];
                    $replys = array();
                    $user_detail = mysqli_query($functions->connection(),
                        "SELECT username FROM users where id = '$user_id'");

                    $username = mysqli_fetch_assoc($user_detail);
                    $username1 = implode(":",$username);

                    $select_reply = mysqli_query($functions->connection(),
                        "SELECT * FROM Reply_comment where Comment_id = '$cm_id' AND food_id = '$food_id' AND user_id = $user_id");
                    
                    $replys= [];
                    while ($result2 = mysqli_fetch_assoc($select_reply)){
                       $reply_text = $result2['reply_txt'];
                       $reply_id = $result2['id'];
                       $Comment_id = $result2['Comment_id'];


                       array_push($replys,array('id'=>$reply_id, 'reply_txt'=>$reply_text, 'comment_to_reply_id'=>$Comment_id,));
                    }
                    $arr[] = array(
                        'comment_id'=>$cm_id,
                        'comment_text'=>$cm_txt,
                        'username'=>$username1,
                        'user_id'=>$user_id,
                        'Replys'=>$replys
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
            }
        }else{

        }
    }else{

    }
}else{

}