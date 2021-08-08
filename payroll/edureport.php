<?php
include("php/dbconnect.php");
include("php/checklogin.php");
$errormsg= '';
if(isset($_POST['save']))
{
$paid =floatval(mysqli_real_escape_string($conn,$_POST['paid']));
$submitdate = mysqli_real_escape_string($conn,$_POST['submitdate']);
$transaction_remark = mysqli_real_escape_string($conn,$_POST['transaction_remark']);
$sid = mysqli_real_escape_string($conn,$_POST['sid']);
$stdid = mysqli_real_escape_string($conn,$_POST['stdid']);
$admissionadvance = floatval(mysqli_real_escape_string($conn,$_POST['admissionadvance']));
$tdeduction = floatval(mysqli_real_escape_string($conn,$_POST['tdeduction']));
$totalamount = floatval(mysqli_real_escape_string($conn,$_POST['totalamount']));
$firstyearfee = floatval(mysqli_real_escape_string($conn,$_POST['firstyearfee']));
$secondyearfee = floatval(mysqli_real_escape_string($conn,$_POST['secondyearfee']));
$thirdyearfee = floatval(mysqli_real_escape_string($conn,$_POST['thirdyearfee']));
$miscellaneousfee = floatval(mysqli_real_escape_string($conn,$_POST['miscellaneousfee']));
$academicyear = mysqli_real_escape_string($conn,$_POST['academicyear']);
$university = mysqli_real_escape_string($conn,$_POST['university']);

if($paid>0&&$totalamount>0){
$sql = "select contact,fees,balance  from student where id = '$stdid'";
$sq = $conn->query($sql);
$sr = $sq->fetch_assoc();
$contact = $sr['contact'];
$tbalance=$sr['balance'];
$sql = "select totalamount,paid  from edu_transaction where id = '$sid'";
$sq = $conn->query($sql);
$sr = $sq->fetch_assoc();
$oldbalance = $sr['totalamount']-$sr['paid'];
$sql = "UPDATE edu_transaction SET submitdate='$submitdate',admissionadvance='$admissionadvance',firstyearfee='$firstyearfee',secondyearfee='$secondyearfee',thirdyearfee='$thirdyearfee',miscellaneousfee='$miscellaneousfee',academicyear='$academicyear',university='$university',transcation_remark='$transaction_remark',paid='$paid',total_deduction='$tdeduction',totalamount='$totalamount' WHERE id='$sid'";
$conn->query($sql);
$tbalance =$tbalance-$oldbalance+($totalamount- $paid) ;
$sql = "update student set balance='$tbalance' where id = '$stdid'";
$conn->query($sql);
 echo '<script type="text/javascript">window.location="edureport.php?act=1";</script>';}
 else{
  echo '<script type="text/javascript">window.location="edureport.php?act=2";</script>';
}
}
if(isset($_REQUEST['act']) && @$_REQUEST['act']=="1")
{
$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong>Edu Payment Edit Successfully</div>";
}
if(isset($_REQUEST['act']) && @$_REQUEST['act']=="2")
{
$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>failure!</strong>please check input values</div>";
}
if(isset($_REQUEST['act']) && @$_REQUEST['act']=="3")
{
$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>failure!</strong>you already added a payment for selected month for the student</div>";
}
if(isset($_GET['action']) && $_GET['action']=="delete"){


  $sqll = "select * from edu_transaction where id='".$_GET['id']."'";
  $sqll = $conn->query($sqll);
  $srl = $sqll->fetch_assoc();	
  $spaid=$srl['paid'];
  $sbtpay=$srl['totalamount'];
  $stdid=$srl['stdid'];
  $sql = "select balance  from student where id ='".$stdid."'";
  $sq = $conn->query($sql);
  $sr = $sq->fetch_assoc();	
  $sb=$sr['balance'];
  $balance =$sb-($sbtpay-$spaid);
  $conn->query("UPDATE student SET balance='$balance' WHERE id='".$stdid."'");
  $conn->query("DELETE FROM edu_transaction WHERE id='".$_GET['id']."'");
  
    header("location: edureport.php");
    
    }
    if(isset($_GET['action']) && $_GET['action']=="sms"){
  
  
      $sqll = "select * from edu_transaction where id='".$_GET['id']."'";
      $sqll = $conn->query($sqll);
      $srl = $sqll->fetch_assoc();	
      $spaid=$srl['paid'];
      $paid=$srl['paid'];
      $sbtpay=$srl['balacetopay'];
      $btpay=$srl['balacetopay'];
      $stdid=$srl['stdid'];
      $tpa=$srl['total_payment'];
      $basic=$srl['totalfee'];
      $allowance=$srl['allowance'];
      $shdays=$srl['sh_days'];
      $pdays=$srl['present_days'];
      $oth=$srl['ot_hours'];
  
      $submitdate=$srl['submitdate'];
      $pf=$srl['pf'];
      $esi=$srl['esi'];
       $fest=$srl['festadvance'];
      $tea=$srl['texpense'];
      $un=$srl['unexpense'];
      $oth=$srl['othexpense'];
      $mn=$srl['mnadvance'];
      $sql = "select balance,contact  from student where id ='".$stdid."'";
      $sq = $conn->query($sql);
      $sr = $sq->fetch_assoc();	
      $sb=$sr['balance'];
      $contact=$sr['contact'];
      $ch = curl_init();
      $sms="PAYMENT%20SUBMITTED%20for%20$submitdate%2E%0D%0ABASIC%3A$basic%2E%0D%0AALLOWANCE%3A$allowance%2E%0D%0APRESENT%20DAYS%3A$pdays%2E%0D%0ASUNDAY/HOLYDAY%3A$shdays%2E%0D%0AOT%20HOURS%3A$oth%2E%0D%0ATOTAL%20SALARY%3A$tpa%0D%0ADEDUCTIONS%3A%20PF%3A$pf%20ESI%3A$esi%0D%0AFEST%20ADVANCE%3A$fest%20TEA%3A$tea%20Monthly%20Advance%3A$mn%0D%0AUnion%20Expence%3A$un%20Other%20Advance%3A$oth%0D%0ABALANCE%20TO%20PAY%3A$btpay%20%20PAID%3A$paid";
  // set URL and other appropriate options
  // curl_setopt($ch, CURLOPT_URL, "http://sms.bulksmsserviceproviders.com/api/send_http.php?authkey=3053537567524ee68a27afa19b325e27&mobiles=$contact&message=$sms&sender=BKAENG&route=B");
  // curl_setopt($ch, CURLOPT_HEADER, 0);
  
  // // grab URL and pass it to the browser
  // curl_exec($ch);
  
  // close cURL resource, and free up system resources
  curl_close($ch);
        header("location: edureport.php");
        
        }
  
        if(isset($_GET['action']) && $_GET['action']=="payb"){
  
          $balance=$_GET['bln'];
          echo $balance;
  
            
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
	<link href="css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" />	
	<link href="css/datepicker.css" rel="stylesheet" />	
	   <link href="css/datatable/datatable.css" rel="stylesheet" />
	   
    <script src="js/jquery-1.10.2.js"></script>	
    <script type='text/javascript' src='js/jquery/jquery-ui-1.10.1.custom.min.js'></script>
   <script type="text/javascript" src="js/validation/jquery.validate.min.js"></script>
 
		 <script src="js/dataTable/jquery.dataTables.min.js"></script>
		
		 
	
</head>
<?php
include("php/header.php");
?>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Education Service Payment Report  
						
						</h1>

                    </div>
                </div>
				
				
	
		
		

<div class="row" style="margin-bottom:20px;">
<div class="col-md-12">
<fieldset class="scheduler-border" >
    <legend  class="scheduler-border">Search:</legend>
<form class="form-inline" role="form" id="searchform" action="functions.php" method="post" name="upload_excel"   
                      enctype="multipart/form-data">
   <div class="form-group">
    <label for="email">Name</label>
    <input type="text" class="form-control" id="student" name="student">
  </div>
  
  <div class="form-group">
    <label for="email"> Month Of Payment </label>
    <input type="text" class="form-control" id="doj" name="doj" >
  </div>
  <div class="form-group">
    <label for="email"> Date Of Payment </label>
    <input type="text" class="form-control" id="dom" name="dom" >
  </div>
  <div class="form-group">
    <label for="email"> Department </label>
    <select  class="form-control" id="branch" name="branch" >
		<option value="" >Select Department</option>
                                    <?php
									$sql = "select * from branch where delete_status='0' and id='4' order by branch.branch  asc";
									$q = $conn->query($sql);
									
									while($r = $q->fetch_assoc())
									{
									echo '<option value="'.$r['id'].'"  '.(($branch==$r['id'])?'selected="selected"':'').'>'.$r['branch'].'</option>';
									}
									?>
	</select>
  </div>
  <div class="form-group">
    <label for="email"> Course </label>
    <select  class="form-control" id="course" name="course" >
		<option value="" >Select Course</option>
                                    <?php
									$sql = "select * from course where delete_status='0' order by course.course asc";
									$q = $conn->query($sql);
									
									while($r = $q->fetch_assoc())
									{
									echo '<option value="'.$r['id'].'"  '.(($course==$r['id'])?'selected="selected"':'').'>'.$r['course'].'</option>';
									}
									?>
	</select>
  </div>
   <button type="button" class="btn btn-success btn-sm" id="find" > Find </button>
  <button type="reset" class="btn btn-danger btn-sm" id="clear" > Clear </button>
  <button type="submit" class="btn btn-danger btn-sm" id="EduExport" name="EduExport" > Export </button>
    <!-- <button type="submit" class="btn btn-danger btn-sm" id="SMS" name="SMS" > Send Sms to All </button> -->

</form>
</fieldset>

</div>
</div>

<script type="text/javascript">
$(document).ready( function() {

/*
$('#doj').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: false,
        dateFormat: 'mm/yy',
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });
	1353c-p function 18cp 
*/
	
/******************/	
	 $("#doj").datepicker({
         
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'mm/yy',
        onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
        }
    });

    $("#doj").focus(function () {
        $(".ui-datepicker-calendar").hide();
        $("#ui-datepicker-div").position({
            my: "center top",
            at: "center bottom",
            of: $(this)
        });
    });

/*****************/
$("#dom").datepicker({
         
         changeMonth: true,
         changeYear: true,
         changeDate:true,
         showButtonPanel: true,
         dateFormat: 'dd/mm/yy',
         onClose: function(dateText, inst) {
             var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
             var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
             $(this).val($.datepicker.formatDate('D mm yy', new Date(year, month, date)));
         }
     });
 
     $("#dom").focus(function () {
         $(".ui-datepicker-calendar").hide();
         $("#ui-datepicker-div").position({
             my: "center top",
             at: "center bottom",
             of: $(this)
         });
     });
     
/*****************/
$('#student').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : 'ajx.php',
		      			dataType: "json",
						data: {
						   name_startsWith: request.term,
						   type: 'edureport'
						},
						 success: function( data ) {
						 
							 response( $.map( data, function( item ) {
							
								return {
									label: item,
									value: item
								}
							}));
						}
						
						
						
		      		});
		      	}
				/*,
		      	autoFocus: true,
		      	minLength: 0,
                 select: function( event, ui ) {
						  var abc = ui.item.label.split("-");
						  //alert(abc[0]);
						   $("#student").val(abc[0]);
						   return false;

						  },
                 */
  

						  
		      });
	

