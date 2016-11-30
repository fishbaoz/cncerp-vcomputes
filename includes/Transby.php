<?php
function addTransBy($type,$typeno,$step=0,$userid=0){
	global $db;
	if($userid==0){
		$userid=$_SESSION['UserID'];
	}
	$stepdate=Date('Y-m-d H:i:s');
	$sql='select realname from www_users where userid=\''.$userid.'\'';
	$result=DB_query($sql, $db);
	$myrow=DB_fetch_array($result);
	$sql='insert into transby(type,typeno,step,stepdate,userid,realname)values('.$type.','.$typeno.','.$step.',\''.$stepdate.'\',\''.$userid.'\',\''.$myrow['realname'].'\');';
	
	DB_query($sql, $db);
}
function getTransBy($type,$typeno,$step=0){
	global $db;
	$sql='select userid,realname,stepdate from transby where type='.$type.' and typeno='.$typeno.' and step='.$step.' order by id desc limit 1';
	$result=DB_query($sql, $db);
	$myrow=DB_fetch_array($result);
	if($myrow)
		return array($myrow['userid'],$myrow['realname'],$myrow['stepdate']);
	else
		return array('','',0);
}
?>
