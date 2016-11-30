<?php

/* $Id: PDFStockLocTransfer.php 5231 2012-04-07 18:10:09Z vvs2012 调拨发货单$*/
include('includes/session.inc');
$Title = _('打印调拨单');
include('includes/Transby.php');//获取操作员签名
$PaperSize='BillsGB';//定义纸张

include('includes/PDFStarter.php');

if (isset($_POST['TransferNo'])) {
	$_GET['TransferNo']=$_POST['TransferNo'];
}

if (!isset($_GET['TransferNo'])){

	include ('includes/header.inc');
	$sql='select distinct reference from loctransfers order by reference desc';
	$result=DB_query($sql, $db);
	
	echo '<p class="page_title_text"><img src="'.$RootPath.'/css/'.$Theme.'/images/maintenance.png" title="' . _('Search') .
		'" alt="" />' . ' ' . _('打印调拨单').'</p><br />';
	echo '<form method="post" action="' . htmlspecialchars($_SERVER['PHP_SELF'],ENT_QUOTES,'UTF-8') . '">';
    echo '<div>';
	echo '<input type="hidden" name="FormID" value="' . $_SESSION['FormID'] . '" />';
	echo '<table>
			<tr>
				<td>'._('请选择调拨单号').'</td>
				<td>';
	echo '<select name="TransferNo">';
	while ($myrow=DB_fetch_array($result)) {
		echo '<option value="'.$myrow['reference'].'">'.$myrow['reference'].'</option>';
	}
	echo '</select>';
	//<input type="text" class="number" size="10" name="TransferNo" />
	echo '</td>
			</tr>
		</table>';
	echo '<br />
          <div class="centre">
			<input type="submit" name="Print" value="' . _('Print') .'" />
          </div>';
    echo '</div>
          </form>';
	include ('includes/footer.inc');
	exit;
}

$pdf->addInfo('Title', _('调拨提单') );
$pdf->addInfo('Subject', _('调拨提单号') . ' : ' . $_GET['TransferNo']);
$FontSize=10;
$PageNumber=1;
$line_height=15;

$ErrMsg = _('An error occurred retrieving the items on the transfer'). '.' . '<p>'. _('This page must be called with a location transfer reference number').'.';
$DbgMsg = _('The SQL that failed while retrieving the items on the transfer was');
$sql = "SELECT loctransfers.reference,
			   loctransfers.stockid,
			   stockmaster.description,
			   loctransfers.shipqty,
			   loctransfers.recqty,
			   loctransfers.shipdate,
			   loctransfers.shiploc,
			   locations.locationname as shiplocname,
			   loctransfers.recloc,
			   locationsrec.locationname as reclocname,
			   stockmaster.decimalplaces
		FROM loctransfers
		INNER JOIN stockmaster ON loctransfers.stockid=stockmaster.stockid
		INNER JOIN locations ON loctransfers.shiploc=locations.loccode
		INNER JOIN locations AS locationsrec ON loctransfers.recloc = locationsrec.loccode
		WHERE loctransfers.reference='" . $_GET['TransferNo'] . "'";

$result = DB_query($sql,$db, $ErrMsg, $DbgMsg);

If (DB_num_rows($result)==0){

	include ('includes/header.inc');
	prnMsg(_('The transfer reference selected does not appear to be set up') . ' - ' . _('enter the items to be transferred first'),'error');
	include ('includes/footer.inc');
	exit;
}

$TransferRow = DB_fetch_array($result);

include ('includes/PDFStockLocTransferHeader.inc');
$line_height=15;
$FontSize=10;
if ($TransferRow['decimalplaces']>2){
                $FormatQty = 2 ;
			   }else{
				$FormatQty = 2 ;/*$TransferRow['decimalplaces'];*/
                  }
do {

	$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,100,$FontSize,$TransferRow['stockid'], 'left');
	$LeftOvers = $pdf->addTextWrap(150,$YPos,200,$FontSize,$TransferRow['description'], 'left');
	$LeftOvers = $pdf->addTextWrap(350,$YPos,60,$FontSize,locale_number_format($TransferRow['shipqty'],$FormatQty), 'right');
	$LeftOvers = $pdf->addTextWrap(470,$YPos,60,$FontSize,locale_number_format($TransferRow['recqty'],$FormatQty), 'right');

	$pdf->line($Left_Margin, $YPos-2,$Page_Width-$Right_Margin, $YPos-2);

	$YPos -= $line_height;

	if ($YPos < $Bottom_Margin + $line_height) {

		$PageNumber++;
		include('includes/PDFStockLocTransferHeader.inc');
	}

} while ($TransferRow = DB_fetch_array($result));
$pdf->OutputD($_SESSION['DatabaseName'] . '_StockLocTrfShipment_' . date('Y-m-d') . '.pdf');
$pdf->__destruct();
?>