<?php
   include('config.php');


   $id = $_REQUEST['id'];
   $uid = $_SESSION['uid'];


    $query1 = "UPDATE task set task_status = 1 where tid='$id'";
    $result1 = mysqli_query($db,$query1) or die (mysqli_error());

    if($result1)
    {
      $sql = "INSERT INTO task_tracker (uid, tid, task_status)
         VALUES('$uid','$id','1')";
          mysqli_query($db, $sql);
          $res = "success";
    }
    else {

        $res = "error";
    }

    //echo $res;
    //$json_res = json_encode($res);
    //echo $json_res;



    //$res = "success";


    //passing the data for completed task section
    $sql = "SELECT task from task where task_status = '1' AND tid = '$id'";
    $result = mysqli_query($db, $sql) or die('error getting');
    $fetched = mysqli_fetch_assoc($result);
    $c_task['task'] = $fetched['task'];
    $c_task['tid']  = $id;
    $c_task['success'] = $res;

    //pasing tracking info for completed task section

    //getting value of date when it is added
    $query2 = "SELECT date_time from task_tracker WHERE tid = '$id' AND task_status = '2'";
    $result2 = mysqli_query($db, $query2) or die('error getting');
    $fetched2 = mysqli_fetch_assoc($result2);
    $c_task['add_date'] = $fetched2['date_time'];

    //getting value for date when it is completed
    $query3 = "SELECT date_time from task_tracker WHERE tid = '$id' AND task_status = '1'";
    $result3 = mysqli_query($db, $query3) or die('error getting');
    $fetched3 = mysqli_fetch_assoc($result3);
    $c_task['com_date'] = $fetched3['date_time'];

    //encoding c-task because it is array type
    $json_c_task = json_encode($c_task);
    echo $json_c_task;

?>
