<?php
include("php/dbconnect.php");
include("php/checklogin.php");
require_once('excel_reader2.php');
require_once('SpreadsheetReader.php');
$errormsg = '';
$action = "add";

$id="";
$emailid='';
$sname='';
$joindate = '';$birthdate = '';
$course = '';$coursetype = '';
$organization = '';
$remark='';
$contact='';
$balance = 0;
$fees='';
$about = '';
$branch='';
$rollno='';
$branchname='';
$place='';
$academicyear='';
$university='';
if(isset($_POST['save']))
{

$sname = mysqli_real_escape_string($conn,$_POST['sname']);
$joindate = mysqli_real_escape_string($conn,$_POST['joindate']);
$birthdate = mysqli_real_escape_string($conn,$_POST['birthdate']);
$course = mysqli_real_escape_string($conn,$_POST['course']);
$organization = mysqli_real_escape_string($conn,$_POST['organization']);
$contact = mysqli_real_escape_string($conn,$_POST['contact']);
$about = mysqli_real_escape_string($conn,$_POST['about']);
$emailid = mysqli_real_escape_string($conn,$_POST['emailid']);
$branch = mysqli_real_escape_string($conn,$_POST['branch']);
$rollno = mysqli_real_escape_string($conn,$_POST['rollno']);
$academicyear = mysqli_real_escape_string($conn,$_POST['academicyear']);
$university= mysqli_real_escape_string($conn,$_POST['university']);
$fees = mysqli_real_escape_string($conn,$_POST['fees']);
$place = mysqli_real_escape_string($conn,$_POST['place']);

$sql = "select * from course where id='".$course."'";

$q = $conn->query($sql);
if($q->num_rows==1)
{

$res = $q->fetch_assoc();
$coursename=$res['course'];
$coursetype=$res['coursetype'];
}
$sql2 = "select * from branch where id='".$branch."'";

$q2 = $conn->query($sql2);
if($q2->num_rows==1)
{

$res2 = $q2->fetch_assoc();
$branchname=$res2['branch'];
}
 if($_POST['action']=="add")
 {

//  $advancefees = mysqli_real_escape_string($conn,$_POST['advancefees']);
//  $balance = $fees-$advancefees;
 
  $q1 = $conn->query("INSERT INTO student (sname,joindate,contact,about,emailid,branch,balance,fees,rollno,birthdate,course,coursename,coursetype,organization,branchname,place,academicyear,university) VALUES ('$sname','$joindate','$contact','$about','$emailid','$branch','$balance','$fees','$rollno','$birthdate','$course','$coursename','$coursetype','$organization','$branchname','$place','$academicyear','$university')") ;
  
  $sid = $conn->insert_id;
  
 
   echo '<script type="text/javascript">window.location="student.php?act=1";</script>';
 
 }else
  if($_POST['action']=="update")
 {
	 //$fees = mysqli_real_escape_string($conn,$_POST['fees']);
	// $advancefees = mysqli_real_escape_string($conn,$_POST['advancefees']);
	// $balance = $fees-$advancefees;
 $id = mysqli_real_escape_string($conn,$_POST['id']);	
   $sql = $conn->query("UPDATE  student  SET  sname='$sname',branch='$branch',branchname='$branchname',course  = '$course',place='$place',coursename='$coursename',about='$about',coursetype='$coursetype',organization='$organization',contact='$contact', emailid  = '$emailid',joindate='$joindate',birthdate='$birthdate',fees='$fees', rollno='$rollno',academicyear='$academicyear',university='$university'  WHERE  id  = '$id'");
  echo '<script type="text/javascript">window.location="student.php?act=2";</script>';
 }



}




if(isset($_GET['action']) && $_GET['action']=="delete"){

$conn->query("UPDATE  student set delete_status = '1'  WHERE id='".$_GET['id']."'");	
header("location: student.php?act=3");

}


$action = "add";
if(isset($_GET['action']) && $_GET['action']=="edit" ){
$id = isset($_GET['id'])?mysqli_real_escape_string($conn,$_GET['id']):'';

$sqlEdit = $conn->query("SELECT * FROM student WHERE id='".$id."'");
if($sqlEdit->num_rows)
{
$rowsEdit = $sqlEdit->fetch_assoc();
extract($rowsEdit);
$action = "update";
}else
{
$_GET['action']="";
}

}


