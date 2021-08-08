<?php
//$to =$_GET['email'];
$from = 'riasecacademy@gmail.com'; 
$fromName = 'RIASEC ACADEMY'; 
 
$subject = "Riasec Academy- Online Service Bill"; 
include("php/dbconnect.php");
include("php/checklogin.php");
error_reporting(0);
$msgerror = '';
$msgsuccess='';
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
        $skey='';
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
        $bid = mysqli_real_escape_string($conn,$_GET['bid']);

        $sql = "select * from onlinepay_transaction where id='".$bid."'";
        $q = $conn->query($sql);
        if($q->num_rows>0)
        {
        $res=$q->fetch_assoc();
        $submitdate=$res["submitdate"];
        $digitalfee=$res["digitalfee"];
        $websitefee=$res["websitefee"];
        $appfee=$res["appfee"];
        $skey=$res["skey"];
        $financialfee=$res["financialfee"];
        $applicationfee=$res["applicationfee"];
        $certificatefee=$res["certificatefee"];
        $othexpense=$res["others"];
        $total_deduction=$res["total_deduction"];
        $totalamount=$res["totalamount"];
        $paid=$res["paid"];
        $balance=$totalamount-$paid;
        $stdid=$res["stdid"];
        $paymentmethod=$res['transaction_remarks'];
        $sqll = "select * from client where id='".$stdid."'";
        $qs= $conn->query($sqll);
        if($qs->num_rows>0)
        {
        $ress=$qs->fetch_assoc();
        $clientname=strtoupper($ress["cname"]);
        $place=strtoupper($ress["place"]);
        $contact=$ress["contact"];
        $emailid=$ress["emailid"];
        $to=$emailid;
        $company=strtoupper($ress["company"]);

        }
        
        $class_obj = new numbertowordconvertsconver();
        $convert_number = $totalamount;
        $amounttext=$class_obj->convert_number($convert_number);
        }
        $htmlContent .= '  
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
          <head>
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <meta name="x-apple-disable-message-reformatting" />
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta name="color-scheme" content="light dark" />
            <meta name="supported-color-schemes" content="light dark" />
            <title></title>
            <style type="text/css" rel="stylesheet" media="all">
            /* Base ------------------------------ */
            
            @import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");
            body {
              width: 100% !important;
              height: 100%;
              margin: 0;
              -webkit-text-size-adjust: none;
            }
            
            a {
              color: #3869D4;
            }
            
            a img {
              border: none;
            }
            
            td {
              word-break: break-word;
            }
            
            .preheader {
              display: none !important;
              visibility: hidden;
              mso-hide: all;
              font-size: 1px;
              line-height: 1px;
              max-height: 0;
              max-width: 0;
              opacity: 0;
              overflow: hidden;
            }
            /* Type ------------------------------ */
            
            body,
            td,
            th {
              font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
            }
            
            h1 {
              margin-top: 0;
              color: #333333;
              font-size: 22px;
              font-weight: bold;
              text-align: left;
            }
            
            h2 {
              margin-top: 0;
              color: #333333;
              font-size: 16px;
              font-weight: bold;
              text-align: left;
            }
            
            h3 {
              margin-top: 0;
              color: #333333;
              font-size: 14px;
              font-weight: bold;
              text-align: left;
            }
            
            td,
            th {
              font-size: 16px;
            }
            
            p,
            ul,
            ol,
            blockquote {
              margin: .4em 0 1.1875em;
              font-size: 16px;
              line-height: 1.625;
            }
            
            p.sub {
              font-size: 13px;
            }
            /* Utilities ------------------------------ */
            
            .align-right {
              text-align: right;
            }
            
            .align-left {
              text-align: left;
            }
            
            .align-center {
              text-align: center;
            }
            /* Buttons ------------------------------ */
            
            .button {
              background-color: #3869D4;
              border-top: 10px solid #3869D4;
              border-right: 18px solid #3869D4;
              border-bottom: 10px solid #3869D4;
              border-left: 18px solid #3869D4;
              display: inline-block;
              color: #FFF;
              text-decoration: none;
              border-radius: 3px;
              box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
              -webkit-text-size-adjust: none;
              box-sizing: border-box;
            }
            
            .button--green {
              background-color: #22BC66;
              border-top: 10px solid #22BC66;
              border-right: 18px solid #22BC66;
              border-bottom: 10px solid #22BC66;
              border-left: 18px solid #22BC66;
            }
            
            .button--red {
              background-color: #FF6136;
              border-top: 10px solid #FF6136;
              border-right: 18px solid #FF6136;
              border-bottom: 10px solid #FF6136;
              border-left: 18px solid #FF6136;
            }
            
            @media only screen and (max-width: 500px) {
              .button {
                width: 100% !important;
                text-align: center !important;
              }
            }
            /* Attribute list ------------------------------ */
            
            .attributes {
              margin: 0 0 21px;
            }
            
            .attributes_content {
              background-color: #F4F4F7;
              padding: 16px;
            }
            
            .attributes_item {
              padding: 0;
            }
            /* Related Items ------------------------------ */
            
            .related {
              width: 100%;
              margin: 0;
              padding: 25px 0 0 0;
              -premailer-width: 100%;
              -premailer-cellpadding: 0;
              -premailer-cellspacing: 0;
            }
            
            .related_item {
              padding: 10px 0;
              color: #CBCCCF;
              font-size: 15px;
              line-height: 18px;
            }
            
            .related_item-title {
              display: block;
              margin: .5em 0 0;
            }
            
            .related_item-thumb {
              display: block;
              padding-bottom: 10px;
            }
            
            .related_heading {
              border-top: 1px solid #CBCCCF;
              text-align: center;
              padding: 25px 0 10px;
            }
            /* Discount Code ------------------------------ */
            
            .discount {
              width: 100%;
              margin: 0;
              padding: 24px;
              -premailer-width: 100%;
              -premailer-cellpadding: 0;
              -premailer-cellspacing: 0;
              background-color: #F4F4F7;
              border: 2px dashed #CBCCCF;
            }
            
            .discount_heading {
              text-align: center;
            }
            
            .discount_body {
              text-align: center;
              font-size: 15px;
            }
            /* Social Icons ------------------------------ */
            
            .social {
              width: auto;
            }
            
            .social td {
              padding: 0;
              width: auto;
            }
            
            .social_icon {
              height: 20px;
              margin: 0 8px 10px 8px;
              padding: 0;
            }
            /* Data table ------------------------------ */
            
            .purchase {
              width: 100%;
              margin: 0;
              padding: 35px 0;
              -premailer-width: 100%;
              -premailer-cellpadding: 0;
              -premailer-cellspacing: 0;
            }
            
            .purchase_content {
              width: 100%;
              margin: 0;
              padding: 25px 0 0 0;
              -premailer-width: 100%;
              -premailer-cellpadding: 0;
              -premailer-cellspacing: 0;
            }
            
            .purchase_item {
              padding: 10px 0;
              color: #51545E;
              font-size: 15px;
              line-height: 18px;
            }
            
            .purchase_heading {
              padding-bottom: 8px;
              border-bottom: 1px solid #EAEAEC;
            }
            
            .purchase_heading p {
              margin: 0;
              color: #85878E;
              font-size: 12px;
            }
            
            .purchase_footer {
              padding-top: 15px;
              border-top: 1px solid #EAEAEC;
            }
            
            .purchase_total {
              margin: 0;
              text-align: right;
              font-weight: bold;
              color: #333333;
            }
            
            .purchase_total--label {
              padding: 0 15px 0 0;
            }
            
            body {
              background-color: #cbcbce;
              color: #51545E;
            }
            
            p {
              color: #51545E;
            }
            
            p.sub {
              color: #6B6E76;
            }
            
            .email-wrapper {
              width: 100%;
              margin: 0;
              padding: 0;
              -premailer-width: 100%;
              -premailer-cellpadding: 0;
              -premailer-cellspacing: 0;
              background-color: #F4F4F7;
            }
            
            .email-content {
              width: 100%;
              margin: 0;
              padding: 0;
              -premailer-width: 100%;
              -premailer-cellpadding: 0;
              -premailer-cellspacing: 0;
            }
            /* Masthead ----------------------- */
            
            .email-masthead {
              padding: 25px 0;
              text-align: center;
            }
            
            .email-masthead_logo {
              width: 94px;
            }
            
            .email-masthead_name {
              font-size: 16px;
              font-weight: bold;
              color: #A8AAAF;
              text-decoration: none;
              text-shadow: 0 1px 0 white;
            }
            /* Body ------------------------------ */
            
            .email-body {
              width: 100%;
              margin: 0;
              padding: 0;
              -premailer-width: 100%;
              -premailer-cellpadding: 0;
              -premailer-cellspacing: 0;
              background-color: #FFFFFF;
            }
            
            .email-body_inner {
              width: 570px;
              margin: 0 auto;
              padding: 0;
              -premailer-width: 570px;
              -premailer-cellpadding: 0;
              -premailer-cellspacing: 0;
              background-color: #FFFFFF;
            }
            
            .email-footer {
              width: 570px;
              margin: 0 auto;
              padding: 0;
              -premailer-width: 570px;
              -premailer-cellpadding: 0;
              -premailer-cellspacing: 0;
              text-align: center;
            }
            
            .email-footer p {
              color: #6B6E76;
            }
            
            .body-action {
              width: 100%;
              margin: 30px auto;
              padding: 0;
              -premailer-width: 100%;
              -premailer-cellpadding: 0;
              -premailer-cellspacing: 0;
              text-align: center;
            }
            
            .body-sub {
              margin-top: 25px;
              padding-top: 25px;
              border-top: 1px solid #EAEAEC;
            }
            
            .content-cell {
              padding: 35px;
            }
            /*Media Queries ------------------------------ */
            
            @media only screen and (max-width: 600px) {
              .email-body_inner,
              .email-footer {
                width: 100% !important;
              }
            }
            
            @media (prefers-color-scheme: dark) {
              body,
              .email-body,
              .email-body_inner,
              .email-content,
              .email-wrapper,
              .email-masthead,
              .email-footer {
                background-color: #333333 !important;
                color: #FFF !important;
              }
              p,
              ul,
              ol,
              blockquote,
              h1,
              h2,
              h3,
              span,
              .purchase_item {
                color: #FFF !important;
              }
              .attributes_content,
              .discount {
                background-color: #222 !important;
              }
              .email-masthead_name {
                text-shadow: none !important;
              }
            }
            
            :root {
              color-scheme: light dark;
              supported-color-schemes: light dark;
            }
            </style>
            <!--[if mso]>
            <style type="text/css">
              .f-fallback  {
                font-family: Arial, sans-serif;
              }
            </style>
          <![endif]-->
          </head>
          <body>
            <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
              <tr>
                <td align="center">
                  <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                      <td class="email-masthead">
                        <a href="http://www.riasecacademy.com/" class="f-fallback email-masthead_name">
                        Riasec Online Services
                      </a>
                      </td>
                    </tr>
                    <!-- Email Body -->
                    <tr>
                      <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                          <!-- Body content -->
                          <tr>
                            <td class="content-cell">
                              <div class="f-fallback">
                                <img src="http://www.riasecacademy.com/feesmanager/img/Online2.png" alt="logo" width="500" height="93">
                                <p>Dear '.$clientname.',<br><br>
                                  This is a billing reminder that your invoice no.E'.$bid.' is generated on '.date("d/M/Y", strtotime($submitdate)).'<br></p>
                                  <p>Your payment method is: '.$paymentmethod.'<br></p>
                                <p>Invoice: E'.$bid.'<br> Total: '.$totalamount.'<br> Total Paid: '.$paid.'<br><br> Balance: '.$balance.'<br></p>
                                <!-- Discount -->
                               
                                <table class="purchase" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                  <tr>
                                    <td>
                                      <h3>Invoice :E'.$bid.'</h3></td>
                                    <td>
                                      <h3 class="align-right">Date:'.date("d/M/Y", strtotime($submitdate)).'</h3></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2">
                                      <table class="purchase_content" width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                          <th class="purchase_heading" align="left">
                                            <p class="f-fallback">Particular</p>
                                          </th>
                                          <th class="purchase_heading" align="right">
                                            <p class="f-fallback">Amount</p>
                                          </th>
                                        </tr>
                                        ';
