<?php
	$dirct = "../wpmu41";
        $hdl = opendir ($dirct);
        while ($file = readdir ($hdl)) 
            if (strstr ($file, "PHOTO".$_POST ["user"]."_".$_POST ["id"].".") == true)
				unlink ("../wpmu41/".$file);
		//header("location:".$_SERVER[HTTP_REFERER]);
?>