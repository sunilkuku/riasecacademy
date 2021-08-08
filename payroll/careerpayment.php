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
$totalfee = floatval(mysqli_real_escape_string($conn,$_POST['totalfee']));
// $pf = floatval(mysqli_real_escape_string($conn,$_POST['pf']));
// $esi = floatval(mysqli_real_escape_string($conn,$_POST['esi']));
$tdeduction = floatval(mysqli_real_escape_string($conn,$_POST['tdeduction']));
$btpay = floatval(mysqli_real_escape_string($conn,$_POST['btpay']));

$othex = floatval(mysqli_real_escape_string($conn,$_POST['oth']));
$counsellingfee = floatval(mysqli_real_escape_string($conn,$_POST['counsellingfee']));
$monitoringfee = floatval(mysqli_real_escape_string($conn,$_POST['monitoringfee']));
$aptitudefee = floatval(mysqli_real_escape_string($conn,$_POST['aptitudefee']));
$personalityfee = floatval(mysqli_real_escape_string($conn,$_POST['personalityfee']));
$assessmentfee = floatval(mysqli_real_escape_string($conn,$_POST['assessmentfee']));

if($paid>0&&$btpay>0){
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $skey = '';

  for ($i = 0; $i < 12; $i++) {
      $skey .= $characters[mt_rand(0, strlen($characters) - 1)];
  }
$sql = "select contact,fees,balance  from student where id = '$sid'";
$sq = $conn->query($sql);
$sr = $sq->fetch_assoc();
$contact = $sr['contact'];
$tbalance=$sr['balance'];
$sql = "insert into fees_transaction(stdid,submitdate,counsellingfee,monitoringfee,aptitudefee,personalityfee,assessmentfee,transcation_remark,paid,totalfee,total_deduction,balacetopay,othexpense,skey) values('$sid','$submitdate','$counsellingfee','$monitoringfee','$aptitudefee','$personalityfee','$assessmentfee','$transaction_remark','$paid','$totalfee','$tdeduction','$btpay','$othex','$skey')";
$conn->query($sql);
$tbalance =$tbalance+($btpay- $paid) ;
$sql = "update student set balance='$tbalance' where id = '$sid'";
$conn->query($sql);
 echo '<script type="text/javascript">window.location="careerpayment.php?act=1";</script>';}
 else{
  echo '<script type="text/javascript">window.location="careerpayment.php?act=2";</script>';
}
}
if(isset($_REQUEST['act']) && @$_REQUEST['act']=="1")
{
$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Fees submit successfully</div>";
}
if(isset($_REQUEST['act']) && @$_REQUEST['act']=="2")
{
$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>failure!</strong>please check input values</div>";
}
if(isset($_REQUEST['act']) && @$_REQUEST['act']=="3")
{
$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>failure!</strong>you already added a payment for selected month for the student</div>";
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
                        <h1 class="page-head-line">Career Guidance Payment  
						
						</h1>

                    </div>
                </div>
				
				
				
    	<?php
		echo $errormsg;
		?>
		
		

<div class="row" style="margin-bottom:20px;">
<div class="col-md-12">
<fieldset class="scheduler-border" >
    <legend  class="scheduler-border">Search:</legend>
<form class="form-inline" role="form" id="searchform">
  <div class="form-group">
    <label for="email">Name/Contact</label>
    <input type="text" class="form-control" id="student" name="student">
  </div>
  
   <div class="form-group">
    <label for="email"> Date Of Joining </label>
    <input type="text" class="form-control" id="doj" name="doj" >
  </div>
  <div class="form-group">
    <label for="email"> Date Of Birth </label>
    <input type="text" class="form-control" id="dob" name="dob" >
  </div>
  <div class="form-group">
    <label for="email"> Department </label>
    <select  class="form-control" id="branch" name="branch" >
		<option value="" >Select Depatment</option>
                                    <?php
									$sql = "select * from branch where delete_status='0' and id='2' order by branch.branch  asc";
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
$("#dob").datepicker({
         
         changeMonth: true,
         changeYear: true,
         showButtonPanel: true,
         dateFormat: 'mm/yy',
         yearRange: "1970:<?php echo date('Y');?>",
         onClose: function(dateText, inst) {
             var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
             var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
             $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
         }
     });
 
     $("#dob").focus(function () {
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
						   type: 'studentname'
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
        
              $("#subjectresult").html('<table class="table table-striped table-bordered table-hover" id="tSortable22"><thead><tr><th>Name/Contact</th><th>Course</th><th>Balance</th><th>College/School</th><th>DOJ</th><th>Action</th></tr></thead><tbody></tbody></table>');
			  
			    $("#tSortable22").dataTable({
							      'sPaginationType' : 'full_numbers',
							     "bLengthChange": false,
                  "bFilter": false,
                  "bInfo": false,
							       'bProcessing' : true,
							       'bServerSide': true,
							       'sAjaxSource': "datatable.php?"+$('#searchform').serialize()+"&type=feesearch",
							       'aoColumnDefs': [{
                                   'bSortable': false,
                                   'aTargets': [-1] /* 1st one, start by the right */
                                                }]
                                   });


}
		
////////////////////////////
 $("#tSortable22").dataTable({
			     
                  'sPaginationType' : 'full_numbers',
				  "bLengthChange": false,
                  "bFilter": false,
                  "bInfo": false,
                  
                  'bProcessing' : true,
				  'bServerSide': true,
                  'sAjaxSource': "datatable.php?type=feesearch",
				  
			      'aoColumnDefs': [{
                  'bSortable': false,
                  'aTargets': [-1] /* 1st one, start by the right */
              }]
            });

///////////////////////////		


	
});


function GetFeeForm(sid)
{

$.ajax({
            type: 'post',
            url: 'getfeeform.php',
            data: {student:sid,req:'1'},
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
                                <table class="table table-striped table-bordered table-hover" id="tSortable22">
                                    <thead>
                                        <tr>
                                          
                                            <th>Name/Contact</th>                                            
                                            <th>Course</th>
											<th>Balance</th>
											<th>College/School</th>
											<th>DOJ</th>
											<th>Action</th>
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
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="fa fa-inr">Add Payment</h4>
        </div>
        <div class="modal-body" id="formcontent">
        
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
