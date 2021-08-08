<?php
include("php/dbconnect.php");

if(isset($_POST['req']) && $_POST['req']=='1') 
{
  $sname='';
  $fees='0';
  $stdid='';
$sid = (isset($_POST['student']))?mysqli_real_escape_string($conn,$_POST['student']):'';
$sql = "select * from fees_transaction  where id='".$sid."'";
  $fq = $conn->query($sql);
  $email='';
  if($fq->num_rows>0)
  {
    $frq=$fq->fetch_assoc();
 $sql2 = "select id,sname,balance,fees,contact,branchname,coursename from student where id='".$frq['stdid']."'";
$q = $conn->query($sql2);
if($q->num_rows>0)
{
$res = $q->fetch_assoc();
$sname=$res['sname'];
$fees=$res['fees'];
$stdid=$res['id'];
}
echo '  <form class="form-horizontal" id ="signupForm1" action="careerreport.php" method="post">
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Name:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" disabled  value="'.$sname.'" >
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-2" for="email">Date:</label>
    <div class="col-sm-10">
	
      <input type="text" class="form-control" value="'.$frq['submitdate'].'" name="submitdate"  id="submitdate" style="background:#fff;" />
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2">Registration:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$fees.'" name="totalfee" id="totalfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Counselling:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['counsellingfee'].'" name="counsellingfee" id="counsellingfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Monitoring:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['monitoringfee'].'" name="monitoringfee" id="monitoringfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Aptitude Test:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['aptitudefee'].'" name="aptitudefee" id="aptitudefee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Personality Test:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['personalityfee'].'" name="personalityfee" id="personalityfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Assessment:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['assessmentfee'].'" name="assessmentfee" id="assessmentfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" >Others:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="oth" id="oth"  value="'.$frq['othexpense'].'" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" >Total Deduction:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="tdeduction" value="'.$frq['total_deduction'].'" id="tdeduction" onchange="totalbt()"/>
    </div>
  </div>
   <div class="form-group">
    <label class="control-label col-sm-2">Total Amount:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['balacetopay'].'" name="btpay" id="btpay"  />
	  <input type="hidden" value="'.$frq['id'].'" name="sid">
    <input type="hidden" value="'.$stdid.'" name="stdid">
    </div>
  </div>
  <div class="form-group">
  <label class="control-label col-sm-2" >Paid:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" value="'.$frq['paid'].'" name="paid"  id="paid"  />
  </div>
</div>

   <div class="form-group">
    <label class="control-label col-sm-2" >Payment Method:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['transcation_remark'].'" name="transaction_remark" id="transaction_remark"/>
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

$sname='';
$organization='';
$stdid='';
$sql = "select * from edu_transaction  where id='".$sid."'";
$fq = $conn->query($sql);
$email='';
if($fq->num_rows>0)
{
  $frq=$fq->fetch_assoc();
$sql2 = "select id,sname,organization from student where id='".$frq['stdid']."'";
$q = $conn->query($sql2);
if($q->num_rows>0)
{
$res = $q->fetch_assoc();
$sname=$res['sname'];
$organization=$res['organization'];
$stdid=$res['id'];
}
echo '  <form class="form-horizontal" id ="signupForm1" action="edureport.php" method="post">
  
 <div class="form-group">
    <label class="control-label col-sm-2" for="email">Name:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" disabled  value="'.$sname.'" >
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Organization:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" disabled  value="'.$organization.'" >
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-2" for="email">Date:</label>
    <div class="col-sm-10">
	
      <input type="text" class="form-control" value="'.$frq['submitdate'].'" name="submitdate"  id="submitdate" style="background:#fff;" />
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2">Academic Year:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['academicyear'].'" name="academicyear" id="academicyear" />
    </div>
  </div>

  <div class="form-group">
  <label class="control-label col-sm-2">University:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" value="'.$frq['university'].'" name="university" id="university" />
  </div>
</div>

  <div class="form-group">
    <label class="control-label col-sm-2">Admission Advance:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['admissionadvance'].'" name="admissionadvance" id="admissionadvance" onchange="totalbt()"/>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2">First Year Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['firstyearfee'].'" name="firstyearfee" id="firstyearfee" onchange="totalbt()"/>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2">Second Year Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['secondyearfee'].'" name="secondyearfee" id="secondyearfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Third Year Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['thirdyearfee'].'" name="thirdyearfee" id="thirdyearfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Miscellaneous Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['miscellaneousfee'].'" name="miscellaneousfee" id="miscellaneousfee" onchange="totalbt()"/>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" >Total Deduction:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['total_deduction'].'" name="tdeduction" value="0" id="tdeduction" onchange="totalbt()"/>
    </div>
  </div>
   <div class="form-group">
    <label class="control-label col-sm-2">Total Amount:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['totalamount'].'" name="totalamount" id="totalamount"  />
	  <input type="hidden" value="'.$frq['id'].'" name="sid">
    <input type="hidden" value="'.$stdid.'" name="stdid">
    </div>
  </div>
  <div class="form-group">
  <label class="control-label col-sm-2" >Paid:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" value="'.$frq['paid'].'" name="paid"  id="paid"  />
  </div>
</div>

   <div class="form-group">
    <label class="control-label col-sm-2" >Payment Method:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['transcation_remark'].'" name="transaction_remark" id="transaction_remark"/>
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
if(isset($_POST['req']) && $_POST['req']=='3') 
{

$sid = (isset($_POST['client']))?mysqli_real_escape_string($conn,$_POST['client']):'';
$sname='';
$organization='';
$stdid='';
$sql = "select * from onlinepay_transaction  where id='".$sid."'";
$fq = $conn->query($sql);
$email='';
if($fq->num_rows>0)
{
  $frq=$fq->fetch_assoc();
  $stdid=$frq['stdid'];
  $sql2 = "select id,cname,balance,company,contact,departmentname from client where id='".$stdid."'";
  $q = $conn->query($sql2);
if($q->num_rows>0)
{
$res = $q->fetch_assoc();
$sname=$res['cname'];
$organization=$res['company'];
}
echo '  <form class="form-horizontal" id ="signupForm1" action="onlineservicereport.php" method="post">
  
 <div class="form-group">
    <label class="control-label col-sm-2" for="email">Name:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" disabled  value="'.$sname.'" >
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Organization:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" disabled  value="'.$organization.'" >
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-2" for="email">Date:</label>
    <div class="col-sm-10">
	
      <input type="text" class="form-control" value="'.$frq['submitdate'].'" name="submitdate"  id="submitdate" style="background:#fff;" />
    </div>
  </div>
  

  <div class="form-group">
    <label class="control-label col-sm-2">Website Development:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['websitefee'].'" name="websitefee" id="websitefee" onchange="totalbt()"/>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2">Digital Marketing:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['digitalfee'].'" name="digitalfee" id="digitalfee" onchange="totalbt()"/>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2">App Developement:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['appfee'].'" name="appfee" id="appfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Financial Services:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['financialfee'].'" name="financialfee" id="financialfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Applications:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['applicationfee'].'" name="applicationfee" id="applicationfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Certificates:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['certificatefee'].'" name="certificatefee" id="certificatefee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
  <label class="control-label col-sm-2">Others:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" value="'.$frq['others'].'" name="others" id="others" onchange="totalbt()"/>
  </div>
</div>
  <div class="form-group">
    <label class="control-label col-sm-2" >Total Deduction:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="tdeduction" value="'.$frq['total_deduction'].'" id="tdeduction" onchange="totalbt()"/>
    </div>
  </div>
   <div class="form-group">
    <label class="control-label col-sm-2">Total Amount:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['totalamount'].'" name="totalamount" id="totalamount"  />
	  <input type="hidden" value="'.$frq['id'].'" name="sid">
    <input type="hidden" value="'.$stdid.'" name="stdid">
    </div>
  </div>
  <div class="form-group">
  <label class="control-label col-sm-2" >Paid:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" value="'.$frq['paid'].'" name="paid"  id="paid"  />
  </div>
</div>

   <div class="form-group">
    <label class="control-label col-sm-2" >Payment Method:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['transcation_remark'].'" name="transaction_remark" id="transaction_remark"/>
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

if(isset($_POST['req']) && $_POST['req']=='4') 
{

$sid = (isset($_POST['student']))?mysqli_real_escape_string($conn,$_POST['student']):'';
$sname='';
  $rollno='';
  $stdid='';
$sql = "select * from virtual_transaction  where id='".$sid."'";
  $fq = $conn->query($sql);
  $email='';
  if($fq->num_rows>0)
  {
    $frq=$fq->fetch_assoc();
    $stdid=$frq['stdid'];
 $sql2 = "select id,sname,rollno from student where id='".$stdid."'";
$q = $conn->query($sql2);
if($q->num_rows>0)
{
$res = $q->fetch_assoc();
$sname=$res['sname'];
$rollno=$res['rollno'];
$stdid=$res['id'];
}
echo '  <form class="form-horizontal" id ="signupForm1" action="virtualreport.php" method="post">
  
 <div class="form-group">
    <label class="control-label col-sm-2" for="email">Name:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" disabled  value="'.$sname.'" >
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Admission No:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" disabled  value="'.$rollno.'" >
    </div>
  </div>

    <div class="form-group">
    <label class="control-label col-sm-2" for="email">Date:</label>
    <div class="col-sm-10">
	
      <input type="text" class="form-control" value="'.$frq['submitdate'].'" name="submitdate"  id="submitdate" style="background:#fff;" />
    </div>
  </div>


  <div class="form-group">
    <label class="control-label col-sm-2">Admission Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['admissionfee'].'" name="admissionfee" id="admissionfee" onchange="totalbt()"/>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2">Secondary Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['secondaryfee'].'" name="secondaryfee" id="secondaryfee" onchange="totalbt()"/>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2">SR. Secondary Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['seniorsecondary'].'" name="seniorsecondary" id="seniorsecondary" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">UG Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['ugfee'].'" name="ugfee" id="ugfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">PG Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['pgfee'].'" name="pgfee" id="pgfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Diploma/PG Diploma Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['diplomafee'].'" name="diplomafee" id="diplomafee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Registration Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['regfee'].'" name="regfee" id="regfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Exam Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['examfee'].'" name="examfee" id="examfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Materials Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['materialsfee'].'" name="materialsfee" id="materialsfee" onchange="totalbt()"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2">Miscellaneous Fee:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['miscellaneousfee'].'" name="miscellaneousfee" id="miscellaneousfee" onchange="totalbt()"/>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" >Total Deduction:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="tdeduction" value="'.$frq['total_deduction'].'" id="tdeduction" onchange="totalbt()"/>
    </div>
  </div>
   <div class="form-group">
    <label class="control-label col-sm-2">Total Amount:</label>
    <div class="col-sm-10">
    <input type="text" class="form-control" value="'.$frq['totalamount'].'" name="totalamount" id="totalamount"  />
	  <input type="hidden" value="'.$frq['id'].'" name="sid">
    <input type="hidden" value="'.$stdid.'" name="stdid">
    </div>
  </div>
  <div class="form-group">
  <label class="control-label col-sm-2" >Paid:</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" value="'.$frq['paid'].'" name="paid"  id="paid"  />
  </div>
</div>

   <div class="form-group">
    <label class="control-label col-sm-2" >Payment Method:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" value="'.$frq['transcation_remark'].'"  name="transaction_remark" id="transaction_remark"/>
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


?>