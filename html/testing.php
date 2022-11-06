<?php
include_once 'header.php';
// include_once 'dashboard_upper.php';
include_once 'conn.php';

$val = $_GET['val'];
if ($val) {
    $query4 = "DELETE FROM `answer` WHERE answer_id = '7' ";
    $data4 = mysqli_query($conn, $query4);
}
?>

<!-- **************************** -->

<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        function functionConfirm(msg, myYes, myNo) {
            var confirmBox = $("#confirm");
            confirmBox.find(".message").text(msg);
            confirmBox.find(".yes,.no").unbind().click(function() {
                confirmBox.hide();
            });
            confirmBox.find(".yes").click(myYes);
            confirmBox.find(".no").click(myNo);
            confirmBox.show();
        }
    </script>
    <style>
        .css_border {
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
            border-radius: 10px;
        }

        #confirm {
            display: none;
            background-color: white;
            /* border: 1px solid ; */
            margin-left: -100px;
            position: fixed;
            width: 400px;
            height: 150px;
            left: 50%;
            /* margin-left: -1px; */
            z-index: 1;
            padding: 8px;
            box-sizing: border-box;
            /* text-align: center; */
        }

        #confirm button.yes {
            background-color: green;
            display: inline-block;
            border-radius: 5px;
            border: 1px solid #aaa;
            padding: 5px;
            text-align: center;
            width: 80px;
            cursor: pointer;
            margin-top: 20px;
        }

        #confirm button.no {
            background-color: red;
            display: inline-block;
            border-radius: 5px;
            border: 1px solid #aaa;
            padding: 5px;
            text-align: center;
            width: 80px;
            cursor: pointer;
            margin-top: 20px;
        }

        #confirm .message {
            text-align: left;
        }
    </style>
</head>
<form method="post">

    <body>
        <div id="confirm" class="css_border">
            <div class="message flex d-flex justify-content-center pt-3"></div>
            <div class="flex d-flex justify-content-center">
                <button type="button" class="yes me-3"><a href="testing.php?val=<?php echo 'yes'; ?>">Yes</a> </button>
                <button name="#" type="button" class="no">No</button>
            </div>

        </div>
        <button name="submit" type="button" onclick='functionConfirm(" Do you want to delete ?", function yes() {
        // alert("deleted");
            },
            function no() {
            // alert("Not Sure")
            });'>delete</button>

</form>
</body>

</html>


<?php
// include_once 'dashboard_lower.php';
include_once 'footer.php';
?>