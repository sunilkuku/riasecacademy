<?php
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PSWD', ''); 
DEFINE ('DB_HOST', 'localhost'); 
DEFINE ('DB_NAME', 'paysystem'); 
require_once 'excel_reader2.php';
$conn =  new mysqli(DB_HOST,DB_USER,DB_PSWD,DB_NAME);
if(isset($_POST["Import"])){
		

    $file = $_FILES["file"]["tmp_name"];
    $file_open = fopen($file,"r");
    /**
     * PHPExcel - Excel data import to MySQL database script example
     * ==============================================================================
     * 
     * @version v1.0: PHPExcel_excel_to_mysql_demo.php 2016/03/03
     * @copyright Copyright (c) 2016, http://www.ilovephp.net
     * @author Sagar Deshmukh <sagarsdeshmukh91@gmail.com>
     * @SourceOfPHPExcel https://github.com/PHPOffice/PHPExcel, https://sourceforge.net/projects/phpexcelreader/
     * ==============================================================================
     *
     */
     
    require 'Classes/PHPExcel/IOFactory.php';
  
    $inputfilename = 'example_file.xlsx';
    $exceldata = array();
    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    //  Read your Excel workbook
    try
    {
        $inputfiletype = PHPExcel_IOFactory::identify($inputfilename);
        $objReader = PHPExcel_IOFactory::createReader($inputfiletype);
        $objPHPExcel = $objReader->load($inputfilename);
    }
    catch(Exception $e)
    {
        die('Error loading file "'.pathinfo($inputfilename,PATHINFO_BASENAME).'": '.$e->getMessage());
    }
    
    //  Get worksheet dimensions
    $sheet = $objPHPExcel->getSheet(0); 
    $highestRow = $sheet->getHighestRow(); 
    $highestColumn = $sheet->getHighestColumn();
    
    //  Loop through each row of the worksheet in turn
    for ($row = 1; $row <= $highestRow; $row++)
    { 
        //  Read a row of data into an array
        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
        
        //  Insert row data array into your database of choice here
        $sql = "INSERT INTO users (firstname, lastname, email)
                VALUES ('".$rowData[0][0]."', '".$rowData[0][1]."', '".$rowData[0][2]."')";
        
        if (mysqli_query($conn, $sql)) {
            $exceldata[] = $rowData[0];
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    
    // Print excel data
    echo "<table>";
    foreach ($exceldata as $index => $excelraw)
    {
        echo "<tr>";
        foreach ($excelraw as $excelcolumn)
        {
            echo "<td>".$excelcolumn."</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    
    mysqli_close($conn);
}
    ?>
    
	 