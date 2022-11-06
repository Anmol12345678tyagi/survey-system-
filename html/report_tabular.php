<?php
include_once 'conn.php';  
$s_id = $_GET['s_id'];

if(isset($_POST['export_csv'])){

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=csv_data.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Name', 'Email','Question','Answer']);
    $query2 = "SELECT `answer_submitted_name`,`answer_submitted_email`,`Question`,`answer_description` FROM question AS q LEFT JOIN answer AS a ON q.Question_id=a.question_id_2 WHERE a.answer_survey_id= '$s_id' ORDER BY q.Question_id";
    $data2 = mysqli_query($conn, $query2);
    while($row = mysqli_fetch_array($data2)){
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
    }
 


include_once 'header.php';
include_once 'dashboard_upper.php'; 

// $query1 = "SELECT * FROM `question` AS q LEFT JOIN answer AS a ON q.Question_id=a.question_id_2";
$query1 = "SELECT * FROM answer AS a LEFT JOIN question AS q ON q.Question_id=a.question_id_2 WHERE a.answer_survey_id= '$s_id'";
$data1 = mysqli_query($conn, $query1);

while ($res = mysqli_fetch_array($data1)) {

    $name = $res['answer_submitted_name'];
    $email = $res['answer_submitted_email'];
    $val['ques'] = $res['Question'];
    $val['ans'] =  $res['answer_description'];
    $mul_arr[$name][$email][] = $val;
}

// echo "<pre>";
// print_r($mul_arr);
// echo "</pre>";


?>

<div class="container-lg my-3">
    <!-- <div class="d-flex flex-column  flx_1"> -->

    <div class="card bg-info rounded">
        <div class="card-body">

            <div>
                <p style="color:white;font-weight:400;font-size:30px;text-align:center">Report
                    <hr>
                </p>
            </div>
            <div style="margin-bottom:20px;">
            <form method="post">
                <button type="submit" id="export_csv" name="export_csv" class="btn btn-success">Download CSV</button>
                </form>
            </div>
            <div>
                <div class="table-responsive">
                    <!-- <form method="post"> -->
                        <table class="table table-bordered border-dark" id="table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Survey Question</th>
                                    <th scope="col">Survey Answer</th>
                                    <!-- <th scope="col">Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(!empty($mul_arr)){
                                    
                                foreach ($mul_arr as $m => $a) { 
                                    $i=1;
                                    ?>
                                    <tr>
                                        <td><?php echo $m; ?></td>
                                        <?php
                                        foreach ($a as $k => $v) { ?>
                                            <td><?php echo $k; ?></td>
                                            <td colspan="2" style="padding:2px">
                                                <?php

                                                foreach ($v as $key => $val) {  ?>
                                                    <table class="my-2 py-2" style="width:100%;border:1px solid black" border="2">
                                                        <tr>

                                                            <td class="px-2" style="width:52%;border:1px solid black"><strong>Q<?php echo $i ;?>. &nbsp</strong><?php echo $val['ques']; ?></td>
                                                            <td class="px-2"><?php echo $val['ans']; ?></td>
                                                        </tr>
                                                    </table>
                                                <?php $i++; }  ?>

                                            </td>
                                        <?php    } ?>
                                    </tr>
                                <?php } }

                                ?>
                            </tbody>
                        </table>
                </div>

                <!-- </form> -->
            </div>

        </div>
    </div>


    <!-- </div> -->
</div>



<?php
include_once 'dashboard_lower.php';
include_once 'footer.php';
?>