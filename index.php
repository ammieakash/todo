<?php

    include('config.php');
    if(!isset($_SESSION['email']))
    {
      header('Location: login.php ');
    }

 ?>
<!doctype html>
<html>
<head>
 <title>To Do Application</title>
    <!--INCLUDING SCRIPT FILES-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


      <!--INCLUDING CSS FILES-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css"/>
    <script>
    function enter_task(user,obj){



      //for validation of task field
       var task_name    = document.getElementById("task").value;
       var task_format = /^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/;



       document.getElementById("task_error").innerHTML = "";

       if(task_name == "") {
          document.getElementById("task_error").innerHTML = "Please enter task";
          return false;
      }
      else if(task_name.match(task_format)== null)
      {
         document.getElementById("task_error").innerHTML = "added task can't be special characters ";
         return false;
      }
      else {

        var task = $("#task").val();
          //ajax for adding task below incomplete task div
              $.ajax({

                      type : "POST",
                      url  : "index_server.php",
                      datatype:'JSON',
                      data : { user: user, task:task},
                      success : function(data)
                        {
                            //alert(data);
                            //window.location.reload(true);
                            //console.log(tid);
                          if(data == "exist")
                          {
                              //alert("already present");
                              document.getElementById("task_error").innerHTML = "Task aleady added ";
                          }
                          else
                          {
                            //$(obj).parent().parent().remove();
                            //window.location.reload(true);
                            var obj = JSON.parse(data);
                            var tid = obj.tid;

                            //inserting values to dynamic datatable
                              var enter = $('#insert').DataTable();
                                enter.row.add( [
                                 obj.task,
                                 '<input type="button" class="btn btn-primary btn-sm" name="save" id = "done" value="Done" onclick = "return updateRecord('+tid+')">',
                                 '<input type="button" class="btn btn-danger btn-sm" name="save" value="Delete" id="del" onclick = "return deleteRecord('+tid+')">'
                             ] ).draw( false );

                                  //appending the row at incomplete task div
                                  //$('#insert').append(table);


                          }
                        }

                    });


             return true;
           }
        }




//updating the record in db on done button click
        function updateRecord(value){

                  $.ajax({

                              type: "POST",
                              url: "completed.php",
                              datatype: "JSON",
                              data : { id : value},
                              success : function(response)
                              {
                                var obj1 = JSON.parse(response);
                                var tid1 = obj1.tid;
                                var task1 = obj1.task;
                                var match = obj1.success;
                                var add_date = obj1.add_date;
                                var com_date = obj1.com_date;
                                //console.log(response);

                                //removing row from incomplete div on the click of done button
                                var done_incom = $('#insert').DataTable();

                                $('#insert tbody').on( 'click', 'tr', function () {
                                    if ( $(this).hasClass('selected') ) {
                                        $(this).removeClass('selected');
                                    }
                                    else {
                                        done_incom.$('tr.selected').removeClass('selected');
                                        $(this).addClass('selected');
                                    }
                                    done_incom.row('.selected').remove().draw( false );
                                });

                                //inserting row in completed div data table on done button click
                                var t = $('#insert1').DataTable();
                                t.row.add( [
                                 task1,
                                 add_date,
                                 com_date,
                                 '<input type="button" class="btn btn-danger btn-sm" name="save" value="Delete" id="del" onclick = "return deleteRecord('+tid1+')">',
                             ] ).draw( false );

                           }
                      });

                 }


                 //function onclick with ajax for deleting task
                 function deleteRecord(value){

                   $.ajax({

                     type : "POST",
                     url  : "delete.php",
                     datatype:'JSON',
                     data : { id: value},
                     success : function(response)
                     {
                        obj2 = JSON.parse(response);//parsed data which is json encoded

                       if(obj2 == "success")
                       {

                         //removing row from incomplete div on delete button click
                         var del_incom = $('#insert').DataTable();

                         $('#insert tbody').on( 'click', 'tr', function () {
                             if ( $(this).hasClass('selected') ) {
                                 $(this).removeClass('selected');
                             }
                             else {
                                 del_incom.$('tr.selected').removeClass('selected');
                                 $(this).addClass('selected');
                             }
                             del_incom.row('.selected').remove().draw( false );
                         });

                        // $(obj).parent().parent().remove();
                          //removing from completed div with delete button click
                          var del = $('#insert1').DataTable();

                          $('#insert1 tbody').on( 'click', 'tr', function () {
                              if ( $(this).hasClass('selected') ) {
                                  $(this).removeClass('selected');
                              }
                              else {
                                  del.$('tr.selected').removeClass('selected');
                                  $(this).addClass('selected');
                              }
                              del.row('.selected').remove().draw( false );
                          } );

                       }


                     }
                   });

                 }