if($websitefee>0){
    $htmlContent.='<tr><td width="80%" class="purchase_item"><span class="f-fallback">Website Fee </span></td>
                                          <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">'.$websitefee.'</span></td>
                                        </tr>';
}
if($digitalfee>0){
    $htmlContent.='<tr>
                                          <td width="80%" class="purchase_item"><span class="f-fallback">Digital Marketing Fee</span></td>
                                          <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">'.$digitalfee.'</span></td>
                                        </tr>';
}
if($appfee>0){
    $htmlContent.='<tr>
                                          <td width="80%" class="purchase_item"><span class="f-fallback">App Fee</span></td>
                                          <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">'.$appfee.'</span></td>
                                        </tr>';
}
if($financialfee>0){
        $htmlContent.='<tr>
                                          <td width="80%" class="purchase_item"><span class="f-fallback">Finanial Fee</span></td>
                                          <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">'.$financialfee.'</span></td>
                                        </tr>';
}
if($applicationfee>0){
             $htmlContent.='<tr>
                                          <td width="80%" class="purchase_item"><span class="f-fallback">Applications Fee</span></td>
                                          <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">'.$applicationfee.'</span></td>
                                        </tr>';
}
if($certificatefee>0){
         $htmlContent.='<tr>
                                          <td width="80%" class="purchase_item"><span class="f-fallback">Certificate Fee</span></td>
                                          <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">'.$certificatefee.'</span></td>
                                        </tr>';
}
$htmlContent.='<tr>
                                          <td width="80%" class="purchase_item"><span class="f-fallback">Others</span></td>
                                          <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">'.$othexpense.'</span></td>
                                        </tr>
                                        <tr>
                                          <td width="80%" class="purchase_item"><span class="f-fallback">Deduction</span></td>
                                          <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">'.$total_deduction.'</span></td>
                                        </tr>
                                       
                                        <tr>
                                          <td width="80%" class="purchase_footer" valign="middle">
                                            <p class="f-fallback purchase_total purchase_total--label">Total</p>
                                          </td>
                                          <td width="20%" class="purchase_footer" valign="middle">
                                            <p class="f-fallback purchase_total">'.$totalamount.'</p>
                                          </td>

                                        </tr>
                                        <tr>
                                          <td width="80%" class="purchase_footer" valign="middle">
                                            <p class="f-fallback purchase_total purchase_total--label">Paid</p>
                                          </td>
                                          <td width="20%" class="purchase_footer" valign="middle">
                                            <p class="f-fallback purchase_total">'.$paid.'</p>
                                          </td>

                                        </tr>
                                        <tr>
                                          <td width="80%" class="purchase_footer" valign="middle">
                                            <p class="f-fallback purchase_total purchase_total--label">Balance</p>
                                          </td>
                                          <td width="20%" class="purchase_footer" valign="middle">
                                            <p class="f-fallback purchase_total">'.$balance.'</p>
                                          </td>

                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </table>
                                <p>If you have any questions about this receipt, simply reply to this email or reach out to our <a href="http://www.riasecacademy.com/">http://www.riasecacademy.com/</a> for help. or Call/Whatsapp +91-7994209292,+91-8089939292,04933294292 </p>
                                <p>Thanks,
                                  <br>The Riasec Online Service Team</p>
                                <!-- Action -->
                                <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                  <tr>
                                    <td align="center">
                                      <!-- Border based button-->
                      
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                       
                                        <tr>
                                          <td align="center">
                                            <a href="http://www.riasecacademy.com/feesmanager/onlinebillclient.php?bid='.$bid.'&skey='.$skey.'" class="f-fallback button button--green">View Bill</button>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </table>
                                <!-- Sub copy -->
                              
                              </div>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td class="content-cell" align="center">
                              <p class="f-fallback sub align-center">&copy; 2021 Cyan Innovations. All rights reserved.</p>
                              <p class="f-fallback sub align-center">
                                [Riasec Career LLP]
                                <br>Salafi Masjid Building,Manjeri Road Tirurkad
                                <br>Malapuram-679321,Kerala,India
                              </p>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </body>
        </html>';
