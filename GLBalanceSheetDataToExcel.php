<?php

//error_reporting(E_ALL);


	/*arrange in the excel template file*/
	$glbalanceexceltemplate_columns=array('A','B','C','D','E','F');
	$glbalanceexceltemplate_rows=39;
	
	$RetainedEarningsAct = $_SESSION['CompanyRecord']['retainedearnings'];
	$BalancePeriodEnd = $_POST['BalancePeriodEnd'];
//	$Detail = $_POST['Detail'];
	
	$actuals=array();
	
	$sql = "SELECT lastdate_in_period FROM periods WHERE periodno='" . $BalancePeriodEnd . "'";
	$PrdResult = DB_query($sql, $db);
	$myrow = DB_fetch_row($PrdResult);
	$BalanceDate = ConvertSQLDate($myrow[0]);

	$SqlTopLevelAccout='select accountcode from chartmaster where accountcode<9999 and accountcode>1000;';
	$TopLevelAccoutResult = DB_query($SqlTopLevelAccout, $db);
	while ($myrow=DB_fetch_array($TopLevelAccoutResult)) {
		$AccountCode=$myrow[0];
		$SqlThis='select sum(actual+bfwd) from chartdetails where accountcode like \''.$AccountCode.'%\' and period='.$BalancePeriodEnd;
		$tempresult=DB_query($SqlThis, $db);
		$temprow = DB_fetch_row($tempresult);
		$ThisActual=$temprow[0];
		$SqlLast='select sum(actual+bfwd) from chartdetails where accountcode like \''.$AccountCode.'%\' and period='.($BalancePeriodEnd-12);
		$tempresult=DB_query($SqlThis, $db);
		$temprow = DB_fetch_row($tempresult);
		$LastActual=$temprow[0];
		$actuals[$AccountCode]=array(
			locale_number_format($ThisActual,$_SESSION['CompanyRecord']['decimalplaces']),
			locale_number_format($LastActual,$_SESSION['CompanyRecord']['decimalplaces'])
		);
	}
	
	require_once 'includes/phpexcel/PHPExcel/IOFactory.php';
	$objReader = PHPExcel_IOFactory::createReader('Excel5');
	$objPHPExcel = $objReader->load('companies/'.$_SESSION['DatabaseName'].'/reports/glbalancesheet_template.xls');
	
	for ($j=0;$j< count($glbalanceexceltemplate_columns);$j++){
		for ($i=1; $i<$glbalanceexceltemplate_rows; $i++){
			$cellNo=$glbalanceexceltemplate_columns[$j].$i;
			$va=$objPHPExcel->getActiveSheet()->getCell($cellNo)->getValue();
			
			if($va instanceof PHPExcel_RichText){
				$va=$va->getPlainText();
			}
		
			if(empty($va))continue;
			
			if(false!==strpos($va,'{companyname}')){
				$v=str_replace('{companyname}',$_SESSION['CompanyRecord']['coyname'],$va);
				$objPHPExcel->getActiveSheet()->setCellValue($cellNo,$v);
			}elseif (false!==strpos($va,'{date}')){
				$v=str_replace('{date}',Date($_SESSION['DefaultDateFormat']),$va);
				$objPHPExcel->getActiveSheet()->setCellValue($cellNo,$v);
			}else{
				
				$va=trim($va);

				if(strlen($va)>=4 && is_numeric(substr($va, 0, 4)) && !strpos($va,'.')){
				}else{
					continue;
				}
				
				if($glbalanceexceltemplate_columns[$j]=='B'||$glbalanceexceltemplate_columns[$j]=='E'){}else{
					continue;
				}
				if($cellNo=='B8'||$cellNo=='B6'){
					$cellNo=$cellNo;
				}
				
				$exp =$va;
				$arr_exp = array();
				for($ii=0;$ii<strlen($exp);$ii++){
					$arr_exp[] = $exp[$ii];
				}
				$myvalue[]=calcexp(array_reverse($arr_exp),0);
				$myvalue[]=calcexp(array_reverse($arr_exp),1);
				$objPHPExcel->getActiveSheet()->setCellValue($cellNo,$myvalue[0]);
				$cellNoNextCol=$glbalanceexceltemplate_columns[$j+1].$i;
				$objPHPExcel->getActiveSheet()->setCellValue($cellNoNextCol,$myvalue[1]);
				unset($myvalue);
			}
		}
	}
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');//'PDF'
	
	$outputFileName='GLBalanceSheet_'.str_replace('/', '_', $BalanceDate).'.xls';
	header("Content-Type: application/force-download");   
	header("Content-Type: application/octet-stream");   
	header("Content-Type: application/download");   
	header('Content-Disposition:inline;filename="'.$outputFileName.'"');   
	header("Content-Transfer-Encoding: binary");   
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");   
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");   
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");   
	header("Pragma: no-cache");
	$objWriter->save('php://output');

