<?php
include("php/dbconnect.php");
include("php/checklogin.php");
$bid=0;
$submitdate='';
        $admissionadvance='';
        $firstyearfee='';
        $secondyearfee='';
        $thirdyearfee='';
        $miscellaneousfee='';
        $totalamount='';
        $othexpense='';
        $total_deduction='';
        $academicyear='';
        $university='';
        $paid='';
        $stdid='';
        $studentname='';
        $place='';
        $contact='';
        $emailid='';
        $balance=0;
        $company='';
class numbertowordconvertsconver {
    function convert_number($number) 
    {
        if (($number < 0) || ($number > 999999999)) 
        {
            throw new Exception("Number is out of range");
        }
        $giga = floor($number / 1000000);
        // Millions (giga)
        $number -= $giga * 1000000;
        $kilo = floor($number / 1000);
        // Thousands (kilo)
        $number -= $kilo * 1000;
        $hecto = floor($number / 100);
        // Hundreds (hecto)
        $number -= $hecto * 100;
        $deca = floor($number / 10);
        // Tens (deca)
        $n = $number % 10;
        // Ones
        $result = "";
        if ($giga) 
        {
            $result .= $this->convert_number($giga) .  "Million";
        }
        if ($kilo) 
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($kilo) . " Thousand";
        }
        if ($hecto) 
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($hecto) . " Hundred";
        }
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
        if ($deca || $n) {
            if (!empty($result)) 
            {
                $result .= " and ";
            }
            if ($deca < 2) 
            {
                $result .= $ones[$deca * 10 + $n];
            } else {
                $result .= $tens[$deca];
                if ($n) 
                {
                    $result .= "-" . $ones[$n];
                }
            }
        }
        if (empty($result)) 
        {
            $result = "zero";
        }
        return $result;
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>EDUCATION SERVICE BILL</title>
    
    <style>
    .invoice-box {
        max-width: 100%;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;        
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
        border: 2px solid black;
  border-collapse: collapse;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: center;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #C0C0C0	;
        color:black;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
   
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /* RTL */
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
   
    </style>
    <html>

</head>

<body>

    <div class="invoice-box" id="content2">
        <?php
        $bid = mysqli_real_escape_string($conn,$_GET['bid']);
        
        $sql = "select * from edu_transaction where id='".$bid."'";
        $q = $conn->query($sql);
        if($q->num_rows>0)
        {
        $res=$q->fetch_assoc();
        $admissionadvance=$res["admissionadvance"];
        $submitdate=$res["submitdate"];
        $firstyearfee=$res["firstyearfee"];
        $secondyearfee=$res["secondyearfee"];
        $thirdyearfee=$res["thirdyearfee"];
        $miscellaneousfee=$res["miscellaneousfee"];
        $totalamount=$res["totalamount"];
        $academicyear=$res["academicyear"];
        $university=$res["university"];
        $total_deduction=$res["total_deduction"];
        $paid=$res["paid"];
        $balance=$totalamount-$paid;
        $stdid=$res["stdid"];
        $sqll = "select * from student where id='".$stdid."'";
        $qs= $conn->query($sqll);
        if($qs->num_rows>0)
        {
        $ress=$qs->fetch_assoc();
        $studentname=strtoupper($ress["sname"]);
        $place=strtoupper($ress["place"]);
        $contact=$ress["contact"];
        $emailid=$ress["emailid"];
        $college=strtoupper($ress["organization"]);

        }
        $i=1;
        $class_obj = new numbertowordconvertsconver();
        $convert_number = $totalamount;
        }
        ?>
         <div class="top">
               <img src="img/Educational.png" style="width:100%;max-height:200px;"/>
           </div>
        <table cellpadding="0" cellspacing="0" style="max-width:100%;">
           
            
            <tr class="information">
                <td colspan="10">
                    <table>
                        <tr>
                            <td>BILL TO ,<br>
                               <?php echo $studentname ?>
                               <br>
                               <?php echo $place ?>
                               <br>
                               COLLEGE: <?php echo $college ?>
                               <br>ACADEMIC YEAR: <?php echo $academicyear ?>
                               <br>
                               UNIVERSITY: <?php echo $university ?>
                               <br>
                               MOB NO: <?php echo $contact ?>
                            </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>INVOICE #E<?php echo $bid?><br>
                                ISSUED DATE : <?php echo date("d/m/Y", strtotime($submitdate))?>
                            </td>
                           
                        </tr>
                    </table>
                </td>
            </tr>
            
           
            <table>
            <tr class="heading">
               
                <td>
                    Particular
                </td>
                <td>
                     Amount
                </td>
              
            </tr>
            <!--ProductStart-->
            <tr>
           <td>Admission Advance</td>
           <td><?php echo $admissionadvance;?></td>
           </tr>
            <tr>
           <td>First Year Fee</td>
           <td><?php echo $firstyearfee;?></td>
           </tr>
           <tr>
           <td>Second Year Fee</td>
           <td><?php echo $secondyearfee;?></td>
           </tr>
           <tr>
           <td>Third Year Fee</td>
           <td><?php echo $thirdyearfee;?></td>
           </tr>
           <tr>
           <td>Miscellaneous Fee</td>
           <td><?php echo $miscellaneousfee;?></td>
           </tr>
           <tr>
           <td>Deduction</td>
           <td><?php echo $total_deduction;?></td>
          </tr>
          <tr class="heading">
           <td>Total Amount</td>
           <td><?php echo $totalamount;?></td>
          </tr>
          <tr class="heading">
           <td>Amount In Words :</td>
           <td><?php echo $class_obj->convert_number($convert_number); ?> Only</td>
          </tr>
          <tr class="heading">
           <td>Total Paid :</td>
           <td><?php echo $paid; ?></td>
          </tr>
          <?php if($balance>0){ ?>
          <tr class="heading">
           <td>Balance :</td>
           <td><?php echo $balance; ?></td>
          </tr>
          <?php } ?>
    </table>
        <!--ProductEnd-->
        
             <tr class="information">
                <td colspan="10">
                    <table>
                        <tr>
                            <td class="title">
                                <!-- <img src="qr.png" style="width:60%; max-width:150px;max-height: 200px;"> -->
                            </td>
                            <td><br><br>Accountant</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><br><br>Authorized Signature</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>

                            <td><br><br>Chairman
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
  
</body>
</html>