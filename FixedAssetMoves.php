<?php

/* $Id: FixedAssetTransfer.php 5105 2012-03-16 22:34:02Z vvs2012 $*/

include('includes/session.inc');

$Title = _('Change Asset Location');

include('includes/header.inc');

if (isset($_GET['AssetID'])) {
	$AssetID=$_GET['AssetID'];
} else if (isset($_POST['AssetID'])) {
	$AssetID=$_POST['AssetID'];
}

{
	$sql="SELECT categoryid, categorydescription FROM fixedassetcategories";
	$result=DB_query($sql, $db);
	echo '<form action="'. htmlspecialchars($_SERVER['PHP_SELF'],ENT_QUOTES,'UTF-8') . '" method="post">';
    echo '<div>';
	echo '<input type="hidden" name="FormID" value="' . $_SESSION['FormID'] . '" />';
	echo '<p class="page_title_text"><img src="'.$Rootpath.'/css/'.$Theme.'/images/magnifier.png" title="' . _('Search') .
		'" alt="" />' . ' ' . $Title . '</p>';
	echo '<table class="selection"><tr>';
	echo '<td>'. _('In Asset Category') . ': ';
	echo '<select name="AssetCat">';

	if (!isset($_POST['AssetCat'])) {
		$_POST['AssetCat'] = '';
	}

	while ($myrow = DB_fetch_array($result)) {
		if ($myrow['categoryid'] == $_POST['AssetCat']) {
			echo '<option selected="selected" value="' . $myrow['categoryid'] . '">' . $myrow['categorydescription'] . '</option>';
		} else {
			echo '<option value="' . $myrow['categoryid'] . '">' . $myrow['categorydescription'] . '</option>';
		}
	}

	echo '</select></td>';	
	echo '<td>'. _('OR') . '<b> ' . _('Note') . '</b>:';
	echo '<input type="text" name="Note" size="20" maxlength="25" value="'. $_POST['Note'] . '"/></td></tr>';

	echo '<tr><td>'. _('Enter partial') . '<b> ' . _('Description') . '</b>:';
	if (isset($_POST['Keywords'])) {
		echo '<input type="text" name="Keywords" value="' . $_POST['Keywords'] . '" size="20" maxlength="25" />';
	} else {
		echo '<input type="text" name="Keywords" size="20" maxlength="25" />';
	}
	
	echo '</td><td><b>' . _('OR').' ' . '</b>' . _('Enter partial') .' <b>'. _('Asset Code') . '</b>:';

	if (isset($_POST['AssetID'])) {
		echo '<input type="text" name="AssetID" value="'. $_POST['AssetID'] . '" size="15" maxlength="18" />';
	} else {
		echo '<input type="text" name="AssetID" size="15" maxlength="18" />';
	}

	echo '</td></tr></table>';

	echo '<div class="centre"><input type="submit" name="Search" value="'. _('Search Now') . '" /></div>
          </div>
          </form>
          <br />';
}

if(isset($_POST['Prev']) || isset($_POST['Next'])){
	$_POST['Search']='';
	$_POST['AssetCat']=$_SESSION['AssetCat'];
	$_POST['Keywords']=$_SESSION['Keywords'];
	$_POST['AssetID']=$_SESSION['AssetID'];
	$_POST['Note']=$_SESSION['Note'];
}


if (isset($_POST['Search'])) {

	$_SESSION['AssetCat']=$_POST['AssetCat'];
	$_SESSION['Keywords']=$_POST['Keywords'];
	$_SESSION['AssetID']=$_POST['AssetID'];
	$_SESSION['Note']=$_POST['Note'];
	
	$SQL_WHERE = ' WHERE 1';
	if (!empty($_POST['AssetCat'])) {
		$SQL_WHERE .= ' AND fixedassets.assetcategoryid=\'' .$_POST['AssetCat'].'\'';
	}
	if (!empty($_POST['Keywords'])) {
		$SQL_WHERE .= ' AND fixedassets.description ' . LIKE . ' \'%'.$_POST['Keywords'].'%\'';
	}
	if (!empty($_POST['AssetID'])) {
		$SQL_WHERE .= ' AND fixedassets.assetid ' . LIKE . ' \'%'.$_POST['AssetID'].'%\'';
	}
	if (!empty($_POST['Note'])) {
		$SQL_WHERE .= ' AND fixedassetmoves.note ' . LIKE . ' \'%'.$_POST['Note'].'%\'';
	}

	$sql= "SELECT fixedassets.assetid,
					fixedassets.description as assetname,
					fixedassetmoves.note as note,
					locfrom.paths as fromloc,
					locto.paths as toloc,
					fixedassetcategories.categorydescription as category,
					www_users.realname as createdby,
					fixedassetmoves.createdday
				FROM fixedassetmoves
				INNER JOIN fixedassets 
				ON fixedassetmoves.fixedassetid=fixedassets.assetid
				LEFT JOIN fixedassetlocations locfrom
				ON fixedassetmoves.fromloc=locfrom.locationid
				LEFT JOIN fixedassetlocations locto 
				ON fixedassetmoves.toloc=locto.locationid
				LEFT JOIN fixedassetcategories 
				ON fixedassets.assetcategoryid=fixedassetcategories.categoryid
				INNER JOIN www_users 
				ON fixedassetmoves.createdby=www_users.userid ".
					$SQL_WHERE."
				ORDER BY fixedassetmoves.id DESC";

	$Result=DB_query($sql, $db);
}

	
	echo '<div>';
	echo '<table class="selection">';
	echo '<tr>
			<th>'._('Asset ID') . '</th>
			<th>' . _('Asset Description') . '</th>
			<th>' . _('Asset Category') . '</th>
			<th>' . _('Asset Note') . '</th>
			<th>' . _('From') . '</th>
			<th>' . _('To') . '</th>
			<th>' . _('Created Day') . '</th>
			<th>' . _('Created by') . '</th>
		</tr>';
	if($Result<>null)
	while ($myrow=DB_fetch_array($Result)) {

		echo '<tr>
				<td>'.$myrow['assetid'].'</td>
				<td>'.$myrow['assetname'].'</td>
				<td>'.$myrow['category'].'</td>
				<td>'.$myrow['note'].'</td>
				<td>'.$myrow['fromloc'].'</td>
				<td>'.$myrow['toloc'].'</td>
				<td>'.date("Y-m-d H:i:s",strtotime($myrow['createdday'])).'</td>
				<td>'.$myrow['createdby'].'</td>
			</tr>';
	}
	echo '</table>
          </div>';


include('includes/footer.inc');

?>