<?php require_once('header.php'); ?>
<?php
//$id=$_SESSION['cust_id'];
include('config.php');?>


<?php
// Check if the customer is logged in or not

if(!isset($_SESSION['customer'])) {
    header('location: '.BASE_URL.'logout.php');
    exit;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'],0));
    $total = $statement->rowCount();
    if($total) {
        header('location: '.BASE_URL.'logout.php');
        exit;
    }
}
if(isset($_POST['submit']))
{
	$query=
$uid=$_SESSION['customer']['cust_id'];
$blog=$_POST['blog'];
$ex=mysqli_query($con,"SELECT cust_name from tbl_customer where cust_id='".$uid."'");
$exx=mysqli_fetch_array($ex);
$ew=mysqli_query($con,"SELECT cust_cname from tbl_customer where cust_id='".$uid."'");
$eww=mysqli_fetch_array($ew);
$pic=mysqli_query($con,"SELECT photo from tbl_customer where cust_id='".$uid."'");
$picc=mysqli_fetch_array($pic);

$statement = $con->prepare("insert into blog(cust_id, cust_name,cust_cname,cust_blog,cust_dp)values('".$uid."','".$exx['cust_name']."','".$eww['cust_cname']."','".$blog."','".$picc['photo']."') ");
		$statement->execute();
		
			$path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
	}}
		// removing the existing photo
    	//if($_SESSION['customer']['photo']!='') {
    		//unlink('assets/uploads/'.$_SESSION['customer']['photo']);	
    	//}

    	// updating the data
    	$final_name = 'customer-blog'.$_SESSION['customer']['cust_id'].'.'.$ext;
        move_uploaded_file( $path_tmp, './assets/uploads/'.$final_name );
        $_SESSION['customer']['photo'] = $final_name;

        // updating the database
		$statement = $pdo->prepare("UPDATE blog SET photo=? WHERE cust_id=?");
		$statement->execute(array($final_name,$_SESSION['customer']['cust_id']));
		
		
		
		
		
		
echo'<script> alert("Your blog has been successfully filled.")</script>';
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
   <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
<style>
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  float: right;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

.button1 {
  background-color: white; 
  color: black; 
  border: 2px solid #4CAF50;
}

</style>
</head>
</html>
 
 <?php require_once('customer-sidebar.php'); ?>
 
 <body>
 <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
 <div class="form-group">
							<label for="" class="col-sm-3 control-label">Blog:</label>
							<div class="col-sm-8">
								<textarea name="blog" class="form-control" cols="30" rows="10" id="blog"></textarea>
							</div><br><br>
							
							<label for="" class="col-sm-3 control-label">Attach Photo:</label>
							<div class="col-sm-8">
								 <input type="file" class="form-control" name="photo" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="submit">Submit</button>
							</div>
							
						</div>
						</form>
 
  <?php require_once('footer.php'); ?>
 </body>