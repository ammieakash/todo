<!DOCTYPE html>
<html>
<head>
<title>More Completed Records</title>
<script>
//datatable jquery part for completed div
$(document).ready(function() {
             $('#insert1').DataTable({
              "searching" : false,
              pageLength : 5,
            lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']] //for setting 5 reords per page
            });
//window.reload(true);
});

</script>

</head>
<table id = "insert1" class="table table-striped table-hover table-bordered table-sm " style="width:100%">

  <thead>
    <tr>
    <th style="width:100%"></th>
    <th></th>
  </tr>
  </thead>
  <?php
  include('config.php');
  $uid = $_SESSION['uid'];
  $sql_com = "SELECT tid,task from task where task_status= '1' AND uid = '$uid'";
  $result_com = mysqli_query($db, $sql_com) or die('error getting');

  if($result_com-> num_rows > 0 )

  {
    while($row_com = mysqli_fetch_array($result_com, MYSQLI_ASSOC))
      {   $id = $row_com['tid'];
         echo  "<tr>";
            echo "<td>";
            echo $row_com['task'];
            echo "</td>";
            echo "<td>";
            echo "<input type='button' class='btn btn-danger btn-sm' name='save' value='Delete' onclick='return deleteRecord($id,this);'>";
            echo "</td>";
       echo "</tr>";

              }
            echo "</table>";
        }
        else {
        die();
        }


        mysqli_close($db);
 ?>
</html>
