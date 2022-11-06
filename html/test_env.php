<?php

include_once 'conn.php';
$ques_id = $_GET['ques_id'];
// $get_ques_type = $_GET['ques_type'];
$s_id = $_GET['s_id'];
$header = false;
$pattern = '/#*&$/';

// echo count($option_count);
// get form inputs*********************
if (isset($_POST['save'])) {
  extract($_POST);

  $options = $_POST['opt'];
  $options = array_filter($options);

  $opt_cmt = $_POST['opt_cmt'];
  $opt_cmt = array_filter($opt_cmt);

  // if ($drop == "mcq_c" || $drop == "sc_c") {
  //   if (empty($opt_cmt)) {
  //     $options[] = "no_text";
  //   } else {
  //     foreach ($opt_cmt as $k => $v) {
  //       if (preg_match($pattern, $v)) {
  //         $options[] = $v;  
  //       } else {
  //         $options[] = $v . "#*&";
  //       }
  //     }
  //   }
  // } 
  if ($drop == "mcq_c" || $drop == "sc_c") {

    if (!empty($opt_cmt)) {
      foreach ($opt_cmt as $k => $v) {
        if (preg_match($pattern, $v)) {
          $options[] = $v;
        } else {
          $options[] = $v . "#*&";
        }
      }
    }
  }

  // update******************************
  $i = 0;
  $query2 = "SELECT * FROM  question AS q LEFT JOIN option_table AS o ON q.Question_id=o.Question_id_1 WHERE Q.Question_id = '$ques_id'";
  $data2 = mysqli_query($conn, $query2);
  while ($result = mysqli_fetch_array($data2)) {
    $option_id[] = $result['Option_id'];
  }

  
  if ($ques != "" && $drop != "") {
    if ($drop == "mcq" || $drop == "mcq_c" || $drop == "sc" || $drop == "sc_c") {
      if ((!@($options[0] == "no_text") && !empty($options))  || (empty($options) && (@$options[0] == "no_text"))) {

        //upsert*****************************
        if (count($option_id) <= count($options)) {
          $header = true;
          $query1 = "UPDATE question SET Question = '$ques' , Question_option_type = '$drop' WHERE question.Question_id = '$ques_id'";
          $data1 = mysqli_query($conn, $query1);
          foreach ($options as $key => $value) {
            // echo $value;
            @$optid = $option_id[$i];
            $i++;
            $query3 = "REPLACE INTO option_table(`Option_id` ,`Question_id_1`, `Option_description`) VALUES ('$optid','$ques_id','$value')";
            $data3 = mysqli_query($conn, $query3);
          }
        }
        // delete****************************
        else {
          $header = true;
          $query1 = "UPDATE question SET Question = '$ques' , Question_option_type = '$drop' WHERE question.Question_id = '$ques_id'";
          $data1 = mysqli_query($conn, $query1);
          foreach ($options as $key => $value) {
            @$optid = $option_id[$i];
            $i++;
            $query3 = "REPLACE INTO option_table(`Option_id` ,`Question_id_1`, `Option_description`) VALUES ('$optid','$ques_id','$value')";
            $data3 = mysqli_query($conn, $query3);

            if ($i == count($options)) {
              for ($i == count($options); $i < count($option_id); $i++) {
                $optid = $option_id[$i];
                $query4 = "DELETE FROM `option_table` WHERE Option_id = '$optid'";
                $data4 = mysqli_query($conn, $query4);
              }
            }
          }
        }
        // update and insert************************

        // foreach ($options as $key => $value) {
        //   @$optid = $option_id[$i];
        //   $i++;
        //   // count == new count****************
        //   if (count($option_id) == count($options)) {
        //     $query3 = "UPDATE question LEFT JOIN option_table ON question.Question_id = option_table.Question_id_1 SET Question = '$ques' , Question_option_type = '$drop' , Option_description = '$value' WHERE question.Question_id = '$ques_id' AND Option_id = '$optid'";
        //     $data3 = mysqli_query($conn, $query3);
        //     $header = true;
        //   }
        //   // count < new count*******************
        //   elseif (count($option_id) < count($options)) {
        //     if ($i <= count($option_id)) {
        //       $query3 = "UPDATE question LEFT JOIN option_table ON question.Question_id = option_table.Question_id_1 SET Question = '$ques' , Question_option_type = '$drop' , Option_description = '$value' WHERE question.Question_id = '$ques_id' AND Option_id = '$optid'";
        //       $data3 = mysqli_query($conn, $query3);
        //       $header = true;
        //     } elseif ($i <= count($options)) {
        //       $query5 = "INSERT INTO `option_table`(`Question_id_1`, `Option_description`) VALUES ('$ques_id','$value')";
        //       $data5 = mysqli_query($conn, $query5);
        //       $header = true;
        //     }
        //   }
        // }

        // count > new count(DELETE)*******************
        // if (count($option_id) > count($options)) {
        //   $header = true;
        //   $query4 = "DELETE FROM `option_table` WHERE Question_id_1 = '$ques_id'";
        //   $data4 = mysqli_query($conn, $query4);

        //   foreach ($options as $key => $value) {
        //     @$optid = $option_id[$i];
        //     $i++;
        //     $query5 = "INSERT INTO `option_table`(`Question_id_1`, `Option_description`) VALUES ('$ques_id','$value')";
        //     $data5 = mysqli_query($conn, $query5);
        //   }
        // }

      } else {
        echo "<script>alert('please enter options');</script>";
      }
    } else {
      $query = "UPDATE `question` SET `Question` = '$ques' , Question_option_type = '$drop' WHERE `Question_id`='$ques_id'"; //question update for text,file,....
      $data = mysqli_query($conn, $query);

      for ($i == 0; $i < count($option_id); $i++) { //options deleted if exists
        $optid = $option_id[$i];
        $query4 = "DELETE FROM `option_table` WHERE Option_id = '$optid'";
        $data4 = mysqli_query($conn, $query4);
        echo "<script>alert('deleted');</script>";

        header("location:ques_create.php?id=$s_id");
      }
    }
  } else {
    echo "<script>alert('please enter question & select ques_type');</script>";
  }
}

