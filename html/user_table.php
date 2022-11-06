<?php
include_once 'header.php';
include_once 'dashboard_upper.php';
$conn = mysqli_connect( 'localhost', 'root', '', 'survey' ) or die( 'connection failed' );

    $query = "SELECT * FROM `users`";
    $data = mysqli_query($conn, $query);

?>
<style>
     .fa-pen-to-square{color:green;}
    .fa-trash-can{color:red;}
    .fa-eye{color:yellow}
</style>

<div class="container-lg mt-5">
    <!-- <div class="d-flex flex-column  flx_1"> -->

    <div class="card bg-info  mb-3" >
        <div class="card-body">

            <div>
                <p style="color:white;font-weight:400;font-size:30px;text-align:center">User List</p>
            </div>
            <div style="margin-bottom:20px;">
                <button type="button" class="btn btn-primary"><a href="new_user.php">Add New User +</a></button>   
            </div>
            <div>
                <div class="table-responsive">
                    <form method="get">
                    <table class="table table-bordered border-dark" id="table">
                        <thead>
                            <tr>
                            <th scope="col">User Name</th>
                            <th scope="col">User Email</th>
                            <th scope="col">User Type</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                                if(mysqli_num_rows($data)>0){

                                    while($arr = mysqli_fetch_row($data)){
                                 
                                            echo 
                                                "<tr>
                                                    <td>$arr[1]</td>
                                                    <td style='width:40%'>$arr[2]</td>
                                                    <td style='width:20%'>$arr[7]</td>";?>
                                                    
                                                    <td>
                                                        <a href="update_user.php?id=<?php echo $arr[0]?>"><i class="fa-solid fa-pen-to-square"></i></a> |
                                                        <a  onclick="return confirm('Do you want to delete')"  href="delete.php?id=<?php echo $arr[0]?>"> <i class="fa-solid fa-trash-can"></i></a> 
                                                    </td>
                                                </tr>
                                <?php    }

                                }
                            
                            ?>
                        </tbody>
                    </table>
                </div>
                </form>
            </div>
            
        </div>
    </div>
  
  
    <!-- </div> -->
</div>


<!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->

<!-- <script>
    $(document).ready(function(){
        $('.btn1').click(function(){
            $(this).closest('tr').remove();
        });
    });

</script> -->





<?php
    require_once 'footer.php';
    include_once 'dashboard_lower.php';
?>


