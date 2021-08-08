<?php
include("php/dbconnect.php");
include("php/checklogin.php");
if(isset($_POST["OnlineExport"])){
     header('Content-Type: text/csv; charset=utf-8');  
     $output = fopen("php://output", "w");  
     $Adate= explode(' ',$_POST['doj']);
    $month = $Adate[0];
    $year = $Adate[1];
	$months = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
	
     $doj = $months[$month].'-'.$year;	
     header('Content-Disposition: attachment; filename=OnlineServiceREport_'.$doj.'.csv');  

     fputcsv($output, array('NAME','CONTACT','FEE DATE','WEBSITE FEE','DIGITAL FEE','APP FEE','FINANCIAL FEE','APPLICATION FEE','CERTIFICATE FEE','OTHERS','Deduction','TOTAL_FEES','PAID','PAYMENT TYPE'));  
     $query = "select s.cname,s.contact,t.submitdate,t.websitefee,t.digitalfee,t.appfee,t.financialfee,t.applicationfee,t.certificatefee,t.others,t.total_deduction,t.totalamount,t.paid,t.transcation_remark from client as s,onlinepay_transaction as t where t.stdid=s.id and DATE_FORMAT(t.submitdate, '%m-%Y') = '".$doj."'"; 
      $result = mysqli_query($conn, $query);  
     while($row = mysqli_fetch_assoc($result))  
     {  
          fputcsv($output, $row);  
     }  
     fclose($output);  
} 
if(isset($_POST["VirtualExport"])){
     header('Content-Type: text/csv; charset=utf-8');  
     $output = fopen("php://output", "w");  
     $Adate= explode(' ',$_POST['doj']);
    $month = $Adate[0];
    $year = $Adate[1];
	$months = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
	
     $doj = $months[$month].'-'.$year;	
     header('Content-Disposition: attachment; filename=VirtualAcademyReport_'.$doj.'.csv');  

     fputcsv($output, array('NAME','CONTACT','FEE DATE','ADMISSION FEE','REGISTRATION FEE','SECONDARY FEE','SENIOR SECONDARY FEE','UG FEE','PG FEE','DIPLOMA FEE','MISCELLANEOUS FEE','EXAM FEE','MATERIALS FEE','Deduction','TOTAL_FEES','PAID','PAYMENT TYPE'));  
     $query = "select s.sname,s.contact,t.submitdate,t.admissionfee,t.regfee,t.secondaryfee,t.seniorsecondary,t.ugfee,t.pgfee,t.diplomafee,t.miscellaneousfee,t.examfee,t.materialsfee,t.total_deduction,t.totalamount,t.paid,t.transcation_remark from student as s,virtual_transaction as t where t.stdid=s.id and DATE_FORMAT(t.submitdate, '%m-%Y') = '".$doj."'"; 
      $result = mysqli_query($conn, $query);  
     while($row = mysqli_fetch_assoc($result))  
     {  
          fputcsv($output, $row);  
     }  
     fclose($output);  
} 
if(isset($_POST["EduExport"])){
     header('Content-Type: text/csv; charset=utf-8');  
     $output = fopen("php://output", "w");  
     $Adate= explode(' ',$_POST['doj']);
    $month = $Adate[0];
    $year = $Adate[1];
	$months = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
	
     $doj = $months[$month].'-'.$year;	
     header('Content-Disposition: attachment; filename=EduCationalServiceReport_'.$doj.'.csv');  

     fputcsv($output, array('NAME','CONTACT','FEE DATE','ACADEMIC YEAR','UNIVERSITY','ADMISSION ADVANCE','FIRST YEAR FEE','SECOND YEAR FEE','THIRD YEAR FEE','MISCELLANEOUS FEE','Deduction','TOTAL_FEES','PAID','PAYMENT TYPE'));  
     $query = "select s.sname,s.contact,t.submitdate,t.academicyear,t.university,t.admissionadvance,t.firstyearfee,t.secondyearfee,t.thirdyearfee,t.miscellaneousfee,t.total_deduction,t.totalamount,t.paid,t.transcation_remark from student as s,edu_transaction as t where t.stdid=s.id and DATE_FORMAT(t.submitdate, '%m-%Y') = '".$doj."'"; 
      $result = mysqli_query($conn, $query);  
     while($row = mysqli_fetch_assoc($result))  
     {  
          fputcsv($output, $row);  
     }  
     fclose($output);  
} 
if(isset($_POST["CareerExport"])){
     header('Content-Type: text/csv; charset=utf-8');  
     $output = fopen("php://output", "w");  
     $Adate= explode(' ',$_POST['doj']);
    $month = $Adate[0];
    $year = $Adate[1];
	$months = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
	
     $doj = $months[$month].'-'.$year;	
     header('Content-Disposition: attachment; filename=CareerAcademyReport_'.$doj.'.csv');  
     $query = "select s.sname,s.contact,t.submitdate,t.totalfee,t.counsellingfee,t.monitoringfee,t.aptitudefee,t.personalityfee,t.assessmentfee,t.othexpense,t.total_deduction,t.balacetopay,t.paid,t.transcation_remark from student as s,fees_transaction as t where t.stdid=s.id and DATE_FORMAT(t.submitdate, '%m-%Y') = '".$doj."'"; 
     fputcsv($output, array('NAME','CONTACT','FEE DATE','REGISTRATION FEE','COUNSELLING FEE','MONITORING FEE','APTITUDE FEE','PERSONALITY FEE','ASSESSMENT FEE','OTHERS','Deduction','TOTAL FEES','PAID','PAYMENT TYPE'));  
      $result = mysqli_query($conn, $query);  
     while($row = mysqli_fetch_assoc($result))  
     {  
          fputcsv($output, $row);  
     }  
     fclose($output);  
} 
 
