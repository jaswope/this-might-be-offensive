<?
	set_include_path("..");
	require_once("offensive/assets/header.inc");
	// Include, and check we've got a connection to the database.
	require_once( 'admin/mysqlConnectionInfo.inc' );
	if(!isset($link) || !$link) $link = openDbConnection();

	mustLogIn();

	$fileid = array_key_exists("fileid", $_REQUEST) ? $_REQUEST['fileid'] : "";
	
	if( array_key_exists("un", $_REQUEST) && $_REQUEST['un'] == 1 ) {
		unsubscribe($fileid);
	}
	else {
		subscribe($fileid);
	}

	if(array_key_exists("HTTP_REFERER", $_SERVER)) {
		header( "Location: " . $_SERVER['HTTP_REFERER']);
	} else {
		echo "<html><head><script type=\"text/javascript\">history.go(-1);</script></head><body /></html>";
	}
	exit;

	function subscribe($fid) {
		$sql = "SELECT * FROM offensive_subscriptions WHERE userid = ".me()->id()." AND fileid = $fid";
		if(mysql_num_rows(tmbo_query($sql)) > 0) return;

		$sql = "INSERT INTO offensive_subscriptions (userid, fileid) VALUES (".me()->id().", $fid )";
		tmbo_query( $sql );
	}

	function unsubscribe($fid) {
		$sql = "DELETE FROM offensive_subscriptions WHERE userid=".me()->id()." AND fileid=$fid";
		tmbo_query( $sql );
	}

?>