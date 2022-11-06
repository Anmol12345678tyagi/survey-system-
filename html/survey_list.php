<?php
include_once 'header.php';
include_once 'dashboard_upper.php';
include_once 'conn.php';

// $conn = mysqli_connect( 'localhost', 'root', '', 'survey' ) or die( 'connection failed' );

$query = "SELECT * FROM `survey` ";
$data = mysqli_query($conn, $query);

$today_date = date('Y-m-d');

if (isset($_POST['submit'])) {
    echo $_POST['switch_toggle'];
}

?>

<style>
    hr {
        border: 1px dotted red;
    }

    .fa-pen-to-square {
        color: green;
    }

    .fa-trash-can {
        color: red;
    }

    .fa-eye {
        color: yellow
    }

    .fa-share-nodes {
        color: blue
    }
</style>

<div class="container-lg my-3">
    <!-- <div class="d-flex flex-column  flx_1"> -->

    <div class="card bg-info rounded">
        <div class="card-body">
            <form method="post">
                <div>
                    <p style="color:white;font-weight:400;font-size:30px;text-align:center">Survey List
                        <hr>
                    </p>
                </div>
                <div style="margin-bottom:20px;">
                    <button type="button" class="btn btn-primary"><a href="survey_desc.php">Add survey +</a></button>
                </div>
                <div>
                    <div class="table-responsive">
                        <form method="get">
                            <table class="table table-bordered border-dark" id="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Survey Name</th>
                                        <th scope="col">Survey catagorie</th>
                                        <th scope="col">Survey description</th>
                                        <th scope="col">Survey Start Date</th>
                                        <th scope="col">Survey End Date</th>
                                        <th scope="col">Survey status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($data) > 0) {

                                        while ($arr = mysqli_fetch_array($data)) { ?>
                                            <tr>
                                                <td style="width:10%"><?php echo $arr['survey_name']; ?></td>
                                                <td><?php echo $arr['Survey_Category']; ?></td>
                                                <td style="width:30%"><?php echo $arr['Survey_description']; ?></td>
                                                <td style="width:10%"><?php echo $arr['Survey_Start_Date']; ?></td>
                                                <td style="width:10%"><?php echo $arr['Survey_End_Date']; ?></td>
                                                <td style="width:10%">
                                                    <div class="form-check form-switch flex d-flex justify-content-center mt-3">
                                                        <input class="form-check-input" type="checkbox" value="<?php if (($today_date == $arr['Survey_Start_Date']) && ($arr['Survey_Start_Date'] < $arr['Survey_End_Date'])) {
                                                                                                                                                                                            echo "1";}
                                                                                                                                                                                            else{
                                                                                                                                                                                                echo "0";
                                                                                                                                                                                            }
                                                                                                                                                                                            ?>" name="switch_toggle" role="switch" id="flexSwitchCheckDefault" <?php if (($today_date == $arr['Survey_Start_Date']) && ($arr['Survey_Start_Date'] < $arr['Survey_End_Date'])) {
                                                                                                                                                                                            echo 'checked="checked"';
                                                                                                                                                                                        } ?>>
                                                    </div>
                                                    <label class="form-check-label mt-1 mx-3" for="flexSwitchCheckDefault"><?php

                                                                                                                            if (($today_date < $arr['Survey_Start_Date']) && ($arr['Survey_Start_Date'] < $arr['Survey_End_Date'])) {
                                                                                                                                echo "Inactive";
                                                                                                                            } elseif (($today_date == $arr['Survey_Start_Date']) && ($arr['Survey_Start_Date'] < $arr['Survey_End_Date'])) {
                                                                                                                                echo "Active";
                                                                                                                            } else {
                                                                                                                                echo "Expired";
                                                                                                                            }
                                                                                                                            ?></label>
                                                </td>

                                                <td>
                                                    <a href="update_survey.php?id=<?php echo $arr['Survey_id'] ?> "><i class="fa-solid fa-pen-to-square"></i></a> |
                                                    <a href="ques_create.php?id=<?php echo $arr[0] ?>&name=<?php echo $arr[1] ?> "><i class="fa-solid fa-eye"></i></a> |
                                                    <a href="share.php?s_id=<?php echo $arr[0] ?>"><i class="fa-solid fa-share-nodes"></i></a> |
                                                    <a onclick="return confirm('Do you want to delete')" href="delete_survey.php?id=<?php echo $arr[0]; ?> "><i class="fa-solid fa-trash-can"></i></a>
                                                </td>
                                            </tr>
                                    <?php    }
                                    }

                                    ?>
                                </tbody>
                            </table>
                    </div>

                    <!-- <div class="form-check form-switch flex d-flex justify-content-center mt-3">
                        <input class="form-check-input" type="checkbox" value="active" name="switch_toggle" role="switch" id="flexSwitchCheckDefault" <?php if ($today_date < $arr['Survey_End_Date']) {
                                                                                                                                                            echo 'checked="checked"';
                                                                                                                                                        } ?>>

                    </div>
                    <button type="submit" name="submit">click me</button> -->

            </form>
        </div>
        </form>
    </div>
</div>


<!-- </div> -->
</div>



















<?php
include_once 'footer.php';
include_once 'dashboard_lower.php';
?>