//datatable intialization which will appear on page refresh with whole bumch of data
                 $(document).ready(function() {

                         $('#insert1').DataTable({
                                      pageLength : 5,
                                    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
                                    "searching": false,
                                     columnDefs: [
                                       { orderable: false, targets: -1 },
                                       { orderable: false, targets: -2 },
                                       { orderable: false, targets: -3 }
                                     ]
                                    });
                          $('#insert').DataTable({
                                        pageLength : 5,
                                        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
                                        "searching": false,
                                        "paging" : false,
                                        columnDefs: [
                                            { orderable: false, targets: -1 },
                                            { orderable: false, targets: -2 }
                                          ]
                                    });
                                });

</script>
</head>


  <div class="container"><br>
    <p class="float-left text muted"><strong>User:</strong> <?php  echo ($_SESSION['email']);  ?></p><a href="http://localhost/todo/logout.php" class="btn btn-primary btn-small float-right">Logout</a><br>
    <br>
    <h1 class="text-center text-secondary">Welcome <?php echo $_SESSION['username']; ?>!!!</h1>
      <form method="post" action = ""  id="add" name="form">
      <div>
       <input type="text" name="task_add" class="form-control" id="task" autocomplete="off" maxlength="20" placeholder="Enter task here">
        <span id="task_error" class="text-danger font-weight-bold"> </span>
      </div>
      <?php
         $id = $_SESSION['uid'];
        echo "<input type=\"submit\" class=\"btn btn-primary btn-sm\" value=\"Add task\" id=\"add_task\" onclick=\"return enter_task($id)\"";
       ?>

    </form><br><br>





    <div class="boxed bg-info">INCOMPLETE TASK</div><br/>
    <table id = "insert" class="table table-responsive table-striped table-hover table-bordered table-sm bg-light" style="overflow:scroll;height:200px;width:100%;overflow:auto">
          <thead>
            <tr>
                <th style = "width:100%">Task
                </th>
                <th>
                </th>
                <th>
                </th>
            </tr>
         </thead>
      <?php


       $uid = $_SESSION['uid'];
       $sql = "SELECT tid,task from task where task_status= '2' AND uid ='$uid'";
       $result = mysqli_query($db, $sql) or die('error getting');
       $row_count = mysqli_num_rows($result);
       //echo $row_count;

                  //fetching data from database dynamically on refresh
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                    {   $id = $row['tid'];
                      echo "<tbody>";
                        echo  "<tr>";
                           echo "<td>";
                           echo $row['task'];
                           echo "</td>";
                           echo "<td>";
                           echo "<input type='button' class='btn btn-primary btn-sm' name='save' id = 'done' value='Done' onclick='return updateRecord($id)'>";
                           echo "</td>";
                           echo "<td>";
                           echo "<input type='button' class='btn btn-danger btn-sm' name='save' value='Delete' id = 'del' onclick='return deleteRecord($id);'>";
                           echo "</td>";
                      echo "</tr></tbody>";

                   }

      ?>
    </table>

<br/>
<br/>

<div class="boxed bg-info">COMPLETED TASK</div><br>
<table id = "insert1"  class="table table-responsive table-striped table-hover table-bordered table-sm">
      <thead>
       <tr>
        <th style = "width:100%"> Total completed task</th>
        <th>Added on  </th>
        <th>Completed on</th>
        <th>  </th>
        </tr>
      <thead>
      <tbody>
        <?php
        include('config.php');
        $uid = $_SESSION['uid'];
        $sql_com = "SELECT task,tid from task WHERE task_status = '1' AND uid = '$uid'";
        $result_com = mysqli_query($db, $sql_com) or die('error getting');

        if($result_com-> num_rows > 0 )

        {
          while($row_com = mysqli_fetch_array($result_com, MYSQLI_ASSOC))
            {   $id = $row_com['tid'];
               //fetching data from db for showing added task date_time
                $sql_add = "SELECT date_time from task_tracker WHERE tid = '$id' AND task_status ='2'";
                $result1 = mysqli_query($db, $sql_add) or die('error getting');
                $task_add = mysqli_fetch_assoc($result1);

                //fetching data from db for showing completed task date_time
                $sql_com = "SELECT date_time from task_tracker WHERE tid = '$id' AND task_status ='1'";
                $result2 = mysqli_query($db, $sql_com) or die('error getting');
                $task_com = mysqli_fetch_assoc($result2);

               echo  "<tr>";
                  echo "<td>";
                  echo $row_com['task'];
                  echo "</td>";
                  echo "<td>";
                  echo $task_add['date_time'];
                  echo "</td>";
                  echo "<td>";
                  echo $task_com['date_time'];
                  echo "</td>";
                  echo "<td>";
                  echo "<input type='button' class='btn btn-danger btn-sm' name='save' value='delete' id ='del' onclick='return deleteRecord($id);'>";
                  echo "</td>";
             echo "</tr>";

                    }
                  echo "</tbody></table>";
              }
              else {
                die();
                //echo "0 result";
              }


              mysqli_close($db);
       ?>

</div>


</html>
