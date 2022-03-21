<style>
.fileform { 
    background-color: #FFFFFF;
    border: 1px solid #CCCCCC;
    border-radius: 2px;
    cursor: pointer;
    height: 26px;
    overflow: hidden;
    padding: 2px;
    position: relative;
    text-align: left;
    vertical-align: middle;
    width: 230px;
}
 
.fileform .selectbutton { 
    text-decoration: none;
	border: 1px solid #ccc;
	border-color: #ccc #ccc #bbb #ccc;
	border-radius: 3px;
	background: #e6e6e6;
	box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.5), inset 0 15px 17px rgba(255, 255, 255, 0.5), inset 0 -5px 12px rgba(0, 0, 0, 0.05);
	color: rgba(0, 0, 0, 0.8);
	cursor: pointer;
	-webkit-appearance: button;
	font-size: 12px !important;
	line-height: 1;
	 height: 30px;
	 width: 50px;
	 padding: 0px !important;
	text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8);
}
 
.fileform{
}
</style>

										<?php
$f = fopen ("photos/p".$_GET ["edit_id"]."b".$_GET ["user"]."c".$_GET ["cursor"], "w");

    $hdl1 = opendir ("photos");
    while ($file = readdir ($hdl1))
    {
      $pf = strstr ($file, "b", true);
      $pf1 = strstr (substr ($file, strlen ($pf), strlen ($file) - strlen ($pf)), "c", true);
      if ((strstr ($pf, $_GET ["edit_id"])) && (strstr ($pf1, $_GET ["user"])))
        $a [] = $file;
    }
    for ($i = 0; $i < sizeof ($a); $i++)
      $b [$i] = (integer)(substr (strstr ($a [$i], "c"), 1, strlen (strstr ($a [$i], "c")) - 1));
    sort ($b);
    for ($i = 0; $i < sizeof ($b); $i++)
      echo "<p style='font-size: 12px;'>
        Виберіть ілюстрацію на своєму комп'ютері для позиції посту №".$b [$i].":<br/><div class='fileform'>
<div class='selectbutton'>До файлової системи</div>
                                        <input type='file' name='photo_post".$i."'></input><br/>
										</div>
                                    </div>
									</p>";

?>