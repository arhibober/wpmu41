<?php
	$f = fopen ("cur_photo.txt", "w+");
	fwrite ($f, $_GET ["caret"]);
	fclose ($f);
?>