if(isset($_REQUEST['act']) && @$_REQUEST['act']=="1")
{
$errormsg = "<div class='alert alert-success'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Student Add successfully</div>";
}else if(isset($_REQUEST['act']) && @$_REQUEST['act']=="2")
{
$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> <strong>Success!</strong> Student Edit successfully</div>";
}
else if(isset($_REQUEST['act']) && @$_REQUEST['act']=="3")
{
$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Student Delete successfully</div>";
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fees Management</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="css/font-awesome.css" rel="stylesheet" />
       <!--CUSTOM BASIC STYLES-->
    <link href="css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	
	<link href="css/ui.css" rel="stylesheet" />
	<link href="css/datepicker.css" rel="stylesheet" />	
	
    <script src="js/jquery-1.10.2.js"></script>
	
    <script type='text/javascript' src='js/jquery/jquery-ui-1.10.1.custom.min.js'></script>
   
	
</head>
<?php
include("php/header.php");
?>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Students  
						
						<?php
						echo (isset($_GET['action']) && @$_GET['action']=="add" || @$_GET['action']=="edit")?
						' <a href="student.php" class="btn btn-primary btn-sm pull-right">Back <i class="glyphicon glyphicon-arrow-right"></i></a>':'<a href="student.php?action=add" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Add </a>';
						?>
                     
<?php

echo $errormsg;
?>
                    </div>
                </div>
		
				<a href="upload.php" class="btn btn-primary btn-sm pull-right">Back <i class="glyphicon glyphicon-arrow-right"></i></a><a href="upload.php" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Import </a>

        <?php 
		 if(isset($_GET['action']) && @$_GET['action']=="add" || @$_GET['action']=="edit")
		 {
		?>
		
			<script type="text/javascript" src="js/validation/jquery.validate.min.js"></script>
                <div class="row">
				
                    <div class="col-sm-10 col-sm-offset-1">
               <div class="panel panel-primary">
                        <div class="panel-heading">
                           <?php echo ($action=="add")? "Add Student": "Edit Student"; ?>
                        </div>
						<form action="student.php" method="post" id="signupForm1" class="form-horizontal">
                        <div class="panel-body">
						<fieldset class="scheduler-border" >
						 <legend  class="scheduler-border">Personal Information:</legend>
						<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Name* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="sname" name="sname" value="<?php echo $sname;?>"  />
								</div>
							</div>
						<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Contact* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="contact" name="contact" value="<?php echo $contact;?>" maxlength="10" />
								</div>
							</div>
							
						<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Department* </label>
								<div class="col-sm-10">
									<select  class="form-control" id="branch" name="branch" >
									<option value="" >Select Department</option>
                                    <?php
									$sql = "select * from branch where delete_status='0' order by branch.branch asc";
									$q = $conn->query($sql);
									
									while($r = $q->fetch_assoc())
									{
									echo '<option value="'.$r['id'].'"  '.(($branch==$r['id'])?'selected="selected"':'').'>'.$r['branch'].'</option>';
									}
									?>									
									
									</select>
								</div>
						</div>
						<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Course* </label>
								<div class="col-sm-10">
									<select  class="form-control" id="course" name="course" >
									<option value="" >Select Course</option>
                                    <?php
									$sql = "select * from course where delete_status='0' order by course.coursetype asc";
									$q = $conn->query($sql);
									
									while($r = $q->fetch_assoc())
									{
									echo '<option value="'.$r['id'].'"  '.(($course==$r['id'])?'selected="selected"':'').'>'.$r['course'].'('.$r['coursetype'].')</option>';
									}
									?>									
									
									</select>
								</div>
						</div>
						<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">DOB* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="birthdate" name="birthdate" placeholder="yy-mm-dd" value="<?php echo  ($birthdate!='')?date("Y-m-d", strtotime($birthdate)):'';?>" style="background-color: #fff;"  />
								<!--<?php echo ($action=="update")?"disabled":""; ?> -->
								
								</div>
							</div>
						<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">DOJ* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="joindate" name="joindate" placeholder="yy-mm-dd" value="<?php echo  ($joindate!='')?date("Y-m-d", strtotime($joindate)):'';?>" style="background-color: #fff;"  />
								<!--<?php echo ($action=="update")?"disabled":""; ?> -->
								
								</div>
							</div>
	
							<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Admission Number* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="rollno" name="rollno" value="<?php echo $rollno;?>" maxlength="10" />
								</div>
							</div>

                            <div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Academic Year* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="academicyear" name="academicyear" value="<?php echo $academicyear;?>" maxlength="10" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">University* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="university" name="university" value="<?php echo $university;?>" maxlength="10" />
								</div>
							</div>

							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Organization/School </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="organization" name="organization" value="<?php echo $organization;?>" maxlength="30" />
								</div>
							</div>

						 </fieldset>
						
						
							<fieldset class="scheduler-border" >
						 <legend  class="scheduler-border">Payment Information:</legend>
						<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Basic Fees* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="fees" name="fees" value="<?php echo $fees;?>"  />
								</div>
						</div>
						<!-- 
						<?php
						if($action=="add")
						{
						?>
						<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Initial Payment* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="advancefees" name="advancefees" readonly   />
								</div>
						</div>
						<?php
						}
						?> -->
<!-- 						
						<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Balance </label>
								<div class="col-sm-10">
									<input type="text" class="form-control"  id="balance" name="balance" value="<?php echo $balance;?>" disabled />
								</div>
						</div>
						 -->
						
						
							
							<?php
						if($action=="add")
						{
						?>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="Password">Payment Remark </label>
								<div class="col-sm-10">
	                        <textarea class="form-control" id="remark" name="remark"><?php echo $remark;?></textarea >
								</div>
							</div>
						<?php
						}
						?>
							
							</fieldset>
							
							 <fieldset class="scheduler-border" >
						 <legend  class="scheduler-border">Optional Information:</legend>
						 <div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Place </label>
								<div class="col-sm-10">
									
									<input type="text" class="form-control" id="place" name="place" value="<?php echo $place;?>"  />
								</div>
						    </div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="Password">About </label>
								<div class="col-sm-10">
	                        <textarea class="form-control" id="about" name="about"><?php echo $about;?></textarea >
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Email Id </label>
								<div class="col-sm-10">
									
									<input type="text" class="form-control" id="emailid" name="emailid" value="<?php echo $emailid;?>"  />
								</div>
						    </div>
							</fieldset>
						
						<div class="form-group">
								<div class="col-sm-8 col-sm-offset-2">
								<input type="hidden" name="id" value="<?php echo $id;?>">
								<input type="hidden" name="action" value="<?php echo $action;?>">
								
									<button type="submit" name="save" class="btn btn-primary">Save </button>
								 
								   
								   
								</div>
							</div>
                         
                           
                           
                         
                           
                         </div>
							</form>
							
                        </div>
                            </div>
            
			
                </div>
               

			   
			   
		<script type="text/javascript">
		

		$( document ).ready( function () {			
			
		$( "#joindate" ).datepicker({
dateFormat:"yy-mm-dd",
changeMonth: true,
changeYear: true,
yearRange: "1970:<?php echo date('Y');?>"
});	
$( "#birthdate" ).datepicker({
dateFormat:"yy-mm-dd",
changeMonth: true,
changeYear: true,
yearRange: "1970:<?php echo date('Y');?>"
});	

		
		if($("#signupForm1").length > 0)
         {
		 
		 <?php if($action=='add')
		 {
		 ?>
		 
			$( "#signupForm1" ).validate( {
				rules: {
					sname: "required",
					joindate: "required",
					emailid: "email",
					branch: "required",
					course:"required"
					contact: {
						required: true,
						digits: true
					},
					
					fees: {
						required: true,
						digits: true
					},
					
				
					
				},
			<?php
			}else
			{
			?>
			
			$( "#signupForm1" ).validate( {
				rules: {
					sname: "required",
					joindate: "required",
					emailid: "email",
					branch: "required",
					course: "required",

					contact: {
						required: true,
						digits: true
					}
					
				},
			
			
			
			<?php
			}
			?>
				
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block" );

					// Add `has-feedback` class to the parent div.form-group
					// in order to add icons to inputs
					element.parents( ".col-sm-10" ).addClass( "has-feedback" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent( "label" ) );
					} else {
						error.insertAfter( element );
					}

					// Add the span element, if doesn't exists, and apply the icon classes to it.
					if ( !element.next( "span" )[ 0 ] ) {
						$( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );
					}
				},
				success: function ( label, element ) {
					// Add the span element, if doesn't exists, and apply the icon classes to it.
					if ( !$( element ).next( "span" )[ 0 ] ) {
						$( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
					}
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-10" ).addClass( "has-error" ).removeClass( "has-success" );
					$( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
				},
				unhighlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-10" ).addClass( "has-success" ).removeClass( "has-error" );
					$( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
				}
			} );
			
			}
			
		} );
		
		
		
		$("#fees").keyup( function(){
		$("#advancefees").val("");
		$("#balance").val(0);
		var fee = $.trim($(this).val());
		if( fee!='' && !isNaN(fee))
		{
		$("#advancefees").removeAttr("readonly");
		$("#balance").val(fee);
		$('#advancefees').rules("add", {
            max: parseInt(fee)
        });
		
		}
		else{
		$("#advancefees").attr("readonly","readonly");
		}
		
		});
		
		
		
		
		$("#advancefees").keyup( function(){
		
		var advancefees = parseInt($.trim($(this).val()));
		var totalfee = parseInt($("#fees").val());
		if( advancefees!='' && !isNaN(advancefees) && advancefees<=totalfee)
		{
		var balance = totalfee-advancefees;
		$("#balance").val(balance);
		
		}
		else{
		$("#balance").val(totalfee);
		}
		
		});
		
		
	</script>


			   
		<?php
		}else{
		?>
		
		 <link href="css/datatable/datatable.css" rel="stylesheet" />
		 
		
		 
		 
		<div class="panel panel-default">
                        <div class="panel-heading">
                            Manage Student  
                        </div>
                        <div class="panel-body">
                            <div class="table-sorting table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="tSortable22">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name/Contact</th>
											<th>DOB</th>
                                            <th>DOJ</th>
											<th>Department</th>
											<th>Course-Info</th>
											<th>University</th>
                                            <th>Balance</th>
											<th>Roll No</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$sql = "select * from student where delete_status='0'";
									$q = $conn->query($sql);
									$i=1;
									while($r = $q->fetch_assoc())
									{
									
									echo '<tr '.(($r['balance']>0)?'class="danger"':'').'>
                                            <td>'.$i.'</td>
                                            <td>'.$r['sname'].'<br/>'.$r['contact'].'</td>
											<td>'.date("d M y", strtotime($r['birthdate'])).'</td>
                                            <td>'.date("d M y", strtotime($r['joindate'])).'</td>
											<td>'.$r['branchname'].'</td>
											<td>'.$r['coursename'].'('.$r['coursetype'].')</td>
											<td>'.$r['university'].'</td>
                                            <td>'.$r['balance'].'</td>
											<td>'.$r['rollno'].'</td>
											<td>
											<a href="student.php?action=edit&id='.$r['id'].'" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
											
											<a onclick="return confirm(\'Are you sure you want to delete this record\');" href="student.php?action=delete&id='.$r['id'].'" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a> </td>
											
                                        </tr>';
										$i++;
									}
									?>
									
                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                     
	<script src="js/dataTable/jquery.dataTables.min.js"></script>
    
     <script>
         $(document).ready(function () {
             $('#tSortable22').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bInfo": false,
    "bAutoWidth": true });
	
         });
		 
	
    </script>
		
		<?php
		}
		?>
				
				
            
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <div id="footer-sec">
	Fees Management System | Developed For Riasec Academy | Powered By: <a href="https://www.cyaninnovations.in/" target="_blank">Cyan Innovations</a>
    </div>
   
  
    <script src="js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="js/jquery.metisMenu.js"></script>
       <!-- CUSTOM SCRIPTS -->
    <script src="js/custom1.js"></script>

    
</body>
</html>