$content = '';

$content .= '
        <style>
        table {
            width: 800px;
            line-height: inherit;
            text-align: left;
            border: 2px solid black;
      border-collapse: collapse;
        }
        
        table td {
            padding: 5px;
            vertical-align: top;
        }
        
         table tr td:nth-child(2) {
            text-align: center;
        }
        
       table tr.top table td {
            padding-bottom: 20px;
        }
        
         table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        
      table tr.information table td {
            padding-bottom: 40px;
        }
        
     table tr.heading td {
            background: #C0C0C0	;
            color:black;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        
        table tr.details td {
            padding-bottom: 20px;
        }
        
        table tr.item td{
            border-bottom: 1px solid #eee;
        }
        
        table tr.item.last td {
            border-bottom: none;
        }
        
       table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
       
        /* RTL */
        .rtl {
            direction: rtl;
            font-family: Tahoma,Helvetica Neue Helvetica, Arial, sans-serif;
        }
        
        .rtl table {
            text-align: right;
        }
        
        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
        </style>

        ';
    
$content.='
<table>   
<tr>
    
        <td><img src="img/Online.png" style="width:420px;height:200px;max-width:420px;max-height:200px;"/></td>
           
</tr>
</table>
<table>   
<tr>
    <td colspan="10">
        <table>
        <tr>
        <td>BILL TO,</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>INVOICE #O:</td>
        <td>'.$bid.'</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>'.$clientname.'</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>ISSUED DATE:</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>'.$place.'</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>'.date("d/m/Y", strtotime($submitdate)).'</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
        <tr>
        <td>COMPANY :</td>
     <td>'.$company.'</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
    </tr>
    <tr>
    <td>MOB NO :</td>
 <td>'.$contact.'</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp; </td>
</tr>
</table>
</td>
</tr>
</table>

<table>
<tr class="heading">
  
    <td>
        Particular
    </td>
    <td>
         Amount
    </td>
  
</tr>
<tr>';
if($websitefee>0){
$content.='<td>Website Fee</td>
<td>'.$websitefee.'</td>
</tr>';
}
if($digitalfee>0){
    $content.='<tr>
<td>Digital Marketing Fee</td>
<td>'.$digitalfee.'</td>
</tr>';
}
if($appfee>0){
    $content.='<tr>
<td>App Fee</td>
<td>'.$appfee.'</td>
</tr>';
}
if($financialfee>0){
    $content.='<tr>
<td>Financial Services Fee</td>
<td>'.$financialfee.'</td>
</tr>';
}
if($applicationfee>0){
    $content.='<tr>
<td>Applications</td>
<td>'.$applicationfee.'</td>
</tr>';
}
if($certificatefee>0){
    $content.='<tr>
<td>Certificate Fee</td>
<td>'.$certificatefee.'</td>
</tr>';
}
$content.='<tr>
<td>Others</td>
<td>'.$othexpense.'</td>
</tr>
<tr>
<td>Deduction</td>
<td>'.$total_deduction.'</td>
</tr>
<tr class="heading">
<td>Total Amount</td>
<td>'.$totalamount.'</td>
</tr>
<tr class="heading">
<td>Amount In Words :</td>
<td>'.$amounttext.' Only</td>
</tr>
<tr class="heading">
           <td>Total Paid :</td>
           <td>'.$paid.'</td>
          </tr>
          <tr class="heading">
           <td>Balance :</td>
           <td>'.$balance.'</td>
          </tr>
</table>
<table>
 <tr class="information">
    <td colspan="10">
        <table>
        <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    
                </td>
                <td>Accountant</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Authorized Signature</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

                <td>Chairman
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>';


$description = wordwrap($description, 100, "<br />");
/* break description content every after 100 character. */


require_once('html2pdf/html2pdf.class.php');
$html2pdf = new HTML2PDF('P', 'A4', 'fr');

        $html2pdf->setDefaultFont('dejavusans');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $message = "<p>Please see the attachment.</p>";
        $separator = md5(time());
        $eol = PHP_EOL;
        $filename = "OnlineServiceBill.pdf";
        $pdfdoc = $html2pdf->Output('', 'S');
        $attachment = chunk_split(base64_encode($pdfdoc));
        $headers = "From: " . $from . $eol;
        $headers .= 'Cc:riasecacademy@gmail.com' . "\r\n"; 
        $headers .= "MIME-Version: 1.0" . $eol;
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol . $eol;
        // $headers .= 'Bcc: cyaninnovations2020@gmail.com' . "\r\n";
        $body = '';

        $body .= "Content-Transfer-Encoding: 7bit" . $eol;
        $body .= "This is a MIME encoded message." . $eol; //had one more .$eol


        $body .= "--" . $separator . $eol;
        $body .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol;
        $body .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
        $body .= $htmlContent . $eol;


        $body .= "--" . $separator . $eol;
        $body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
        $body .= "Content-Transfer-Encoding: base64" . $eol;
        $body .= "Content-Disposition: attachment" . $eol . $eol;
        $body .= $attachment . $eol;
        $body .= "--" . $separator . "--";

        if (mail($to, $subject, $body, $headers)) {
            echo "<script type=\"text/javascript\">
            alert(\"Mail Has Been successfully Sent.\");
            window.location = \"onlineservicereport.php\"
        </script>";
        } else {
            echo 'Email sending failed.';
        }
?>