//	$objWriter->save('companies/fengxiang/reports/GLBalanceSheet_'.str_replace('/', '_', $BalanceDate).'.xls');
//	echo '<a href='.'companies/fengxiang/reports/GLBalanceSheet_'.str_replace('/', '_', $BalanceDate).'.xls'.'>click here</a>';
//	echo '<br/><a href=# onclick=history.go(-1)>back</a>';


/**
 * $index dangqian or next
 */
 function calcexp( $exp,$AccountDataIndex){
     $arr_n = array();
     $arr_op = array();
     $isnum=false;
     $num='';
     $len=count($exp);
     $index=0;
     while( ($s = array_pop( $exp )) != '' ){
     	$index++;
         if( $s == '(' ){
         	$isnum=false;
             $temp = array(); $quote = 1; $endquote = 0;
             while( ($t = array_pop($exp)) != '' ){
                 if( $t == '(' ){
                     $quote++;
                 }
                 if( $t == ')' ){
                     $endquote++;
                     if( $quote == $endquote ){
                         break;
                     }
                 }
                 array_push($temp, $t);
             }
             $temp = array_reverse($temp);
             array_push($arr_n, calcexp($temp,$AccountDataIndex) );
         }else if( $s == '*' || $s == '/' ){
         	$isnum=false;
             $n2 = array_pop($exp);
             if( $n2 == '(' ){
                 $temp = array(); $quote = 1; $endquote = 0;
                 while( ($t = array_pop($exp)) != '' ){
                     if( $t == '(' ){
                         $quote++;
                     }
                     if( $t == ')' ){
                         $endquote++;
                         if( $quote == $endquote )
                             break;
                     }
                     array_push($temp, $t);
                 }
                 $temp = array_reverse($temp);
                 $n2 = calcexp($temp,$AccountDataIndex);
             }
            
             $op = $s;
             $n1 = array_pop($arr_n);
            
             $result = operation($n1, $op, $n2,$AccountDataIndex);
             array_push($arr_n, $result);
         }elseif( $s == '+' || $s == '-' ){
         	$isnum=false;
             array_push($arr_op, $s);
         }else{
         	if(is_numeric($s)){
	         	$isnum=true;
	         	$num.=$s;	
         	}
         }
         
         if(!$isnum||($len==$index)){
         	if(is_numeric($num)){
         		array_push($arr_n, $num);
         		$num='';
         	}
         }
     }
    
     $n2 = array_pop($arr_n);
     if(count($arr_n)==0){
     	return operation('0.00','+',$n2,$AccountDataIndex);
     }
     while( ($op = array_pop($arr_op)) != '' ){
         $n1 = array_pop($arr_n);
         $n2 = operation($n1, $op, $n2,$AccountDataIndex);
     }
     
     return $n2;
 }

 function operation($n1, $op, $n2,$AccountDataIndex){
 	global $actuals;
 	$s1=gettype($n1);
 	$s2=gettype($n2);
 	if($n1=='0.00'){
 		
 	}elseif(!is_float($n1)){
 		$n1=$actuals[$n1][$AccountDataIndex];
 	}
 	$s12=gettype($n1);
 	$s22=gettype($n2);
 	if($n2=='0.00'){

 	}elseif(!is_float($n2)){
 		$n2=$actuals[$n2][$AccountDataIndex];
 	}
 	$s23=gettype($n2);
	switch ($op) {
         case '+':
         	$aa1=floatval($n1);
         	$aa2=floatval($n2);
         	$aa=$aa1 + $aa2;
             return $aa;
             break;
         case '-':
         	$aa1=floatval($n1);
         	$aa2=floatval($n2);
         	$aa=$aa1 - $aa2;
             return $aa;
//             return floatval($n1) - floatval($n2);
             break;
         case '*':
             return floatval($n1) * floatval($n2);
             break;
         case '/':
             return floatval($n1) / floatval($n2);
             break;
     }
 }

?>
