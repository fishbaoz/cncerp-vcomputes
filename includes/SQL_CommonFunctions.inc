<?php

/* $Id: SQL_CommonFunctions.inc 4973 2012-02-26 09:19:38Z tim_schofield $*/

/* Common SQL Functions */


Function GetNextTransNo ($TransType, &$db){

/* SQL to get the next transaction number these are maintained in the table SysTypes - Transaction Types
Also updates the transaction number

10 sales invoice
11 sales credit note
12 sales receipt
etc
*
*/

	DB_query("LOCK TABLES systypes WRITE",$db);

	$SQL = "SELECT typeno FROM systypes WHERE typeid = '" . $TransType . "'";

	$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': <BR>' . _('The next transaction number could not be retrieved from the database because');
	$DbgMsg =  _('The following SQL to retrieve the transaction number was used');
	$GetTransNoResult = DB_query($SQL,$db,$ErrMsg,$DbgMsg);

	$myrow = DB_fetch_row($GetTransNoResult);

	$SQL = "UPDATE systypes SET typeno = '" . ($myrow[0] + 1) . "' WHERE typeid = '" . $TransType . "'";
	$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The transaction number could not be incremented');
	$DbgMsg =  _('The following SQL to increment the transaction number was used');
	$UpdTransNoResult = DB_query($SQL,$db,$ErrMsg,$DbgMsg);

	DB_query("UNLOCK TABLES",$db);

	return $myrow[0] + 1;
}


Function GetStockGLCode ($StockID, &$db){

/*Gets the GL Codes relevant to the stock item account from the stock category record */
	$QuerySQL = "SELECT stockact,
						adjglact,
						issueglact,
						purchpricevaract,
						materialuseagevarac,
						wipact
				FROM stockmaster INNER JOIN stockcategory
				ON stockmaster.categoryid=stockcategory.categoryid
				WHERE stockmaster.stockid = '" . $StockID . "'";

	$ErrMsg =  _('The stock GL codes could not be retrieved because');
	$GetStkGLResult = DB_query($QuerySQL, $db, $ErrMsg);

	$myrow = DB_fetch_array($GetStkGLResult);
	return $myrow;
}

Function GetTaxRate ($TaxAuthority, $DispatchTaxProvince, $TaxCategory, &$db){

/*Gets the Tax rate applicable to an item from the TaxAuthority of the branch and TaxLevel of the item */

	$QuerySQL = "SELECT taxrate
				FROM taxauthrates
				WHERE taxauthority='" . $TaxAuthority . "'
				AND dispatchtaxprovince='" . $DispatchTaxProvince . "'
				AND taxcatid = '" . $TaxCategory . "'";

	$ErrMsg = _('The tax rate for this item could not be retrieved because');
	$GetTaxRateResult = DB_query($QuerySQL,$db,$ErrMsg);

	if (DB_num_rows($GetTaxRateResult)==1){
		$myrow = DB_fetch_row($GetTaxRateResult);
		return $myrow[0];
	} else {
		/*The tax rate is not defined for this Tax Authority and Dispatch Tax Authority */
		return 0;
	}

}

Function GetTaxes ($TaxGroup, $DispatchTaxProvince, $TaxCategory, &$db) {

	$SQL = "SELECT taxgrouptaxes.calculationorder,
					taxauthorities.description,
					taxgrouptaxes.taxauthid,
					taxauthorities.taxglcode,
					taxgrouptaxes.taxontax,
					taxauthrates.taxrate
			FROM taxauthrates INNER JOIN taxgrouptaxes ON
				taxauthrates.taxauthority=taxgrouptaxes.taxauthid
				INNER JOIN taxauthorities ON
				taxauthrates.taxauthority=taxauthorities.taxid
			WHERE taxgrouptaxes.taxgroupid='" . $TaxGroup . "'
			AND taxauthrates.dispatchtaxprovince='" . $DispatchTaxProvince . "'
			AND taxauthrates.taxcatid = '" . $TaxCategory . "'
			ORDER BY taxgrouptaxes.calculationorder";


	$ErrMsg = _('The taxes and rate for this tax group could not be retrieved because');
	$GetTaxesResult = DB_query($SQL,$db,$ErrMsg);

	if (DB_num_rows($GetTaxesResult)>=1){
		return $GetTaxesResult;
	} else {
		/*The tax group is not defined with rates */
		return 0;
	}
}