$('#find').click(function () {
mydatatable();
        });


$('#clear').click(function () {

$('#searchform')[0].reset();
mydatatable();
        });
		
function mydatatable()
{
        
              $("#subjectresult").html('<table class="table table-striped table-bordered table-hover" id="tSortable23"><thead><tr><th>Name/Contact</th><th>Pay Amount</th><th>Paid</th><th>Balance</th><th>Payment Date</th><th>View</th><th>Edit</th></tr></thead><tbody></tbody></table>');
			  
			    $("#tSortable23").dataTable({
							      'sPaginationType' : 'full_numbers',
							     "bLengthChange": false,
                  "bFilter": false,
                  "bInfo": false,
							       'bProcessing' : true,
							       'bServerSide': true,
							       'sAjaxSource': "datatable.php?"+$('#searchform').serialize()+"&type=edureport",
							       'aoColumnDefs': [{
                                   'bSortable': false,
                                   'aTargets': [-1] /* 1st one, start by the right */
                                                }]
                                   });


}
		
////////////////////////////
 $("#tSortable23").dataTable({
			     
                  'sPaginationType' : 'full_numbers',
				  "bLengthChange": false,
                  "bFilter": false,
                  "bInfo": false,
                  
                  'bProcessing' : true,
				  'bServerSide': true,
                  'sAjaxSource': "datatable.php?type=edureport",
				  
			      'aoColumnDefs': [{
                  'bSortable': false,
                  'aTargets': [-1] /* 1st one, start by the right */
              }]
            });