if ($header) {
  header("location:ques_create.php?id=$s_id");
}

if (isset($_POST['cancel'])) {
  header("location:ques_create.php?id=$s_id");
}

// join***************************
$query1 = "SELECT * FROM survey AS s LEFT JOIN question AS q ON s.Survey_id=q.Survey_id_1 LEFT JOIN option_table AS o ON q.Question_id=o.Question_id_1 WHERE s.Survey_id = '$s_id' AND q.Question_id = $ques_id ORDER BY q.Question_id";
$data1 = mysqli_query($conn, $query1);

while ($res = mysqli_fetch_array($data1)) {
  $arr_ques = $res['Question'];
  $ques_type = $res['Question_option_type'];
  $opt['arr_opt'] = $res['Option_description'];
  $opt['opt_id'] = $res['Option_id'];

  $mul_arr[] = $opt;
}

// echo $ques_type. "<br>";
// echo "<pre>"; 
// print_r($mul_arr);
// echo "</pre>";


include_once 'header.php';
include_once 'dashboard_upper.php';
?>
<style>
  .r1 {
    border: 1px solid black
  }

  .r2 {
    border: 1px solid red
  }

  .r3 {
    border: 1px solid green
  }

  .r4 {
    border: 1px solid yellow
  }

  .css_border {
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    border-radius: 10px;
  }
</style>

