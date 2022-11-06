<?php
include_once 'header.php';
include_once 'conn.php';

$s_id = $_GET['s_id'];
@$invitation_key = $_GET['invitation_key'];
$pattern = '/#*&$/';

$query2 = "SELECT * FROM `invitation` WHERE invitation_key = '$invitation_key'";
$data2 = mysqli_query($conn, $query2);
$res = mysqli_fetch_array($data2);
@$getemail = $res['invitation_email'];
@$getname = $res['invitation_name'];


// //decryption***********************************************

//   $ciphering = "AES-128-CTR";

//   // Use OpenSSl Encryption method
//   $iv_length = openssl_cipher_iv_length($ciphering);
//   $options = 0;

//   // Non-NULL Initialization Vector for encryption
//   $encryption_iv = '1234567891011121';

//   // Store the encryption key
//   $encryption_key = "GeeksforGeeks";



// $decryption_key = "GeeksforGeeks";
// $ciphering = "AES-128-CTR";
// $options = 0;
// $decryption_iv = '1234567891011121';

// // Use openssl_decrypt() function to decrypt the data
// echo  $decryption = openssl_decrypt(
//     $en_invitation_key,
//     $ciphering,
//     $decryption_key,
//     $options,
//     $decryption_iv
// )."<br>";

// echo $decryption2 = openssl_decrypt(
//     $en_name,
//     $ciphering,
//     $decryption_key,
//     $options,
//     $decryption_iv
// );



// // $string = $decryption;
// $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
// preg_match_all($pattern, $decryption, $matches);
// echo "<br>";
// print_r($matches);
// foreach($matches as $k => $v){
//     foreach($v as $key => $val){
//         echo "<br>";
//         echo $val;
//     }
// }
// echo "<br>";




// extract
if (isset($_POST['save'])) {
    extract($_POST);

    @$answer = $_POST['options'];
    if (!empty($answer)) {
        $answer = array_map('array_filter', $answer);
        $answer = array_filter($answer);
    }
    // echo "<pre>";
    // print_r($answer);
    // echo "</pre>";

    if (empty($answer)) {
        echo "<script>alert('please fill the survey');</script>";
    } else {
        // INSERT INTO ANSWER************************************** 
        foreach ($answer as $ques => $arr) {
            foreach ($arr as $val => $ans) {
                $query5 = "INSERT INTO `answer`(`answer_id`, `answer_description`, `question_id_2`, `answer_submitted_name`, `answer_submitted_email`, `answer_survey_id`) VALUES ('NULL','$ans','$ques','$getname','$getemail','$s_id')";
                $data5 = mysqli_query($conn, $query5);
            }
        }
    }

    // header("location:thanks_page.php");
}

// join***************************
$query1 = "SELECT * FROM survey AS s LEFT JOIN question AS q ON s.Survey_id=q.Survey_id_1 LEFT JOIN option_table AS o ON q.Question_id=o.Question_id_1 WHERE s.Survey_id = '$s_id'  ORDER BY Question_id ";
$data1 = mysqli_query($conn, $query1);

while ($res = mysqli_fetch_array($data1)) {
    $Survey_name =  $res['survey_name'];
    // $Survey_Category = $res['Survey_Category'];
    // $Survey_description = $res['Survey_description'];

    $arr_ques = $res['Question'];
    $opt['ques_type'] = $res['Question_option_type'];
    $opt['arr_opt'] = $res['Option_description'];
    $opt['ques_id'] = $res['Question_id'];
    $opt['opt_id'] = $res['Option_id'];

    $mul_arr[$res['Survey_id']][$arr_ques][] = $opt;
}
// echo "<pre>";
// print_r($mul_arr);
// echo "<pre>" . "<br>";

if (isset($_POST['cancel'])) {
    header("location:ques_create.php?id=$s_id");
}
?>

<style>
    body {
        background-color: gray;
    }

    @media (min-width: 1025px) {
        .h-custom {
            height: 100vh !important;
        }
    }

    .span_color {
        color: red;
    }

    .class1 {
        width: 100%;
        background-color: none;
    }

    .r2 {
        border: 1px solid black;
    }

    .r3 {
        border: 1px solid red;
    }

    .r4 {
        border: 1px solid green;
    }

    .r5 {
        border: 1px solid blue;

    }

    .d_none {
        display: none;
    }

    hr.style-eight {
        height: 5px;
        border: 1;
        color: aqua;
        box-shadow: inset 0 9px 9px -3px rgba(11, 99, 184, 0.8);
    }

    .css_border {
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        border-radius: 10px;
    }
</style>