// if(isset($_POST["SMS"])){
//      header('Content-Type: text/csv; charset=utf-8');  
//      $output = fopen("php://output", "w");  
//      $Adate= explode(' ',$_POST['doj']);
//     $month = $Adate[0];
//     $year = $Adate[1];
// 	$months = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
	
//      $doj = $months[$month].'-'.$year;	
//      header('Content-Disposition: attachment; filename='.$doj.'.csv');  

//      $query = "select t.stdid,s.sname,s.contact,t.totalfee,t.allowance,t.submitdate,t.sh_days,t.present_days,t.ot_hours,t.total_payment,t.pf,t.esi,t.festadvance,t.texpense,t.unexpense,t.othexpense,t.mnadvance,t.balacetopay,t.paid,s.balance from student as s,fees_transaction as t where t.stdid=s.id and DATE_FORMAT(t.submitdate, '%m-%Y') = '".$doj."'"; 
//       $result = mysqli_query($conn, $query);  
//      while($srl = mysqli_fetch_assoc($result))  
//      {  
//           $spaid=$srl['paid'];
//     $paid=$srl['paid'];
//     $sbtpay=$srl['balacetopay'];
//     $btpay=$srl['balacetopay'];
//     $stdid=$srl['stdid'];
//     $tpa=$srl['total_payment'];
//     $basic=$srl['totalfee'];
//     $allowance=$srl['allowance'];
//     $shdays=$srl['sh_days'];
//     $pdays=$srl['present_days'];
//     $oth=$srl['ot_hours'];

//     $submitdate=$srl['submitdate'];
//     $pf=$srl['pf'];
//     $esi=$srl['esi'];
//     $fest=$srl['festadvance'];
//     $tea=$srl['texpense'];
//     $un=$srl['unexpense'];
//     $oth=$srl['othexpense'];
//     $mn=$srl['mnadvance'];
  
//     $contact=$srl['contact'];
//     $ch = curl_init();
//     $sms="PAYMENT%20SUBMITTED%20for%20$submitdate%2E%0D%0ABASIC%3A$basic%2E%0D%0AALLOWANCE%3A$allowance%2E%0D%0APRESENT%20DAYS%3A$pdays%2E%0D%0ASUNDAY/HOLYDAY%3A$shdays%2E%0D%0AOT%20HOURS%3A$oth%2E%0D%0ATOTAL%20SALARY%3A$tpa%0D%0ADEDUCTIONS%3A%20PF%3A$pf%20ESI%3A$esi%0D%0AFEST%20ADVANCE%3A$fest%20TEA%3A$tea%20Monthly%20Advance%3A$mn%0D%0AUnion%20Expence%3A$un%20Other%20Advance%3A$oth%0D%0ABALANCE%20TO%20PAY%3A$btpay%20%20PAID%3A$paid";
// // set URL and other appropriate options
// // curl_setopt($ch, CURLOPT_URL, "http://sms.bulksmsserviceproviders.com/api/send_http.php?authkey=3053537567524ee68a27afa19b325e27&mobiles=$contact&message=$sms&sender=BKAENG&route=B");
// // curl_setopt($ch, CURLOPT_HEADER, 0);

// // // grab URL and pass it to the browser
// // curl_exec($ch);

// // close cURL resource, and free up system resources
// curl_close($ch);
           
//      }  
//      fclose($output);  
// } 
?>