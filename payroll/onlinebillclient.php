<?php
include("php/dbconnect.php");
$submitdate='';
        $admissionadvance='';
        $websitefee='';
        $digitalfee='';
        $appfee='';
        $financialfee='';
        $totalamount='';
        $othexpense='';
        $total_deduction='';
        $applicationfee='';
        $certificatefee='';
        $paid='';
        $stdid='';
        $clientname='';
        $place='';
        $contact='';
        $emailid='';
        $company='';
        $i=1;
        $balance=0;
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
    <title>ONLINE SERVICES BILL</title>
    
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
</head>

<body>
    <div class="invoice-box">
        <?php
        $bid = mysqli_real_escape_string($conn,$_GET['bid']);
        $skey = mysqli_real_escape_string($conn,$_GET['skey']);

        $sql = "select * from onlinepay_transaction where id='".$bid."' and skey='".$skey."'";
        $q = $conn->query($sql);
        if($q->num_rows>0)
        {
        $res=$q->fetch_assoc();
        $submitdate=$res["submitdate"];
        $digitalfee=$res["digitalfee"];
        $websitefee=$res["websitefee"];
        $appfee=$res["appfee"];
        $financialfee=$res["financialfee"];
        $applicationfee=$res["applicationfee"];
        $certificatefee=$res["certificatefee"];
        $othexpense=$res["others"];
        $total_deduction=$res["total_deduction"];
        $totalamount=$res["totalamount"];
        $paid=$res["paid"];
        $stdid=$res["stdid"];
        $balance=$totalamount-$paid;
        $sqll = "select * from client where id='".$stdid."'";
        $qs= $conn->query($sqll);
        if($qs->num_rows>0)
        {
        $ress=$qs->fetch_assoc();
        $clientname=strtoupper($ress["cname"]);
        $place=strtoupper($ress["place"]);
        $contact=$ress["contact"];
        $emailid=$ress["emailid"];
        $company=strtoupper($ress["company"]);

        }
        
        $class_obj = new numbertowordconvertsconver();
        $convert_number = $totalamount;
        }
        ?>
    <div class="top">
               <img src="img/Online.png" style="width:100%;max-height:200px;"/>
           </div>
        <table cellpadding="0" cellspacing="0">
        
            <tr class="information">
                <td colspan="10">
                    <table>
                        <tr>
                            <td>BILL TO ,<br>
                               <?php echo $clientname ?>
                               <br>
                               <?php echo $place ?>
                               <br>
                               COMPANY : <?php echo $company ?>
                               <br>
                               MOB NO :<?php echo $contact ?>
                            </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>INVOICE #O<?php echo $bid?><br>
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
            <?php if($websitefee>0){?>
           <tr>
           <td>Website Fee</td>
           <td><?php echo $websitefee;?></td>
           </tr>
           <?php }?>
           <?php if($digitalfee>0){?>
           <tr>
           <td>Digital Marketing Fee</td>
           <td><?php echo $digitalfee;?></td>
           </tr>
           <?php }?>
           <?php if($appfee>0){?>
           <tr>
           <td>App Fee</td>
           <td><?php echo $appfee;?></td>
           </tr>
           <?php }?>
           <?php if($financialfee>0){?>
           <tr>
           <td>Financial Services Fee</td>
           <td><?php echo $financialfee;?></td>
           </tr>
           <?php }?>
           <?php if($applicationfee>0){?>
           <tr>
           <td>Applications</td>
           <td><?php echo $applicationfee;?></td>
           </tr>
           <?php }?>
           
           <tr>
           <td>Others</td>
           <td><?php echo $othexpense;?></td>
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