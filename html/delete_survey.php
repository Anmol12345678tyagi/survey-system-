<?php
$conn = mysqli_connect( 'localhost', 'root', '', 'survey' ) or die( 'connection failed' );


$id = $_GET['id'];
$query = "DELETE survey, question , option_table FROM `survey` LEFT JOIN `question` ON survey.Survey_id = question.Survey_id_1 LEFT JOIN `option_table` ON question.Question_id = option_table.Question_id_1
where `Survey_id` = '$id'";
$data = mysqli_query($conn, $query);
header("location:survey_list.php");
?>