<!-- <section class="h-100 h-custom" > Ques screen -->
<form method="post" style="margin-bottom:20px" class="my-4">
    <div class="container-fluid flex d-flex justify-content-center">
        <div class="card col-7 rounded-3 c_class css_border " style="border-color:aqua;border-width:2px">
            <div class="card-body p-2 p-md-3 d-flex flex-column align-items-center ">

                <div class="mb-5" style="margin-left:60px">
                    <h1><?php echo $Survey_name;?></h1>
                </div>
                <!-- question show -->
                <div class="row col-12 mb-3 ms-2 me-2" id="parent_div ">

                    <?php
                    $l = 0;

                    foreach ($mul_arr as $s_id => $ques) {
                        foreach ($ques as $q => $opt) {
                            $l++;
                            if (!empty($q)) {
                                foreach ($opt as $k => $v) {
                                    $ques_id =  $v['ques_id'];
                                    $ques_type = $v['ques_type'];
                                }
                    ?>
                                <div class="row col-10 rounded mb-2 pt-2  parent_delete">
                                    <div class="row ms-2">
                                        <div class="col-sm-10 p-0">
                                            <div class='form-group input-group mb-3 pb-3 pt-1 css_border px-3' style="background-color:white-smoke;border-width:2px">
                                                <div class='input-group-prepend mt-1 me-2'>
                                                    <div class=''> <strong>Q.<?php echo $l; ?></strong> </div>
                                                </div>
                                                <div class="mt-1" style="word-wrap: break-word;width:90%; " disabled><?php echo $q; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $len = count($opt);
                                    $i = 0;
                                    foreach ($opt as $o => $b) {
                                        // sc**********************************
                                        if ($b['arr_opt'] != "") {
                                            if ($b['ques_type'] == "sc") {
                                                $i++;
                                    ?>
                                                <div class='flex d-flex justify-content-start row mb-2'>
                                                    <div class='col-1' style="padding-left:30px"><input type='radio' name='options[<?php echo $b['ques_id'] ?>][]' value="<?php echo $b['arr_opt'] ?>"></div>
                                                    <div class='col-9 ps-1' style="color:black;font-family: serif;font-weight:20px"> <?php print_r($b['arr_opt']); ?></div>
                                                </div>
                                                <?php
                                                if ($i == count($opt)) {
                                                    echo " <hr class='style-eight mt-0'>";
                                                }
                                                // mcq**********************************
                                            } elseif ($b['ques_type'] == "mcq") {
                                                $i++;
                                                ?>
                                                <div class='flex d-flex justify-content-start row mb-2'>
                                                    <div class='col-1' style="padding-left:30px"><input type='checkbox' name='options[<?php echo $b['ques_id'] ?>][]' value="<?php echo $b['arr_opt'] ?>"></div>
                                                    <div class='col-9 ps-1' style="color:black;font-family: serif;font-weight:20px"> <?php print_r($b['arr_opt']); ?></div>
                                                </div>
                                                <?php
                                                if ($i == count($opt)) {
                                                    echo " <hr class='style-eight mt-0'>";
                                                }
                                                // sc_c**********************************
                                            } elseif ($b['ques_type'] == "sc_c") {
                                                $i++;
                                                if ($i == count($opt) && !preg_match(@$pattern, $b['arr_opt'])) { ?>

                                                    <div class='flex d-flex justify-content-start row mb-2'>
                                                        <div class='col-1' style="padding-left:30px"><input type='radio' name='options[<?php echo $b['ques_id'] ?>][]' value="<?php echo $b['arr_opt'] ?>"></div>
                                                        <div class='col-9 ps-1' style="color:black;font-family: serif;font-weight:20px"><?php print_r($b['arr_opt']); ?></div>
                                                    </div>

                                                    <div class="row col-8 ms-4 mb-2">
                                                        <textarea class="mb-2 ps-2 pt-2 rounded" placeholder="#enter text here............"></textarea>
                                                    </div>
                                                    <hr class='style-eight mt-0'>
                                                <?php  } elseif (@preg_match(@$pattern, $b['arr_opt'])) {
                                                    $str = str_replace(str_split('#*&'), '', $b['arr_opt']);
                                                ?>
                                                    <div class="row col-8 ms-4 mb-2">
                                                        <textarea class="mb-2 ps-2 pt-2 rounded" placeholder="<?php echo $str; ?>" name='options[<?php echo $b['ques_id'] ?>][]'></textarea>
                                                    </div>
                                                    <hr class='style-eight mt-0'>
                                                <?php
                                                } else { ?>
                                                    <div class='flex d-flex justify-content-start row mb-2'>
                                                        <div class='col-1' style="padding-left:30px"><input type='radio' name='options[<?php echo $b['ques_id'] ?>][]' value="<?php echo $b['arr_opt'] ?>"></div>
                                                        <div class='col-9 ps-1' style="color:black;font-family: serif;font-weight:20px"><?php print_r($b['arr_opt']); ?></div>
                                                    </div>
                                                <?php   }

                                                // mcq_c**********************************
                                            } elseif ($b['ques_type'] == "mcq_c") {
                                                $i++;
                                                if ($i == count($opt) && !preg_match(@$pattern, $b['arr_opt'])) { ?>

                                                    <div class='flex d-flex justify-content-start row mb-2'>
                                                        <div class='col-1' style="padding-left:30px"><input type='checkbox' name='options[<?php echo $b['ques_id'] ?>][]' value="<?php echo $b['arr_opt'] ?>"></div>
                                                        <div class='col-9  ps-1' style="color:black;font-family: serif;font-weight:20px"> <?php print_r($b['arr_opt']); ?></div>
                                                    </div>

                                                    <div class="row col-8 ms-4 mb-2">
                                                        <textarea class="mb-2 ps-2 pt-2 rounded" placeholder="#enter text here............"></textarea>
                                                    </div>
                                                    <hr class='style-eight mt-0'>

                                                <?php  } elseif (@preg_match(@$pattern, $b['arr_opt'])) {
                                                    $str = str_replace(str_split('#*&'), '', $b['arr_opt']);
                                                ?>
                                                    <div class="row col-8 mt-2 ms-4 mb-2">
                                                        <textarea class="mb-2 ps-2 pt-2 rounded" placeholder="<?php echo $str; ?>" name='options[<?php echo $b['ques_id'] ?>][]'></textarea>
                                                    </div>
                                                    <hr class='style-eight mt-0'>
                                                <?php
                                                } else { ?>
                                                    <div class='flex d-flex justify-content-start row mb-2'>
                                                        <div class='col-1' style="padding-left:30px"><input type='checkbox' name='options[<?php echo $b['ques_id'] ?>][]' value="<?php echo $b['arr_opt'] ?>"></div>
                                                        <div class='col-9  ps-1' style="color:black;font-family: serif;font-weight:20px"> <?php print_r($b['arr_opt']); ?></div>
                                                    </div>
                                                <?php }
                                            }
                                        } else {
                                            if ($b['ques_type'] == "text") { ?>
                                                <div class='row-5 col-9 my-3 ms-3'>
                                                    <input type='text' placeholder='#text here' name='options[<?php echo $b['ques_id'] ?>][]' class='form-control' aria-label='Sizing example input' aria-de scribedby='inputGroup-sizing-default'>
                                                </div>
                                                <hr class='style-eight mt-0'>
                                            <?php   } elseif ($b['ques_type'] == "date") { ?>
                                                <div class='row-5 col-9 my-3 ms-3'>
                                                    <input type='date' placeholder='#text here' name='options[<?php echo $b['ques_id'] ?>][]' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default'>
                                                </div>
                                                <hr class='style-eight mt-0'>
                                            <?php    } elseif ($b['ques_type'] == "time") { ?>
                                                <div class='row-5 col-9 my-3 ms-3'>
                                                    <input type='time' placeholder='#text here' name='options[<?php echo $b['ques_id'] ?>][]' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default'>
                                                </div>
                                                <hr class='style-eight mt-0'>
                                            <?php   } elseif ($b['ques_type'] == "rating") { ?>
                                                <div class='row-5 col-9 my-3 ms-3' id='rating'>
                                                    <div class='col-6 ms-2'>
                                                        <label class='mt-2' for='vol'>Rate us (between 0 and 5):</label>
                                                        <input type='range' id='vol' min='0' max='5' name='options[<?php echo $b['ques_id'] ?>][]' style='width:100%;height:7vh;'>
                                                    </div>
                                                </div>
                                                <hr class='style-eight mt-0'>
                                            <?php   } elseif ($b['ques_type'] == "file") { ?>
                                                <div class='row-5 col-9 my-3 ms-3'>
                                                    <input type='file' class='form-control' name='options[<?php echo $b['ques_id'] ?>][]' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default'>
                                                </div>
                                                <hr class='style-eight mt-0'>
                                <?php       }
                                        }
                                    }
                                }
                                ?>
                                </div>
                        <?php

                        }
                    }
                        ?>
                </div>










            </div>
            <!-- save & cancel button -->
            <div class="col-11 d-flex justify-content-end  mb-3 me-5">
                <button type="submit" name="save" id="qcbtn" class="btn btn-success me-3 p-0" style="width:10%">save</button>
                <button type="submit" name="cancel" id="qc_btn" class="btn btn-danger p-0" style="width:10%">cancel</button>
            </div>

        </div>
    </div>
</form>


<?php
include_once 'footer.php';
?>