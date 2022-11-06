<?php
include_once 'conn.php';
//get survey id & name***************
$s_id = $_GET['id'];
@$qq_id = $_GET['qq_id'];
$flag = false;
$pattern = '/#*&$/';

// delete questions and options*********************
if (!empty($qq_id)) {
  $query4 = "DELETE question , option_table  FROM `question`LEFT JOIN `option_table` ON question.Question_id = option_table.Question_id_1 WHERE question.Question_id = $qq_id";
  $data4 = mysqli_query($conn, $query4);
  header("location:ques_create.php?id=$s_id");
}

if (isset($_POST['save'])) {
  extract($_POST);

  $options = $_POST['opt'];
  $options = array_filter($options);

  if ($drop == "mcq_c" || $drop == "sc_c") {
    $opt_cmt = $_POST['optcmt'];
    $opt_cmt = array_filter($opt_cmt);

    // if (empty($opt_cmt)) {
    //   $options[] = "no_text";
    // } 
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
  // echo "<pre>";
  // print_r($options);
  // echo "</pre><br>";

  // insert query************************************
  if ($ques != "" && $drop != "") {
    if ($drop == "mcq" || $drop == "mcq_c" || $drop == "sc" || $drop == "sc_c") {
      if ((!(@$options[0] == "no_text") && !empty($options))  || (empty($options) && (@$options[0] == "no_text"))) {
        $query = "INSERT INTO `question`(`Survey_id_1`, `Question`, `Question_option_type`) VALUES ('$s_id','$ques','$drop')";
        $data = mysqli_query($conn, $query);
        $flag = true;

        // get ques id***********************
        $query2 = "SELECT * FROM `question` WHERE Question_id=(SELECT MAX(Question_id) FROM question)";
        $data2 = mysqli_query($conn, $query2);
        $arr = mysqli_fetch_row($data2);
        $ques_id = $arr[0];

        //Insert into  Options************************
        foreach ($options as $inp) {
          $query3 = "INSERT INTO `option_table`(`Question_id_1`, `Option_description`) VALUES ('$ques_id','$inp')";
          $data3 = mysqli_query($conn, $query3);
          $flag = true;
        }
      } else {
        echo "<script>alert('please enter options');</script>";
      }
    } else {
      $query = "INSERT INTO `question`(`Survey_id_1`, `Question`, `Question_option_type`) VALUES ('$s_id','$ques','$drop')";
      $data = mysqli_query($conn, $query);
      $flag = true;
    }
  } else {
    echo "<script>alert('please enter question & select ques_type');</script>";
  }

  if ($flag) {
    // echo "<script>alert('added');</script>";
    // header("location:ques_create.php?id=$s_id");
  }
  if (isset($_POST['cancel'])) {
    header("location:ques_create.php?id=$s_id");
  }
}


// question & option fetch*************************

$query1 = "SELECT * FROM survey AS s LEFT JOIN question AS q ON s.Survey_id=q.Survey_id_1 LEFT JOIN option_table AS o ON q.Question_id=o.Question_id_1 WHERE s.Survey_id = '$s_id'  ORDER BY Question_id ";
$data1 = mysqli_query($conn, $query1);

while ($res = mysqli_fetch_array($data1)) {
  $Survey_name =  $res['survey_name'];
  $Survey_Category = $res['Survey_Category'];
  $Survey_description = $res['Survey_description'];

  $arr_ques = $res['Question'];
  $opt['ques_type'] = $res['Question_option_type'];
  $opt['arr_opt'] = $res['Option_description'];
  $opt['ques_id'] = $res['Question_id'];

  $mul_arr[$res['Survey_id']][$arr_ques][] = $opt;
}

// echo "<pre>";
// print_r($mul_arr);  
// echo "</pre>";
include_once 'header.php';
include_once 'dashboard_upper.php';

?>

<style>
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

  .eye_class {
    color: aqua;
  }

  .css_border {
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    border-radius: 10px;
  }
</style>

<!-- back button -->
<div class="row col-1 ms-1 mt-1">
  <a href="survey_list.php" style="width:100%;margin-left:0px"><i class="fa-solid fa-angles-left"></i></a>
</div>

<!-- card -->
<div class="row col-9 ms-5 css_border">
  <div class="card r5" style="width:100%;border-top:10px solid blue">
    <div class="card-body">

      <div class="flex d-flex justify-content-between" style="font-family:Gabriola;font-size:30px;margin-bottom:0px">
        <div class=""> SURVEY </div>
        <div class="">
          <a href="print_ques.php?s_id=<?php echo $s_id; ?>"><i class="fa-solid fa-eye eye_class"></i></a> |
          <a href="share.php?s_id=<?php echo $s_id ?>"><i class="fa-solid fa-share-nodes"></i></a>
        </div>
      </div>
      <hr class="r5 mt-0">
      <div class="row">
        <div class="col-md-3 pt-1 pe-0">
          <p>Survey Name :</p>
        </div>
        <div class="col-md-9 ps-0">
          <input type="text" class="form-control" style="border-left:5px solid blue;" value="<?php echo $Survey_name ?>" aria-label="Username" aria-describedby="basic-addon1" disabled>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3 pt-1 pe-0">
          <p>Survey Category :</p>
        </div>
        <div class="col-md-9 ps-0">
          <input type="text" class="form-control" style="border-left:5px solid blue;" value="<?php echo  $Survey_Category ?>" aria-label="Username" aria-describedby="basic-addon1" disabled>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3 pt-1 pe-0">
          <p>Survey description :</p>
        </div>
        <div class="col-md-9 ps-0">
          <textarea class="form-control py-4" style="border-left:5px solid blue;height:150px" id="floatingTextarea2" disabled><?php echo $Survey_description ?></textarea>
        </div>
      </div>

    </div>
  </div>
</div>



<!-- <section class="h-100 h-custom" > Ques screen -->
<div class="container-fluid py-5 pb-0">
  <div class="row d-flex  justify-content-start align-items-left ms-3">
    <div class="col-lg-10 col-xl-10">
      <div class="card rounded-3 c_class css_border" style="border:inset;">
        <div class="card-body p-2 p-md-3 d-flex flex-column align-items-start " style="border-top:10px solid red;">
          <form method="post">

            <!-- question  creation -->
            <div class="" style="font-family:Gabriola;font-size:30px"> Create New Question</div>
            <div class="" style="width: 100%;">
              <div class="my-2" id="hidediv" style="display:none">
                <div class="row d-flex mt-3 p-3">
                  <div class="row col-11 pt-3 p-2 ms-3 mb-2" style="border-left:10px solid red;background-color:#dcdcdc;">
                    <div class="col-1">
                      <p style="color:black ">Q.</p3>
                    </div>
                    <div class="col-8 p-0">
                      <input class="p-1 " type="text" style="width:100%" name="ques" placeholder="enter question">
                    </div>
                    <div class=" col-3">
                      <select class="form-select" aria-label="Default select example" name="drop" id="drop1">
                        <option value="">Q. Type</option>
                        <option value="mcq">MCQ</option>
                        <option value="mcq_c">MCQ & Comments</option>
                        <option value="sc">Single Choice</option>
                        <option value="sc_c">Single Choice & Comments</option>
                        <option value="text">Text</option>
                        <option value="file">File</option>
                        <option value="date">Date</option>
                        <option value="time">Time</option>
                        <option value="rating">Rating scale</option>
                      </select>
                    </div>
                    required
                  </div>
                  <!-- mcq -->
                  <div class=" row col-11 mt-2 ms-3 pe-5 py-4 commclass comm_mcq " id="mcq" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <div class="row">
                      <div class="col-11 pe-5">
                        <div class="input-group mb-3">
                          <div class="input-group-text">
                            <input class="form-check-input mt-0" name="mcq_r1" type="checkbox" value="" aria-label="Checkbox for following text input" disabled>
                          </div>
                          <input type="text" class="form-control delete_data" name="opt[]" aria-label="Text input with checkbox">
                        </div>
                      </div>
                    </div>
                    <div id="mcq_append">

                    </div>
                    <div class="commclass mcq" style="display:none ">
                      <button type="button" id="mcqopt_btn"> + add options</button>
                    </div>
                  </div>

                  <!-- mcq+comment -->
                  <div class=" row col-11 mt-2 ms-3 pe-5 py-4 commclass comm_mcq" id="mcq_c" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <div class="row">
                      <div class="col-11 pe-5">
                        <div class="input-group mb-3">
                          <div class="input-group-text">
                            <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input" disabled>
                          </div>
                          <input type="text" class="form-control delete_data" name="opt[]" aria-label="Text input with checkbox">
                        </div>
                      </div>
                    </div>
                    <div id="mcq_c_append">
                    </div>
                    <div class=" col-10 mb-3">
                      <textarea type="text" class="form-control p-3" placeholder="#type here" id="form3Example1q" name="optcmt[]" class="form-control"></textarea>
                    </div>
                    <div class="commclass mcq_c" style="display:none">
                      <button type="button" id="mcqopt_c_btn">add options</button>
                    </div>
                  </div>
                  <!-- single choice -->
                  <div class=" row col-11 mt-2 ms-3 pe-5 py-4 commclass comm_mcq" id="sc" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <div class="row mb-3">
                      <div class="col-11 pe-5">
                        <div class="input-group">
                          <div class="input-group-text">
                            <input class="form-check-input mt-0" name="sc_r1" type="radio" value="" aria-label="Radio button for following text input" disabled>
                          </div>
                          <input type="text" class="form-control delete_data" name="opt[]" aria-label="Text input with radio button">
                        </div>
                      </div>
                    </div>
                    <div id="sc_append">
                    </div>
                    <div class="commclass sc" style="display:none">
                      <button type="button" id="sc_btn">add options</button>
                    </div>
                  </div>
                  <!-- sc_c -->
                  <div class=" row col-11 mt-2 ms-3 pe-5 py-4 commclass comm_mcq" id="sc_c" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <div class="row mb-3">
                      <div class="col-11 pe-5">
                        <div class="input-group">
                          <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" value="" aria-label="Radio button for following text input" disabled>
                          </div>
                          <input type="text" class="form-control delete_data" name="opt[]" aria-label="Text input with radio button">
                        </div>
                      </div>
                    </div>
                    <div id="sc_c_append">
                    </div>
                    <div class="col-10 mb-3">
                      <textarea type="text" class="form-control p-3" placeholder="#type here" id="form3Example1q" name="optcmt[]" class="form-control"></textarea>
                    </div>
                    <div class="commclass sc_c" style="display:none">
                      <button type="button" id="sc_c_btn">add options</button>
                    </div>
                  </div>

                  <!-- text -->
                  <div class=" row col-11 mt-2 ms-3 ps-3 pe-3 py-4 commclass" id="text" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <textarea name="text" class="form-control p-4 mt-1 ms-5" style="width:80%" id="#" placeholder="#text" disabled></textarea>
                  </div>
                  <!-- file -->
                  <div class=" row col-11 mt-2 ms-3 ps-3 pe-3 py-4 commclass" id="file" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <div class=" col-8 ms-5 mb-2">
                      <input class="form-control" type="file" id="formFile" disabled>
                    </div>
                  </div>

                  <!-- date -->
                  <div class=" row col-11 mt-2 ms-3 pe-5 py-4 commclass" id="date" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <div class="col-5 ms-5">
                      <input type="date" style="width:100%;height:7vh;" disabled>
                    </div>
                  </div>
                  <!-- time -->
                  <div class=" row col-11 mt-2 ms-3 pe-5 py-4 commclass" id="time" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <div class="col-5 ms-5">
                      <input type="time" style="width:100%;height:7vh;" disabled>
                    </div>
                  </div>
                  <!-- rating -->
                  <div class=" row col-11 mt-2 ms-3 pe-5 py-4 commclass" id="rating" style="border-left:10px solid red;background-color:#dcdcdc;display:none;">
                    <div class="col-5 ms-5">
                      <label for="vol">Rate us (between 0 and 5):</label>
                      <input type="range" id="vol" name="vol" min="0" max="5" style="width:100%;height:7vh;" disabled>
                    </div>
                  </div>

                  <div class="col-12 d-flex justify-content-end mt-2">
                    <button type="submit" name="save" id="qcbtn" class="btn btn-success me-3 p-0" style="width:10%">save</button>
                    <button type="submit" name="cancel" id="qc_btn" class="btn btn-danger p-0" style="width:10%">cancel</button>
                  </div>
                </div>
              </div>


              <!-- add ques button -->
              <div class="">
                <button type="button" id="qbtn" class="btn m-3 btn-success"><i class="fa-solid fa-plus"></i> new question</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- </section> -->



<!-- survey description -->
<div class="container col-9 m-5 ms-5 " style="box-shadow:5px 5px;border:inset;">
  <div class="row" style="  border-top:10px solid blue">
    <div class="col-12 p-3 ">

      <div class="" style="font-family:Gabriola;font-size:30px;"> SURVEY Question</div>
      <hr class="r5 mb-5">

      <!-- question show -->
      <div class="row col-12 mb-3 ms-2 me-2" id="parent_div ">

        <form method="post">
          <?php

          foreach ($mul_arr as $s_id => $ques) {
            foreach ($ques as $q => $opt) {
              if (!empty($q)) {
                foreach ($opt as $k => $v) {
                  $ques_id =  $v['ques_id'];
                  $ques_type = $v['ques_type'];
                }

          ?>
                <div class="row col-10 rounded mb-3 pt-2 ms-2 r5 parent_delete" style="border-left:10px solid blue;">
                  <div class="row ms-2">
                    <div class="col-sm-10 p-0">
                      <div class='form-group input-group mb-3 pb-2 css_border px-3 r5' style="background-color:white-smoke;border-width:2px">
                        <div class='input-group-prepend mt-1 me-2'>
                          <span class=' '> <strong>Q.</strong> </span>
                        </div>
                        <div class="mt-1 " style="background-color:;" disabled><?php echo $q ?></div>
                      </div>
                    </div>
                    <div class="col-1 d-flex justify-content-between mx-2 pt-2 p-0">
                      <div class=""> <a href="test_env.php?ques_id=<?php echo $ques_id ?>&s_id=<?php echo $s_id ?>&ques_type=<?php echo $ques_type ?>"><i class="fa-solid fa-pen-to-square"></i></a></div>
                      <div class=""> <a onclick="return confirm('Do you want to delete')" href="ques_create.php?id=<?php echo $s_id ?>&qq_id=<?php echo $ques_id ?>"><i class="fa-sharp fa-solid fa-trash"></i></a></div>
                    </div>
                  </div>
                  <?php
                  $len = count($opt);
                  $i = 0;
                  foreach ($opt as $o => $b) {
                    if ($b['arr_opt'] != "") {
                      // sc**********************************
                      if ($b['ques_type'] == "sc") {
                        echo "<pre><i>" . "<input type='radio' name='' class='ms-2' disabled> ";
                        print_r($b['arr_opt']);
                        echo "</i></pre>";
                        // mcq**********************************
                      } elseif ($b['ques_type'] == "mcq") {
                        echo "<pre><i>" . "<input type='checkbox' name='checkbox' class='ms-2' disabled>  ";
                        print_r($b['arr_opt']);
                        echo "</i></pre>";
                        // sc_c**********************************
                      } elseif ($b['ques_type'] == "sc_c") {
                        $i++;
                        if ($i == count($opt) && !preg_match(@$pattern, $b['arr_opt'])) {
                          echo "<pre><i>" . "<input class='ms-2' type='radio' name='checkbox' disabled>  ";
                          print_r($b['arr_opt']);
                          echo "</i></pre>";

                  ?>
                          <div class="row col-10 ms-4">
                            <textarea class="mb-2 ps-2 pt-2 rounded border border-primary" placeholder="#enter text here............"></textarea>
                          </div>

                        <?php  } elseif (@preg_match(@$pattern, $b['arr_opt'])) {
                          $str = str_replace(str_split('#*&'), '', $b['arr_opt']);
                        ?>
                          <div class="row col-10 ms-4">
                            <textarea class="mb-2 ps-2 pt-2 rounded border border-primary" placeholder="<?php echo $str; ?>"></textarea>
                          </div>
                        <?php
                        } else {
                          echo "<pre><i>" . "<input class='ms-2' type='radio' name='radio' disabled>  ";
                          print_r($b['arr_opt']);
                          echo "</i></pre>";
                        }

                        // mcq_c**********************************
                      } elseif ($b['ques_type'] == "mcq_c") {
                        $i++;
                        if ($i == count($opt) && !preg_match(@$pattern, $b['arr_opt'])) {
                          echo "<pre><i>" . "<input class='ms-2' type='checkbox' name='checkbox' disabled>  ";
                          print_r($b['arr_opt']);
                          echo "</i></pre>";

                          echo  '<div class="row col-10 ms-4">
                          <textarea class="mb-2 ps-2 pt-2 rounded border border-primary" placeholder="#enter text here............"></textarea>
                        </div> ';

                        ?>

                        <?php  } elseif (@preg_match(@$pattern, $b['arr_opt'])) {
                          $str = str_replace(str_split('#*&'), '', $b['arr_opt']);
                        ?>
                          <div class="row col-10 ms-4">
                            <textarea class="mb-2 ps-2 pt-2 rounded border border-primary" placeholder="<?php echo $str; ?>"></textarea>
                          </div>
                <?php
                        } else {
                          echo "<pre><i>" . "<input class='ms-2' type='checkbox' name='checkbox' disabled>  ";
                          print_r($b['arr_opt']);
                          echo "</i></pre>";
                        }
                      }
                    } else {
                      if ($b['ques_type'] == "text") {
                        echo "<div class='input-group mb-2'>
                <span class='input-group-text' id='inputGroup-sizing-default'></span>
                <input type='text' placeholder='#text here' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default ' disabled>
              </div>";
                      } elseif ($b['ques_type'] == "date") {
                        echo "<div class='input-group mb-2'>
            <span class='input-group-text' id='inputGroup-sizing-default'></span>
            <input type='date' placeholder='#text here' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default ' disabled>
          </div>";
                      } elseif ($b['ques_type'] == "time") {
                        echo "<div class='input-group mb-2'>
            <span class='input-group-text' id='inputGroup-sizing-default'></span>
            <input type='time' placeholder='#text here' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default ' disabled>
          </div>";
                      } elseif ($b['ques_type'] == "rating") {

                        echo "<div class=' row col-10 ms-3  mb-2 mt-2 ' id='rating' style='background-color:#dcdcdc;'>
              <div class='col-6 ms-5'>
              <label class='mt-2' for='vol'>Rate us (between 0 and 5):</label>
              <input type='range' id='vol' name='vol' min='0' max='5' style='width:100%;height:7vh;' disabled>
              </div>
              </div>";
                      } elseif ($b['ques_type'] == "file") {
                        echo "<div class='input-group mb-2 row-6'>
            <span class='input-group-text' id='inputGroup-sizing-default'></span>
            <input type='file'  class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default' disabled>
          </div>";
                      }
                    }
                  }
                }
                ?>
                </div>
            <?php

            }
          }
            ?>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#qbtn').click(function() {
      $('#hidediv').show();
    });
  });
  $(document).ready(function() {
    $('#qc_btn').click(function() {
      $('#hidediv').hide();
    });
  });
  //delete previous value
  $(document).ready(function() {
    $('#drop1').click(function() {
      // var new_drop_qtype1 = $(this).val();
      // if (drop_qtype != new_drop_qtype1) {
      $('.delete_data').val('');
      // }
    });
  });


  $(document).ready(function() {
    $('#drop1').click(function() {
      $(".commclass").hide();
      $('#' + $(this).val()).show();
      $('.' + $(this).val()).show();
    });
  });

  // create new input element 
  // MCQ
  $(document).ready(function() {
    $('#mcq').on('click', '#mcqopt_btn', function() {
      $('#mcq_append').append('<div class="row parent1"> <div class="col-10"><div class="input-group mb-3"><div class="input-group-text"><input class="form-check-input mt-0" name="mcq_r" type="checkbox" value="" aria-label="Checkbox for following text input" disabled></div><input type="text" name="opt[]" class="form-control delete_data" aria-label="Text input with checkbox"></div></div><div class="col-1"> <button type="button" class="btn btn-danger btn_rem1"><i class="fa-solid fa-xmark"></i> </button>  </div></div>');
      // i++;
    });
    $('#mcq_append').on('click', '.btn_rem1', function() {
      $(this).parents('.parent1').remove();
    });
  });
  // MCQ_C
  $(document).ready(function() {
    $('#mcqopt_c_btn').click(function() {
      $('#mcq_c_append').append('<div class="row" id="parent2"><div class="col-10"><div class="input-group mb-3"><div class="input-group-text"><input class="form-check-input mt-0" type="checkbox" name="mcq_c_r" value="" aria-label="Checkbox for following text input" disabled></div><input type="text" class="form-control delete_data" name="opt[]" aria-label="Text input with checkbox"></div></div><div class="col-1"> <button type="button" class="btn btn-danger btn_rem2"><i class="fa-solid fa-xmark"></i> </button>  </div>');
      // i++;
    });
    $('#mcq_c_append').on('click', '.btn_rem2', function() {
      $(this).parents('#parent2').remove();
    })
  });
  // sc
  $(document).ready(function() {
    $('#sc_btn').click(function() {
      $('#sc_append').append('<div class="row" id="parent3"> <div class="col-10"><div class="input-group mb-3"><div class="input-group-text"><input class="form-check-input mt-0" type="radio" name="sc_r" value="" aria-label="Checkbox for following text input" disabled></div><input type="text" class="form-control delete_data" name="opt[]" aria-label="Text input with checkbox"></div></div><div class="col-1"> <button type="button" class="btn btn-danger btn_rem3"><i class="fa-solid fa-xmark"></i> </button>  </div></div>');
      // i++;
    });
    $('#sc_append').on('click', '.btn_rem3', function() {
      $(this).parents('#parent3').remove();
    });
  });
  // sc_c
  $(document).ready(function() {
    $('#sc_c_btn').click(function() {
      $('#sc_c_append').append('<div class="row" id="parent4"> <div class="col-10"><div class="input-group mb-3"><div class="input-group-text"><input class="form-check-input mt-0" type="radio" value="" name="sc_cr" aria-label="Checkbox for following text input" disabled></div><input type="text" class="form-control delete_data" name="opt[]" aria-label="Text input with checkbox"></div></div><div class="col-1"> <button type="button" class="btn btn-danger btn_rem4"><i class="fa-solid fa-xmark"></i> </button>  </div></div>');
      // i++;
    });
    $('#sc_c_append').on('click', '.btn_rem4', function() {
      $(this).parents('#parent4').remove();
    });
  });
</script>

<?php
include_once 'dashboard_lower.php';
include_once 'footer.php';
?>