Function GetCreditAvailable($DebtorNo,&$db) {

	$sql = "SELECT debtorsmaster.debtorno,
			debtorsmaster.creditlimit,
			SUM(debtortrans.ovamount + debtortrans.ovgst + debtortrans.ovfreight + debtortrans.ovdiscount - debtortrans.alloc) as balance
		FROM debtorsmaster INNER JOIN debtortrans
			ON debtorsmaster.debtorno=debtortrans.debtorno
		WHERE debtorsmaster.debtorno='" . $DebtorNo . "'
		GROUP BY debtorsmaster.debtorno,
			debtorsmaster.creditlimit";

	$ErrMsg =  _('The current account balance of the customer could not be retrieved because');
	$GetAccountBalanceResult = DB_query($sql, $db, $ErrMsg);

	if (DB_num_rows($GetAccountBalanceResult)==1){

		$myrow = DB_fetch_array($GetAccountBalanceResult);
		$CreditAvailable = $myrow['creditlimit'] - $myrow['balance'];
	} else {
		$sql = "SELECT creditlimit
				FROM debtorsmaster
				WHERE debtorno='" . $DebtorNo . "'";
		$GetAccountBalanceResult = DB_query($sql, $db, $ErrMsg);
		$myrow = DB_fetch_array($GetAccountBalanceResult);
		$CreditAvailable = $myrow['creditlimit'];
	}
	/*Take into account the value of outstanding sales orders too */
	$sql = "SELECT SUM(salesorderdetails.unitprice *
				(salesorderdetails.quantity - salesorderdetails.qtyinvoiced) *
				(1 - salesorderdetails.discountpercent)) AS ordervalue
				FROM salesorders INNER JOIN salesorderdetails
				ON salesorders.orderno = salesorderdetails.orderno
				WHERE salesorders.debtorno = '" . $DebtorNo . "'
				AND salesorderdetails.completed = 0
				AND salesorders.quotation = 0";

	$ErrMsg =  _('The value of outstanding orders for the customer could not be retrieved because');
	$GetOSOrdersResult = DB_query($sql, $db, $ErrMsg);

	$myrow = DB_fetch_array($GetOSOrdersResult);
	$CreditAvailable -= $myrow['ordervalue'];

	return $CreditAvailable;
}

function ItemCostUpdateGL($db, $StockID, $NewCost, $OldCost, $QOH) {

		if ($_SESSION['CompanyRecord']['gllink_stock']==1 AND $QOH!=0){

			$CostUpdateNo = GetNextTransNo(35, $db);
			$PeriodNo = GetPeriod(date($_SESSION['DefaultDateFormat']), $db);
			$StockGLCode = GetStockGLCode($StockID,$db);

			$ValueOfChange = $QOH * ($NewCost - $OldCost);
			
			$SQL = "SELECT description from stockmaster where stockid='".$StockID."'";
			$result1 = DB_query($SQL,$db);
			$MyRow1 = DB_fetch_row($result1);
			
			$SQL = "INSERT INTO gltrans (type,
										typeno,
										trandate,
										periodno,
										account,
										narrative,
										amount)
							VALUES ('35',
							'" . $CostUpdateNo . "',
							'" . Date('Y-m-d') . "',
							'" . $PeriodNo . "',
							'" . $StockGLCode['adjglact'] . "',
							'" . $MyRow1[0].'['.$StockID . '] ' . _('cost was') . ' ' . $OldCost . ' ' . _('changed to') . ' ' . $NewCost . ' x ' . _('Quantity on hand of') . ' ' . $QOH . "',
							'" . -$ValueOfChange . "')";

			$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The GL credit for the stock cost adjustment posting could not be inserted because');
			$DbgMsg = _('The following SQL to insert the GLTrans record was used');
			$Result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

			$SQL = "INSERT INTO gltrans (type,
							typeno,
							trandate,
							periodno,
							account,
							narrative,
							amount)
						VALUES ('35',
							'" . $CostUpdateNo . "',
							'" . Date('Y-m-d') . "',
							'" . $PeriodNo . "',
							'" . $StockGLCode['stockact'] . "',
							'" . $MyRow1[0].'['.$StockID . '] ' . _('cost was') . ' ' . $OldCost . ' ' . _('changed to') .' ' . $NewCost . ' x ' . _('Quantity on hand of') . ' ' . $QOH . "',
							'" . $ValueOfChange . "')";

			$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The GL debit for stock cost adjustment posting could not be inserted because');
			$DbgMsg = _('The following SQL to insert the GLTrans record was used');
			$Result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
		}
}

/* Calculates the material cost of a bill of materials, given parent code*/
function BomMaterialCost($Parent, $db) {
	$SQL = "SELECT materialcost from stockmaster where stockid='".$Parent."'";
	$result1 = DB_query($SQL,$db);
	$MyRow1 = DB_fetch_row($result1);
	$OldCost = $MyRow1[0];
	$SQL = "SELECT sum(quantity) as qoh from locstock where stockid='".$Parent."'";
	$result1 = DB_query($SQL,$db);
	$MyRow1 = DB_fetch_row($result1);
	$QOH = $MyRow1[0];
	$SQL = "SELECT Sum(stockmaster.materialcost*bom.quantity) AS SumOfmaterialcost
	   					FROM bom LEFT JOIN stockmaster
							 ON bom.component = stockmaster.stockid
							 WHERE bom.parent='". $Parent . "'";
	$result = DB_query($SQL,$db);
	$MyRow = DB_fetch_row($result);
	$MaterialCost = $MyRow[0];
	$Result = DB_Txn_Begin($db);
	ItemCostUpdateGL($db, $Parent, $MaterialCost, $OldCost, $QOH);
	$Result = DB_Txn_Commit($db);
	return $MaterialCost;
}