///////////////////////////		


	
});


function GetFeeForm(sid,sdt)
{

$.ajax({
            type: 'post',
            url: 'getfeeform.php',
            data: {student:sid,dat:sdt,req:'5'},
            success: function (data) {
              $('#formcontent').html(data);
			  $("#myModal").modal({backdrop: "static"});
            }
          });


}

</script>
<script>
function GetEditForm(sid)
{
  $.ajax({
            type: 'post',
            url: 'geteditform.php',
            data: {student:sid,req:'2'},
            success: function (data) {
              $('#formcontent').html(data);
			  $("#myModal").modal({backdrop: "static"});
            }
          });

}
</script>

		

<style>
#doj .ui-datepicker-calendar
{
display:none;
}

</style>
		
		<div class="panel panel-default">
                        <div class="panel-heading">
                            Manage Payments  
                        </div>
                        <div class="panel-body">
                            <div class="table-sorting table-responsive" id="subjectresult">
                                <table class="table table-striped table-bordered table-hover" id="tSortable23">
                                    <thead>
                                        <tr>
                                          
                                            <th>Name/Contact</th>                                            
                                            <th>Pay Amount</th>
											<th>Paid</th>
                      <th>Balance</th>
											<th>Payment Date</th>
											<th>View</th>
                      <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
								    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                     
	
	<!-------->
	
	<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Payment Report</h4>
        </div>
        <div class="modal-body"  id="formcontent">
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

	
    <!--------->
    			
            
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->

    <div id="footer-sec">
    Fees Management System | Developed For Riasec Academy | Powered By: <a href="https://www.cyaninnovations.in/" target="_blank">Cyan Innovations</a>
    </div>
   
  
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="js/jquery.metisMenu.js"></script>
       <!-- CUSTOM SCRIPTS -->
    <script src="js/custom1.js"></script>

    
</body>
</html>
