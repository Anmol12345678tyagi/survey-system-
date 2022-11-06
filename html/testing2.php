<?php
include_once 'header.php';
include_once 'dashboard_upper.php';
include_once 'conn.php';

$query = "SELECT * FROM `users` WHERE `user_id` = '18'";
$data = mysqli_query($conn, $query);
$res = mysqli_fetch_array($data);
// echo $res['user_name'];
$output = "";
$output .= $res['user_name'];
echo $output;

?>
<input type="text" id="inp1" placeholder="input">
<button type="submit" id="btn" class="btn btn-primary">Primary</button>

<script type="text/javascript">
    // $(document).ready(function() {
    //             $('#btn').click(function() {
    //                 alert("alert")
    //                 //     $.ajax({
    //                 //         url: "testing2.php",
    //                 //         type: "POST",
    //                 //         success: function(data) {    
    //                 //             // document.write(data);       
    //                 //             $('#inp1').val(data);
    //                 //         }
    //                 // $.ajax({
    //                 //         url: "testing3.php",
    //                 //         type: "POST",
    //                 //         data : {id : "hello"},
    //                 //         success: function() {

    //                 //         }
    //                 //     });
    //             })

                $(document).ready(function() {
                    $('#btn').click(function() {
                    //   alert("alert");
                    var data_id = "18";
                          $.ajax({
                            type: "POST",
                            url: "testing3.php",
                            data : {id : data_id},
                            success: function(data) {    
                                // document.write(data);
                                alert(data);       
                                // $('#inp1').val(data);
                            }
                        });
                });
            });



                // $(document).on('click','#btn',function(){
                //     alert("alert");
                //     $.ajax({
                //         url: "testing3.php",
                //         type: "POST",
                //         data : {id : "hello"},
                //         success: function() {

                //         }
                //     }) 
                // });
</script>


<?php
include_once 'footer.php';
include_once 'dashboard_lower.php';
?>