/*Iterates through the levels of the bom, recalculating each bom it meets*/
function UpdateCost($db, $Item) {
	$SQL = "SELECT parent FROM bom where component = '" . $Item . "'";
	$Result = DB_query($SQL, $db);
	while ($MyRow=DB_fetch_array($Result)){
		$NewParent = $MyRow['parent'];
		$MaterialCost = BomMaterialCost($NewParent, $db);
		$SQL = "UPDATE stockmaster SET materialcost=" . $MaterialCost . " WHERE stockid='" . $NewParent . "'";
		$result1 = DB_query($SQL,$db);
		if (DB_error_no($db)!=0) {
			return 1;
		}
		UpdateCost($db, $NewParent);
	}
	return 0;
}

/* Accepts work order information and iterates through the bom, inserting real components (dissolving phantom assemblies) */
function WoRealRequirements($db, $WO, $LocCode, $StockID, $Qty=1, $ParentID='') {

	// remember, 'G' is for ghost (phantom part type)

	// all components should be referenced to the initial parent
	if ($ParentID == '') {
		$ParentID = $StockID;
	}

	// insert new real immediate components of this item
	$sql = "INSERT INTO worequirements (wo,
				parentstockid,
				stockid,
				qtypu,
				stdcost,
				autoissue)
			SELECT '" . $WO . "',
				'" . $ParentID . "',
				bom.component,
				bom.quantity*" . $Qty . ",
				materialcost+labourcost+overheadcost,
				bom.autoissue
			FROM bom INNER JOIN stockmaster
			ON bom.component=stockmaster.stockid
			WHERE bom.parent='" . $StockID . "'
			AND bom.loccode ='" . $LocCode . "'
			AND stockmaster.mbflag<>'G'
			AND bom.component NOT IN (
				SELECT stockid
				FROM worequirements
				WHERE wo = '" . $WO . "'
				AND parentstockid = '" . $ParentID . "'
			)";
	$result = DB_query($sql, $db);

	// combine real immediate components of this item with other occurrences in this work order
	// otherwise, we could encounter a uniqueness violation:
	//     - the same component could occur in multiple dissolved phantom assemblies
	//     - need to sum quantities of multiple component occurrences
	if ($ParentID != $StockID) {
		$sql = "UPDATE worequirements
					INNER JOIN (
						SELECT CAST('" . $WO . "' AS SIGNED) as wo,
							CAST('NODE-1' AS CHAR) as parentstockid,
							bom.component AS stockid,
							bom.quantity*1 AS qtypu,
							materialcost+labourcost+overheadcost AS stdcost,
							bom.autoissue
						FROM bom INNER JOIN stockmaster
						ON bom.component=stockmaster.stockid
						WHERE bom.parent='" . $StockID . "'
						AND bom.loccode ='" . $LocCode . "'
						AND stockmaster.mbflag<>'G'
						AND bom.component IN (
							SELECT stockid
							FROM worequirements
							WHERE wo = '" . $WO . "'
							AND parentstockid = '". $ParentID . "'
						)
					) AS g ON g.wo=worequirements.wo
						AND g.parentstockid=worequirements.parentstockid
						AND g.stockid=worequirements.stockid
					SET worequirements.qtypu=worequirements.qtypu+g.qtypu";
		$result = DB_query($sql, $db);
	}

	// dissolve phantom assemblies
	$sql = "SELECT
				bom.component,
				bom.quantity
			FROM bom INNER JOIN stockmaster
			ON bom.component=stockmaster.stockid
			WHERE parent='" . $StockID . "'
			AND loccode ='" . $LocCode . "'
			AND stockmaster.mbflag='G'";
	$result = DB_query($sql, $db);
	while ($MyRow=DB_fetch_array($result)) {
		WoRealRequirements($db, $WO, $LocCode, $MyRow['component'], $MyRow['quantity'], $ParentID);
	}

}

/*Ensures general ledger entries balance for a given transaction */
function EnsureGLEntriesBalance ($TransType, $TransTypeNo, $db) {

	$result = DB_query("SELECT SUM(amount)
						FROM gltrans
						WHERE type = '" . $TransType . "'
						AND typeno = '" . $TransTypeNo . "'",
						$db);
	$myrow = DB_fetch_row($result);
	$Difference = $myrow[0];
	if (abs($Difference)!=0){
		if (abs($Difference)>0.1){
			prnMsg(_('The general ledger entries created do not balance. See your system administrator'),'error');
		} else {
			$result = DB_query("SELECT counterindex,
										MAX(amount)
								FROM gltrans
								WHERE type = '" . $TransType . "'
								AND typeno = '" . $TransTypeNo . "'
								GROUP BY counterindex",
								$db);
			$myrow = DB_fetch_array($result);
			$TransToAmend = $myrow['counterindex'];
			$result = DB_query("UPDATE gltrans SET amount = amount - " . $Difference . "
								WHERE counterindex = '" . $TransToAmend . "'",
								$db);

		}
	}
}

?>