<!-- <section class="h-100 h-custom" > Ques screen -->
<div class="container-fluid py-5 border border-sucess">
  <div class="row d-flex justify-content-start align-items-left ms-3">
    <div class="col-lg-10 col-xl-10">
      <div class="card rounded-3 c_class css_border " style="border:inset;">
        <div class="card-body p-2 p-md-3 d-flex flex-column align-items-start " style="border-top:10px solid red;">

          <!-- <div class="col-12 p-1 mb-3 px-2" style="background-color:#dcdcdc"><h3><?php echo $Survey_name ?></h3></div> -->
          <form method="post">

            <!-- question  creation -->
            <div class="" id="parents_append" style="width: 100%;">
              <div class="my-2" id="hidediv">
                <div class="row d-flex mt-3 p-3">
                  <div class="row col-11 pt-3 p-2 ms-3 mb-2" style="border-left:10px solid red;background-color:#dcdcdc;">
                    <div class="col-1">
                      <p style="color:black ">Q.</p3>
                    </div>

                    <div class="col-8 p-0">
                      <input class="p-1 " type="text" style="width:100%" name="ques" value="<?php echo $arr_ques; ?>">
                    </div>
                    <div class=" col-3">
                      <select class="form-select" aria-label="Default select example" name="drop" id="drop1">

                        <option value="mcq" <?php if ($ques_type == "mcq") {
                                              echo "selected";
                                            } ?>>MCQ</option>

                        <option value="mcq_c" <?php if ($ques_type == "mcq_c") {
                                                echo "selected";
                                              } ?>>MCQ & Comments</option>
                        <option value="sc" <?php if ($ques_type == "sc") {
                                              echo "selected";
                                            } ?>>Single Choice</option>
                        <option value="sc_c" <?php if ($ques_type == "sc_c") {
                                                echo "selected";
                                              } ?>>Single Choice & Comments</option>
                        <option value="text" <?php if ($ques_type == "text") {
                                                echo "selected";
                                              } ?>>Text</option>
                        <option value="file" <?php if ($ques_type == "file") {
                                                echo "selected";
                                              } ?>>File</option>
                        <option value="date" <?php if ($ques_type == "date") {
                                                echo "selected";
                                              } ?>>Date</option>
                        <option value="time" <?php if ($ques_type == "time") {
                                                echo "selected";
                                              } ?>>Time</option>
                        <option value="rating" <?php if ($ques_type == "rating") {
                                                  echo "selected";
                                                } ?>>Rating scale</option>

                      </select>
                    </div>
                  </div>
                  <!--append divs*********************************  -->
                  <!-- mcq -->
                  <div class=" row col-11 mt-2 ms-3 pe-5 py-4  new_cmclass comm_mcq " id="mcq" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <div class=" mcq mb-3" style="display:none ">
                      <button type="button" class="mcq mcqopt_btn"> + add options</button>
                    </div>
                    <div class="row">
                      <div class="col-11 pe-5">
                        <div class="input-group mb-3">
                          <div class="input-group-text">
                            <input class="form-check-input mt-0" name="mcq_r1" type="checkbox" value="" aria-label="Checkbox for following text input" disabled>
                          </div>
                          <input type="text" class="form-control" name="opt[]" aria-label="Text input with checkbox">
                        </div>
                      </div>
                    </div>
                    <div class="mcq_append1">

                    </div>

                  </div>

                  <!-- mcq+comment -->
                  <div class=" row col-11 mt-2 ms-3 pe-5 py-4 new_cmclass comm_mcq" id="mcq_c" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <div class=" mcq_c" style="display:none">
                      <button type="button" class="mcqopt_c_btn mb-3">add options</button>
                    </div>
                    <div class="row">
                      <div class="col-11 pe-5">
                        <div class="input-group mb-3">
                          <div class="input-group-text">
                            <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input" disabled>
                          </div>
                          <input type="text" class="form-control" name="opt[]" aria-label="Text input with checkbox">
                        </div>
                      </div>
                    </div>
                    <div class="mcq_c_append">
                    </div>
                    <div class=" col-10 mb-3">
                      <textarea type="text" class="form-control p-3" placeholder="#type here" id="form3Example1q" name="opt_cmt[]" class="form-control"></textarea>
                    </div>

                  </div>
                  <!-- single choice -->
                  <div class=" row col-11 mt-2 ms-3 pe-5 py-4 new_cmclass comm_mcq" id="sc" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <div class="mb-3 sc" style="display:none">
                      <button type="button" class="sc_btn">add options</button>
                    </div>
                    <div class="row mb-3">
                      <div class="col-11 pe-5">
                        <div class="input-group">
                          <div class="input-group-text">
                            <input class="form-check-input mt-0" name="sc_r1" type="radio" value="" aria-label="Radio button for following text input" disabled>
                          </div>
                          <input type="text" class="form-control" name="opt[]" aria-label="Text input with radio button">
                        </div>
                      </div>
                    </div>
                    <div class="sc_append">
                    </div>

                  </div>
                  <!-- sc_c -->
                  <div class=" row col-11 mt-2 ms-3 pe-5 py-4 new_cmclass comm_mcq" id="sc_c" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <div class=" sc_c mb-3" style="display:none">
                      <button type="button" class="sc_c_btn">add options</button>
                    </div>
                    <div class="row mb-3">
                      <div class="col-11 pe-5">
                        <div class="input-group">
                          <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" value="" aria-label="Radio button for following text input" disabled>
                          </div>
                          <input type="text" class="form-control" name="opt[]" aria-label="Text input with radio button">
                        </div>
                      </div>
                    </div>
                    <div class="sc_c_append">
                    </div>
                    <div class="col-10 mb-3">
                      <textarea type="text" class="form-control p-3" placeholder="#type here" id="form3Example1q" name="opt_cmt[]" class="form-control"></textarea>
                    </div>

                  </div>

                  <!-- text -->
                  <div class=" row col-11 mt-2 ms-3 ps-3 pe-3 py-4 new_cmclass" id="text" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <textarea name="text" class="form-control p-4 mt-1 ms-5" style="width:80%" id="#" placeholder="#text" disabled></textarea>
                  </div>
                  <!-- file -->
                  <div class=" row col-11 mt-2 ms-3 ps-3 pe-3 py-4 new_cmclass" name="opt_cmt[]" id="file" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <div class=" col-8 ms-5 mb-2">
                      <input class="form-control" type="file" id="formFile" disabled>
                    </div>
                  </div>

                  <!-- date -->
                  <div class=" row col-11 mt-2 ms-3 pe-5 py-4 new_cmclass" id="date" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <div class="col-5 ms-5">
                      <input type="date" style="width:100%;height:7vh;" disabled>
                    </div>
                  </div>
                  <!-- time -->
                  <div class=" row col-11 mt-2 ms-3 pe-5 py-4 new_cmclass" id="time" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <div class="col-5 ms-5">
                      <input type="time" style="width:100%;height:7vh;" disabled>
                    </div>
                  </div>
                  <!-- rating -->
                  <div class=" row col-11 mt-2 ms-3 pe-5 py-4 new_cmclass" id="rating" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <div class="col-5 ms-5">
                      <label for="vol">Rate us (between 0 and 5):</label>
                      <input type="range" id="vol" name="vol" min="0" max="5" style="width:100%;height:7vh;" disabled>
                    </div>
                  </div>
                  <!--/append divs*********************************  -->


                  <!-- mcq********************* -->
                  <?php
                  $len = count($mul_arr);
                  $i = 0;
                  $two_textarea = true;
                  if ($ques_type == "mcq") { ?>
                    <div class=" row col-11 mt-2 ms-3 pe-5 py-4 new_div" style="border-left:10px solid red;background-color:#dcdcdc;">
                      <div class="row">

                        <div class="commclass mcq mb-3">
                          <button type="button" class="mcqopt_btn"> + add options</button>
                        </div>

                      </div>
                      <div class="row">
                        <?php
                        foreach ($mul_arr as $k => $v) {
                          $i++;
                          if (!empty($v['arr_opt'] )) {
                        ?>
                            <div class="row parent1">
                              <div class="col-10">
                                <div class="input-group mb-3">
                                  <div class="input-group-text"><input class="form-check-input mt-0" name="mcq_r" type="checkbox" value="" aria-label="Checkbox for following text input" disabled></div><input type="text" name="opt[]" value="<?php echo $v['arr_opt']; ?>" class="form-control delete_data" aria-label="Text input with checkbox">
                                </div>
                              </div>
                              <div class="col-1"> <button type="button" class="btn btn-danger btn_rem1"><i class="fa-solid fa-xmark"></i> </button> </div>
                            </div>
                      <?php }
                          if ($i == $len) {
                            echo "<div class='row  pe-0 me-0  mcq_append1'></div>";
                          }
                        }
                      } ?>
                      </div>

                      <!-- mcq_c********************* -->
                      <?php if ($ques_type == "mcq_c") {
                      ?>
                        <div class=" row col-11  ms-3 pe-5 py-4 new_div " style="border-left:10px solid red;background-color:#dcdcdc;">
                          <div class="row">
                            <div class="commclass mcq mb-3">
                              <button type="button" class="mcqopt_c_btn"> + add options</button>
                            </div>
                          </div>
                          <div class="row ">
                            <?php foreach ($mul_arr as $k => $v) {
                              $i++;
                              if ($i == count($mul_arr) && !preg_match(@$pattern, $v['arr_opt'])) {  ?>

                                <div class="row " id="parent2">
                                  <div class="col-10">
                                    <div class="input-group mb-3">
                                      <div class="input-group-text"><input class="form-check-input mt-0 " name="mcq_r" type="checkbox" value="" aria-label="Checkbox for following text input" disabled></div>
                                      <input type="text" name="opt[]" value="<?php echo $v['arr_opt']; ?>" class="form-control delete_data" aria-label="Text input with checkbox">
                                    </div>
                                  </div>
                                  <div class="col-1"> <button type="button" class="btn btn-danger btn_rem2 "><i class="fa-solid fa-xmark"></i> </button> </div>
                                </div>

                                <div class="row pe-0 me-0 mcq_c_append"> </div>
                                <div class="row col-10 ms-1">
                                  <textarea class="mb-2 ps-2 pt-2 rounded border border-primary delete_data" name="opt_cmt[]" placeholder="#comment here"></textarea>
                                </div>
                                <?php
                              } else {
                                if (@preg_match(@$pattern, $v['arr_opt'])) {
                                  $str = str_replace(str_split('#*&'), '', $v['arr_opt']);
                                ?>
                                  <div class="row pe-0 me-0 mcq_c_append"> </div>
                                  <div class="row col-10 ms-1">
                                    <textarea class="mb-2 ps-2 pt-2 rounded border border-primary delete_data" name="opt_cmt[]"><?php echo $str; ?></textarea>
                                  </div>
                                  <?php  } else {
                                  if ($i == 1) { ?>
                                    <div class="row " id="parent2">
                                      <div class="col-10">
                                        <div class="input-group mb-3">
                                          <div class="input-group-text"><input class="form-check-input mt-0 " name="mcq_r" type="checkbox" value="" aria-label="Checkbox for following text input" disabled></div>
                                          <input type="text" name="opt[]" value="<?php echo $v['arr_opt']; ?>" class="form-control delete_data" aria-label="Text input with checkbox">
                                        </div>
                                      </div>
                                      <div class="col-1"> <button type="button" class="btn btn-danger btn_rem2 "><i class="fa-solid fa-xmark"></i> </button> </div>
                                    </div>
                                  <?php } else {
                                  ?>
                                    <div class="row " id="parent2">
                                      <div class="col-10">
                                        <div class="input-group mb-3">
                                          <div class="input-group-text"><input class="form-check-input mt-0 " name="mcq_r" type="checkbox" value="" aria-label="Checkbox for following text input" disabled></div>
                                          <input type="text" name="opt[]" value="<?php echo $v['arr_opt']; ?>" class="form-control delete_data" aria-label="Text input with checkbox">
                                        </div>
                                      </div>
                                      <div class="col-1"> <button type="button" class="btn btn-danger btn_rem2 "><i class="fa-solid fa-xmark"></i> </button> </div>
                                    </div>

                                <?php }
                                } ?>
                          <?php }
                            }
                          } ?>
                          </div>
                          <!-- sc ************************-->
                          <?php if ($ques_type == "sc") { ?>
                            <div class=" row col-11 mt-2 ms-3 pe-5 py-4 new_div" style="border-left:10px solid red;background-color:#dcdcdc;">
                              <div class="row">


                                <div class="commclass mcq mb-3">
                                  <button type="button" class="sc_btn"> + add options</button>
                                </div>
                              </div>
                              <div class="row ">
                                <?php
                                foreach ($mul_arr as $k => $v) {
                                  $i++;
                                  if (!empty($v['arr_opt'] )) {
                                ?>
                                    <div class="row " id="parent3">
                                      <div class="col-10">
                                        <div class="input-group mb-3">
                                          <div class="input-group-text"><input class="form-check-input mt-0" name="mcq_r" type="radio" value="" aria-label="Checkbox for following text input" disabled></div><input type="text" name="opt[]" value="<?php echo $v['arr_opt']; ?>" class="form-control delete_data" aria-label="Text input with checkbox">
                                        </div>
                                      </div>
                                      <div class="col-1"> <button type="button" class="btn btn-danger btn_rem3"><i class="fa-solid fa-xmark"></i> </button> </div>
                                    </div>
                              <?php }
                                  if ($i == $len) {
                                    echo "<div class='sc_append row pe-0 me-0'>
                               
                        </div>";
                                  }
                                }
                              } ?>

                              <!-- sc_c********************* -->
                              <?php if ($ques_type == "sc_c") { ?>
                                <div class=" row col-11 mt-2 ms-3 pe-5 py-4 new_div" style="border-left:10px solid red;background-color:#dcdcdc;">
                                  <div class="row">

                                    <div class="commclass mcq mb-3">
                                      <button type="button" class="sc_c_btn"> + add options</button>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <?php foreach ($mul_arr as $k => $v) {
                                      $i++;
                                      if ($i == count($mul_arr) && !preg_match(@$pattern, $v['arr_opt'])) {  ?>

                                        <div class="row" id="parent4">
                                          <div class="col-10">
                                            <div class="input-group mb-3">
                                              <div class="input-group-text"><input class="form-check-input mt-0 " name="mcq_r" type="radio" value="" aria-label="Checkbox for following text input" disabled></div>
                                              <input type="text" name="opt[]" value="<?php echo $v['arr_opt']; ?>" class="form-control delete_data" aria-label="Text input with checkbox">
                                            </div>
                                          </div>
                                          <div class="col-1"> <button type="button" class="btn btn-danger btn_rem4"><i class="fa-solid fa-xmark"></i> </button> </div>
                                        </div>

                                        <div class="row pe-0 me-0  sc_c_append"> </div>
                                        <div class="row col-10 ms-1">
                                          <textarea class="mb-2 ps-2 pt-2 rounded border border-primary delete_data" name="opt_cmt[]" placeholder="#comment here"></textarea>
                                        </div>

                                        <?php
                                      } 
                                        elseif (@preg_match(@$pattern, $v['arr_opt'])) {
                                          $str = str_replace(str_split('#*&'), '', $v['arr_opt']);
                                        ?>
                                          <div class="row pe-0 me-0 sc_c_append"> </div>
                                          <div class="row col-10 ms-1">
                                            <textarea name="opt_cmt[]" class="mb-2 ps-2 pt-2 rounded border border-primary delete_data"><?php echo $str; ?></textarea>
                                          </div>
                                          <?php  } else {
                                          if ($i == 1) {  ?>
                                            <div class="row" id="parent4">
                                              <div class="col-10">
                                                <div class="input-group mb-3">
                                                  <div class="input-group-text"><input class="form-check-input mt-0 " name="mcq_r" type="radio" value="" aria-label="Checkbox for following text input" disabled></div>
                                                  <input type="text" name="opt[]" value="<?php echo $v['arr_opt']; ?>" class="form-control delete_data" aria-label="Text input with checkbox">
                                                </div>
                                              </div>
                                              <div class="col-1"> <button type="button" class="btn btn-danger btn_rem4"><i class="fa-solid fa-xmark"></i> </button> </div>
                                            </div>
                                          <?php } else { ?>
                                            <div class="row" id="parent4">
                                              <div class="col-10">
                                                <div class="input-group mb-3">
                                                  <div class="input-group-text"><input class="form-check-input mt-0 " name="mcq_r" type="radio" value="" aria-label="Checkbox for following text input" disabled></div>
                                                  <input type="text" name="opt[]" value="<?php echo $v['arr_opt']; ?>" class="form-control delete_data" aria-label="Text input with checkbox">
                                                </div>
                                              </div>
                                              <div class="col-1"> <button type="button" class="btn btn-danger btn_rem4"><i class="fa-solid fa-xmark"></i> </button> </div>
                                            </div>


                                  <?php }
                                        }
                                      
                                    }
                                  } ?>


                                  <!-- text******************* -->
                                  <?php if ($ques_type == "text") {
                                  ?>
                                    <div class=" row col-11 mt-2 ms-3 ps-3 pe-3 py-4 new_div" style="border-left:10px solid red;background-color:#dcdcdc;">
                                      <textarea name="text" class="form-control p-4 mt-1 ms-5" style="width:80%" id="#" placeholder="#text" disabled></textarea>
                                    </div>
                                  <?php
                                  } ?>
                                  <!-- date******************* -->
                                  <?php if ($ques_type == "date") {
                                  ?>
                                    <div class=" row col-11 mt-2 ms-3 pe-5 py-4 new_div" style="border-left:10px solid red;background-color:#dcdcdc;;">
                                      <div class="col-5 ms-5">
                                        <input type="date" style="width:100%;height:7vh;" disabled>
                                      </div>
                                    </div>
                                  <?php
                                  } ?>
                                  <!-- time******************* -->
                                  <?php if ($ques_type == "time") {
                                  ?>
                                    <div class=" row col-11 mt-2 ms-3 pe-5 py-4 new_div" style="border-left:10px solid red;background-color:#dcdcdc">
                                      <div class="col-5 ms-5">
                                        <input type="time" style="width:100%;height:7vh;" disabled>
                                      </div>
                                    </div>
                                  <?php
                                  } ?>
                                  <!-- file******************* -->
                                  <?php if ($ques_type == "file") {
                                  ?>
                                    <div class=" row col-11 mt-2 ms-3 ps-3 pe-3 py-4  new_div" style="border-left:10px solid red;background-color:#dcdcdc">
                                      <div class=" col-8 ms-5 mb-2">
                                        <input class="form-control" type="file" id="formFile" disabled>
                                      </div>
                                    </div>
                                  <?php
                                  } ?>
                                  <!-- rating******************* -->
                                  <?php if ($ques_type == "rating") {
                                  ?>
                                    <div class=" row col-11 mt-2 ms-3 pe-5 py-4 new_div" style="border-left:10px solid red;background-color:#dcdcdc;  ">
                                      <div class="col-5 ms-5">
                                        <label for="vol">Rate us (between 0 and 5):</label>
                                        <input type="range" id="vol" name="vol" min="0" max="5" style="width:100%;height:7vh;" disabled>
                                      </div>
                                    </div>
                                  <?php
                                  } ?>

                                  <?php
                                  ?>

                                  </div>
                                </div>
                                <!-- save & cancel button -->
                                <div class="col-12 d-flex justify-content-end my-3">
                                  <button type="submit" name="save" id="qcbtn" class="btn btn-success me-3 p-0" style="width:10%">save</button>
                                  <button type="submit" name="cancel" id="qc_btn" class="btn btn-danger p-0" style="width:10%">cancel</button>
                                </div>
                              </div>
                            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- </section> -->
