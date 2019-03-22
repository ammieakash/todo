
<?php
    include('config.php');
    $id = $_REQUEST['id'];
    $uid = $_SESSION['uid'];
    $query = "update task set task_status = 0 where tid=$id";
    $result = mysqli_query($db,$query) or die (mysqli_error());

    //filling db tracking
    if($result)
    {
    $sql = "INSERT INTO task_tracker (uid, tid, task_status) VALUES('$uid','$id','0')";
    mysqli_query($db, $sql);
    $res = "success";
    }
    else {

      $res = "error";
    }


    $res_json = json_encode($res);
    echo $res_json;

?>
