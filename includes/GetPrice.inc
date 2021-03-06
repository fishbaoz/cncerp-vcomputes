<?php
/* $Id: GetPrice.inc 5469 2012-07-02 10:52:47Z daintree $*/
function GetPrice ($StockID, $DebtorNo, $BranchCode, $db, $ReportZeroPrice=1){
	$GLOBALS['PriceListNotSet'] = false;
	$Price = 0;
	/*Search by branch and customer for a date specified price */
	$sql="SELECT prices.price
			FROM prices,
				debtorsmaster
			WHERE debtorsmaster.salestype=prices.typeabbrev
			AND debtorsmaster.debtorno='" . $DebtorNo . "'
			AND prices.stockid = '" . $StockID . "'
			AND prices.currabrev = debtorsmaster.currcode
			AND prices.debtorno=debtorsmaster.debtorno
			AND prices.branchcode='" . $BranchCode . "'
			AND prices.startdate <='" . Date('Y-m-d') . "'
			AND prices.enddate >='" . Date('Y-m-d') . "'";

	$ErrMsg =  _('There is a problem in retrieving the pricing information for part') . ' ' . $StockID  . ' ' . _('and for Customer') . ' ' . $DebtorNo .  ' ' . _('the error message returned by the SQL server was');
	$result = DB_query($sql, $db,$ErrMsg);
	if (DB_num_rows($result)==0){
		/*Need to try same specific search but for a default price with a zero end date */
		$sql="SELECT prices.price,
					prices.startdate
				FROM prices,
					debtorsmaster
				WHERE debtorsmaster.salestype=prices.typeabbrev
				AND debtorsmaster.debtorno='" . $DebtorNo . "'
				AND prices.stockid = '" . $StockID . "'
				AND prices.currabrev = debtorsmaster.currcode
				AND prices.debtorno=debtorsmaster.debtorno
				AND prices.branchcode='" . $BranchCode . "'
				AND prices.startdate <='" . Date('Y-m-d') . "'
				AND prices.enddate ='0000-00-00'
				ORDER BY prices.startdate DESC";

		$result = DB_query($sql, $db,$ErrMsg);

		if (DB_num_rows($result)==0){

			/* No result returned for customer and branch search try for just a customer match */
			$sql = "SELECT prices.price
					FROM prices,
					debtorsmaster
					WHERE debtorsmaster.salestype=prices.typeabbrev
					AND debtorsmaster.debtorno='" . $DebtorNo . "'
					AND prices.stockid = '" . $StockID . "'
					AND prices.currabrev = debtorsmaster.currcode
					AND prices.debtorno=debtorsmaster.debtorno
					AND prices.branchcode=''
					AND prices.startdate <='" . Date('Y-m-d') . "'
					AND prices.enddate >='" . Date('Y-m-d') . "'";


			$result = DB_query($sql,$db,$ErrMsg);
			if (DB_num_rows($result)==0){
				//if no specific price between the dates maybe there is a default price with no end date specified
				$sql = "SELECT prices.price,
							   prices.startdate
						FROM prices,
							debtorsmaster
						WHERE debtorsmaster.salestype=prices.typeabbrev
						AND debtorsmaster.debtorno='" . $DebtorNo . "'
						AND prices.stockid = '" . $StockID . "'
						AND prices.currabrev = debtorsmaster.currcode
						AND prices.debtorno=debtorsmaster.debtorno
						AND prices.branchcode=''
						AND prices.startdate <='" . Date('Y-m-d') . "'
						AND prices.enddate >='0000-00-00'
						ORDER BY prices.startdate DESC";

				$result = DB_query($sql,$db,$ErrMsg);

				if (DB_num_rows($result)==0){

					/*No special customer specific pricing use the customers normal price list but look for special limited time prices with specific end date*/
					$sql = "SELECT prices.price
							FROM prices,
							debtorsmaster
							WHERE debtorsmaster.salestype=prices.typeabbrev
							AND debtorsmaster.debtorno='" . $DebtorNo . "'
							AND prices.stockid = '" . $StockID . "'
							AND prices.debtorno=''
							AND prices.currabrev = debtorsmaster.currcode
							AND prices.startdate <='" . Date('Y-m-d') . "'
							AND prices.enddate >='" . Date('Y-m-d') . "'";

					$result = DB_query($sql,$db,$ErrMsg);

					if (DB_num_rows($result)==0){
						/*No special customer specific pricing use the customers normal price list but look for default price with 0000-00-00 end date*/
						$sql = "SELECT prices.price,
									   prices.startdate
								FROM prices,
									debtorsmaster
								WHERE debtorsmaster.salestype=prices.typeabbrev
								AND debtorsmaster.debtorno='" . $DebtorNo . "'
								AND prices.stockid = '" . $StockID . "'
								AND prices.debtorno=''
								AND prices.currabrev = debtorsmaster.currcode
								AND prices.startdate <='" . Date('Y-m-d') . "'
								AND prices.enddate ='0000-00-00'
								ORDER BY prices.startdate DESC";

						$result = DB_query($sql,$db,$ErrMsg);

						if (DB_num_rows($result)==0){

							/* Now use the default salestype/price list cos all else has failed */
							$sql="SELECT prices.price
									FROM prices,
										debtorsmaster
									WHERE prices.stockid = '" . $StockID . "'
									AND prices.currabrev = debtorsmaster.currcode
									AND debtorsmaster.debtorno='" . $DebtorNo . "'
									AND prices.typeabbrev='" . $_SESSION['DefaultPriceList'] . "'
									AND prices.debtorno=''
									AND prices.startdate <='" . Date('Y-m-d') . "'
									AND prices.enddate >='" . Date('Y-m-d') . "'";;

							$result = DB_query($sql, $db,$ErrMsg);

							if (DB_num_rows($result)==0){

								/* Now use the default salestype/price list cos all else has failed */
								$sql="SELECT prices.price,
											 prices.startdate
										FROM prices,
											debtorsmaster
										WHERE prices.stockid = '" . $StockID . "'
										AND prices.currabrev = debtorsmaster.currcode
										AND debtorsmaster.debtorno='" . $DebtorNo . "'
										AND prices.typeabbrev='" . $_SESSION['DefaultPriceList'] . "'
										AND prices.debtorno=''
										AND prices.startdate <='" . Date('Y-m-d') . "'
										AND prices.enddate ='0000-00-00'
										ORDER BY prices.startdate DESC";

								$result = DB_query($sql, $db,$ErrMsg);

								if (DB_num_rows($result)==0){
									/*Not even a price set up in the default price list so return 0 */
									if ($ReportZeroPrice ==1){
										prnMsg(_('There are no prices set up for') . ' ' . $StockID . _(' and for customer:') . $DebtorNo ,'warn');
									}
									$GLOBALS['PriceListNotSet']=true;
									Return 0;
								}
							}
						}
					}
				}
			}
		}
	}

	if (DB_num_rows($result)!=0){
		/*There is a price from one of the above so return that */

		$myrow=DB_fetch_row($result);
		Return $myrow[0];
	} else {
		Return 0;
	}

}
?>