<script>
  var drop_qtype = $('#drop1').val();

  $(document).ready(function() {
    $('#drop1').click(function() {
      var new_drop_qtype = $(this).val();
      if (new_drop_qtype == drop_qtype) {
        $(".new_div").show();
        $(".new_cmclass").hide();
      } else {
        $(".new_cmclass").hide(); //  hide all old divs
        $('#' + $(this).val()).show();
        $('.' + $(this).val()).show();
        $(".new_div").hide(); //when click on drop hide new_div
      }
    });
  });
  //delete previous value
  $(document).ready(function() {
    $('#drop1').click(function() {
      var new_drop_qtype1 = $(this).val();
      if (drop_qtype != new_drop_qtype1) {
        $('.delete_data').val('');
      }
    });
  });

  // create new input element 
  // MCQ
  $(document).ready(function() {
    $('.mcqopt_btn').click(function() {
      $('.mcq_append1').append('<div class="row parent1"  style="padding-right:0px;"> <div class="col-10"><div class="input-group mb-3"><div class="input-group-text"><input class="form-check-input mt-0" name="mcq_r" type="checkbox" value="" aria-label="Checkbox for following text input" disabled></div><input type="text" name="opt[]" class="form-control mcq_cval delete_data" aria-label="Text input with checkbox"></div></div><div class="col-1"> <button type="button" class="btn btn-danger btn_rem1"><i class="fa-solid fa-xmark"></i> </button>  </div></div>');
      // i++;
    });
    $('#parents_append').on('click', '.btn_rem1', function() {
      $(this).parents('.parent1').remove();
      $(this).parents('.mcq_cval').val("");
    });
  });
  // MCQ_C
  $(document).ready(function() {
    $('.mcqopt_c_btn').click(function() {
      $('.mcq_c_append').append('<div class="row" style="padding-right:0px;" id="parent2"><div class="col-10"><div class="input-group mb-3"><div class="input-group-text"><input class="form-check-input mt-0" type="checkbox" name="mcq_c_r" value="" aria-label="Checkbox for following text input" disabled></div><input type="text" class="form-control mcq_cval delete_data" name="opt[]" aria-label="Text input with checkbox"></div></div><div class="col-1"> <button type="button" class="btn btn-danger btn_rem2"><i class="fa-solid fa-xmark"></i></button></div>');
      // i++;
    });
    $('#parents_append').on('click', '.btn_rem2', function() {
      $(this).parents('#parent2').remove();
      $(this).parents('.mcq_cval').val("");
    })
  });
  // sc
  $(document).ready(function() {
    $('.sc_btn').click(function() {
      $('.sc_append').append('<div class="row" style="padding-right:0px;" id="parent3"> <div class="col-10"><div class="input-group mb-3"><div class="input-group-text"><input class="form-check-input mt-0" type="radio" name="sc_r" value="" aria-label="Checkbox for following text input" disabled></div><input type="text" class="form-control mcq_cval delete_data" name="opt[]" aria-label="Text input with checkbox"></div></div><div class="col-1"> <button type="button" class="btn btn-danger btn_rem3"><i class="fa-solid fa-xmark"></i> </button>  </div></div>');
      // i++;
    });
    $('#parents_append').on('click', '.btn_rem3', function() {
      $(this).parents('#parent3').remove();
      $(this).parents('.mcq_cval').val("");
    });
  });
  // sc_c
  $(document).ready(function() {
    $('.sc_c_btn').click(function() {
      $('.sc_c_append').append('<div class="row" style="padding-right:0px;"  id="parent4"> <div class="col-10"><div class="input-group mb-3"><div class="input-group-text"><input class="form-check-input mt-0" type="radio" value="" name="sc_cr" aria-label="Checkbox for following text input" disabled></div><input type="text" class="form-control mcq_cval delete_data" name="opt[]" aria-label="Text input with checkbox"></div></div><div class="col-1"> <button type="button" class="btn btn-danger btn_rem4"><i class="fa-solid fa-xmark"></i> </button>  </div></div>');
      // i++;
    });
    $('#parents_append').on('click', '.btn_rem4', function() {
      $(this).parents('#parent4').remove();
      $(this).parents('.mcq_cval').val("");
    });
  });
</script>





<?php
include_once 'dashboard_lower.php';
include_once 'footer.php';
?>