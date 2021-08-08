<?php
include("php/dbconnect.php");

if(isset($_POST['req']) && $_POST['req']=='1') 
{

$sid = (isset($_POST['student']))?mysqli_real_escape_string($conn,$_POST['student']):'';

 $sql = "select id,sname,balance,fees,contact,branchname,coursename from student where id='".$sid."'";
$q = $conn->query($sql);
if($q->num_rows>0)
{

$res = $q->fetch_assoc();
echo '  <form class="form-horizontal" id ="signupForm1" action="careerpayment.php" method="post">
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Name:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" disabled  value="'.$res['sname'].'" >
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-2" for="email">Date:</label>
    <div class="col-sm-10">
	
      <input type="text" class="form-control" name="submitdate"  id="submitdate" style="background:#fff;" />
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2">Registration:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$res['fees'].'" name="totalfee" id="totalfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Counselling:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="counsellingfee" id="counsellingfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Monitoring:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="monitoringfee" id="monitoringfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Aptitude Test:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="aptitudefee" id="aptitudefee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Personality Test:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="personalityfee" id="personalityfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Assessment:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="assessmentfee" id="assessmentfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" >Others:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="oth" id="oth"  value="0" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" >Total Deduction:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="tdeduction" value="0" id="tdeduction" onchange="totalbt()"/>
    </div>
  </div>
   <div class="form-group">
    <label class="control-label col-sm-2">Total Amount:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="btpay" id="btpay"  />
	  <input type="hidden" value="'.$res['id'].'" name="sid">
    </div>
  </div>
  <div class="form-group">
  <label class="control-label col-sm-2" >Paid:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" name="paid"  id="paid"  />
  </div>
</div>

   <div class="form-group">
    <label class="control-label col-sm-2" >Payment Method:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="transaction_remark" id="transaction_remark"/>
    </div>
  </div>

  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary" name="save">Save</button>
    </div>
  </div>
</form>
<script>

function totalbt() {
  var first_number = (parseFloat)(document.getElementById("totalfee").value);
  var second_number = (parseFloat)(document.getElementById("counsellingfee").value);
  var third_number = (parseFloat)(document.getElementById("monitoringfee").value);
  var fourth_number = (parseFloat)(document.getElementById("aptitudefee").value);
  var fifth_number = (parseFloat)(document.getElementById("personalityfee").value);
  var sixth_number = (parseFloat)(document.getElementById("assessmentfee").value);
  var seventh_number = (parseFloat)(document.getElementById("oth").value);
  var eight_number = (parseFloat)(document.getElementById("tdeduction").value);

  var result=(first_number+second_number+third_number+fourth_number+fifth_number+sixth_number+seventh_number)-eight_number;

document.getElementById("btpay").value = result;
}

</script>
<script type="text/javascript">
$(document).ready( function() {
$("#submitdate").datepicker( {
        changeMonth: true,
        changeYear: true,
       
        dateFormat: "yy-mm-dd",
        
    });
	
	
///////////////////////////

$( "#signupForm1" ).validate( {
				rules: {
					submitdate: "required",
					
					paid: {
						required: true,
						number: true,
          }	,
          totalfees: {
						required: true,
						number: true,
					},	
					
          btpay: {
						required: true,
						number: true,
					}	
				},
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

					
					if ( !element.next( "span" )[ 0 ] ) {
						$( "<span class=\'glyphicon glyphicon-remove form-control-feedback\'></span>" ).insertAfter( element );
					}
				},
				success: function ( label, element ) {
					if ( !$( element ).next( "span" )[ 0 ] ) {
						$( "<span class=\'glyphicon glyphicon-ok form-control-feedback\'></span>" ).insertAfter( $( element ) );
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


//////////////////////////	
	
	
	
});

</script>
';

}else
{
echo "Something Goes Wrong! Try After sometime.";
}


}

if(isset($_POST['req']) && $_POST['req']=='2') 
{

$sid = (isset($_POST['student']))?mysqli_real_escape_string($conn,$_POST['student']):'';
$sql = "select id,paid,submitdate,balacetopay from fees_transaction  where stdid='".$sid."'";
$fq = $conn->query($sql);
$fqq = $conn->query($sql);

if($fq->num_rows>0)
{


 $sql = "select * from student as s,branch as b where id='".$sid."'";
$sq = $conn->query($sql);
$sr = $sq->fetch_assoc();

echo '
<h4>Student Info</h4>
<div class="table-responsive">
<table class="table table-bordered">
<tr>
<th>Name</th>
<td>'.$sr['sname'].'</td>
<th>Department</th>
<td>'.$sr['branchname'].'</td>
</tr>
<tr>
<th>Contact</th>
<td>'.$sr['contact'].'</td>
<th>Joining Date</th>
<td>'.date("d-m-Y", strtotime($sr['joindate'])).'</td>
</tr>


</table>
</div>
';


echo '
<h4>Payment Info</h4>
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
      <tr>
        <th>Date</th>
        <th>Total Amount</th>
        <th>Paid</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>';
	$totapaid = 0;
  $balance = 0;
while($res = $fq->fetch_assoc())
{
$totapaid+=$res['paid'];
$totalpay=$res['balacetopay'];
$paymentmethod=$res['transcation_remark'];
$balance=$totalpay-$totapaid;
        echo '<tr>
        <td>'.date("d-m-Y", strtotime($res['submitdate'])).'</td>
        <td>'.$res['balacetopay'].'</td>
        <td>'.$res['paid'].'</td>
        <td>        
        <a onclick="return confirm(\'Are you sure you want to delete this record\');" href="careerreport.php?action=delete&id='.$res['id'].'" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a> </td>      </tr>' ;
}
      
echo '	  
    </tbody>
  </table>
 </div> 
 
<table style="width: 300px;" >
<tr>
<th>Total Payment: 
</th>
<td>'.$totalpay.'
</td>
</tr>

<tr>
<th>Total Paid: 
</th>
<td>'.$totapaid.'
</td>
</tr>
<tr>
<th>Balance: 
</th>
<td>'.$balance.'
</td>
</tr>
<tr>
<th>Payment Method: 
</th>
<td>'.$paymentmethod.'
</td>
</tr>
</table>
 ';


 }
else
{
echo 'No Payements submit.';
}
 
}

		 
if(isset($_POST['req']) && $_POST['req']=='3') 
{

  $sid = (isset($_POST['student']))?mysqli_real_escape_string($conn,$_POST['student']):'';
  $sql = "select * from fees_transaction  where id='".$sid."'";
  $fq = $conn->query($sql);
  $fqq = $conn->query($sql);
  $email='';
  $frq=$fq->fetch_assoc();
  if($fq->num_rows>0)
  {
  
  
   $sql = "select * from student where id='".$frq['stdid']."'";
  $sq = $conn->query($sql);
  $sr = $sq->fetch_assoc();
  $email=$sr['emailid'];
echo '
<h4>STUDENT INFO</h4>
<div class="table-responsive">
<table class="table table-bordered">
<tr>
<th>Name</th>
<td>'.$sr['sname'].'</td>
<th>Department</th>
<td>'.$sr['branchname'].'</td>
</tr>
<tr>
<th>Contact</th>
<td>'.$sr['contact'].'</td>
<th>Joining Date</th>
<td>'.date("d-m-Y", strtotime($sr['joindate'])).'</td>
</tr>
<tr>
<th>Course</th>
<td>'.$sr['coursename'].'</td>
<th>Balance</th>
<td>'.$sr['balance'].'</td>
</tr>


</table>
</div>
';


echo '
<h4>Payment Info</h4>
<div class="table-responsive" >
<table class="table table-bordered" style="max-width:100%;font-size:12px;">
    <thead>
      <tr>
        <th>DATE</th>
        <th>TOTAL</th>
        <th>PAID</th>
        <th>Action</th>
        <th>Open</th>
        <th>Mail</th>
      </tr>
    </thead>
    <tbody>';
  $totapaid = 0;
  $balance=0;
while($res = $fqq->fetch_assoc())
{
  $totapaid+=$res['paid'];
  $totalpay=$res['balacetopay'];
  $paymentmethod=$res['transcation_remark'];  
  $balance=$totalpay-$totapaid;      
  echo '<tr>
        <td>'.date("d-m-Y", strtotime($res['submitdate'])).'</td>
        <td>'.$res['balacetopay'].'</td>
        <td>'.$res['paid'].'</td>
        
        <td><a onclick="return confirm(\'Are you sure you want to delete this record\');" href="careerreport.php?action=delete&id='.$res['id'].'" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a> </td>
        <td><a href="careerbill.php?bid='.$res['id'].'" class="btn btn-primary" target="_blank"><span class="glyphicon glyphicon-open"></span></a> </td>
        <td><a href="sentcareermail.php?bid='.$res['id'].'" class="btn btn-primary" ><span class="glyphicon glyphicon-cloud-upload"></span></a> </td>
        </tr>' ;
}
      
echo '	  
    </tbody>
  </table>
 </div> 
 
<table style="width:300px;">
<tr>
<th>Total Payment: 
</th>
<td>'.$totalpay.'
</td>
</tr>
<tr>
<th>Total Paid: 
</th>
<td>'.$totapaid.'
</td>
</tr>
<th>Balance: 
</th>
<td>'.$balance.'
</td>
</tr>
<tr>
<th>Payment Method: 
</th>
<td>'.$paymentmethod.'
</td>
</tr>
</table>
 ';


 }
else
{
echo 'No Payements submit.';
}
 
}
			
if(isset($_POST['req']) && $_POST['req']=='4') 
{

$sid = (isset($_POST['student']))?mysqli_real_escape_string($conn,$_POST['student']):'';

 $sql = "select id,sname,balance,organization,fees,contact,branchname,coursename from student where id='".$sid."'";
$q = $conn->query($sql);
if($q->num_rows>0)
{

$res = $q->fetch_assoc();
echo '  <form class="form-horizontal" id ="signupForm1" action="edupayment.php" method="post">
  
 <div class="form-group">
    <label class="control-label col-sm-2" for="email">Name:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" disabled  value="'.$res['sname'].'" >
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Organization:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" disabled  value="'.$res['organization'].'" >
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-2" for="email">Date:</label>
    <div class="col-sm-10">
	
      <input type="text" class="form-control" name="submitdate"  id="submitdate" style="background:#fff;" />
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2">Academic Year:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="" name="academicyear" id="academicyear" />
    </div>
  </div>

  <div class="form-group">
  <label class="control-label col-sm-2">University:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" value="" name="university" id="university" />
  </div>
</div>

  <div class="form-group">
    <label class="control-label col-sm-2">Admission Advance:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="admissionadvance" id="admissionadvance" onchange="totalbt()"/>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2">First Year Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="firstyearfee" id="firstyearfee" onchange="totalbt()"/>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2">Second Year Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="secondyearfee" id="secondyearfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Third Year Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="thirdyearfee" id="thirdyearfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Miscellaneous Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="miscellaneousfee" id="miscellaneousfee" onchange="totalbt()"/>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" >Total Deduction:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="tdeduction" value="0" id="tdeduction" onchange="totalbt()"/>
    </div>
  </div>
   <div class="form-group">
    <label class="control-label col-sm-2">Total Amount:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="totalamount" id="totalamount"  />
	  <input type="hidden" value="'.$res['id'].'" name="sid">
    </div>
  </div>
  <div class="form-group">
  <label class="control-label col-sm-2" >Paid:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" name="paid"  id="paid"  />
  </div>
</div>

   <div class="form-group">
    <label class="control-label col-sm-2" >Payment Method:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="transaction_remark" id="transaction_remark"/>
    </div>
  </div>

  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary" name="save">Save</button>
    </div>
  </div>
</form>
<script>

function totalbt() {
  var first_number = (parseFloat)(document.getElementById("admissionadvance").value);
  var second_number = (parseFloat)(document.getElementById("firstyearfee").value);
  var third_number = (parseFloat)(document.getElementById("secondyearfee").value);
  var fourth_number = (parseFloat)(document.getElementById("thirdyearfee").value);
  var fifth_number = (parseFloat)(document.getElementById("miscellaneousfee").value);
  var sixth_number = (parseFloat)(document.getElementById("tdeduction").value);

  var result=(first_number+second_number+third_number+fourth_number+fifth_number)-sixth_number;

document.getElementById("totalamount").value = result;
}

</script>
<script type="text/javascript">
$(document).ready( function() {
$("#submitdate").datepicker( {
        changeMonth: true,
        changeYear: true,
       
        dateFormat: "yy-mm-dd",
        
    });
	
	
///////////////////////////

$( "#signupForm1" ).validate( {
				rules: {
					submitdate: "required",
					
					paid: {
						required: true,
						number: true,
          }	,
					
          totalamount: {
						required: true,
						number: true,
					}	
				},
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

					
					if ( !element.next( "span" )[ 0 ] ) {
						$( "<span class=\'glyphicon glyphicon-remove form-control-feedback\'></span>" ).insertAfter( element );
					}
				},
				success: function ( label, element ) {
					if ( !$( element ).next( "span" )[ 0 ] ) {
						$( "<span class=\'glyphicon glyphicon-ok form-control-feedback\'></span>" ).insertAfter( $( element ) );
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


//////////////////////////	
	
	
	
});

</script>
';

}else
{
echo "Something Goes Wrong! Try After sometime.";
}
}

if(isset($_POST['req']) && $_POST['req']=='5') 
{

$sid = (isset($_POST['student']))?mysqli_real_escape_string($conn,$_POST['student']):'';
$sql = "select * from edu_transaction  where id='".$sid."'";
$fq = $conn->query($sql);
  $fqq = $conn->query($sql);
  $email='';
  $frq=$fq->fetch_assoc();
  if($fq->num_rows>0)
  {
  
  
   $sql = "select * from student where id='".$frq['stdid']."'";
  $sq = $conn->query($sql);
  $sr = $sq->fetch_assoc();
  $email=$sr['emailid'];
echo '
<h4>STUDENT INFO</h4>
<div class="table-responsive">
<table class="table table-bordered">
<tr>
<th>Name</th>
<td>'.$sr['sname'].'</td>
<th>Department</th>
<td>'.$sr['branchname'].'</td>
</tr>
<tr>
<th>Contact</th>
<td>'.$sr['contact'].'</td>
<th>Joining Date</th>
<td>'.date("d-m-Y", strtotime($sr['joindate'])).'</td>
</tr>
<tr>
<th>Course</th>
<td>'.$sr['coursename'].'</td>
<th>Balance</th>
<td>'.$sr['balance'].'</td>
</tr>


</table>
</div>
';


echo '
<h4>Payment Info</h4>
<div class="table-responsive" >
<table class="table table-bordered" style="max-width:100%;font-size:12px;">
    <thead>
      <tr>
        <th>DATE</th>
        <th>TOTAL</th>
        <th>PAID</th>
        <th>Action</th>
        <th>Open</th>
        <th>Mail</th>
      </tr>
    </thead>
    <tbody>';
  $totapaid = 0;
  $balance=0;
while($res = $fqq->fetch_assoc())
{
  $totapaid+=$res['paid'];
  $totalpay=$res['totalamount'];
  $paymentmethod=$res['transcation_remark']; 
  $balance=$totalpay-$totapaid;
          echo '<tr>
        <td>'.date("d-m-Y", strtotime($res['submitdate'])).'</td>
        <td>'.$res['totalamount'].'</td>
        <td>'.$res['paid'].'</td>
        
        <td><a onclick="return confirm(\'Are you sure you want to delete this record\');" href="edureport.php?action=delete&id='.$res['id'].'" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a> </td>
        <td><a href="edubill.php?bid='.$res['id'].'" class="btn btn-primary" target="_blank"><span class="glyphicon glyphicon-open"></span></a> </td>
        <td><a href="sentedumail.php?bid='.$res['id'].'" class="btn btn-primary" ><span class="glyphicon glyphicon-cloud-upload" ></span></a> </td>
        </tr>' ;
}
      
echo '	  
    </tbody>
  </table>
 </div> 
 
<table style="width: 300px;" >
<tr>
<th>Total Payment: 
</th>
<td>'.$totalpay.'
</td>
</tr>
<tr>
<th>Total Paid: 
</th>
<td>'.$totapaid.'
</td>
</tr>
<tr>
<th>Balance: 
</th>
<td>'.$balance.'
</td>
</tr>
<tr>
<th>Balance: 
</th>
<td>'.$paymentmethod.'
</td>
</tr>
</table>
 ';


 }
else
{
echo 'No Payements submit.';
}
 
}


if(isset($_POST['req']) && $_POST['req']=='6') 
{

$sid = (isset($_POST['client']))?mysqli_real_escape_string($conn,$_POST['client']):'';

 $sql = "select id,cname,balance,company,contact,departmentname from client where id='".$sid."'";
$q = $conn->query($sql);
if($q->num_rows>0)
{

$res = $q->fetch_assoc();
echo '  <form class="form-horizontal" id ="signupForm1" action="onlineservicepay.php" method="post">
  
 <div class="form-group">
    <label class="control-label col-sm-2" for="email">Name:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" disabled  value="'.$res['cname'].'" >
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Organization:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" disabled  value="'.$res['company'].'" >
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-2" for="email">Date:</label>
    <div class="col-sm-10">
	
      <input type="text" class="form-control" name="submitdate"  id="submitdate" style="background:#fff;" />
    </div>
  </div>
  

  <div class="form-group">
    <label class="control-label col-sm-2">Website Development:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="websitefee" id="websitefee" onchange="totalbt()"/>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2">Digital Marketing:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="digitalfee" id="digitalfee" onchange="totalbt()"/>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2">App Developement:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="appfee" id="appfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Financial Services:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="financialfee" id="financialfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Applications:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="applicationfee" id="applicationfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Certificates:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="certificatefee" id="certificatefee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
  <label class="control-label col-sm-2">Others:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" value="0" name="others" id="others" onchange="totalbt()"/>
  </div>
</div>
  <div class="form-group">
    <label class="control-label col-sm-2" >Total Deduction:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="tdeduction" value="0" id="tdeduction" onchange="totalbt()"/>
    </div>
  </div>
   <div class="form-group">
    <label class="control-label col-sm-2">Total Amount:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="totalamount" id="totalamount"  />
	  <input type="hidden" value="'.$res['id'].'" name="sid">
    </div>
  </div>
  <div class="form-group">
  <label class="control-label col-sm-2" >Paid:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" name="paid"  id="paid"  />
  </div>
</div>

   <div class="form-group">
    <label class="control-label col-sm-2" >Payment Method:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="transaction_remark" id="transaction_remark"/>
    </div>
  </div>

  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary" name="save">Save</button>
    </div>
  </div>
</form>
<script>

function totalbt() {
  var first_number = (parseFloat)(document.getElementById("websitefee").value);
  var second_number = (parseFloat)(document.getElementById("digitalfee").value);
  var third_number = (parseFloat)(document.getElementById("appfee").value);
  var fourth_number = (parseFloat)(document.getElementById("financialfee").value);
  var fifth_number = (parseFloat)(document.getElementById("applicationfee").value);
  var sixth_number = (parseFloat)(document.getElementById("certificatefee").value);
  var seventh_number = (parseFloat)(document.getElementById("others").value);

  var eighth_number = (parseFloat)(document.getElementById("tdeduction").value);

  var result=(first_number+second_number+third_number+fourth_number+fifth_number+seventh_number+seventh_number)-eighth_number;

document.getElementById("totalamount").value = result;
}

</script>
<script type="text/javascript">
$(document).ready( function() {
$("#submitdate").datepicker( {
        changeMonth: true,
        changeYear: true,
       
        dateFormat: "yy-mm-dd",
        
    });
	
	
///////////////////////////

$( "#signupForm1" ).validate( {
				rules: {
					submitdate: "required",
					
					paid: {
						required: true,
						number: true,
          }	,
					
          totalamount: {
						required: true,
						number: true,
					}	
				},
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

					
					if ( !element.next( "span" )[ 0 ] ) {
						$( "<span class=\'glyphicon glyphicon-remove form-control-feedback\'></span>" ).insertAfter( element );
					}
				},
				success: function ( label, element ) {
					if ( !$( element ).next( "span" )[ 0 ] ) {
						$( "<span class=\'glyphicon glyphicon-ok form-control-feedback\'></span>" ).insertAfter( $( element ) );
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


//////////////////////////	
	
	
	
});

</script>
';

}else
{
echo "Something Goes Wrong! Try After sometime.";
}
}

if(isset($_POST['req']) && $_POST['req']=='7') 
{

$sid = (isset($_POST['client']))?mysqli_real_escape_string($conn,$_POST['client']):'';
$sql = "select * from onlinepay_transaction  where id='".$sid."'";
$fq = $conn->query($sql);
$fqq = $conn->query($sql);
$email='';
$frq=$fq->fetch_assoc();
if($fq->num_rows>0)
{


 $sql = "select * from client where id='".$frq['stdid']."'";
$sq = $conn->query($sql);
$sr = $sq->fetch_assoc();
$email=$sr['emailid'];
echo '
<h4>CLIENT INFO</h4>
<div class="table-responsive">
<table class="table table-bordered">
<tr>
<th>Name</th>
<td>'.$sr['cname'].'</td>
<th>Department</th>
<td>'.$sr['departmentname'].'</td>
</tr>
<tr>
<th>Contact</th>
<td>'.$sr['contact'].'</td>
<th>Email</th>
<td>'.$sr['emailid'].'</td>
</tr>
<tr>
<th>Company</th>
<td>'.$sr['company'].'</td>
<th>Balance</th>
<td>'.$sr['balance'].'</td>
</tr>


</table>
</div>
';


echo '
<h4>Payment Info</h4>
<div class="table-responsive" >
<table class="table table-bordered" style="max-width:100%;font-size:12px;">
    <thead>
      <tr>
        <th>DATE</th>
        <th>TOTAL</th>
        <th>PAID</th>
        <th>Action</th>
        <th>Open</th>
        <th>Mail</th>
      </tr>
    </thead>
    <tbody>';
  $totapaid = 0;
  $balance=0;
while($res = $fqq->fetch_assoc())
{
  $totapaid+=$res['paid'];
  $totalpay=$res['totalamount'];
  $paymentmethod=$res['transcation_remark']; 
  $balance=$totalpay-$totapaid;
          echo '<tr>
        <td>'.date("d-m-Y", strtotime($res['submitdate'])).'</td>
        <td>'.$res['totalamount'].'</td>
        <td>'.$res['paid'].'</td>
        
        <td><a onclick="return confirm(\'Are you sure you want to delete this record\');" href="onlineservicereport.php?action=delete&id='.$res['id'].'" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a> </td>
        <td><a href="onlinebill.php?bid='.$res['id'].'" class="btn btn-primary" target="_blank"><span class="glyphicon glyphicon-open"></span></a> </td>
        <td><a href="sentonlinemail.php?bid='.$res['id'].'" class="btn btn-primary" ><span class="glyphicon glyphicon-cloud-upload"></span></a> </td>
        </tr>' ;
}
      
echo '	  
    </tbody>
  </table>
 </div> 
 
<table style="width:300px;" >
<tr>
<th>Total Payment: 
</th>
<td>'.$totalpay.'
</td>
</tr>
<tr>
<th>Total Paid: 
</th>
<td>'.$totapaid.'
</td>
</tr>
<tr>
<th>Balance: 
</th>
<td>'.$balance.'
</td>
</tr>
<tr>
<th>Payment Method: 
</th>
<td>'.$paymentmethod.'
</td>
</tr>
</table>
 ';


 }
else
{
echo 'No Payements submit.';
}
 
}



if(isset($_POST['req']) && $_POST['req']=='8') 
{

$sid = (isset($_POST['student']))?mysqli_real_escape_string($conn,$_POST['student']):'';

 $sql = "select id,sname,balance,rollno,fees,contact,branchname,coursename from student where id='".$sid."'";
$q = $conn->query($sql);
if($q->num_rows>0)
{

$res = $q->fetch_assoc();
echo '  <form class="form-horizontal" id ="signupForm1" action="virtualpayment.php" method="post">
  
 <div class="form-group">
    <label class="control-label col-sm-2" for="email">Name:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" disabled  value="'.$res['sname'].'" >
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Admission No:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" disabled  value="'.$res['rollno'].'" >
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-2" for="email">Date:</label>
    <div class="col-sm-10">
	
      <input type="text" class="form-control" name="submitdate"  id="submitdate" style="background:#fff;" />
    </div>
  </div>


  <div class="form-group">
    <label class="control-label col-sm-2">Admission Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="admissionfee" id="admissionfee" onchange="totalbt()"/>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2">Secondary Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="secondaryfee" id="secondaryfee" onchange="totalbt()"/>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2">SR. Secondary Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="seniorsecondary" id="seniorsecondary" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">UG Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="ugfee" id="ugfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">PG Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="pgfee" id="pgfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Diploma/PG Diploma Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="diplomafee" id="diplomafee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Registration Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="regfee" id="regfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Exam Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="examfee" id="examfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Materials Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="materialsfee" id="materialsfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Miscellaneous Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="0" name="miscellaneousfee" id="miscellaneousfee" onchange="totalbt()"/>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" >Total Deduction:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="tdeduction" value="0" id="tdeduction" onchange="totalbt()"/>
    </div>
  </div>
   <div class="form-group">
    <label class="control-label col-sm-2">Total Amount:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="totalamount" id="totalamount"  />
	  <input type="hidden" value="'.$res['id'].'" name="sid">
    </div>
  </div>
  <div class="form-group">
  <label class="control-label col-sm-2" >Paid:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" name="paid"  id="paid"  />
  </div>
</div>

   <div class="form-group">
    <label class="control-label col-sm-2" >Payment Method:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="transaction_remark" id="transaction_remark"/>
    </div>
  </div>

  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary" name="save">Save</button>
    </div>
  </div>
</form>
<script>

function totalbt() {
  var first_number = (parseFloat)(document.getElementById("admissionfee").value);
  var second_number = (parseFloat)(document.getElementById("secondaryfee").value);
  var third_number = (parseFloat)(document.getElementById("seniorsecondary").value);
  var fourth_number = (parseFloat)(document.getElementById("ugfee").value);
  var fifth_number = (parseFloat)(document.getElementById("pgfee").value);
  var sixth_number = (parseFloat)(document.getElementById("diplomafee").value);
  var seventh_number = (parseFloat)(document.getElementById("regfee").value);
  var eighth_number = (parseFloat)(document.getElementById("examfee").value);
  var nineth_number = (parseFloat)(document.getElementById("materialsfee").value);
  var tenth_number = (parseFloat)(document.getElementById("miscellaneousfee").value);
  var eleventh_number = (parseFloat)(document.getElementById("tdeduction").value);

  var result=(first_number+second_number+third_number+fourth_number+fifth_number+sixth_number+seventh_number+eighth_number+nineth_number+tenth_number)-eleventh_number;

document.getElementById("totalamount").value = result;
}

</script>
<script type="text/javascript">
$(document).ready( function() {
$("#submitdate").datepicker( {
        changeMonth: true,
        changeYear: true,
       
        dateFormat: "yy-mm-dd",
        
    });
	
	
///////////////////////////

$( "#signupForm1" ).validate( {
				rules: {
					submitdate: "required",
					
					paid: {
						required: true,
						number: true,
          }	,
					
          totalamount: {
						required: true,
						number: true,
					}	
				},
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

					
					if ( !element.next( "span" )[ 0 ] ) {
						$( "<span class=\'glyphicon glyphicon-remove form-control-feedback\'></span>" ).insertAfter( element );
					}
				},
				success: function ( label, element ) {
					if ( !$( element ).next( "span" )[ 0 ] ) {
						$( "<span class=\'glyphicon glyphicon-ok form-control-feedback\'></span>" ).insertAfter( $( element ) );
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


//////////////////////////	
	
	
	
});

</script>
';

}else
{
echo "Something Goes Wrong! Try After sometime.";
}
}

if(isset($_POST['req']) && $_POST['req']=='9') 
{

$sid = (isset($_POST['student']))?mysqli_real_escape_string($conn,$_POST['student']):'';
$sql = "select * from virtual_transaction  where id='".$sid."'";
$fq = $conn->query($sql);
  $fqq = $conn->query($sql);
  $email='';
  $frq=$fq->fetch_assoc();
  if($fq->num_rows>0)
  {
  
  
   $sql = "select * from student where id='".$frq['stdid']."'";
  $sq = $conn->query($sql);
  $sr = $sq->fetch_assoc();
  $email=$sr['emailid'];
echo '
<h4>STUDENT INFO</h4>
<div class="table-responsive">
<table class="table table-bordered">
<tr>
<th>Name</th>
<td>'.$sr['sname'].'</td>
<th>Department</th>
<td>'.$sr['branchname'].'</td>
</tr>
<tr>
<th>Contact</th>
<td>'.$sr['contact'].'</td>
<th>Joining Date</th>
<td>'.date("d-m-Y", strtotime($sr['joindate'])).'</td>
</tr>
<tr>
<th>Course</th>
<td>'.$sr['coursename'].'</td>
<th>Balance</th>
<td>'.$sr['balance'].'</td>
</tr>


</table>
</div>
';


echo '
<h4>Payment Info</h4>
<div class="table-responsive" >
<table class="table table-bordered" style="max-width:100%;font-size:12px;">
    <thead>
      <tr>
        <th>DATE</th>
        <th>TOTAL</th>
        <th>PAID</th>
        <th>Action</th>
        <th>Open</th>
        <th>Mail</th>
      </tr>
    </thead>
    <tbody>';
  $totapaid = 0;
  $balance=0;
while($res = $fqq->fetch_assoc())
{
  $totapaid+=$res['paid'];
  $totalpay=$res['totalamount'];
  $paymentmethod=$res['transcation_remark'];
  $balance=$totalpay-$totapaid;
          echo '<tr>
        <td>'.date("d-m-Y", strtotime($res['submitdate'])).'</td>
        <td>'.$res['totalamount'].'</td>
        <td>'.$res['paid'].'</td>
        
        <td><a onclick="return confirm(\'Are you sure you want to delete this record\');" href="virtualreport.php?action=delete&id='.$res['id'].'" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a> </td>
        <td><a href="virtualbill.php?bid='.$res['id'].'" class="btn btn-primary" target="_blank"><span class="glyphicon glyphicon-open"></span></a> </td>
        <td><a href="sentvirtualmail.php?bid='.$res['id'].'" class="btn btn-primary" ><span class="glyphicon glyphicon-cloud-upload" ></span></a> </td>
        </tr>' ;
}
      
echo '	  
    </tbody>
  </table>
 </div> 
 
<table style="width:300px;" >
<tr>
<th>Total Payment: 
</th>
<td>'.$totalpay.'
</td>
</tr>
<tr>
<th>Total Paid: 
</th>
<td>'.$totapaid.'
</td>
</tr>
<tr>
<th>Balance: 
</th>
<td>'.$balance.'
</td>
</tr>
<tr>
<th>Payment Method: 
</th>
<td>'.$paymentmethod.'
</td>
</tr>
</table>
 ';


 }
else
{
echo 'No Payements submit.';
}
 
}
?>