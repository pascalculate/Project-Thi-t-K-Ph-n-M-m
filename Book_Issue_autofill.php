<?php

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");

	handle_maintenance();

	header('Content-type: text/javascript; charset=' . datalist_db_encoding);

	$table_perms = getTablePermissions('Book_Issue');
	if(!$table_perms[0]){ die('// Access denied!'); }

	$mfk=$_GET['mfk'];
	$id=makeSafe($_GET['id']);
	$rnd1=intval($_GET['rnd1']); if(!$rnd1) $rnd1='';

	if(!$mfk){
		die('// No js code available!');
	}

	switch($mfk){

		case 'Member':
			if(!$id){
				?>
				$('Number<?php echo $rnd1; ?>').innerHTML='&nbsp;';
				<?php
				break;
			}
			$res = sql("SELECT `Users`.`id` as 'id', `Users`.`Membership_Number` as 'Membership_Number', `Users`.`Name` as 'Name', `Users`.`Contact` as 'Contact', `Users`.`ID_Number` as 'ID_Number' FROM `Users`  WHERE `Users`.`id`='$id' limit 1", $eo);
			$row = db_fetch_assoc($res);
			?>
			$j('#Number<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['Membership_Number']))); ?>&nbsp;');
			<?php
			break;

		case 'Book_Number':
			if(!$id){
				?>
				$('Book_Title<?php echo $rnd1; ?>').innerHTML='&nbsp;';
				<?php
				break;
			}
			$res = sql("SELECT `books`.`id` as 'id', `books`.`ISBN_NO` as 'ISBN_NO', `books`.`Book_Title` as 'Book_Title', IF(    CHAR_LENGTH(`Types1`.`Name`), CONCAT_WS('',   `Types1`.`Name`), '') as 'Book_Type', `books`.`Author_Name` as 'Author_Name', `books`.`Quantity` as 'Quantity', if(`books`.`Purchase_Date`,date_format(`books`.`Purchase_Date`,'%m/%d/%Y'),'') as 'Purchase_Date', `books`.`Edition` as 'Edition', `books`.`Price` as 'Price', `books`.`Pages` as 'Pages', `books`.`Publisher` as 'Publisher' FROM `books` LEFT JOIN `Types` as Types1 ON `Types1`.`id`=`books`.`Book_Type`  WHERE `books`.`id`='$id' limit 1", $eo);
			$row = db_fetch_assoc($res);
			?>
			$j('#Book_Title<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['Book_Title']))); ?>&nbsp;');
			<?php
			break;


	}

?>
