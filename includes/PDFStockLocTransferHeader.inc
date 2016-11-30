<?php
/* $Id: PDFStockLocTransferHeader.inc 5511 2012-07-17 06:07:56Z tehonu调拨发货单单头 $*/

/*PDF page header for inventory check report */
if ($PageNumber>1){
	$pdf->newPage();
}
$pdf->addJpegFromFile($_SESSION['LogoFile'],$Left_Margin,$Page_Height-$Top_Margin-100,0,30);
$FontSize=15;
$YPos= $Page_Height-$Top_Margin-95;
$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,550,$FontSize,$_SESSION['CompanyRecord']['coyname'].'物料调拨单','center');
$FontSize=12;
//$YPos -=15;
//$FontSize=12;


$YPos -=15;
$FontSize=12;
$LeftOvers2 = $pdf->addTextWrap($Left_Margin,$YPos,550,$FontSize,_('发货时间'). ': ' . ConvertSQLDateTime($TransferRow['shipdate']),'center');
$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,520,$FontSize,_('调拨No').'. ' . $_GET['TransferNo'],'right');
$YPos -=15;
$FontSize=12;
$LeftOvers2 = $pdf->addTextWrap($Left_Margin,$YPos,550,$FontSize,_('由').': ' . $TransferRow['shiplocname'].' '.'调往'.' :'.$TransferRow['reclocname']);
//$LeftOvers2 = $pdf->addTextWrap($Left_Margin,$YPos,550,$FontSize, _('to').'' . $TransferRow['reclocname']);
$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,520,$FontSize, _('Printed'). ': ' . Date($_SESSION['DefaultDateFormat']) . '   ' . _('Page'). ' ' . $PageNumber,'right');
//打印日期
/*Draw a rectangle to put the headings in     */
$YPos +=15;
$BoxHeight =$Page_Height-163;
$FontSize=12;
$YPos-=15;
$pdf->line($Left_Margin, $YPos,$Page_Width-$Right_Margin, $YPos);
$pdf->line($Left_Margin, $YPos,$Left_Margin, $YPos-$BoxHeight);
$pdf->line($Left_Margin, $YPos-$BoxHeight,$Page_Width-$Right_Margin, $YPos-$BoxHeight);
$pdf->line($Page_Width-$Right_Margin, $YPos,$Page_Width-$Right_Margin, $YPos-$BoxHeight);
$YPos -=10;

$YPos +=5;

/*set up the headings */
$Xpos = $Left_Margin+1;
//$LeftOvers = $pdf->addTextWrap($Xpos,$YPos-10,100-$Left_Margin,$FontSize,_('Item Code'), 'center');
//$LeftOvers = $pdf->addTextWrap(150,$YPos-10,150-$Left_Margin,$FontSize,_('Description'), 'center');
//$LeftOvers = $pdf->addTextWrap(341,$YPos-10,120,$FontSize,_('Qty Shipped'), 'center');
//$LeftOvers = $pdf->addTextWrap(341+120,$YPos-10,120,$FontSize,_('Qty Received'), 'center');
$LeftOvers = $pdf->addTextWrap($Xpos,$YPos-10,110-$Left_Margin,$FontSize,_('Item Code'), 'center');
$LeftOvers = $pdf->addTextWrap(150,$YPos-10,150-$Left_Margin,$FontSize,_('Description'), 'center');
$LeftOvers = $pdf->addTextWrap(341,$YPos-10,120,$FontSize,_('Qty Shipped'), 'center');
$LeftOvers = $pdf->addTextWrap(341+120,$YPos-10,120,$FontSize,_('Qty Received'), 'center');
$pdf->line($Left_Margin, $YPos-16,$Page_Width-$Right_Margin, $YPos-16);
//////////////////////////////////////////////////////
$FontSize=8;
$LeftOvers = $pdf->addTextWrap($Page_Width-$Right_Margin,$YPos,30,$FontSize, _('白 '));//
$LeftOvers = $pdf->addTextWrap($Page_Width-$Right_Margin,$YPos-10,30,$FontSize, _('联 '));//
$LeftOvers = $pdf->addTextWrap($Page_Width-$Right_Margin,$YPos-20,30,$FontSize, _('存'));//
$LeftOvers = $pdf->addTextWrap($Page_Width-$Right_Margin,$YPos-30,30,$FontSize, _('根 '));//

$LeftOvers = $pdf->addTextWrap($Page_Width-$Right_Margin,$YPos-60,30,$FontSize, _('红 '));//
$LeftOvers = $pdf->addTextWrap($Page_Width-$Right_Margin,$YPos-70,30,$FontSize, _('联 '));//
$LeftOvers = $pdf->addTextWrap($Page_Width-$Right_Margin,$YPos-80,30,$FontSize, _('记 '));//
$LeftOvers = $pdf->addTextWrap($Page_Width-$Right_Margin,$YPos-90,30,$FontSize, _('账 '));//

$LeftOvers = $pdf->addTextWrap($Page_Width-$Right_Margin,$YPos-120,30,$FontSize, _('黄 '));//
$LeftOvers = $pdf->addTextWrap($Page_Width-$Right_Margin,$YPos-130,30,$FontSize, _('联 '));//
$LeftOvers = $pdf->addTextWrap($Page_Width-$Right_Margin,$YPos-140,30,$FontSize, _('仓 '));//
$LeftOvers = $pdf->addTextWrap($Page_Width-$Right_Margin,$YPos-150,30,$FontSize, _('库 '));//
$FontSize=12;
//////////////////////////////////
$FontSize=10;
$YPos -= 30;
////////////////////////////////

list($userid,$realname,$stepdate)=getTransBy(16,$_GET['TransferNo']);
$LeftOvers = $pdf->addTextWrap($Left_Margin,$Bottom_Margin+5,120,$FontSize,_('发货') . ': ' .'', 'lift');
$LeftOvers = $pdf->addTextWrap(341+120,$Bottom_Margin+5,120,$FontSize,_('制单') . ': ' . $realname, 'lift');
list($userid,$realname,$stepdate)=getTransBy(16,$_GET['TransferNo'],1);
$LeftOvers = $pdf->addTextWrap($Left_Margin+200,$Bottom_Margin+5,120,$FontSize,_('收货') . ': ' .'', 'lift');
?>