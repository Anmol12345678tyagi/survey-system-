<?php
include_once 'header.php';
include_once 'dashboard_upper.php';
include_once 'conn.php';

// $query2 = "SELECT * FROM `test_table`";
// $data2 = mysqli_query($conn, $query2);

$query1 = "SELECT * FROM survey  ORDER BY survey.Survey_id  ";
$data1 = mysqli_query($conn, $query1);


// echo "<pre>";
// print_r($survey);
// echo "</pre>";


?>
<style>
  .css_border {
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    border-radius: 10px;
  }
</style>


<form method="post">
  <div class="container border border-danger">
<?php 
  while ($res = mysqli_fetch_array($data1)) {
  $s_id = $res['Survey_id'];
      ?>
    <div class="card css_border border border-danger my-3" style="width: 18rem;">
      <div class="card-body">
     <?php echo $res['survey_name']."<br><hr>";
     echo $res['Survey_description']."<br><br>";
     echo "<button type='button' class='btn btn-secondary'><a href='report_tabular.php?s_id=$s_id'>Tabular formate</a></button>";
     ?>
      </div>
</div>
<?php } ?>
  



  </div>
</form>




<?php
include_once 'dashboard_lower.php';
include_once 'footer.php';
?>