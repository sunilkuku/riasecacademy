<?php
include("php/dbconnect.php");
include("php/checklogin.php");


if($_GET['type']=="feesearch")
{
$aColumns = array( 's.id','s.sname','s.rollno','s.balance','s.organization','s.coursename','b.branch','s.contact','s.joindate');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "s.id";
	
	/* DB table to use */
	$sTable = " student as s,branch as b";
	
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysqli_real_escape_string($conn,$_GET['iDisplayStart'] ).", ".
			mysqli_real_escape_string($conn, $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	 $sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysqli_real_escape_string($conn, $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	$cond = "";
	$condArr = array();
	if(isset($_GET['student']) && $_GET['student']!="")
	{
	$condArr[] = "s.sname like '%".mysqli_real_escape_string($conn,$_GET['student'])."%' or s.contact like'%".mysqli_real_escape_string($conn,$_GET['student'])."%' ";
	
	}
	
	// if(isset($_GET['branch']) && $_GET['branch']!="")
	// {
	// $condArr[] = "s.branch = '".mysqli_real_escape_string($conn,$_GET['branch'])."'";
	$condArr[] = "s.branch = '2'";
	// }
	if(isset($_GET['course']) && $_GET['course']!="")
	{
	$condArr[] = "s.course = '".mysqli_real_escape_string($conn,$_GET['course'])."'";
	
	}
	
	if(isset($_GET['doj']) && $_GET['doj']!="")
	{
	$Adate= explode(' ',$_GET['doj']);
    $month = $Adate[0];
    $year = $Adate[1];
	$months = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
	
	$doj = $months[$month].'-'.$year;	
	$condArr[] = " DATE_FORMAT(s.joindate, '%m-%Y') = '".$doj."'";
	
	}
	if(isset($_GET['dob']) && $_GET['dob']!="")
	{
	$Adate= explode(' ',$_GET['dob']);
    $month = $Adate[0];
    $year = $Adate[1];
	$months = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
	
	$doj = $months[$month].'-'.$year;	
	$condArr[] = " DATE_FORMAT(s.birthdate, '%m-%Y') = '".$doj."'";
	
	}
	if(count($condArr)>0)
	{
	$cond = " and ( ".implode(" and ",$condArr)." )";
	}
	 
	$mycount = count($aColumns);
	 
	$sWhere = " WHERE b.id=s.branch and s.delete_status='0' ";
	if ( isset($_GET['sSearch'])&& $_GET['sSearch'] != "" )
	{
	    
		$sWhere = $sWhere." and (";
		for ( $i=0 ; $i<$mycount ; $i++ )
		{
		    
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering 
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn,$_GET['sSearch_'.$i])."%' ";
		}
	}*/
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS   ".implode(", ", $aColumns)."
		FROM   ".$sTable."	".$sWhere.$cond." ".$sOrder." ".$sLimit;
	
	$rResult = $conn->query($sQuery) or die(mysqli_error($conn));
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS() as rr
	";
	$rResultFilterTotal = $conn->query( $sQuery) or die(mysqli_error($conn));
	$aResultFilterTotal = $rResultFilterTotal->fetch_assoc();
	$iFilteredTotal = $aResultFilterTotal['rr'];
	
	/* Total data set length */
	$sQuery = "SELECT COUNT(".$sIndexColumn.") as cc
		FROM   ".$sTable." WHERE b.id=s.branch and s.delete_status='0' ";
	$rResultTotal = $conn->query( $sQuery ) or die(mysqli_error($conn));
	$aResultTotal = $rResultTotal->fetch_assoc();
	$iTotal = $aResultTotal['cc'];
	
	
	/*
	 * Output
	 */
	 
	if(isset($_GET['sEcho'])) 
	{
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	}else
	{
	 $output = array(
		
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	}
	
     $row =array();
	while ( $aRow = $rResult->fetch_assoc()  )
	{
		
		
		$row = array(
                    html_entity_decode($aRow['sname'].'<br/>'.$aRow['contact']),
                    $aRow['coursename'],
					$aRow['balance'],
                    $aRow['organization'],
					date("d M y", strtotime($aRow['joindate'])),
                    
					html_entity_decode('<button class="btn btn-warning btn-xs" onclick="javascript:GetFeeForm('.$aRow['id'].')"><i class="fa fa-inr "></i>  Add Payment </button>')
										
                );
		
		$output['aaData'][] =$row;
		
	}
	
	echo json_encode( $output );

}
if($_GET['type']=="edufeesearch")
{
$aColumns = array( 's.id','s.sname','s.rollno','s.balance','s.coursename','s.organization','b.branch','s.contact','s.joindate');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "s.id";
	
	/* DB table to use */
	$sTable = " student as s,branch as b";
	
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysqli_real_escape_string($conn,$_GET['iDisplayStart'] ).", ".
			mysqli_real_escape_string($conn, $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	 $sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysqli_real_escape_string($conn, $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	$cond = "";
	$condArr = array();
	if(isset($_GET['student']) && $_GET['student']!="")
	{
	$condArr[] = "s.sname like '%".mysqli_real_escape_string($conn,$_GET['student'])."%' or s.contact like'%".mysqli_real_escape_string($conn,$_GET['student'])."%' ";
	
	}
	
	// if(isset($_GET['branch']) && $_GET['branch']!="")
	// {
	// $condArr[] = "s.branch = '".mysqli_real_escape_string($conn,$_GET['branch'])."'";
	$condArr[] = "s.branch = '4'";
	// }
	if(isset($_GET['course']) && $_GET['course']!="")
	{
	$condArr[] = "s.course = '".mysqli_real_escape_string($conn,$_GET['course'])."'";
	
	}
	
	if(isset($_GET['doj']) && $_GET['doj']!="")
	{
	$Adate= explode(' ',$_GET['doj']);
    $month = $Adate[0];
    $year = $Adate[1];
	$months = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
	
	$doj = $months[$month].'-'.$year;	
	$condArr[] = " DATE_FORMAT(s.joindate, '%m-%Y') = '".$doj."'";
	
	}
	if(isset($_GET['dob']) && $_GET['dob']!="")
	{
	$Adate= explode(' ',$_GET['dob']);
    $month = $Adate[0];
    $year = $Adate[1];
	$months = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
	
	$doj = $months[$month].'-'.$year;	
	$condArr[] = " DATE_FORMAT(s.birthdate, '%m-%Y') = '".$doj."'";
	
	}
	if(count($condArr)>0)
	{
	$cond = " and ( ".implode(" and ",$condArr)." )";
	}
	 
	$mycount = count($aColumns);
	 
	$sWhere = " WHERE b.id=s.branch and s.delete_status='0' ";
	if ( isset($_GET['sSearch'])&& $_GET['sSearch'] != "" )
	{
	    
		$sWhere = $sWhere." and (";
		for ( $i=0 ; $i<$mycount ; $i++ )
		{
		    
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering 
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn,$_GET['sSearch_'.$i])."%' ";
		}
	}*/
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS   ".implode(", ", $aColumns)."
		FROM   ".$sTable."	".$sWhere.$cond." ".$sOrder." ".$sLimit;
	
	$rResult = $conn->query($sQuery) or die(mysqli_error($conn));
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS() as rr
	";
	$rResultFilterTotal = $conn->query( $sQuery) or die(mysqli_error($conn));
	$aResultFilterTotal = $rResultFilterTotal->fetch_assoc();
	$iFilteredTotal = $aResultFilterTotal['rr'];
	
	/* Total data set length */
	$sQuery = "SELECT COUNT(".$sIndexColumn.") as cc
		FROM   ".$sTable." WHERE b.id=s.branch and s.delete_status='0' ";
	$rResultTotal = $conn->query( $sQuery ) or die(mysqli_error($conn));
	$aResultTotal = $rResultTotal->fetch_assoc();
	$iTotal = $aResultTotal['cc'];
	
	
	/*
	 * Output
	 */
	 
	if(isset($_GET['sEcho'])) 
	{
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	}else
	{
	 $output = array(
		
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	}
	
     $row =array();
	while ( $aRow = $rResult->fetch_assoc()  )
	{
		
		
		$row = array(
                    html_entity_decode($aRow['sname'].'<br/>'.$aRow['contact']),
                    $aRow['coursename'],
					$aRow['balance'],
                    $aRow['organization'],
					date("d M y", strtotime($aRow['joindate'])),
                    
					html_entity_decode('<button class="btn btn-warning btn-xs" onclick="javascript:GetFeeForm('.$aRow['id'].')"><i class="fa fa-inr "></i>  Add Payment </button>')
										
                );
		
		$output['aaData'][] =$row;
		
	}
	
	echo json_encode( $output );

}
if($_GET['type']=="virtualfeesearch")
{
$aColumns = array( 's.id','s.sname','s.rollno','s.organization','s.balance','s.coursename','b.branch','s.contact','s.joindate');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "s.id";
	
	/* DB table to use */
	$sTable = " student as s,branch as b";
	
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysqli_real_escape_string($conn,$_GET['iDisplayStart'] ).", ".
			mysqli_real_escape_string($conn, $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	 $sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysqli_real_escape_string($conn, $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	$cond = "";
	$condArr = array();
	if(isset($_GET['student']) && $_GET['student']!="")
	{
	$condArr[] = "s.sname like '%".mysqli_real_escape_string($conn,$_GET['student'])."%' or s.contact like'%".mysqli_real_escape_string($conn,$_GET['student'])."%' ";
	
	}
	
	// if(isset($_GET['branch']) && $_GET['branch']!="")
	// {
	// $condArr[] = "s.branch = '".mysqli_real_escape_string($conn,$_GET['branch'])."'";
	$condArr[] = "s.branch = '1'";
	// }
	if(isset($_GET['course']) && $_GET['course']!="")
	{
	$condArr[] = "s.course = '".mysqli_real_escape_string($conn,$_GET['course'])."'";
	
	}
	
	if(isset($_GET['doj']) && $_GET['doj']!="")
	{
	$Adate= explode(' ',$_GET['doj']);
    $month = $Adate[0];
    $year = $Adate[1];
	$months = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
	
	$doj = $months[$month].'-'.$year;	
	$condArr[] = " DATE_FORMAT(s.joindate, '%m-%Y') = '".$doj."'";
	
	}
	if(isset($_GET['dob']) && $_GET['dob']!="")
	{
	$Adate= explode(' ',$_GET['dob']);
    $month = $Adate[0];
    $year = $Adate[1];
	$months = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
	
	$doj = $months[$month].'-'.$year;	
	$condArr[] = " DATE_FORMAT(s.birthdate, '%m-%Y') = '".$doj."'";
	
	}
	if(count($condArr)>0)
	{
	$cond = " and ( ".implode(" and ",$condArr)." )";
	}
	 
	$mycount = count($aColumns);
	 
	$sWhere = " WHERE b.id=s.branch and s.delete_status='0' ";
	if ( isset($_GET['sSearch'])&& $_GET['sSearch'] != "" )
	{
	    
		$sWhere = $sWhere." and (";
		for ( $i=0 ; $i<$mycount ; $i++ )
		{
		    
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering 
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn,$_GET['sSearch_'.$i])."%' ";
		}
	}*/
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS   ".implode(", ", $aColumns)."
		FROM   ".$sTable."	".$sWhere.$cond." ".$sOrder." ".$sLimit;
	
	$rResult = $conn->query($sQuery) or die(mysqli_error($conn));
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS() as rr
	";
	$rResultFilterTotal = $conn->query( $sQuery) or die(mysqli_error($conn));
	$aResultFilterTotal = $rResultFilterTotal->fetch_assoc();
	$iFilteredTotal = $aResultFilterTotal['rr'];
	
	/* Total data set length */
	$sQuery = "SELECT COUNT(".$sIndexColumn.") as cc
		FROM   ".$sTable." WHERE b.id=s.branch and s.delete_status='0' ";
	$rResultTotal = $conn->query( $sQuery ) or die(mysqli_error($conn));
	$aResultTotal = $rResultTotal->fetch_assoc();
	$iTotal = $aResultTotal['cc'];
	
	
	/*
	 * Output
	 */
	 
	if(isset($_GET['sEcho'])) 
	{
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	}else
	{
	 $output = array(
		
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	}
	
     $row =array();
	while ( $aRow = $rResult->fetch_assoc()  )
	{
		
		
		$row = array(
                    html_entity_decode($aRow['sname'].'<br/>'.$aRow['contact']),
                    $aRow['coursename'],
					$aRow['balance'],
                    $aRow['organization'],
					date("d M y", strtotime($aRow['joindate'])),
                    
					html_entity_decode('<button class="btn btn-warning btn-xs" onclick="javascript:GetFeeForm('.$aRow['id'].')"><i class="fa fa-inr "></i>  Add Payment </button>')
										
                );
		
		$output['aaData'][] =$row;
		
	}
	
	echo json_encode( $output );

}

if($_GET['type']=="clientsearch")
{
$aColumns = array( 's.id','s.cname','s.balance','s.company','s.departmentname','s.department','s.contact','s.emailid');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "s.id";
	
	/* DB table to use */
	$sTable = " client as s,branch as b";
	
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysqli_real_escape_string($conn,$_GET['iDisplayStart'] ).", ".
			mysqli_real_escape_string($conn, $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	 $sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysqli_real_escape_string($conn, $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	$cond = "";
	$condArr = array();
	if(isset($_GET['client']) && $_GET['client']!="")
	{
	$condArr[] = "s.cname like '%".mysqli_real_escape_string($conn,$_GET['client'])."%' or s.contact like'%".mysqli_real_escape_string($conn,$_GET['student'])."%' ";
	
	}
	
	
	$condArr[] = "s.department = '3'";
		
	
	
	if(count($condArr)>0)
	{
	$cond = " and ( ".implode(" and ",$condArr)." )";
	}
	 
	$mycount = count($aColumns);
	 
	$sWhere = " WHERE b.id=s.department and s.delete_status='0' ";
	if ( isset($_GET['sSearch'])&& $_GET['sSearch'] != "" )
	{
	    
		$sWhere = $sWhere." and (";
		for ( $i=0 ; $i<$mycount ; $i++ )
		{
		    
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering 
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn,$_GET['sSearch_'.$i])."%' ";
		}
	}*/
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS   ".implode(", ", $aColumns)."
		FROM   ".$sTable."	".$sWhere.$cond." ".$sOrder." ".$sLimit;
	
	$rResult = $conn->query($sQuery) or die(mysqli_error($conn));
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS() as rr
	";
	$rResultFilterTotal = $conn->query( $sQuery) or die(mysqli_error($conn));
	$aResultFilterTotal = $rResultFilterTotal->fetch_assoc();
	$iFilteredTotal = $aResultFilterTotal['rr'];
	
	/* Total data set length */
	$sQuery = "SELECT COUNT(".$sIndexColumn.") as cc
		FROM   ".$sTable." WHERE b.id=s.department and s.delete_status='0' ";
	$rResultTotal = $conn->query( $sQuery ) or die(mysqli_error($conn));
	$aResultTotal = $rResultTotal->fetch_assoc();
	$iTotal = $aResultTotal['cc'];
	
	
	/*
	 * Output
	 */
	 
	if(isset($_GET['sEcho'])) 
	{
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	}else
	{
	 $output = array(
		
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	}
	
     $row =array();
	while ( $aRow = $rResult->fetch_assoc()  )
	{
		
		
		$row = array(
                    html_entity_decode($aRow['cname'].'<br/>'.$aRow['contact']),
                    $aRow['company'],
					$aRow['balance'],
                    $aRow['departmentname'],                    
					html_entity_decode('<button class="btn btn-warning btn-xs" onclick="javascript:GetFeeForm('.$aRow['id'].')"><i class="fa fa-inr "></i>  Add Payment </button>')
										
                );
		
		$output['aaData'][] =$row;
		
	}
	
	echo json_encode( $output );

}




//monthly report

if($_GET['type']=="monthlyreport")
{
$aColumns = array( 's.id','s.sname','b.balacetopay','b.paid','s.contact','b.submitdate','b.id');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "s.id";
	
	/* DB table to use */
	$sTable = " student as s,fees_transaction as b ";
	
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysqli_real_escape_string($conn,$_GET['iDisplayStart'] ).", ".
			mysqli_real_escape_string($conn, $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	 $sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysqli_real_escape_string($conn, $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	$cond = "";
	$condArr = array();
	if(isset($_GET['student']) && $_GET['student']!="")
	{
	$condArr[] = "s.sname like '%".mysqli_real_escape_string($conn,$_GET['student'])."%'";
	
	}
	
	if(isset($_GET['branch']) && $_GET['branch']!="")
	{
	$condArr[] = "s.branch = '".mysqli_real_escape_string($conn,$_GET['branch'])."'";
	
	}
	
	if(isset($_GET['course']) && $_GET['course']!="")
	{
	$condArr[] = "s.course = '".mysqli_real_escape_string($conn,$_GET['course'])."'";
	
	}
	if(isset($_GET['doj']) && $_GET['doj']!="")
	{
	$Adate= explode(' ',$_GET['doj']);
    $month = $Adate[0];
    $year = $Adate[1];
	$months = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
	
	$doj = $months[$month].'-'.$year;	
	$condArr[] = " DATE_FORMAT(b.submitdate, '%m-%Y') = '".$doj."'";
	
	}
	if(isset($_GET['dom']) && $_GET['dom']!="")
	{
	
	$dom =mysqli_real_escape_string($conn,$_GET['dom']);	
	$condArr[] = " DATE_FORMAT(b.submitdate, '%d/%m/%Y') = '".$dom."'";
	
	}
	if(count($condArr)>0)
	{
	$cond = " and ( ".implode(" and ",$condArr)." )";
	}
	 
	$mycount = count($aColumns);
	 
	$sWhere = " WHERE b.stdid=s.id and s.delete_status='0'  ";
	if ( isset($_GET['sSearch'])&& $_GET['sSearch'] != "" )
	{
	    
		$sWhere = $sWhere." and (";
		for ( $i=0 ; $i<$mycount ; $i++ )
		{
		    
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering 
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn,$_GET['sSearch_'.$i])."%' ";
		}
	}*/
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS   ".implode(", ", $aColumns)."
		FROM   ".$sTable."	".$sWhere.$cond." ".$sOrder." ".$sLimit;
	
	$rResult = $conn->query($sQuery) or die(mysqli_error($conn));
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS() as rr
	";
	$rResultFilterTotal = $conn->query( $sQuery) or die(mysqli_error($conn));
	$aResultFilterTotal = $rResultFilterTotal->fetch_assoc();
	$iFilteredTotal = $aResultFilterTotal['rr'];
	
	/* Total data set length */
	$sQuery = "SELECT COUNT(".$sIndexColumn.") as cc
		FROM   ".$sTable." WHERE b.stdid=s.id and s.delete_status='0'   ";
	$rResultTotal = $conn->query( $sQuery ) or die(mysqli_error($conn));
	$aResultTotal = $rResultTotal->fetch_assoc();
	$iTotal = $aResultTotal['cc'];
	
	
	/*
	 * Output
	 */
	 
	if(isset($_GET['sEcho'])) 
	{
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	}else
	{
	 $output = array(
		
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	}
	
     $row =array();
	 $balance=0;
	while ( $aRow = $rResult->fetch_assoc()  )
	{
		$balance=$aRow['balacetopay']-$aRow['paid'];
		$row = array(
                    html_entity_decode($aRow['sname'].'<br/>'.$aRow['contact']),
                    $aRow['balacetopay'],
					$aRow['paid'],
					$balance,
					date("d/m/Y", strtotime($aRow['submitdate'])),
					html_entity_decode('<button class="btn btn-warning btn-xs" onclick="javascript:GetFeeForm('.$aRow['id'].','.$aRow['paid'].')"><span class="glyphicon glyphicon-folder-open"></span></button>'),
					html_entity_decode('<button class="btn btn-warning btn-xs" onclick="javascript:GetEditForm('.$aRow['id'].')"><span class="glyphicon glyphicon-edit"></span></button>')				
               );
		
		$output['aaData'][] =$row;
		
	}
	
	echo json_encode( $output );

}

if($_GET['type']=="edureport")
{
$aColumns = array( 's.id','s.sname','b.totalamount','b.paid','s.contact','b.submitdate','b.id');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "s.id";
	
	/* DB table to use */
	$sTable = "student as s,edu_transaction as b ";
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysqli_real_escape_string($conn,$_GET['iDisplayStart'] ).", ".
			mysqli_real_escape_string($conn, $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	 $sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysqli_real_escape_string($conn, $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	$cond = "";
	$condArr = array();
	if(isset($_GET['student']) && $_GET['student']!="")
	{
	$condArr[] = "s.sname like '%".mysqli_real_escape_string($conn,$_GET['student'])."%'";
	
	}
	
	if(isset($_GET['branch']) && $_GET['branch']!="")
	{
	$condArr[] = "s.branch = '".mysqli_real_escape_string($conn,$_GET['branch'])."'";
	
	}
	
	if(isset($_GET['course']) && $_GET['course']!="")
	{
	$condArr[] = "s.course = '".mysqli_real_escape_string($conn,$_GET['course'])."'";
	
	}
	if(isset($_GET['doj']) && $_GET['doj']!="")
	{
	$Adate= explode(' ',$_GET['doj']);
    $month = $Adate[0];
    $year = $Adate[1];
	$months = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
	
	$doj = $months[$month].'-'.$year;	
	$condArr[] = " DATE_FORMAT(b.submitdate, '%m-%Y') = '".$doj."'";
	
	}
	if(isset($_GET['dom']) && $_GET['dom']!="")
	{
	
	$dom = mysqli_real_escape_string($conn,$_GET['dom']);	
	$condArr[] = " DATE_FORMAT(b.submitdate, '%d/%m/%Y') = '".$dom."'";
	
	}
	if(count($condArr)>0)
	{
	$cond = " and ( ".implode(" and ",$condArr)." )";
	}
	 
	$mycount = count($aColumns);
	 
	$sWhere = " WHERE b.stdid=s.id and s.delete_status='0'  ";
	if ( isset($_GET['sSearch'])&& $_GET['sSearch'] != "" )
	{
	    
		$sWhere = $sWhere." and (";
		for ( $i=0 ; $i<$mycount ; $i++ )
		{
		    
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS   ".implode(", ", $aColumns)."
		FROM   ".$sTable."	".$sWhere.$cond." ".$sOrder." ".$sLimit;
	
	$rResult = $conn->query($sQuery) or die(mysqli_error($conn));
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS() as rr
	";
	$rResultFilterTotal = $conn->query( $sQuery) or die(mysqli_error($conn));
	$aResultFilterTotal = $rResultFilterTotal->fetch_assoc();
	$iFilteredTotal = $aResultFilterTotal['rr'];
	
	/* Total data set length */
	$sQuery = "SELECT COUNT(".$sIndexColumn.") as cc
		FROM   ".$sTable." WHERE b.stdid=s.id and s.delete_status='0'   ";
	$rResultTotal = $conn->query( $sQuery ) or die(mysqli_error($conn));
	$aResultTotal = $rResultTotal->fetch_assoc();
	$iTotal = $aResultTotal['cc'];
	
	
	/*
	 * Output
	 */
	 
	if(isset($_GET['sEcho'])) 
	{
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	}else
	{
	 $output = array(
		
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	}
	
     $row =array();
	 $balance=0;
	while ( $aRow = $rResult->fetch_assoc()  )
	{
		$balance=$aRow['totalamount']-$aRow['paid'];
		$row = array(
                    html_entity_decode($aRow['sname'].'<br/>'.$aRow['contact']),
                    $aRow['totalamount'],
					$aRow['paid'],
					$balance,
					date("d/m/Y", strtotime($aRow['submitdate'])),                    
					html_entity_decode('<button class="btn btn-warning btn-xs" onclick="javascript:GetFeeForm('.$aRow['id'].','.$aRow['paid'].')"><span class="glyphicon glyphicon-folder-open"></span></button>'),
					html_entity_decode('<button class="btn btn-warning btn-xs" onclick="javascript:GetEditForm('.$aRow['id'].')"><span class="glyphicon glyphicon-edit"></span></button>')				
               );
		
		$output['aaData'][] =$row;
		
	}
	
	echo json_encode( $output );

}

if($_GET['type']=="virtualreport")
{
$aColumns = array( 's.id','s.sname','b.totalamount','b.paid','s.contact','b.submitdate','b.id');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "s.id";
	
	/* DB table to use */
	$sTable = "student as s,virtual_transaction as b ";
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysqli_real_escape_string($conn,$_GET['iDisplayStart'] ).", ".
			mysqli_real_escape_string($conn, $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	 $sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysqli_real_escape_string($conn, $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	$cond = "";
	$condArr = array();
	if(isset($_GET['student']) && $_GET['student']!="")
	{
	$condArr[] = "s.sname like '%".mysqli_real_escape_string($conn,$_GET['student'])."%'";
	
	}
	
	if(isset($_GET['branch']) && $_GET['branch']!="")
	{
	$condArr[] = "s.branch = '".mysqli_real_escape_string($conn,$_GET['branch'])."'";
	
	}
	
	if(isset($_GET['course']) && $_GET['course']!="")
	{
	$condArr[] = "s.course = '".mysqli_real_escape_string($conn,$_GET['course'])."'";
	
	}
	if(isset($_GET['doj']) && $_GET['doj']!="")
	{
	$Adate= explode(' ',$_GET['doj']);
    $month = $Adate[0];
    $year = $Adate[1];
	$months = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
	
	$doj = $months[$month].'-'.$year;	
	$condArr[] = " DATE_FORMAT(b.submitdate, '%m-%Y') = '".$doj."'";
	
	}
	if(isset($_GET['dom']) && $_GET['dom']!="")
	{
	
	$dom = mysqli_real_escape_string($conn,$_GET['dom']);	
	$condArr[] = " DATE_FORMAT(b.submitdate, '%d/%m/%Y') = '".$dom."'";
	
	}
	if(count($condArr)>0)
	{
	$cond = " and ( ".implode(" and ",$condArr)." )";
	}
	 
	$mycount = count($aColumns);
	 
	$sWhere = " WHERE b.stdid=s.id and s.delete_status='0'  ";
	if ( isset($_GET['sSearch'])&& $_GET['sSearch'] != "" )
	{
	    
		$sWhere = $sWhere." and (";
		for ( $i=0 ; $i<$mycount ; $i++ )
		{
		    
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS   ".implode(", ", $aColumns)."
		FROM   ".$sTable."	".$sWhere.$cond." ".$sOrder." ".$sLimit;
	
	$rResult = $conn->query($sQuery) or die(mysqli_error($conn));
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS() as rr
	";
	$rResultFilterTotal = $conn->query( $sQuery) or die(mysqli_error($conn));
	$aResultFilterTotal = $rResultFilterTotal->fetch_assoc();
	$iFilteredTotal = $aResultFilterTotal['rr'];
	
	/* Total data set length */
	$sQuery = "SELECT COUNT(".$sIndexColumn.") as cc
		FROM   ".$sTable." WHERE b.stdid=s.id and s.delete_status='0'   ";
	$rResultTotal = $conn->query( $sQuery ) or die(mysqli_error($conn));
	$aResultTotal = $rResultTotal->fetch_assoc();
	$iTotal = $aResultTotal['cc'];
	
	
	/*
	 * Output
	 */
	 
	if(isset($_GET['sEcho'])) 
	{
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	}else
	{
	 $output = array(
		
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	}
	
     $row =array();
	 $balance=0;
	while ( $aRow = $rResult->fetch_assoc()  )
	{
		$balance=$aRow['totalamount']-$aRow['paid'];
		$row = array(
                    html_entity_decode($aRow['sname'].'<br/>'.$aRow['contact']),
                    $aRow['totalamount'],
					$aRow['paid'],
					$balance,
					date("d/m/Y", strtotime($aRow['submitdate'])),                    
					html_entity_decode('<button class="btn btn-warning btn-xs" onclick="javascript:GetFeeForm('.$aRow['id'].','.$aRow['paid'].')"><span class="glyphicon glyphicon-folder-open"></span></button>'),
					html_entity_decode('<button class="btn btn-warning btn-xs" onclick="javascript:GetEditForm('.$aRow['id'].')"><span class="glyphicon glyphicon-edit"></span></button>')				
               );
		
		$output['aaData'][] =$row;
		
	}
	
	echo json_encode( $output );

}

if($_GET['type']=="onlineservicereport")
{
$aColumns = array( 's.id','s.cname','b.totalamount','b.paid','s.contact','b.submitdate','b.id');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "s.id";
	
	/* DB table to use */
	$sTable = "client as s,onlinepay_transaction as b ";
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysqli_real_escape_string($conn,$_GET['iDisplayStart'] ).", ".
			mysqli_real_escape_string($conn, $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	 $sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysqli_real_escape_string($conn, $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	$cond = "";
	$condArr = array();
	if(isset($_GET['client']) && $_GET['client']!="")
	{
	$condArr[] = "s.cname like '%".mysqli_real_escape_string($conn,$_GET['client'])."%'";
	
	}
	
	if(isset($_GET['branch']) && $_GET['branch']!="")
	{
	$condArr[] = "s.department = '".mysqli_real_escape_string($conn,$_GET['branch'])."'";
	
	}

	if(isset($_GET['doj']) && $_GET['doj']!="")
	{
	$Adate= explode(' ',$_GET['doj']);
    $month = $Adate[0];
    $year = $Adate[1];
	$months = array('January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06','July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12');
	
	$doj = $months[$month].'-'.$year;	
	$condArr[] = " DATE_FORMAT(b.submitdate, '%m-%Y') = '".$doj."'";
	
	}
	if(isset($_GET['dom']) && $_GET['dom']!="")
	{
	
	$dom = mysqli_real_escape_string($conn,$_GET['dom']);	
	$condArr[] = " DATE_FORMAT(b.submitdate, '%d/%m/%Y') = '".$dom."'";
	
	}
	
	if(count($condArr)>0)
	{
	$cond = " and ( ".implode(" and ",$condArr)." )";
	}
	 
	$mycount = count($aColumns);
	 
	$sWhere = " WHERE b.stdid=s.id and s.delete_status='0'  ";
	if ( isset($_GET['sSearch'])&& $_GET['sSearch'] != "" )
	{
	    
		$sWhere = $sWhere." and (";
		for ( $i=0 ; $i<$mycount ; $i++ )
		{
		    
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn, $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS   ".implode(", ", $aColumns)."
		FROM   ".$sTable."	".$sWhere.$cond." ".$sOrder." ".$sLimit;
	
	$rResult = $conn->query($sQuery) or die(mysqli_error($conn));
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS() as rr
	";
	$rResultFilterTotal = $conn->query( $sQuery) or die(mysqli_error($conn));
	$aResultFilterTotal = $rResultFilterTotal->fetch_assoc();
	$iFilteredTotal = $aResultFilterTotal['rr'];
	
	/* Total data set length */
	$sQuery = "SELECT COUNT(".$sIndexColumn.") as cc
		FROM   ".$sTable." WHERE b.stdid=s.id and s.delete_status='0'   ";
	$rResultTotal = $conn->query( $sQuery ) or die(mysqli_error($conn));
	$aResultTotal = $rResultTotal->fetch_assoc();
	$iTotal = $aResultTotal['cc'];
	
	
	/*
	 * Output
	 */
	 
	if(isset($_GET['sEcho'])) 
	{
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	}else
	{
	 $output = array(
		
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	}
	
     $row =array();
	 $balance=0;
	while ( $aRow = $rResult->fetch_assoc()  )
	{
		$balance=$aRow['totalamount']-$aRow['paid'];
		$row = array(
                    html_entity_decode($aRow['cname'].'<br/>'.$aRow['contact']),
                    $aRow['totalamount'],
					$aRow['paid'],
					$balance,
					date("d/m/Y", strtotime($aRow['submitdate'])),                    
					html_entity_decode('<button class="btn btn-warning btn-xs" onclick="javascript:GetFeeForm('.$aRow['id'].','.$aRow['paid'].')"><span class="glyphicon glyphicon-folder-open"></span></button>'),
					html_entity_decode('<button class="btn btn-warning btn-xs" onclick="javascript:GetEditForm('.$aRow['id'].')"><span class="glyphicon glyphicon-edit"></span></button>')				
                );
		
		$output['aaData'][] =$row;
		
	}
	
	echo json_encode( $output );

}
?>