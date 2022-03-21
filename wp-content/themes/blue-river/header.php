<?php
//include "http://localhost/wpmu31/wp-includes/pluggable.php";
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Blue River
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">


<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php
		echo "&nbsp;<a href='http://localhost/wpmu31' style='margin-top: 100px !important;' title='Головна сторінка мережі'><img src='http://localhost/wpmu31/hata1_sm.jpg' style='margin-top: 10px !important;'></a>";
		if ($user_ID > 1)
		{
			$sqlstr = "SELECT path from wp_blogs where blog_id=(SELECT meta_value from wp_usermeta where meta_key='primary_blog' and user_id=".$user_ID.")";		
			$sites = $wpdb->get_results ($sqlstr, ARRAY_A);
			if (strlen ($sites [0]["path"]) > 0)
			{
			$sqlstr2 = "SELECT meta_value from wp_usermeta where user_id=".$user_ID." AND meta_key='sex'";			
		$user_data8 = $wpdb->get_results ($sqlstr2, ARRAY_A);
		$i = 0;
		if (file_exists ("../wpmu31/wp-content/uploads/avatars/".$user_ID))
		{
			$hdl1 = opendir ("../wpmu31/wp-content/uploads/avatars/".$user_ID);
			while ($file = readdir ($hdl1))
				$i++;
		}
		if ((strlen ($user_data8 [0]["meta_value"]) > 0) && ($user_data8 [0]["meta_value"] != "Не вказана") && ($i == 0))
			if ($user_data8 [0]["meta_value"] == "Чоловіча")
				echo "<a href='http://localhost/wpmu31/редагувати-особистий-профіль/' title='Редагувати особистий профіль' style='float: right !important; padding-top: 10px;'><img src='http://localhost/wpmu31/images12.jpg' style='height: 65px !important;'/>&nbsp;</a>";
			else
				echo "<a href='http://localhost/wpmu31/редагувати-особистий-профіль/' title='Редагувати особистий профіль' style='float: right !important; padding-top: 10px;'><img src='http://localhost/wpmu31/girl2.jpg' style='height: 65px !important;'/>&nbsp;</a>";
		else
			echo "<a href='http://localhost/wpmu31/редагувати-особистий-профіль/' title='Редагувати особистий профіль' style='float: right !important; padding-top: 10px;'>".get_avatar ($user_ID, 65)."&nbsp;</a>";
			}
		}
		do_action( 'before' );?>
	<header id="masthead" class="site-header" role="banner">
		<?php		
			global $blog_id;
				
		global $switched;		
		global $wpdb;
		$blog_list = get_blog_list( 0, 'all' ); 
		$sqlstr = "SELECT path from wp_blogs where blog_id=".$blog_id;		
		$pathes = $wpdb->get_results($sqlstr, ARRAY_A);
		$p1 = $pathes [0]["path"];
		$sqlstr = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$blog_id;		
		$photo_list = $wpdb->get_results($sqlstr, ARRAY_A);
		if ($blog_id != 1)
		foreach ($photo_list as $post)
		{
			$p = $post ["user_id"];
			$sqlstr2 = "SELECT meta_value from wp_usermeta where user_id=".$p." AND meta_key='sex'";			
		$user_data8 = $wpdb->get_results ($sqlstr2, ARRAY_A);
		$i = 0;
		if (file_exists ("../wpmu31/wp-content/uploads/avatars/".$p))
		{
			$hdl1 = opendir ("../wpmu31/wp-content/uploads/avatars/".$p);
			while ($file = readdir ($hdl1))
				$i++;
		}
		if ((strlen ($user_data8 [0]["meta_value"]) > 0) && ($user_data8 [0]["meta_value"] != "Не вказана") && ($i == 0))
			if ($user_data8 [0]["meta_value"] == "Чоловіча")
				echo "<a href='http://localhost".$p1."' style='margin-left: 10% !important;'><img src='http://localhost/wpmu31/images12.jpg' style='height: 100px !important;'/></a>";
			else
				echo "<a href='http://localhost".$p1."' style='margin-left: 10% !important;'><img src='http://localhost/wpmu31/girl2.jpg' style='height: 100px !important;'/></a>";
		else
			echo "<a href='http://localhost".$p1."' style='margin-left: 10% !important;'>".get_avatar ($post ["user_id"], 100)."</a>";
		}
		 
		$sqlstr = "SELECT user_login from wp_users where ID=".$p;		
		$user_list = $wpdb->get_results($sqlstr, ARRAY_A);
		if ($blog_id != 1)
		{
		foreach ($user_list as $user)
		{		
			$u = $user ["user_login"];
			break;
		}
		}
		$sqlstr = "SELECT meta_value from wp_usermeta where meta_key='first_name' and user_id=(SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$blog_id.")";
		$names = $wpdb->get_results($sqlstr, ARRAY_A);
		$sqlstr = "SELECT meta_value from wp_usermeta where meta_key='last_name' and user_id=(SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$blog_id.")";		
		$surnames = $wpdb->get_results($sqlstr, ARRAY_A);
		?>
		<div style="display: inline-block !important;">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php 
			if ($blog_id == 1)
				bloginfo( 'name' );
			else
				if ($names [0]["meta_value"] != "")
				{
					echo $names [0]["meta_value"];
					if ($surnames [0]["meta_value"] != "")
						echo " ".$surnames [0]["meta_value"];
				}
				else
					if ($surnames [0]["meta_value"] != "")
						echo $surnames [0]["meta_value"];
					else
						echo "?";
			?></a></h1>
			<h2 class="site-description"><?php
			/*if ($blog_id != 1)
				echo "Блог користувача ".$u;
			else*/
			if ($blog_id == 1)
				if (get_the_ID() == 28)
					echo "Головна сторінка"
			?></h2>
		</div>
		<?php // Output a single menu item
		function projects_menu_entry($id, $title, $link_self){    global $blog_id;    if ($link_self || $id != $blog_id) {        echo '<li>';        if ($id == $blog_id) {            echo '<strong>';        }        $url = get_home_url($id);        if (substr($url, -1) != '/') {            // Note: I added a "/" to the end of the URL because WordPress            // wasn't doing that automatically in v3.0.4. YMMV.
		$url .= '/';        }        echo '<a href="' . $url . '">' . $title . '</a>';        if ($id == $blog_id) {            echo '</strong>';        }        echo '</li>'; 
		}} // Output the whole menu// If $link_self is false, skip the current site - used to display the menu on the homepage
		function projects_menu($link_self = true){    global $wpdb;     echo '<ul>';     projects_menu_entry(1, 'До основної стрічку користувача', $link_self);     $blogs = $wpdb->get_results("        SELECT blog_id        FROM {$wpdb->blogs}        WHERE site_id = '{$wpdb->siteid}'        AND spam = '0'        AND deleted = '0'        AND archived = '0'        AND blog_id != 1    ");     $sites = array();    foreach ($blogs as $blog) {        $sites[$blog->blog_id] = get_blog_option($blog->blog_id, 'blogname');    }     natsort($sites);    foreach ($sites as $blog_id => $blog_title) {        projects_menu_entry($blog_id, $blog_title, $link_self);    }    echo '</ul>';
		} // Adds a [bloglist] shortcode, so I can embed the menu into the static homepage.// Note: I originally put it directly into the template, but that didn't work// with WPtouch.
		function bloglist_shortcode($atts){    projects_menu(false);} add_shortcode('bloglist', 'bloglist_shortcode');
		?>
		

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<h1 class="menu-toggle"><?php _e( 'Меню', 'blue-river' ); ?></h1>
			<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'blue-river' ); ?></a>

			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content" style="width: 100%; display; inline-block !important; position: relative; top: 50px !important; padding-bottom: 30px !important;">
