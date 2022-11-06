<?php
include_once 'conn.php';


$s_id = $_GET['s_id'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

if (isset($_POST['send'])) {
  extract($_POST);

  $invitation_key = md5($email.time());

  // insert into invitation table

  @$date = date('Y-m-d');
  @$invitedby = $_SESSION['id'];

  $query = "INSERT INTO `invitation`(`invitation_id`, `invitation_survey_id`,`invitated_name`,`invitated_email`,`invitation_msg`, `invitation_date`, `invited_by`,`invitation_key`) VALUES ('NULL','$s_id','$name','$email','$message','$date','$invitedby','$invitation_key')";
  $data = mysqli_query($conn, $query);

  //**********************************

  $url = "http://192.168.1.75/html/print_ques?s_id=$s_id&invitation_key=$invitation_key";
  $link = "<a href='$url'> please click here </a>";

  $mail = new PHPMailer(true);

  try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'tyagianmol1999@gmail.com';                     //SMTP username
    $mail->Password   = 'itsjvqmawjwvbufa';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $mail->setFrom('tyagianmol1999@gmail.com', "Anmol Tyagi");
    $mail->addAddress($email);    //Reciever's email

    $mail->isHTML(true);
    $mail->Subject = 'Mail';
    $mail->Body    = $message . $link;

    // $message =  $message . $link;

    $mail->send();
    echo "<script>
        alert('Succesfully invited!!');
        </script>";

    if ($data) {
      echo "<script>
         alert('Succesfully inserted!!');
         </script>";
    }
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }



  //     $mail->Username = 'tyagianmol1999@gmail.com'; // YOUR gmail email
  //     $mail->Password = 'itsjvqmawjwvbufa'; // YOUR gmail password


}

if (isset($_POST['cancel'])) {
  header("location:survey_list.php");
}

include_once 'header.php';
include_once 'dashboard_upper.php';

?>
<style>
  /* Border Shadow in <hr> tag */
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

<!-- card -->
<form onsubmit="return validateform();" method="post">
  <div class="row col-9 ms-5 my-5 css_border">
    <div class="card r5" style="width:100%;border-top:10px solid blue">
      <div class="card-body mb-3">

        <div class="flex d-flex justify-content-between" style="font-family:Gabriola;font-size:30px;margin-bottom:0px">
          INVITATION
        </div>
        <hr class="style-eight mt-0">

        <div class="row">
          <div class="col-md-3 pt-1 pe-0">
            <p>Name :</p>
          </div>
          <div class="col-md-9 ps-0">
            <input type="text" class="form-control" style="border-left:5px solid blue;" id="name"  name="name" placeholder="enter name........." aria-label="Username" aria-describedby="basic-addon1">
            <span id="nameprompt" class="text-danger"></span><br>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3 pt-1 pe-0">
            <p>Email :</p>
          </div>
          <div class="col-md-9 ps-0">
            <input type="text" class="form-control" style="border-left:5px solid blue;" id="email" name="email" placeholder="enter email........." aria-label="Username" aria-describedby="basic-addon1">
            <span id="emailprompt" class="text-danger"></span><br>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3 pt-1 pe-0 ">
            <p>Subject :</p>
          </div>
          <div class="col-md-9 ps-0">
            <textarea class="form-control py-3" style="border-left:5px solid blue;height:90px" id="subject" name="subject" placeholder="enter subject........."></textarea>
            <span id="subjectprompt" class="text-danger"></span><br>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-3 pt-1 pe-0">
            <p>Message :</p>
          </div>
          <div class="col-md-9 ps-0">
            <textarea class="form-control py-3" style="border-left:5px solid blue;height:150px" id="message" name="message" placeholder="enter message........."></textarea>
            <span id="messageprompt" class="text-danger"></span><br>
          </div>
        </div>

        <!-- <div class="row mt-3">
            <div class="col-md-3 pt-1 pe-0">
              <p>Link :</p>
            </div>
            <div class="col-md-9 ps-0">
              <input type="text" class="form-control" style="border-left:5px solid blue;" name="link" placeholder="paste link........." aria-label="Username" aria-describedby="basic-addon1">
            </div>
          </div> -->

        <!-- <div class="row mt-3">
          <div class="col-md-3 pt-1 pe-0">
            <p>From :</p>
          </div>
          <div class="col-md-9 ps-0">
            <input type="email" class="form-control" style="border-left:5px solid blue;" name="from" placeholder="enter sender's email........." value="" aria-label="Username" aria-describedby="basic-addon1">
          </div>
        </div> -->

        <div class="col-12 d-flex justify-content-end mt-2">
          <button type="submit" name="send" id="qcbtn" class="btn btn-success me-3 p-0" style="width:10%">Share</button>
          <button type="submit" name="cancel" id="qc_btn" class="btn btn-danger p-0" style="width:10%">Cancel</button>
        </div>


      </div>
    </div>
  </div>

</form>

<script src="../javascript_validation/share.js"></script>

<script src="../PHPMailer/src"></script>

<?php
include_once 'footer.php';
include_once 'dashboard_lower.php';
?>