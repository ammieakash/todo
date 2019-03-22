<?php


include('config.php');



          $id     = $_REQUEST['user'];
          $task   = $_REQUEST['task'];


          $query1   = "SELECT task,tid from task where uid = '$id' AND task_status ='2' ORDER BY tid ";
          $result1  = mysqli_query($db, $query1);

          //fetching data from db in numeric indexing format
          while($row  = mysqli_fetch_row($result1))
          {
               //var_dump($row);
               $match.= $row[0];
          }
          //checking weather task is already present or not
          if( strpos( $match, $task ) !== false)
          {
                echo "exist";
                die();
          }
          else
          {


            $query2 = "INSERT INTO task (task, uid, task_status)
               VALUES('$task', '$id', '2')";

               $result2 = mysqli_query($db, $query2);
               $tid = mysqli_insert_id($db);

           //echo "success";

            //for selecting that paticular task for displayig
            if($result2)
            {
              $sql = "INSERT INTO task_tracker (uid, tid, task_status)
                 VALUES('$id','$tid','2')";
                  mysqli_query($db, $sql);
            }

            //


           //for showing the response
           $query4     = "SELECT task from task where tid = '$tid' ";
           $result4    = mysqli_query($db, $query4);
           $row_count = mysqli_num_rows($result4);
           if($row_count > 0)
           {
               $detail4    = mysqli_fetch_assoc($result4);

               $task_name['task']  = $detail4['task'];
               $task_name['tid']  = $tid;
          }
          else {

              $task_name = '';
          }



           $task_name_json = json_encode($task_name);
           echo $task_name_json;

          }







 ?>
