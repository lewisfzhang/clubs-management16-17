<?php 

	setcookie("clubid", "", time()-3600);
	setcookie("clubname", "", time()-3600);
	setcookie("clubleaders", "", time()-3600);
	setcookie("clubmoderator", "", time()-3600);
	setcookie("clubmeetinginfo", "", time()-3600);
	setcookie("clubdescription", "", time()-3600);
	setcookie("studentname", "", time()-3600);
	setcookie("studentid", "", time()-3600);

	header("Location: http://times.bcp.org/clubs/login.php?state=3") ;

?>