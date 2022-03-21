<?php

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Blue River
 */
 
global $user_ID;
?>

<?php
		if ($_POST ["edit_id"] > 0)
		{
		?>
		<!DOCTYPE html>
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
		$sqlstr = "SELECT path from wp_blogs where blog_id=".$_GET ["user"];		
		$pathes = $wpdb->get_results($sqlstr, ARRAY_A);
		$p1 = $pathes [0]["path"];
		$sqlstr = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$user_ID;		
		$photo_list = $wpdb->get_results($sqlstr, ARRAY_A);
		if ($user_ID != 1)
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
		if ($user_ID != 1)
		{
		foreach ($user_list as $user)
		{		
			$u = $user ["user_login"];
			break;
		}
		}
		$sqlstr = "SELECT meta_value from wp_usermeta where meta_key='first_name' and user_id=(SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$user_ID.")";
		$names = $wpdb->get_results($sqlstr, ARRAY_A);
		$sqlstr = "SELECT meta_value from wp_usermeta where meta_key='last_name' and user_id=(SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$user_ID.")";		
		$surnames = $wpdb->get_results($sqlstr, ARRAY_A);
		?>
		<div style="display: inline-block !important;">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php 
			if ($_GET ["user"] == 1)
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
			if ($user_ID == 1)
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
	<?php
		$is_submit = true;
		global $wpdb;
		global $blog_id;
		global $user_ID;
		$blog_list = get_blog_list ( 0, 'all'); 		
		$output = '';
		$own_post = false;
		$sqlstr = "SELECT meta_value from wp_usermeta where meta_key='primary_blog' and meta_value=".$user_ID;		
		$posts2 = $wpdb->get_results ($sqlstr, ARRAY_A);
		foreach ($posts2 as $post2)
			if ($post2 ["meta_value"] == $_POST ["blog_id"])
				$own_post = true;
			if (($user_ID != 0) && ($own_post))
			{
echo "<div id='primary' class='content-area' style='background-color: #ffffff !important; padding-left: 10px; padding-top: 10px;'>
<main id='main' class='site-main' role='main'>";
			$isAvatar = false;
		$dirct = "../wpmu31";
        $hdl = opendir ($dirct);
        while ($file = readdir ($hdl)) 
            if (strstr ($file, "PHOTO".$user_ID."_".$_POST ["edit_id"].".") == true)
			{
				echo "<form method='post' action='http://localhost/wpmu31/remove_avatar.php'>
				<input type='hidden' name='user' value='".$user_ID."'>
				<input type='hidden' name='id' value='".$_POST ["edit_id"]."'>
				<input type='submit' value='Видалити аватар' class='buttons' style='font-size: 12px !important;'>
				</form>";
				$isAvatar = true;
			}
		global $userdata;
		$sqlstr = "SELECT post_title, post_content from wp_".$_POST ["blog_id"]."_posts where ID=".$_POST ["edit_id"];		
		$posts = $wpdb->get_results($sqlstr, ARRAY_A);
		foreach ($posts as $post1)
		{
			$title1 = $post1 ["post_title"];
			$content1 = $post1 ["post_content"];
		}
        $userdata = get_user_by( 'id', $userdata->ID );

		echo $_POST['wpuf_post_new_submit'];
        if ( isset( $_POST['wpuf_post_new_submit'] ) ) {
            submit_post();
        }
        if ($_POST['wpuf_edit_post_submit'] == "yes") {
			$is_submit = false;
            submit_post1();
        }

        $info = __( "Post It!", 'wpuf' );
        $can_post = 'yes';

        $info = apply_filters( 'wpuf_addpost_notice', $info );
        $can_post = apply_filters( 'wpuf_can_post', $can_post );
        $featured_image = wpuf_get_option( 'enable_featured_image', 'wpuf_frontend_posting', 'no' );

        $title = isset( $_POST['wpuf_post_title'] ) ? esc_attr( $_POST ['wpuf_post_title'] ) : '';
        $description = isset( $_POST['wpuf_post_content'] ) ? $_POST ['wpuf_post_content'] : '';		
		global $wpdb;
		$sqlstr = "SELECT id from wp_".$blog_id."_posts";
		$post_list = $wpdb->get_results($sqlstr, ARRAY_A);
		$current_id = 0;
		foreach ($post_list as $post1) 
			if ($post1 ["id"] > $current_id)	
				$current_id = $post1 ["id"];
		$current_id++;
		
		$post_tags = wp_get_post_tags($_POST ["edit_id"]);
        $tagsarray = array();
        foreach ($post_tags as $tag) {
            $tagsarray[] = $tag->name;
        }
        $tagslist = implode( ', ', $tagsarray );
        $categories = get_the_category($_POST ["edit_id"]);
        $featured_image = wpuf_get_option( 'enable_featured_image', 'wpuf_frontend_posting', 'no' );
		if ($is_submit)
		{
        ?>	
		<h2>Редагувати поточний пост</h2>
        <div id="wpuf-post-area1">	
            <form name="wpuf_edit_post_form" id="wpuf_edit_post_form" action="" enctype="multipart/form-data" method="POST">
                <?php wp_nonce_field( 'wpuf-edit-post' ) ?>
                <ul class="wpuf-post-form">

                    <?php do_action( 'wpuf_add_post_form_top', $curpost->post_type, $curpost ); //plugin hook      ?>
                    <?php wpuf_build_custom_field_form( 'top', true, $_POST ["edit_id"]); ?>

                    

                    <li>
                        <label for="new-post-title1">
                            <?php echo wpuf_get_option( 'title_label', 'wpuf_labels', 'Заголовок' ); ?> <span class="required">*</span>
                        </label>
                        <input type="text" name="wpuf_post_title1" id="new-post-title1" minlength="2" value="<?php echo $title1; ?>">
                        <div class="clear"></div>
                        <p class="description"><?php echo stripslashes( wpuf_get_option( 'title_help', 'wpuf_labels' ) ); ?></p>
                    </li>
					<?php if ( $featured_image == 'yes' ) { ?>
                        <?php if ( current_theme_supports( 'post-thumbnails' ) ) { ?>
                            <li>
                                <label for="post-thumbnail"><?php echo wpuf_get_option( 'ft_image_label', 'wpuf_labels', 'Аватар' ); ?></label>
                                <div id="wpuf-ft-upload-container">
                                    <div id="wpuf-ft-upload-filelist">
                                        <?php
                                        $style = '';
		echo "<style>
		.fileform { 
    background-color: #FFFFFF;
    border: 1px solid #CCCCCC;
    border-radius: 2px;
    cursor: pointer;
    height: 26px;
    overflow: hidden;
    position: relative;
    text-align: left;
    vertical-align: middle;
    width: 92px;
}
 
.fileform .selectbutton {
	padding: 5px !important;
    font-size: smaller !important;
    background-color: #3C96C9 !important;
    transition: #3A6EA5 0.3s ease-in-out 0s !important;
	color: #FFF !important;
	border: 0 !important;
	box-shadow: none !important;
	border-radius: 0 !important;
}
 
.fileform #upload{
    position:absolute; 
    top:0; 
    left:0; 
    width:100%; 
    -moz-opacity: 0; 
    filter: alpha(opacity=0); 
    opacity: 0; 
    font-size: 150px; 
    height: 30px; 
    z-index:20;
}
</style>

										<div class='fileform'>
<div class='selectbutton'>Завантажити</div>
                                        <input type='file' id='upload' name='avatar'></input>
										</div>";
                                        ?>
										
                                    </div>
                                    
                                </div>
                                <div class="clear"></div>
                            </li>
                        <?php } else { ?>
                            <div class="info"><?php _e( 'Your theme doesn\'t support featured image', 'wpuf' ) ?></div>
                        <?php } ?>
                    <?php } ?>

                    <?php if ( wpuf_get_option( 'allow_cats', 'wpuf_frontend_posting', 'on' ) == 'on' ) { ?>
                        <li>
                            <label for="new-post-cat">
                                <?php echo wpuf_get_option( 'cat_label', 'wpuf_labels', 'Категорія' ); ?> <span class="required">*</span>
                            </label>

                            <?php
                            $exclude = wpuf_get_option( 'exclude_cats', 'wpuf_frontend_posting' );
                            $cat_type = wpuf_get_option( 'cat_type', 'wpuf_frontend_posting' );

                            $cats = get_the_category (183);
							$selected = $_POST ["cat"];
                            ?>
                            <div class="category-wrap" style="float:left;">
                                <div id="lvl01">
                                    <?php
									
									$cats = array ("Щоденник", "Поезія", "Проза", "Живопис і фотографія", "Музика", "Відео");
									echo "<select name='category'>";
									for ($i = 0; $i < 6; $i++)
									{
										echo "<option id='".$i."'";
										if ($i == $_POST ["cat"] - 1)
											echo " selected";
										echo ">".$cats [$i]."</option>";
									}
									echo "</select>";
                                    ?>
                                </div>
                            </div>
                            <div class="loading"></div>
                            <div class="clear"></div>
                            <p class="description"><?php echo stripslashes( wpuf_get_option( 'cat_help', 'wpuf_labels' ) ); ?></p>
                        </li>
                    <?php } ?>

                    <?php do_action( 'wpuf_add_post_form_description', $curpost->post_type, $curpost ); ?>
                    <?php wpuf_build_custom_field_form( 'description', true, $_POST ["edit_id"]); ?>

                    
                        
						<li style="float: block !important;">

                        <label for="new-post-desc">
                            <?php echo wpuf_get_option( 'desc_label', 'wpuf_labels', 'Текст посту' ); ?> <span class="required">*</span><br/>
                        </label>

                        <?php
                        $editor = 'full';
                            ?>
                            <div style="float:left;">
                                <?php
								echo "<textarea name='wpuf_post_content1' id='wpuf_post_content1' cols='60' rows='10'>".
			$content1.
			"</textarea>";
			?>
                            </div>
                    </li>

                    <?php do_action( 'wpuf_add_post_form_after_description', $curpost->post_type, $curpost ); ?>
                    <?php wpuf_build_custom_field_form( 'tag', true, $_POST ["edit_id"]);
echo "
						<input type='hidden' name='edit_id' value='".$_POST ["edit_id"]."'/>
				<input type='hidden' name='blog_id' value='".$_POST ["blog_id"]."'/>
				<input type='hidden' name='cat' value='".$_POST ["cat"]."'/>";					?>
					
					<br/><br/><br/><br/><br/><br/><br/><br/><br/>

                                           

                    

					
		                    <li style="float: block !important;">
                        <label>&nbsp;</label>
                        <input class="buttons" style="background-color: #3C96C9 !important; font-size: 12px !important; font-family: 'Berkshire Swash, comic',cursive !important;" type="submit" name="wpuf_edit_post_submit1" value="<?php echo esc_attr( wpuf_get_option( 'update_label', 'wpuf_labels', 'Оновити пост' ) ); ?>">
                        <input type="hidden" name="wpuf_edit_post_submit" value="yes" />
                        <input type="hidden" name="post_id1" value="<?php echo $_POST ["edit_id"]; ?>">
                    </li>
                </ul>
            </form>
        </div>


        <?php
		}
		echo "</main></div><div id='secondary' class='widget-area' role='complementary'>";
		
	
 get_sidebar();
 echo "</div>
 </div>";
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Blue River
 */


	echo "<footer id='colophon' class='site-footer' role='contentinfo' style='position: relative; top: 50px;'>
		<div class='site-info' style='text-align: center;'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( '2014', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Дизайн: <a href="mailto:arhibober@gmail.com" rel="designer">arhobober</a>' ));
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->";

wp_footer();
echo "</body>
</html>";
		}
		else
		{
			echo "<div id='primary' class='content-area' style='background-color: #ffffff !important; padding-left: 10px; padding-top: 10px;'>
		<main id='main' class='site-main' role='main'>
		Здається, Ви мали на увазі іншу сторінку.";
		echo "</main></div><div id='secondary' class='widget-area' role='complementary'>";
		
	
 get_sidebar();
 echo "</div>
 </div>";
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Blue River
 */



	echo "<footer id='colophon' class='site-footer' role='contentinfo' style='position: relative; top: 50px;'>
		<div class='site-info' style='text-align: center;'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( '2014', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Дизайн: <a href="mailto:arhibober@gmail.com" rel="designer">arhobober</a>' ));
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->";

echo "</body>
</html>";

		}
		}
else
{
if ($_POST ["remove_id"] > 0)
		{
		
		?>
		<!DOCTYPE html>
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
		$sqlstr = "SELECT path from wp_blogs where blog_id=".$_GET ["user"];		
		$pathes = $wpdb->get_results($sqlstr, ARRAY_A);
		$p1 = $pathes [0]["path"];
		$sqlstr = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$user_ID;		
		$photo_list = $wpdb->get_results($sqlstr, ARRAY_A);
		if ($user_ID != 1)
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
		if ($user_ID != 1)
		{
		foreach ($user_list as $user)
		{		
			$u = $user ["user_login"];
			break;
		}
		}
		$sqlstr = "SELECT meta_value from wp_usermeta where meta_key='first_name' and user_id=(SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$user_ID.")";
		$names = $wpdb->get_results($sqlstr, ARRAY_A);
		$sqlstr = "SELECT meta_value from wp_usermeta where meta_key='last_name' and user_id=(SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$user_ID.")";		
		$surnames = $wpdb->get_results($sqlstr, ARRAY_A);
		?>
		<div style="display: inline-block !important;">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php 
			if ($_GET ["user"] == 1)
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
			if ($user_ID == 1)
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
	<?php
		global $wpdb;
		global $blog_id;
		global $user_ID;
		$blog_list = get_blog_list ( 0, 'all'); 		
		$output = '';
		$own_post = false;
		$sqlstr = "SELECT meta_value from wp_usermeta where meta_key='primary_blog' and meta_value=".$user_ID;		
		$posts2 = $wpdb->get_results ($sqlstr, ARRAY_A);
		foreach ($posts2 as $post2)
			if ($post2 ["meta_value"] == $_POST ["blog_id"])
				$own_post = true;
			if (($user_ID != 0) && ($own_post))
			{
			global $wpdb;
	$wpdb->query("DELETE FROM wp_".$_POST ["blog_id"]."_posts WHERE ID=".$_POST ["remove_id"]);
	echo "<div id='primary' class='content-area' style='background-color: #ffffff !important; padding-left: 10px; padding-top: 10px;'>
<main id='main' class='site-main' role='main'>
<div class='container'>Пост успішно видален.</div>
	</main></div><div id='secondary' class='widget-area' role='complementary'>";
		
	
 get_sidebar();
 echo "</div>
 </div>";
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Blue River
 */


	echo "<footer id='colophon' class='site-footer' role='contentinfo' style='position: relative; top: 50px;'>
		<div class='site-info' style='text-align: center;'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( '2014', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Дизайн: <a href="mailto:arhibober@gmail.com" rel="designer">arhobober</a>' ));
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->";

wp_footer();
echo "</body>
</html>";
		}
		else
		{
			echo "<div id='primary' class='content-area' style='background-color: #ffffff !important; padding-left: 10px; padding-top: 10px;'>
<main id='main' class='site-main' role='main'>
Здається, Ви мали на увазі іншу сторінку.";
		echo "</main></div><div id='secondary' class='widget-area' role='complementary'>";
		
	
 get_sidebar();
 echo "</div>
 </div>";
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Blue River
 */



			echo "<footer id='colophon' class='site-footer' role='contentinfo' style='position: relative; top: 50px;'>
			<div class='site-info' style='text-align: center;'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( '2014', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Дизайн: <a href="mailto:arhibober@gmail.com" rel="designer">arhobober</a>' ));
			echo "</div><!-- .site-info -->
			</footer><!-- #colophon -->";
			echo "</body>
			</html>";
		}
	}
else
{
	switch ($_GET ["type"])
	{
		case "all_posts":
		get_header();
		echo "<h1 style='color: #ffffff;'>Нові пости мережі</h1>
		<div style='display: inline-block; position: relative; top: -68px;' class='left-column content-area' id='primary'>";
		global $switched;		
		global $wpdb;
		global $user_ID;
		global $pages;
		$table_prefix = $wpdb->base_prefix;
		$blog_list = get_blog_list (0, "all"); 		
		$output = '';
		$j = 0;
		foreach ($blog_list as $blog)
		{
			if ($blog ['blog_id'] != 1)
			{
			if ($j > 0)
				$sqlstr .= " union ";
				$sqlstr .= "SELECT b.path, b.blog_id, p.id, p.post_title, p.post_content, p.post_date, p.post_date_gmt, p.post_modified, p.post_name from wp_".$blog ["blog_id"]."_posts as p, wp_blogs as b where p.post_status = 'publish' and p.post_type = 'post' and b.blog_id=".$blog ["blog_id"];
			$j++;
			}			
		}
		$sqlstr.= " ORDER BY post_modified desc ";
		
		$post_list = $wpdb->get_results($sqlstr, ARRAY_A);
		$i = $_GET ["page1"] * 10;
		for ($i = $_GET ["page1"] * 10; $i < $_GET ["page1"] * 10 + 10; $i++)
		{
			if ($i == count ($post_list))
				break;
					echo "<div style='display: inline !important;'><div style='position: relative !important;
					top: 70px !important;
					left: -70px !important;
	width: 70px !important;
	height: 70px !important;
	border-top-left-radius: 35px !important;
	border-bottom-left-radius: 35px !important;
	border-bottom-right-radius: 35px !important;
	padding: 0.4em !important;
	font-size: 1.2em !important;
	text-align: center !important;
	color: #ffffff !important;
	background-color: #004369 !important;'>";
	echo substr ($post_list [$i]["post_date"], 8, 2).".".substr ($post_list [$i]["post_date"], 5, 2);
	echo "</div><div style='background-color: #ffffff;'>
					
					<article id='post-".$post_list [$i]["id"]."' >	

	<header class='entry-header'>";
	the_post();
		
		echo "<h1 class='entry-title'><a href='http://localhost".$post_list [$i]["path"].substr ($post_list [$i]["post_date"], 0, 4)."/".substr ($post_list [$i]["post_date"], 5, 2)."/".substr ($post_list [$i]["post_date"], 8, 2)."/".$post_list [$i]["post_name"]."' rel='bookmark'>".$post_list [$i]["post_title"]."</a></h1>";
	$sqlstr = "select term_id, slug, name from wp_".$post_list [$i]["blog_id"]."_terms where term_id=(select term_taxonomy_id from wp_".$post_list [$i]["blog_id"]."_term_relationships where object_id=".$post_list [$i]["id"].")";
		$cat_list = $wpdb->get_results ($sqlstr, ARRAY_A);
		
		echo "<span class='cat-links'>
		<a href='http://localhost".$post_list [$i]["path"]."/category/".$cat_list [0]["slug"]."/' title='".$cat_list [0]["name"]."'>".$cat_list [0]["name"]."</a>
		</span>
		
	</header><!-- .entry-header -->
	
	<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Автор: ".substr ($post_list [$i]["path"], 8, strlen ($post_list [$i]["path"]) - 9)."</div>
	<div class='thumb-container'>
		<a href='http://localhost".$post_list [$i]["path"].substr ($post_list [$i]["post_date"], 0, 4)."/".substr ($post_list [$i]["post_date"], 5, 2)."/".substr ($post_list [$i]["post_date"], 8, 2)."/".$post_list [$i]["post_name"]."' title='".$post_list [$i]["post_title"]."'>";
				get_post_thumbnail_id ($post_list [$i]["id"]);
				if (strstr ($post_list [$i]["post_content"], "nggallery"))
				{
				echo "</a>
	</div><!-- .thumb-container -->	

	<div class='entry-summary' style='max-height: 600px !important; overflow: hidden !important;'>";
	$cont = $post_list [$i]["post_content"];
	$cont1 = "";
	while (strstr ($cont, "nggallery"))
	{
		$cont = strstr ($cont, "[nggallery");
		global $wpdb;
		$sqlstr = "SELECT name from wp_".$post_list [$i]["blog_id"]."_ngg_gallery where gid=".substr (strstr ($cont, "]", true), 14, strlen (strstr ($cont, "]", true)) - 14);
		$gal_name = $wpdb->get_results ($sqlstr, ARRAY_A);
		$cont = substr (strstr ($cont, "]"), 1, strlen (strstr ($cont, "]")) - 1);
		$cont1 .= "<div style='display: inline !important;'>";
		$hdl1 = opendir ("../wpmu31/wp-content/uploads/sites/".$post_list [$i]["blog_id"]."/nggallery/".$gal_name [0]["name"]."/thumbs");
		while ($f = readdir ($hdl1))
		if (!strstr ($f, "_backup") && ($f != ".") && ($f != ".."))
			$cont1 .= "<span style='width: 100px !important;'><img src='http://localhost/wpmu31/wp-content/uploads/sites/".$post_list [$i]["blog_id"]."/nggallery/".$gal_name [0]["name"]."/thumbs/".$f."'></span>";
		$cont1 .= "</div>";
	}
	$cont1 .= $cont;		
	echo $cont1."</div>";;
		}
		else
				echo "</a>
	</div><!-- .thumb-container -->	

	<div class='entry-summary' style='max-height: 600px !important; overflow: hidden !important;'>".$post_list [$i]["post_content"]."</div><!-- .entry-summary -->";
	$sqlstr = "select comment_ID from wp_".$post_list [$i]["blog_id"]."_comments where comment_post_ID=".$post_list [$i]["id"];
	$comm_list = $wpdb->get_results ($sqlstr, ARRAY_A);

	echo "<footer class='entry-meta'>
	<div style='padding: 0 !important;'>
			<span class='comments-link' style='font-size: 12px;'><a href='http://localhost".$post_list [$i]["path"].substr ($post_list [$i]["post_date"], 0, 4)."/".substr ($post_list [$i]["post_date"], 5, 2)."/".substr ($post_list [$i]["post_date"], 8, 2)."/".$post_list [$i]["post_name"]."/#respond'>";
			switch (count ($comm_list))
			{
				case 0:
					echo "Залишити коментарій";
					break;
				case 1:
					echo "1 коментарій";
					break;
				default:
					echo count ($comm_list)." коментаріів";
					break;
			}
			echo "</a></span>";
			
			global $post;
global $blog_id;
				
		global $switched;		
		global $wpdb;
		$blog_list = get_blog_list( 0, 'all' ); 		
		$output = '';
		$own_post = false;
		echo false;
		$sqlstr = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$post_list [$i]["blog_id"];		
		$photo_list = $wpdb->get_results ($sqlstr, ARRAY_A);
		foreach ($photo_list as $post2)
			if ($post2 ["user_id"] == $user_ID)
				$own_post = true;
			if (($user_ID != 0) && ($post1 ["blog_id"] != 1) && ($own_post))
				echo "<form action='http://localhost/wpmu31/додати-новий-пост' method='post' style='display: inline !important;'>
				<input type='hidden' name='edit_id' value='".$post_list [$i]["id"]."'/>
				<input type='hidden' name='blog_id' value='".$post_list [$i]["blog_id"]."'/>
				<input type='hidden' name='cat' value='".$cat_list [0]["term_id"]."'/>
				<input type='submit' value='Редагувати' class='buttons' style='height: 30px !important; font-size: 12px !important;'/>
				</form>
				<form action='http://localhost/wpmu31/додати-новий-пост' method='post' style='display: inline !important;'>
				<input type='hidden' name='remove_id' value='".$post_list [$i]["id"]."'/>
				<input type='hidden' name='blog_id' value='".$post_list [$i]["blog_id"]."'/>
				<input type='submit' value='Видалити' class='buttons' style='height: 30px !important; font-size: 12px !important;'/>
				</form>";

		echo "<div class='read-more' style='height: 30px !important; margin: 0px !important; float: right !important;'>
			<a href='http://localhost".$post_list [$i]["path"].substr ($post_list [$i]["post_date"], 0, 4)."/".substr ($post_list [$i]["post_date"], 5, 2)."/".substr ($post_list [$i]["post_date"], 8, 2)."/".$post_list [$i]["post_name"]."'>Далі</a>
		</div>
		</div>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
</div>
</div>";
}
if (($i > 10) || ($i < count ($post_list)))
{
	echo "<div style='background-color: #ffffff; position: relative; top: 71px; height: 45px; vertical-align: middle; padding-top: 10px; padding-right: 20px; padding-left: 20px; margin-bottom: 3px;'>";
	if ($i < count ($post_list))
		echo "<div style='float: right;'><a href='http://localhost/wpmu31/додати-новий-пост/?type=all_posts&page1=".($i / 10)."'>Старі пости<span class='meta-nav'>&rarr;</span></a></div>";
	if ($i > 10)
		echo "<div style='float: left;'><a href='http://localhost/wpmu31/додати-новий-пост/?type=all_posts&page1=".($i / 10 - 2)."'><span class='meta-nav'>&larr;</span>Нові пости</a></div>";
	echo "</div>";
}
		echo "</div>
		<div id='secondary' class='widget-area' role='complementary' style='position: relative; top: -43px;'>";			
 get_sidebar();
 if (count ($post_list) > 10)
	echo "</div>
	</div>
	<footer id='colophon' class='site-footer' role='contentinfo' style='position: relative; top: 50px;'>
		<div class='site-info'>";
 else
	echo "</div>
	</div>
	<footer id='colophon' class='site-footer' role='contentinfo'>
		<div class='site-info' style='text-align: center;'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( '2014', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Дизайн: <a href="mailto:arhibober@gmail.com" rel="designer">arhobober</a>' ));
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->";

wp_footer();
echo "</body>
</html>";
	break;
case "all_posts_abc":
get_header();
echo "<div style='display: inline-block; position: relative; top: -68px;' class='left-column content-area' id='primary'>";
global $switched;		
		global $wpdb;
		global $user_ID;
		global $pages;
		$table_prefix = $wpdb->base_prefix;
		$blog_list = get_blog_list (0, "all"); 		
		$output = '';
		$j = 0;
		foreach ($blog_list as $blog)
		{
			if ($blog ['blog_id'] != 1)
			{
			if ($j > 0)
				$sqlstr .= " union ";
				$sqlstr .= "SELECT b.path, b.blog_id, p.id, p.post_title, p.post_content, p.post_date, p.post_date_gmt, p.post_modified, p.post_name from wp_".$blog ["blog_id"]."_posts as p, wp_blogs as b where p.post_status = 'publish' and p.post_type = 'post' and b.blog_id=".$blog ["blog_id"];
			$j++;
			}			
		}
		$sqlstr.= " ORDER BY post_title asc ";
		
		$post_list = $wpdb->get_results($sqlstr, ARRAY_A);
		$i = $_GET ["page1"] * 10;
		for ($i = $_GET ["page1"] * 10; $i < $_GET ["page1"] * 10 + 10; $i++)
		{
			if ($i == count ($post_list))
				break;
					echo "<div style='display: inline !important;'><div style='position: relative !important;
					top: 70px !important;
					left: -70px !important;
	width: 70px !important;
	height: 70px !important;
	border-top-left-radius: 35px !important;
	border-bottom-left-radius: 35px !important;
	border-bottom-right-radius: 35px !important;
	padding: 0.4em !important;
	font-size: 1.2em !important;
	text-align: center !important;
	color: #ffffff !important;
	background-color: #004369 !important;'>";
	echo substr ($post_list [$i]["post_date"], 8, 2).".".substr ($post_list [$i]["post_date"], 5, 2);
	echo "</div><div style='background-color: #ffffff;'>
					
					<article id='post-".$post_list [$i]["id"]."' >	

	<header class='entry-header'>";
	the_post();
		
		echo "<h1 class='entry-title'><a href='http://localhost".$post_list [$i]["path"].substr ($post_list [$i]["post_date"], 0, 4)."/".substr ($post_list [$i]["post_date"], 5, 2)."/".substr ($post_list [$i]["post_date"], 8, 2)."/".$post_list [$i]["post_name"]."' rel='bookmark'>".$post_list [$i]["post_title"]."</a></h1>";
	$sqlstr = "select term_id, slug, name from wp_".$post_list [$i]["blog_id"]."_terms where term_id=(select term_taxonomy_id from wp_".$post_list [$i]["blog_id"]."_term_relationships where object_id=".$post_list [$i]["id"].")";
		$cat_list = $wpdb->get_results ($sqlstr, ARRAY_A);
		
		echo "<span class='cat-links'>
		<a href='http://localhost".$post_list [$i]["path"]."/category/".$cat_list [0]["slug"]."/' title='".$cat_list [0]["name"]."'>".$cat_list [0]["name"]."</a>
		</span>
		
	</header><!-- .entry-header -->
	
	<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Автор: ".substr ($post_list [$i]["path"], 8, strlen ($post_list [$i]["path"]) - 9)."</div>
	<div class='thumb-container'>
		<a href='http://localhost".$post_list [$i]["path"].substr ($post_list [$i]["post_date"], 0, 4)."/".substr ($post_list [$i]["post_date"], 5, 2)."/".substr ($post_list [$i]["post_date"], 8, 2)."/".$post_list [$i]["post_name"]."' title='".$post_list [$i]["post_title"]."'>";
				get_post_thumbnail_id ($post_list [$i]["id"]);
				if (strstr ($post_list [$i]["post_content"], "nggallery"))
				{
				echo "</a>
	</div><!-- .thumb-container -->	

	<div class='entry-summary' style='max-height: 600px !important; overflow: hidden !important;'>";
	$cont = $post_list [$i]["post_content"];
	$cont1 = "";
	while (strstr ($cont, "nggallery"))
	{
		$cont = strstr ($cont, "[nggallery");
		global $wpdb;
		$sqlstr = "SELECT name from wp_".$post_list [$i]["blog_id"]."_ngg_gallery where gid=".substr (strstr ($cont, "]", true), 14, strlen (strstr ($cont, "]", true)) - 14);
		$gal_name = $wpdb->get_results ($sqlstr, ARRAY_A);
		$cont = substr (strstr ($cont, "]"), 1, strlen (strstr ($cont, "]")) - 1);
		$cont1 .= "<div style='display: inline !important;'>";
		$hdl1 = opendir ("../wpmu31/wp-content/uploads/sites/".$post_list [$i]["blog_id"]."/nggallery/".$gal_name [0]["name"]."/thumbs");
		while ($f = readdir ($hdl1))
		if (!strstr ($f, "_backup") && ($f != ".") && ($f != ".."))
			$cont1 .= "<span style='width: 100px !important;'><img src='http://localhost/wpmu31/wp-content/uploads/sites/".$post_list [$i]["blog_id"]."/nggallery/".$gal_name [0]["name"]."/thumbs/".$f."'></span>";
		$cont1 .= "</div>";
	}
	$cont1 .= $cont;		
	echo $cont1."</div>";;
		}
		else
				echo "</a>
	</div><!-- .thumb-container -->	

	<div class='entry-summary' style='max-height: 600px !important; overflow: hidden !important;'>".$post_list [$i]["post_content"]."</div><!-- .entry-summary -->";
	$sqlstr = "select comment_ID from wp_".$post_list [$i]["blog_id"]."_comments where comment_post_ID=".$post_list [$i]["id"];
	$comm_list = $wpdb->get_results ($sqlstr, ARRAY_A);

	echo "<footer class='entry-meta'>
	<div style='padding: 0 !important;'>
			<span class='comments-link' style='font-size: 12px;'><a href='http://localhost".$post_list [$i]["path"].substr ($post_list [$i]["post_date"], 0, 4)."/".substr ($post_list [$i]["post_date"], 5, 2)."/".substr ($post_list [$i]["post_date"], 8, 2)."/".$post_list [$i]["post_name"]."/#respond'>";
			switch (count ($comm_list))
			{
				case 0:
					echo "Залишити коментарій";
					break;
				case 1:
					echo "1 коментарій";
					break;
				default:
					echo count ($comm_list)." коментаріів";
					break;
			}
			echo "</a></span>";
			
			global $post;
global $blog_id;
				
		global $switched;		
		global $wpdb;
		$blog_list = get_blog_list( 0, 'all' ); 		
		$output = '';
		$own_post = false;
		$sqlstr = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$post_list [$i]["blog_id"];		
		$photo_list = $wpdb->get_results ($sqlstr, ARRAY_A);
		foreach ($photo_list as $post2)
			if ($post2 ["user_id"] == $user_ID)
				$own_post = true;
			if (($user_ID != 0) && ($post1 ["blog_id"] != 1) && ($own_post))
				echo "<form action='http://localhost/wpmu31/додати-новий-пост' method='post' style='display: inline !important;'>
				<input type='hidden' name='edit_id' value='".$post_list [$i]["id"]."'/>
				<input type='hidden' name='blog_id' value='".$post_list [$i]["blog_id"]."'/>
				<input type='hidden' name='cat' value='".$cat_list [0]["term_id"]."'/>
				<input type='submit' value='Редагувати' class='buttons' style='height: 30px !important; font-size: 12px !important;'/>
				</form>
				<form action='http://localhost/wpmu31/додати-новий-пост' method='post' style='display: inline !important;'>
				<input type='hidden' name='remove_id' value='".$post_list [$i]["id"]."'/>
				<input type='hidden' name='blog_id' value='".$post_list [$i]["blog_id"]."'/>
				<input type='submit' value='Видалити' class='buttons' style='height: 30px !important; font-size: 12px !important;'/>
				</form>";

		echo "<div class='read-more' style='height: 30px !important; margin: 0px !important; float: right !important;'>
			<a href='http://localhost".$post_list [$i]["path"].substr ($post_list [$i]["post_date"], 0, 4)."/".substr ($post_list [$i]["post_date"], 5, 2)."/".substr ($post_list [$i]["post_date"], 8, 2)."/".$post_list [$i]["post_name"]."'>Далі</a>
		</div>
		</div>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
</div>
</div>";
}
if (($i > 10) || ($i < count ($post_list)))
{
	echo "<div style='background-color: #ffffff; position: relative; top: 71px; height: 45px; vertical-align: middle; padding-top: 10px; padding-right: 20px; padding-left: 20px; margin-bottom: 3px;'>";
	if ($i < count ($post_list))
		echo "<div style='float: right;'><a href='http://localhost/wpmu31/додати-новий-пост/?type=all_posts_abc&page1=".($i / 10)."'>Наступні пости<span class='meta-nav'>&rarr;</span></a></div>";
	if ($i > 10)
		echo "<div style='float: left;'><a href='http://localhost/wpmu31/додати-новий-пост/?type=all_posts_abc&page1=".($i / 10 - 2)."'><span class='meta-nav'>&larr;</span>Попередні пости</a></div>";
	echo "</div>";
}
		echo "</div>
		<div id='secondary' class='widget-area' role='complementary'>";			
 get_sidebar();
 if (count ($post_list) > 10)
	echo "</div>
	</div>
	<footer id='colophon' class='site-footer' role='contentinfo' style='position: relative; top: 50px;'>
		<div class='site-info'>";
 else
	echo "</div>
	</div>
	<footer id='colophon' class='site-footer' role='contentinfo' style='text-align: center;'>
		<div class='site-info'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( '2014', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Дизайн: <a href="mailto:arhibober@gmail.com" rel="designer">arhobober</a>' ));
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->";

wp_footer();
echo "</body>
</html>";
	break;
	case "general_archive":
	get_header();
	switch ($_GET ["month"])
	{
		case "1" :
			$month = "Січень";
			break;
		case "2" :
			$month = "Лютий";
			break;
		case "3" :
			$month = "Березень";
			break;
		case "4" :
			$month = "Квітень";
			break;
		case "5" :
			$month = "Травень";
			break;
		case "6" :
			$month = "Червень";
			break;
		case "7" :
			$month = "Липень";
			break;
		case "8" :
			$month = "Серпень";
			break;
		case "9" :
			$month = "Вересень";
			break;
		case "10" :
			$month = "Жовтень";
			break;
		case "11" :
			$month = "Листопад";
			break;
		case "12" :
			$month = "Грудень";
			break;
	}
	echo "<h1 style='color: white'>Місяць: ".$month." ".$_GET ["year"]."</h1>";
echo "<div style='display: inline-block; position: relative; top: -68px;' class='left-column content-area' id='primary'>";
global $switched;		
		global $wpdb;
		global $user_ID;
		global $pages;
		$table_prefix = $wpdb->base_prefix;
		$blog_list = get_blog_list (0, "all"); 		
		$output = '';
		$j = 0;
		$sqlstr = "";
		foreach ($blog_list as $blog)
		{
			if ($blog ['blog_id'] != 1)
			{
			if ($j > 0)
				$sqlstr .= " union ";
				$sqlstr .= "SELECT b.path, b.blog_id, p.id, p.post_title, p.post_content, p.post_date, p.post_date_gmt, p.post_modified, p.post_name from wp_".$blog ["blog_id"]."_posts as p, wp_blogs as b where p.post_status = 'publish' and p.post_type = 'post' and b.blog_id=".$blog ["blog_id"]." and p.post_date like '%".$_GET ["year"]."_".$_GET ["month"]."%'";
			$j++;
			}			
		}
		$sqlstr.= " ORDER BY post_modified desc";
		
		$post_list = $wpdb->get_results($sqlstr, ARRAY_A);
		$i = $_GET ["page1"] * 10;
		for ($i = $_GET ["page1"] * 10; $i < $_GET ["page1"] * 10 + 10; $i++)
		{
			if ($i == count ($post_list))
				break;
					echo "<div style='display: inline !important;'><div style='position: relative !important;
					top: 70px !important;
					left: -70px !important;
	width: 70px !important;
	height: 70px !important;
	border-top-left-radius: 35px !important;
	border-bottom-left-radius: 35px !important;
	border-bottom-right-radius: 35px !important;
	padding: 0.4em !important;
	font-size: 1.2em !important;
	text-align: center !important;
	color: #ffffff !important;
	background-color: #004369 !important;'>";
	echo substr ($post_list [$i]["post_date"], 8, 2).".".substr ($post_list [$i]["post_date"], 5, 2);
	echo "</div><div style='background-color: #ffffff;'>
					
					<article id='post-".$post_list [$i]["id"]."' >	

	<header class='entry-header'>";
	the_post();
		
		echo "<h1 class='entry-title'><a href='http://localhost".$post_list [$i]["path"].substr ($post_list [$i]["post_date"], 0, 4)."/".substr ($post_list [$i]["post_date"], 5, 2)."/".substr ($post_list [$i]["post_date"], 8, 2)."/".$post_list [$i]["post_name"]."' rel='bookmark'>".$post_list [$i]["post_title"]."</a></h1>";
	$sqlstr = "select term_id, slug, name from wp_".$post_list [$i]["blog_id"]."_terms where term_id=(select term_taxonomy_id from wp_".$post_list [$i]["blog_id"]."_term_relationships where object_id=".$post_list [$i]["id"].")";
		$cat_list = $wpdb->get_results ($sqlstr, ARRAY_A);
		
		echo "<span class='cat-links'>
		<a href='http://localhost".$post_list [$i]["path"]."/category/".$cat_list [0]["slug"]."/' title='".$cat_list [0]["name"]."'>".$cat_list [0]["name"]."</a>
		</span>
		
	</header><!-- .entry-header -->
	
	<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Автор: ".substr ($post_list [$i]["path"], 8, strlen ($post_list [$i]["path"]) - 9)."</div>
	<div class='thumb-container'>
		<a href='http://localhost".$post_list [$i]["path"].substr ($post_list [$i]["post_date"], 0, 4)."/".substr ($post_list [$i]["post_date"], 5, 2)."/".substr ($post_list [$i]["post_date"], 8, 2)."/".$post_list [$i]["post_name"]."' title='".$post_list [$i]["post_title"]."'>";
				get_post_thumbnail_id ($post_list [$i]["id"]);
				if (strstr ($post_list [$i]["post_content"], "nggallery"))
				{
				echo "</a>
	</div><!-- .thumb-container -->	

	<div class='entry-summary' style='max-height: 600px !important; overflow: hidden !important;'>";
	$cont = $post_list [$i]["post_content"];
	$cont1 = "";
	while (strstr ($cont, "nggallery"))
	{
		$cont = strstr ($cont, "[nggallery");
		global $wpdb;
		$sqlstr = "SELECT name from wp_".$post_list [$i]["blog_id"]."_ngg_gallery where gid=".substr (strstr ($cont, "]", true), 14, strlen (strstr ($cont, "]", true)) - 14);
		$gal_name = $wpdb->get_results ($sqlstr, ARRAY_A);
		$cont = substr (strstr ($cont, "]"), 1, strlen (strstr ($cont, "]")) - 1);
		$cont1 .= "<div style='display: inline !important;'>";
		$hdl1 = opendir ("../wpmu31/wp-content/uploads/sites/".$post_list [$i]["blog_id"]."/nggallery/".$gal_name [0]["name"]."/thumbs");
		while ($f = readdir ($hdl1))
		if (!strstr ($f, "_backup") && ($f != ".") && ($f != ".."))
			$cont1 .= "<span style='width: 100px !important;'><img src='http://localhost/wpmu31/wp-content/uploads/sites/".$post_list [$i]["blog_id"]."/nggallery/".$gal_name [0]["name"]."/thumbs/".$f."'></span>";
		$cont1 .= "</div>";
	}
	$cont1 .= $cont;		
	echo $cont1."</div>";;
		}
		else
				echo "</a>
	</div><!-- .thumb-container -->	

	<div class='entry-summary' style='max-height: 600px !important; overflow: hidden !important;'>".$post_list [$i]["post_content"]."</div><!-- .entry-summary -->";
	$sqlstr = "select comment_ID from wp_".$post_list [$i]["blog_id"]."_comments where comment_post_ID=".$post_list [$i]["id"];
	$comm_list = $wpdb->get_results ($sqlstr, ARRAY_A);

	echo "<footer class='entry-meta'>
	<div style='padding: 0 !important;'>
			<span class='comments-link' style='font-size: 12px;'><a href='http://localhost".$post_list [$i]["path"].substr ($post_list [$i]["post_date"], 0, 4)."/".substr ($post_list [$i]["post_date"], 5, 2)."/".substr ($post_list [$i]["post_date"], 8, 2)."/".$post_list [$i]["post_name"]."/#respond'>";
			switch (count ($comm_list))
			{
				case 0:
					echo "Залишити коментарій";
					break;
				case 1:
					echo "1 коментарій";
					break;
				default:
					echo count ($comm_list)." коментаріів";
					break;
			}
			echo "</a></span>";
			
			global $post;
global $blog_id;
				
		global $switched;		
		global $wpdb;
		$blog_list = get_blog_list( 0, 'all' ); 		
		$output = '';
		$own_post = false;
		$sqlstr = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$post_list [$i]["blog_id"];		
		$photo_list = $wpdb->get_results ($sqlstr, ARRAY_A);
		foreach ($photo_list as $post2)
			if ($post2 ["user_id"] == $user_ID)
				$own_post = true;
			if (($user_ID != 0) && ($post1 ["blog_id"] != 1) && ($own_post))
				echo "<form action='http://localhost/wpmu31/додати-новий-пост' method='post' style='display: inline !important;'>
				<input type='hidden' name='edit_id' value='".$post_list [$i]["id"]."'/>
				<input type='hidden' name='blog_id' value='".$post_list [$i]["blog_id"]."'/>
				<input type='hidden' name='cat' value='".$cat_list [0]["term_id"]."'/>
				<input type='submit' value='Редагувати' class='buttons' style='height: 30px !important; font-size: 12px !important;'/>
				</form>
				<form action='http://localhost/wpmu31/додати-новий-пост' method='post' style='display: inline !important;'>
				<input type='hidden' name='remove_id' value='".$post_list [$i]["id"]."'/>
				<input type='hidden' name='blog_id' value='".$post_list [$i]["blog_id"]."'/>
				<input type='submit' value='Видалити' class='buttons' style='height: 30px !important; font-size: 12px !important;'/>
				</form>";

		echo "<div class='read-more' style='height: 30px !important; margin: 0px !important; float: right !important;'>
			<a href='http://localhost".$post_list [$i]["path"].substr ($post_list [$i]["post_date"], 0, 4)."/".substr ($post_list [$i]["post_date"], 5, 2)."/".substr ($post_list [$i]["post_date"], 8, 2)."/".$post_list [$i]["post_name"]."'>Далі</a>
		</div>
		</div>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
</div>
</div>";
}
if (($i > 10) || ($i < count ($post_list)))
{
	echo "<div style='background-color: #ffffff; position: relative; top: 71px; height: 45px; vertical-align: middle; padding-top: 10px; padding-right: 20px; padding-left: 20px; margin-bottom: 3px;'>";
	if ($i < count ($post_list))
		echo "<div style='float: right;'><a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".$_GET ["year"]."&month=".$_GET ["month"]."&page1=".($i / 10)."'>Старі пости<span class='meta-nav'>&rarr;</span></a></div>";
	if ($i > 10)
		echo "<div style='float: left;'><a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".$_GET ["year"]."&month=".$_GET ["month"]."&page1=".($i / 10 - 2)."'><span class='meta-nav'>&larr;</span>Нові пости</a></div>";
	echo "</div>";
}
		echo "</div>
		<div id='secondary' class='widget-area' role='complementary' style='position: relative; top: -43px;'>";			
 get_sidebar();
 if (count ($post_list) > 10)
	echo "</div>
	</div>
	<footer id='colophon' class='site-footer' role='contentinfo' style='position: relative; top: 50px;'>
		<div class='site-info'>";
 else
	echo "</div>
	</div>
	<footer id='colophon' class='site-footer' role='contentinfo'>
		<div class='site-info' style='text-align: center;'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( '2014', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Дизайн: <a href="mailto:arhibober@gmail.com" rel="designer">arhobober</a>' ));
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->";

wp_footer();
echo "</body>
</html>";
	break;
	case "general_category":
	get_header();
global $switched;		
		global $wpdb;
		global $user_ID;
		global $pages;
		$table_prefix = $wpdb->base_prefix;
		$blog_list = get_blog_list (0, "all"); 		
		$output = '';
		$j = 0;
		$sqlstr = "SELECT name from wp_5_terms where term_id=".$_GET ["category"];
		$category_list = $wpdb->get_results($sqlstr, ARRAY_A);
		echo "<h1 style='color: white;'>".$category_list [0]["name"]."</h1>";
		echo "<div style='display: inline-block; position: relative; top: -68px;' class='left-column content-area' id='primary'>";
		$sqlstr = "";
		foreach ($blog_list as $blog)
			if ($blog ['blog_id'] != 1)
			{
				if ($j > 0)
					$sqlstr .= " union ";
					$sqlstr .= "SELECT b.path, b.blog_id, p.id, p.post_title, p.post_content, p.post_date, p.post_date_gmt, p.post_modified, p.post_name from wp_".$blog ["blog_id"]."_posts as p, wp_blogs as b where p.post_status = 'publish' and p.post_type = 'post' and b.blog_id=".$blog ["blog_id"]." and p.id in (select object_id from wp_".$blog ["blog_id"]."_term_relationships where term_taxonomy_id=".$_GET ["category"].")";
				$j++;
			}
		$sqlstr.= " ORDER BY post_modified desc";
		
		$post_list = $wpdb->get_results($sqlstr, ARRAY_A);
		if (count ($post_list) == 0)
			echo "<div style='background-color: #ffffff; position: relative !important; top: 67px !important; padding: 20px !important;'>
				Пробачте, але на даний момент категорія порожня.
			</div>";
		$i = $_GET ["page1"] * 10;
		for ($i = $_GET ["page1"] * 10; $i < $_GET ["page1"] * 10 + 10; $i++)
		{
			if ($i == count ($post_list))
				break;
					echo "<div style='display: inline !important;'><div style='position: relative !important;
					top: 70px !important;
					left: -70px !important;
	width: 70px !important;
	height: 70px !important;
	border-top-left-radius: 35px !important;
	border-bottom-left-radius: 35px !important;
	border-bottom-right-radius: 35px !important;
	padding: 0.4em !important;
	font-size: 1.2em !important;
	text-align: center !important;
	color: #ffffff !important;
	background-color: #004369 !important;'>";
	echo substr ($post_list [$i]["post_date"], 8, 2).".".substr ($post_list [$i]["post_date"], 5, 2);
	echo "</div><div style='background-color: #ffffff;'>
					
					<article id='post-".$post_list [$i]["id"]."' >	

	<header class='entry-header'>";
	the_post();
		
		echo "<h1 class='entry-title'><a href='http://localhost".$post_list [$i]["path"].substr ($post_list [$i]["post_date"], 0, 4)."/".substr ($post_list [$i]["post_date"], 5, 2)."/".substr ($post_list [$i]["post_date"], 8, 2)."/".$post_list [$i]["post_name"]."' rel='bookmark'>".$post_list [$i]["post_title"]."</a></h1>";
	$sqlstr = "select term_id, slug, name from wp_".$post_list [$i]["blog_id"]."_terms where term_id=(select term_taxonomy_id from wp_".$post_list [$i]["blog_id"]."_term_relationships where object_id=".$post_list [$i]["id"].")";
		$cat_list = $wpdb->get_results ($sqlstr, ARRAY_A);
		
		echo "</header><!-- .entry-header -->
	
	<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Автор: ".substr ($post_list [$i]["path"], 8, strlen ($post_list [$i]["path"]) - 9)."</div>
	<div class='thumb-container'>
		<a href='http://localhost".$post_list [$i]["path"].substr ($post_list [$i]["post_date"], 0, 4)."/".substr ($post_list [$i]["post_date"], 5, 2)."/".substr ($post_list [$i]["post_date"], 8, 2)."/".$post_list [$i]["post_name"]."' title='".$post_list [$i]["post_title"]."'>";
				get_post_thumbnail_id ($post_list [$i]["id"]);
				if (strstr ($post_list [$i]["post_content"], "nggallery"))
				{
				echo "</a>
	</div><!-- .thumb-container -->	

	<div class='entry-summary' style='max-height: 600px !important; overflow: hidden !important;'>";
	$cont = $post_list [$i]["post_content"];
	$cont1 = "";
	while (strstr ($cont, "nggallery"))
	{
		$cont = strstr ($cont, "[nggallery");
		global $wpdb;
		$sqlstr = "SELECT name from wp_".$post_list [$i]["blog_id"]."_ngg_gallery where gid=".substr (strstr ($cont, "]", true), 14, strlen (strstr ($cont, "]", true)) - 14);
		$gal_name = $wpdb->get_results ($sqlstr, ARRAY_A);
		$cont = substr (strstr ($cont, "]"), 1, strlen (strstr ($cont, "]")) - 1);
		$cont1 .= "<div style='display: inline !important;'>";
		$hdl1 = opendir ("../wpmu31/wp-content/uploads/sites/".$post_list [$i]["blog_id"]."/nggallery/".$gal_name [0]["name"]."/thumbs");
		while ($f = readdir ($hdl1))
		if (!strstr ($f, "_backup") && ($f != ".") && ($f != ".."))
			$cont1 .= "<span style='width: 100px !important;'><img src='http://localhost/wpmu31/wp-content/uploads/sites/".$post_list [$i]["blog_id"]."/nggallery/".$gal_name [0]["name"]."/thumbs/".$f."'></span>";
		$cont1 .= "</div>";
	}
	$cont1 .= $cont;		
	echo $cont1."</div>";
		}
		else
				echo "</a>
	</div><!-- .thumb-container -->	

	<div class='entry-summary' style='max-height: 600px !important; overflow: hidden !important;'>".$post_list [$i]["post_content"]."</div><!-- .entry-summary -->";
	$sqlstr = "select comment_ID from wp_".$post_list [$i]["blog_id"]."_comments where comment_post_ID=".$post_list [$i]["id"];
	$comm_list = $wpdb->get_results ($sqlstr, ARRAY_A);

	echo "<footer class='entry-meta'>
	<div style='padding: 0 !important;'>
			<span class='comments-link' style='font-size: 12px;'><a href='http://localhost".$post_list [$i]["path"].substr ($post_list [$i]["post_date"], 0, 4)."/".substr ($post_list [$i]["post_date"], 5, 2)."/".substr ($post_list [$i]["post_date"], 8, 2)."/".$post_list [$i]["post_name"]."/#respond'>";
			switch (count ($comm_list))
			{
				case 0:
					echo "Залишити коментарій";
					break;
				case 1:
					echo "1 коментарій";
					break;
				default:
					echo count ($comm_list)." коментаріів";
					break;
			}
			echo "</a></span>";
			
			global $post;
global $blog_id;
				
		global $switched;		
		global $wpdb;
		$blog_list = get_blog_list( 0, 'all' ); 		
		$output = '';
		$own_post = false;
		$sqlstr = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$post_list [$i]["blog_id"];		
		$photo_list = $wpdb->get_results ($sqlstr, ARRAY_A);
		foreach ($photo_list as $post2)
			if ($post2 ["user_id"] == $user_ID)
				$own_post = true;
			if (($user_ID != 0) && ($post1 ["blog_id"] != 1) && ($own_post))
				echo "<form action='http://localhost/wpmu31/додати-новий-пост' method='post' style='display: inline !important;'>
				<input type='hidden' name='edit_id' value='".$post_list [$i]["id"]."'/>
				<input type='hidden' name='blog_id' value='".$post_list [$i]["blog_id"]."'/>
				<input type='hidden' name='cat' value='".$cat_list [0]["term_id"]."'/>
				<input type='submit' value='Редагувати' class='buttons' style='height: 30px !important; font-size: 12px !important;'/>
				</form>
				<form action='http://localhost/wpmu31/додати-новий-пост' method='post' style='display: inline !important;'>
				<input type='hidden' name='remove_id' value='".$post_list [$i]["id"]."'/>
				<input type='hidden' name='blog_id' value='".$post_list [$i]["blog_id"]."'/>
				<input type='submit' value='Видалити' class='buttons' style='height: 30px !important; font-size: 12px !important;'/>
				</form>";

		echo "<div class='read-more' style='height: 30px !important; margin: 0px !important; float: right !important;'>
			<a href='http://localhost".$post_list [$i]["path"].substr ($post_list [$i]["post_date"], 0, 4)."/".substr ($post_list [$i]["post_date"], 5, 2)."/".substr ($post_list [$i]["post_date"], 8, 2)."/".$post_list [$i]["post_name"]."'>Далі</a>
		</div>
		</div>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
</div>
</div>";
}if (($i > 10) || ($i < count ($post_list)))
{
	echo "<div style='background-color: #ffffff; position: relative; top: 71px; height: 45px; vertical-align: middle; padding-top: 10px; padding-right: 20px; padding-left: 20px; margin-bottom: 3px;'>";
	if ($i < count ($post_list))
		echo "<div style='float: right;'><a href='http://localhost/wpmu31/додати-новий-пост/?type=general_category&category=".$_GET ["category"]."&page1=".($i / 10)."'>Старі пости<span class='meta-nav'>&rarr;</span></a></div>";
	if ($i > 10)
		echo "<div style='float: left;'><a href='http://localhost/wpmu31/додати-новий-пост/?type=general_category&category=".$_GET ["category"]."&page1=".($i / 10 - 2)."'><span class='meta-nav'>&larr;</span>Нові пости</a></div>";
	echo "</div>";
}
		echo "</div>
		<div id='secondary' class='widget-area' role='complementary' style='position: relative; top: -43px;'>";			
 get_sidebar();
 if (count ($post_list) > 10)
	echo "</div>
	</div>
	<footer id='colophon' class='site-footer' role='contentinfo' style='position: relative; top: 50px;'>
		<div class='site-info'>";
 else
	echo "</div>
	</div>
	<footer id='colophon' class='site-footer' role='contentinfo'>
		<div class='site-info' style='text-align: center;'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( '2014', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Дизайн: <a href="mailto:arhibober@gmail.com" rel="designer">arhobober</a>' ));
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->";

wp_footer();
echo "</body>
</html>";
	break;
	case "all_blogs":
	get_header();
echo "<h1 style='color: #ffffff'>Нові блоги мережі</h1>
<div id='primary' class='content-area' style='background-color: #ffffff !important; padding-left: 20px; padding-top: 20px; padding-bottom: 20px !important; display: inline !important;'>
<div style='display: inline !important;'>";
		global $wpdb;
		$table_prefix = $wpdb->base_prefix;
			
			$sqlstr = "SELECT blog_id, registered, last_updated from ".$table_prefix ."blogs where  public = 1	AND spam = 0 AND archived = '0' AND deleted = 0 AND blog_id != 1 ORDER BY registered desc";
		$blog_list = $wpdb->get_results($sqlstr, ARRAY_A);
		echo $wpdb->print_error();
		$output = '';
		$i = $_GET ["page1"] * 20;
			
		for ($i = $_GET ["page1"] * 20; $i < $_GET ["page1"] * 20 + 20; $i++) {
			if ($i == count ($blog_list))
				break;
			$txt = '<div style="height: 160px; width: 200px; display: inline-block !important; padding-bottom: 20px !important;" class="widget-area"><b style="font-size: 16px;">{title}</b>';			
			
			$title = '';$desc = '';$burl = '';$pcount = 0;$avatar = '';
			switch_to_blog ($blog_list [$i]['blog_id']);					
				if (strpos($txt, '{title}') !== false || strpos($txt, '{title_txt}') !== false)
					$title = get_bloginfo('name');
				if (strpos($txt, '{description}') !== false)
					$desc = get_bloginfo('description');	
				$burl = get_bloginfo('url');
				if (strpos($txt, '{postcount}') !== false || (int)$min_post_count>0)
					$pcount = wp_count_posts()->publish;

				if (strpos($txt, '{avatar}') !== false)
					$avatar = get_avatar(get_bloginfo('admin_email'), $wgt_avsize);	
				
			restore_current_blog();
			
			
			
			if ((int)$min_post_count <= $pcount) {
			
				$output .=  $before_item;
				//@TODO add trailing shash only if in subdir mode 
				$txt = str_replace('{title}', '<a href="' . $burl .'/" style="font-size: 16px;">'. $title .'<br/>' , $txt);
				$txt = str_replace('{more}', '<a href="' . $burl .'/">'.$wgt_mtext.'<br/>' , $txt);
				$txt = str_replace('{title_txt}', $title , $txt);
				$txt = str_replace('{reg}', date_i18n($wgt_dt, strtotime($blog_list [$i]['registered'])), $txt);
				$txt = str_replace('{last_update}', date_i18n($wgt_dt, strtotime($blog_list [$i]['last_updated'])), $txt);
				$txt = str_replace('{description}', $desc, $txt);
				$txt = str_replace('{postcount}', $pcount , $txt);
				$txt = str_replace('{comment_count}', $blog_list [$i]['comment_count'] , $txt);
				$txt = str_replace('{avatar}', $avatar , $txt);
				
				$output .=  $txt;
				global $wpdb;
		$sqlstr1 = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$blog_list [$i]["blog_id"];
		$photo_list = $wpdb->get_results($sqlstr1, ARRAY_A);
		if ($photo_list [0]["user_id"] > 0)
			$output .= "<br/>";
			global $wpdb;
			
		$sqlstr1 = "SELECT meta_value from wp_usermeta where user_id=".$photo_list [0]["user_id"]." AND meta_key='sex'";			
		$user_data8 = $wpdb->get_results ($sqlstr1, ARRAY_A);
		$k = 0;
		if (file_exists ("../wpmu31/wp-content/uploads/avatars/".$photo_list [0]["user_id"]))
		{
			$hdl1 = opendir ("../wpmu31/wp-content/uploads/avatars/".$_GET ["user"]);
			while ($file = readdir ($hdl1))
				$k++;
		}
		if ((strlen ($user_data8 [0]["meta_value"]) > 0) && (($user_data8 [0]["meta_value"] != "Не вказана")) && ($k == 0))
			if ($user_data8 [0]["meta_value"] == "Чоловіча")
				$output .= "<img height='100px' src='http://localhost/wpmu31/images12.jpg' style='height: 100px !important;'/>";
			else
				$output .= "<img height='100px' src='http://localhost/wpmu31/girl2.jpg' style='height: 100px !important;'/>";
		else
			$output .= get_avatar ($photo_list [0]["user_id"], 100)."<br/>";
				
				$output .= "</a></div>";
			}
		}
		
		$output .=  $wpdb->print_error();
		echo $output."<br/>";
		  echo "</div>";
		  
if (($i > 20) || ($i < count ($post_list) - 20))
{
	echo "<div style='background-color: #ffffff; position: relative; top: 71px; height: 45px; vertical-align: middle; padding-top: 10px; padding-right: 20px; padding-left: 20px; margin-bottom: 3px;'>";
	if ($i < count ($post_list) - 20)
		echo "<div style='float: right;'><a href='http://localhost/wpmu31/додати-новий-пост/?type=all_blogs&page1=".($i / 20)."'>Старі блоги<span class='meta-nav'>&rarr;</span></a></div>";
	if ($i > 20)
		echo "<div style='float: left;'><a href='http://localhost/wpmu31/додати-новий-пост/?type=all_blogs&page1=".($i / 20 - 2)."'>Нові блоги<span class='meta-nav'>&larr;</span></a></div>";
	echo "</div>";
}
		  echo "</div>
		  <div id='secondary' class='widget-area' role='complementary' style='position: relative; top: -43px;'>";
 get_sidebar();
	echo "</div>
	</div>
	<footer id='colophon' class='site-footer' role='contentinfo'>
		<div class='site-info' style='text-align: center;'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( '2014', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Дизайн: <a href="mailto:arhibober@gmail.com" rel="designer">arhobober</a>' ));
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->";

wp_footer();
echo "</body>
</html>";
		break;
	case "abc":
get_header();	
echo "<div id='primary' class='content-area' style='background-color: #ffffff !important; padding-left: 20px; padding-top: 20px; padding-bottom: 20px !important; display: inline !important;'>
<div style='display: inline !important;'>";
		global $switched;	
		global $wpdb;
		$table_prefix = $wpdb->base_prefix;
			
			$sqlstr = "SELECT blog_id, registered, last_updated from ".$table_prefix ."blogs where public = 1 AND spam = 0 AND archived = '0' AND deleted = 0 AND blog_id != 1 ORDER BY path";
		$blog_list = $wpdb->get_results($sqlstr, ARRAY_A);
		echo $wpdb->print_error();
		$output = '';
		$i = $_GET ["page1"] * 20;
			
		for ($i = $_GET ["page1"] * 20; $i < $_GET ["page1"] * 20 + 20; $i++) {
			if ($i == count ($blog_list))
				break;
			$txt = '<div style="height: 160px; width: 200px; display: inline-block !important; padding-bottom: 20px !important;" class="widget-area"><b style="font-size: 16px;">{title}</b>';			
			
			$title = '';$desc = '';$burl = '';$pcount = 0;$avatar = '';
			switch_to_blog ($blog_list [$i]['blog_id']);					
				if (strpos($txt, '{title}') !== false || strpos($txt, '{title_txt}') !== false)
					$title = get_bloginfo('name');
				if (strpos($txt, '{description}') !== false)
					$desc = get_bloginfo('description');	
				$burl = get_bloginfo('url');
				if (strpos($txt, '{postcount}') !== false || (int)$min_post_count>0)
					$pcount = wp_count_posts()->publish;

				if (strpos($txt, '{avatar}') !== false)
					$avatar = get_avatar(get_bloginfo('admin_email'), $wgt_avsize);	
				
			restore_current_blog();
			
			
			
			if ((int)$min_post_count <= $pcount) {
			
				$output .=  $before_item;
				//@TODO add trailing shash only if in subdir mode 
				$txt = str_replace('{title}', '<a href="' . $burl .'/" style="font-size: 16px;">'. $title .'<br/>' , $txt);
				$txt = str_replace('{more}', '<a href="' . $burl .'/">'.$wgt_mtext.'<br/>' , $txt);
				$txt = str_replace('{title_txt}', $title , $txt);
				$txt = str_replace('{reg}', date_i18n($wgt_dt, strtotime($blog_list [$i]['registered'])), $txt);
				$txt = str_replace('{last_update}', date_i18n($wgt_dt, strtotime($blog_list [$i]['last_updated'])), $txt);
				$txt = str_replace('{description}', $desc, $txt);
				$txt = str_replace('{postcount}', $pcount , $txt);
				$txt = str_replace('{comment_count}', $blog_list [$i]['comment_count'] , $txt);
				$txt = str_replace('{avatar}', $avatar , $txt);
				
				$output .=  $txt;
				global $wpdb;
		$sqlstr1 = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$blog_list [$i]["blog_id"];
		$photo_list = $wpdb->get_results($sqlstr1, ARRAY_A);
		if ($photo_list [0]["user_id"] > 0)
			$output .= "<br/>";
			global $wpdb;
			
		$sqlstr1 = "SELECT meta_value from wp_usermeta where user_id=".$photo_list [0]["user_id"]." AND meta_key='sex'";			
		$user_data8 = $wpdb->get_results ($sqlstr1, ARRAY_A);
		$k = 0;
		if (file_exists ("../wpmu31/wp-content/uploads/avatars/".$photo_list [0]["user_id"]))
		{
			$hdl1 = opendir ("../wpmu31/wp-content/uploads/avatars/".$_GET ["user"]);
			while ($file = readdir ($hdl1))
				$k++;
		}
		if ((strlen ($user_data8 [0]["meta_value"]) > 0) && (($user_data8 [0]["meta_value"] != "Не вказана")) && ($k == 0))
			if ($user_data8 [0]["meta_value"] == "Чоловіча")
				$output .= "<img height='100px' src='http://localhost/wpmu31/images12.jpg' style='height: 100px !important;'/>";
			else
				$output .= "<img height='100px' src='http://localhost/wpmu31/girl2.jpg' style='height: 100px !important;'/>";
		else
			$output .= get_avatar ($photo_list [0]["user_id"], 100)."<br/>";
				
				$output .= "</a></div>";
			}
		}
		
		$output .=  $wpdb->print_error();
		echo "<h2>Всі блоги мережі</h2>".
		  $output."<br/>";
		  echo "</div>";
		  
if (($i > 20) || ($i < count ($post_list) - 20))
{
	echo "<div style='background-color: #ffffff; position: relative; top: 71px; height: 45px; vertical-align: middle; padding-top: 10px; padding-right: 20px; padding-left: 20px; margin-bottom: 3px;'>";
	if ($i < count ($post_list) - 20)
		echo "<div style='float: right;'><a href='http://localhost/wpmu31/додати-новий-пост/?type=abc&page1=".($i / 20)."'>Наступні блоги<span class='meta-nav'>&rarr;</span></a></div>";
	if ($i > 20)
		echo "<div style='float: left;'><a href='http://localhost/wpmu31/додати-новий-пост/?type=abc&page1=".($i / 20 - 2)."'><span class='meta-nav'>&larr;</span>Попередні блоги</a></div>";
	echo "</div>";
}
		  echo "</div>
		  <div id='secondary' class='widget-area' role='complementary'>";
 get_sidebar();
	echo "</div>
	</div>
	<footer id='colophon' class='site-footer' role='contentinfo' style='position: relative; top: 50px;'>
		<div class='site-info' style='text-align: center;'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( '2014', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Дизайн: <a href="mailto:arhibober@gmail.com" rel="designer">arhobober</a>' ));
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->";

wp_footer();
echo "</body>
</html>";
		break;
		case "profile":
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
		$sqlstr = "SELECT path from wp_blogs where blog_id=".$_GET ["user"];		
		$pathes = $wpdb->get_results($sqlstr, ARRAY_A);
		$p1 = $pathes [0]["path"];
		$sqlstr = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$_GET ["user"];		
		$photo_list = $wpdb->get_results($sqlstr, ARRAY_A);
		if ($_GET ["user"] != 1)
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
		if ($_GET ["user"] != 1)
		{
		foreach ($user_list as $user)
		{		
			$u = $user ["user_login"];
			break;
		}
		}
		$sqlstr = "SELECT meta_value from wp_usermeta where meta_key='first_name' and user_id=(SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$_GET ["user"].")";
		$names = $wpdb->get_results($sqlstr, ARRAY_A);
		$sqlstr = "SELECT meta_value from wp_usermeta where meta_key='last_name' and user_id=(SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$_GET ["user"].")";		
		$surnames = $wpdb->get_results($sqlstr, ARRAY_A);
		?>
		<div style="display: inline-block !important;">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php 
			if ($_GET ["user"] == 1)
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
			if ($_GET ["user"] == 1)
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
	<?php
echo "<div id='primary' class='content-area' style='background-color: #ffffff !important; padding-left: 10px; padding-top: 10px;'>";
		global $wpdb;
			
			$sqlstr = "SELECT user_login, display_name, user_email from wp_users where ID=".$_GET ["user"];
			
		$user_data = $wpdb->get_results ($sqlstr, ARRAY_A);
		echo "<h2>Про користувача</h2><br/>";
		$sqlstr = "SELECT meta_value from wp_usermeta where user_id=".$_GET ["user"]." AND meta_key='sex'";			
		$user_data8 = $wpdb->get_results ($sqlstr, ARRAY_A);
		if (file_exists ("../wpmu31/wp-content/uploads/avatars/".$_GET ["user"]))
		{
			$hdl1 = opendir ("../wpmu31/wp-content/uploads/avatars/".$_GET ["user"]);
			$i = 0;
			while ($file = readdir ($hdl1))
				$i++;
		}
		if ((strlen ($user_data8 [0]["meta_value"]) > 0) && (($user_data8 [0]["meta_value"] != "Не вказана")) && ($i == 0))
			if ($user_data8 [0]["meta_value"] == "Чоловіча")
				echo "<img height='100px' src='http://localhost/wpmu31/image12.jpg'/><br/>";
			else
				echo "<img height='100px' src='http://localhost/wpmu31/girl2.jpg'/><br/>";
		else
			echo get_avatar ($_GET ["user"], 100)."<br/>";
		if ((strlen ($user_data8 [0]["meta_value"]) > 0) && ($user_data8 [0]["meta_value"] != "Не вказана"))
			echo "Стать: ".$user_data8 [0]["meta_value"]."</br>";
		echo "Логін: ".$user_data [0]["user_login"]."<br/>
		Нікнейм: ".$user_data [0]["display_name"]."<br/>
		e-mail: ".$user_data [0]["user_email"]."</br>";
		$sqlstr = "SELECT meta_value from wp_usermeta where user_id=".$_GET ["user"]." AND meta_key='first_name'";
		$user_data1 = $wpdb->get_results ($sqlstr, ARRAY_A);
		if ((strlen ($user_data1 [0]["meta_value"]) > 0) && ($user_data1 [0]["meta_value"] != "0"))
			echo "Ім'я: ".$user_data1 [0]["meta_value"]."</br>";
		$sqlstr = "SELECT meta_value from wp_usermeta where user_id=".$_GET ["user"]." AND meta_key='last_name'";
		$user_data2 = $wpdb->get_results ($sqlstr, ARRAY_A);
		if (strlen ($user_data2 [0]["meta_value"]) > 0 && ($user_data2 [0]["meta_value"] != "0"))
			echo "Прізвище: ".$user_data2 [0]["meta_value"]."</br>";
		$sqlstr = "SELECT meta_value from wp_usermeta where user_id=".$_GET ["user"]." AND meta_key='use_ssl'";
		$user_data3 = $wpdb->get_results ($sqlstr, ARRAY_A);
		if (strlen ($user_data3 [0]["meta_value"]) > 0 && ($user_data3 [0]["meta_value"] != "0"))
			echo "Власний сайт: ".$user_data3 [0]["meta_value"]."</br>";
		$sqlstr = "SELECT meta_value from wp_usermeta where user_id=".$_GET ["user"]." AND meta_key='aim'";			
		$user_data4 = $wpdb->get_results ($sqlstr, ARRAY_A);
		if (strlen ($user_data4 [0]["meta_value"]) > 0 && ($user_data4 [0]["meta_value"] != "0"))
			echo "AIM: ".$user_data4 [0]["meta_value"]."</br>";
		$sqlstr = "SELECT meta_value from wp_usermeta where user_id=".$_GET ["user"]." AND meta_key='yim'";			
		$user_data5 = $wpdb->get_results ($sqlstr, ARRAY_A);
		if (strlen ($user_data5 [0]["meta_value"]) > 0 && ($user_data5 [0]["meta_value"] != "0"))
			echo "Yahoo IM: ".$userdata5 [0]["meta_value"]."</br>";
		$sqlstr = "SELECT meta_value from wp_usermeta where user_id=".$_GET ["user"]." AND meta_key='jabber'";			
		$user_data6 = $wpdb->get_results ($sqlstr, ARRAY_A);
		if (strlen ($user_data6 [0]["meta_value"]) > 0 && ($user_data6 [0]["meta_value"] != "0"))
			echo "Jabber: ".$user_data6 [0]["meta_value"]."</br>";
		$sqlstr = "SELECT meta_value from wp_usermeta where user_id=".$_GET ["user"]." AND meta_key='description'";			
		$user_data7 = $wpdb->get_results ($sqlstr, ARRAY_A);
		if (strlen ($user_data7 [0]["meta_value"]) > 0 && ($user_data7 [0]["meta_value"] != "0"))
			echo "Додаткові дані: ".$user_data7 [0]["meta_value"]."</br>";
		  echo"</div>
		  <div id='secondary' class='widget-area' role='complementary'>";
 get_sidebar();
 echo "</div>
 </div>
 <footer id='colophon' class='site-footer' role='contentinfo' style='position: relative; top: 50px;'>
		<div class='site-info' style='text-align: center;'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( '2014', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Дизайн: <a href="mailto:arhibober@gmail.com" rel="designer">arhobober</a>' ));
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->";

wp_footer();
echo "</body>
</html>";
		break;

default:
	switch (get_the_ID())
	{
	case 28:
get_header();

	?>	
	<div style="display: inline-block;" class="left-column content-area" id="primary"
	<?php
		global $user_ID;
		if (!strstr($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
			echo "style='position: relative !important; top: -200px !important;'";
		
	?>>
	<div style="width: 100% !important;">

			<?php if ((get_the_ID() != 28) || ($user_ID == 0))
		{
		echo "<main id='main' class='site-main' role='main'>";
		while ( have_posts() ) : the_post();

				get_template_part( 'content', 'page' );

			endwhile; // end of the loop. 

		echo "</main>";
		}
		if (($i == 1) && (strstr($_SERVER['HTTP_USER_AGENT'], 'Firefox')))
		echo "<div style='height: 71px !important; background: #17769b !important;'></div>";
		?>
	</div><!-- #primary --><?php
rewind_posts();  
		global $switched;		
		global $wpdb;
		global $user_ID;
		$table_prefix = $wpdb->base_prefix;
		$blog_list = get_blog_list( 0, 'all' );
		$output = '';
		$j = 0;
		foreach ($blog_list as $blog)
		{
			if ($blog ['blog_id'] != 1)
			{
			if ($j > 0)
				$sqlstr .= " union ";
				$sqlstr .= "SELECT b.path, b.blog_id, p.id, p.post_title, p.post_content, p.post_date, p.post_date_gmt, p.post_modified, p.post_name from wp_".$blog ['blog_id']."_posts as p, wp_blogs as b where p.post_status = 'publish' and p.post_type = 'post' and b.blog_id=".$blog ['blog_id'];
			$j++;
			}			
		}
		$sqlstr.= " ORDER BY post_modified desc ";
		
		$post_list = $wpdb->get_results ($sqlstr, ARRAY_A);
		$i = 0;
		if ($user_ID == 0)
			echo "<div style='background-color: #ffffff; font-weight: bold; padding: 20px; font-size: 30px; position: relative; top: 71px; color: #004369'>Нові пости мережі</div>
			<div style='position: relative; top: 71px;'>";
		else
			echo "<div style='background-color: #ffffff; font-weight: bold; padding: 20px; font-size: 30px; color: #004369'>Нові пости мережі</div>
			<div>";
		foreach ($post_list as $post1) 
		{
		$i++;
		if ($i > 5)
			break;
		echo "<div style='display: inline !important;'><div style='position: relative !important;
		top: 69px !important;
		left: -70px !important;
	width: 70px !important;
	height: 70px !important;
	border-top-left-radius: 35px !important;
	border-bottom-left-radius: 35px !important;
	border-bottom-right-radius: 35px !important;
	padding: 0.4em !important;
	font-size: 1.2em !important;
	text-align: center !important;
	color: #ffffff !important;
	background-color: #004369 !important;'>";
	echo substr ($post1 ["post_date"], 8, 2).".".substr ($post1 ["post_date"], 5, 2);
	echo "</div><div style='background-color: #ffffff;'>
					
					<article id='post-".$post1 ["id"]."' >	

	<header class='entry-header'>";
	$sqlstr = "select term_id, slug, name from wp_".$post1 ["blog_id"]."_terms where term_id=(select term_taxonomy_id from wp_".$post1 ["blog_id"]."_term_relationships where object_id=".$post1 ["id"].")";
		$cat_list = $wpdb->get_results ($sqlstr, ARRAY_A);
		
		echo "<h1 class='entry-title'><a href='http://localhost".$post1 ["path"].substr ($post1 ["post_date"], 0, 4)."/".substr ($post1 ["post_date"], 5, 2)."/".substr ($post1 ["post_date"], 8, 2)."/".$post1 ["post_name"]."' rel='bookmark'>".$post1 ["post_title"]."</a></h1>
		<span class='cat-links'>
		<a href='http://localhost".$post1 ["path"]."/category/".$cat_list [0]["slug"]."/' title='".$cat_list [0]["name"]."'>".$cat_list [0]["name"]."</a>
		</span>
		
	</header><!-- .entry-header -->
	
	<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Автор: ".substr ($post1 ["path"], 8, strlen ($post1 ["path"]) - 9)."</div>
	<div class='thumb-container'>
		<a href='http://localhost".$post1 ["path"].substr ($post1 ["post_date"], 0, 4)."/".substr ($post1 ["post_date"], 5, 2)."/".substr ($post1 ["post_date"], 8, 2)."/".$post1 ["post_name"]."' title='".$post1 ["post_title"]."'>";
				get_post_thumbnail_id ($post1 ["id"]);
				if (strstr ($post1 ["post_content"], "nggallery"))
				{
				echo "</a>
	</div><!-- .thumb-container -->	

	<div class='entry-summary' style='max-height: 600px !important; overflow: hidden !important;'>";
	$cont = $post1 ["post_content"];
	$cont1 = "";
	$i = 0;
	while (strstr ($cont, "nggallery"))
	{
		$cont1 .= strstr ($cont, "[nggallery", true);
		$cont = strstr ($cont, "[nggallery");
		global $wpdb;
		$sqlstr = "SELECT name from wp_".$post1 ["blog_id"]."_ngg_gallery where gid=".substr (strstr ($cont, "]", true), 14, strlen (strstr ($cont, "]", true)) - 14);
		$gal_name = $wpdb->get_results ($sqlstr, ARRAY_A);
		$cont = substr (strstr ($cont, "]"), 1, strlen (strstr ($cont, "]")) - 1);
		$cont1 .= "<div style='display: inline !important;'>";
		$hdl1 = opendir ("../wpmu31/wp-content/uploads/sites/".$post1 ["blog_id"]."/nggallery/".$gal_name [0]["name"]."/thumbs");
		while ($f = readdir ($hdl1))
		if (!strstr ($f, "_backup") && ($f != ".") && ($f != ".."))
			$cont1 .= "<span style='width: 100px !important;'><img src='http://localhost/wpmu31/wp-content/uploads/sites/".$post1 ["blog_id"]."/nggallery/".$gal_name [0]["name"]."/thumbs/".$f."'></span>";
		$cont1 .= "</div>";
	}
	$cont1 .= $cont."</div>";;
		}
		else
				echo "</a>
	</div><!-- .thumb-container -->	

	<div class='entry-summary' style='max-height: 600px !important; overflow: hidden !important;'>".$post1 ["post_content"]."</div><!-- .entry-summary -->";
	$sqlstr = "select comment_ID from wp_".$post1 ["blog_id"]."_comments where comment_post_ID=".$post1 ["id"];
	$comm_list = $wpdb->get_results ($sqlstr, ARRAY_A);

	echo "<footer class='entry-meta'>
	<div style='padding: 0 !important;'>
			<span class='comments-link' style='font-size: 12px;'><a href='http://localhost".$post1 ["path"].substr ($post1 ["post_date"], 0, 4)."/".substr ($post1 ["post_date"], 5, 2)."/".substr ($post1 ["post_date"], 8, 2)."/".$post1 ["post_name"]."/#respond'>";
			switch (count ($comm_list))
			{
				case 0:
					echo "Залишити коментарій";
					break;
				case 1:
					echo "1 коментарій";
					break;
				default:
					echo count ($comm_list)." коментаріів";
					break;
			}
			echo "</a></span>";
			
			global $post;
global $blog_id;
				
		global $switched;		
		global $wpdb;
		$blog_list = get_blog_list( 0, 'all' ); 		
		$output = '';
		$own_post = false;
		$sqlstr = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$post1 ["blog_id"];		
		$photo_list = $wpdb->get_results($sqlstr, ARRAY_A);
		foreach ($photo_list as $post2)
			if ($post2 ["user_id"] == $user_ID)
				$own_post = true;
			if (($user_ID != 0) && ($post1 ["blog_id"] != 1) && ($own_post))
				echo "<form action='http://localhost/wpmu31/додати-новий-пост' method='post' style='display: inline !important;'>
				<input type='hidden' name='edit_id' value='".$post1 ["id"]."'/>
				<input type='hidden' name='blog_id' value='".$post1 ["blog_id"]."'/>
				<input type='hidden' name='cat' value='".$cat_list [0]["term_id"]."'/>
				<input type='submit' value='Редагувати' class='buttons' style='height: 30px !important; font-size: 12px !important;'/>
				</form>
				<form action='http://localhost/wpmu31/додати-новий-пост' method='post' style='display: inline !important;'>
				<input type='hidden' name='remove_id' value='".$post1 ["id"]."'/>
				<input type='hidden' name='blog_id' value='".$post1 ["blog_id"]."'/>
				<input type='submit' value='Видалити' class='buttons' style='height: 30px !important; font-size: 12px !important;'/>
				</form>";

		echo "<div class='read-more' style='height: 30px !important; margin: 0px !important; float: right !important;'>
			<a href='http://localhost".$post1 ["path"].substr ($post1 ["post_date"], 0, 4)."/".substr ($post1 ["post_date"], 5, 2)."/".substr ($post1 ["post_date"], 8, 2)."/".$post1 ["post_name"]."'>Далі</a>
		</div>
		</div>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
</div>
</div>";
}
		
		echo "</div></div>";
		$output .=  $wpdb->print_error();
		echo "<div id='secondary' class='widget-area' role='complementary'>";			
 get_sidebar();
 if ($user_ID > 0)
	echo "</div>
	</div>
	<footer id='colophon' class='site-footer' role='contentinfo' style='position: relative; top: 50px;'>
		<div class='site-info' style='text-align: center;'>";
	else
	echo "</div>
	</div>
	<footer id='colophon' class='site-footer' role='contentinfo' style='position: relative; top: 130px;'>
		<div class='site-info' style='text-align: center;'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( '2014', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Дизайн: <a href="mailto:arhibober@gmail.com" rel="designer">arhobober</a>' ));
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->";

wp_footer();
echo "</body>
</html>";
		break;
		case 46: case 40:

		?>
		<!DOCTYPE html>
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
		$sqlstr = "SELECT path from wp_blogs where blog_id=".$_GET ["user"];		
		$pathes = $wpdb->get_results($sqlstr, ARRAY_A);
		$p1 = $pathes [0]["path"];
		$sqlstr = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$user_ID;		
		$photo_list = $wpdb->get_results($sqlstr, ARRAY_A);
		if ($user_ID != 1)
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
		if ($user_ID != 1)
		{
		foreach ($user_list as $user)
		{		
			$u = $user ["user_login"];
			break;
		}
		}
		$sqlstr = "SELECT meta_value from wp_usermeta where meta_key='first_name' and user_id=(SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$user_ID.")";
		$names = $wpdb->get_results($sqlstr, ARRAY_A);
		$sqlstr = "SELECT meta_value from wp_usermeta where meta_key='last_name' and user_id=(SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$user_ID.")";		
		$surnames = $wpdb->get_results($sqlstr, ARRAY_A);
		?>
		<div style="display: inline-block !important;">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php 
			if ($_GET ["user"] == 1)
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
			if ($user_ID == 1)
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
	<div style="display: inline-block;" class="left-column content-area" id="primary"
	<?php
		global $user_ID;
		if (!strstr($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
			echo "style='position: relative !important; top: -200px !important;'";
		
	?>>
	<div style="width: 100% !important;">

			<?php if ((get_the_ID() != 28) || ($user_ID == 0))
		{
		echo "<main id='main' class='site-main' role='main'>";
		while ( have_posts() ) : the_post();

				get_template_part( 'content', 'page' );

			endwhile; // end of the loop. 

		echo "</main>";
		}
		if (($i == 1) && (strstr($_SERVER['HTTP_USER_AGENT'], 'Firefox')))
		echo "<div style='height: 71px !important; background: #17769b !important;'></div>";
		?>
	</div><!-- #primary --><?php
		echo "</div>
		<div id='secondary' class='widget-area' role='complementary'>";
 get_sidebar();
 echo "</div>
 </div>
 <footer id='colophon' class='site-footer' role=' role='contentinfo' style='position: relative; top: 50px;'>
		<div class='site-info' style='text-align: center;'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( '2014', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Дизайн: <a href="mailto:arhibober@gmail.com" rel="designer">arhobober</a>' ));
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->";
wp_footer();
echo "</body>
</html>";
default:
get_header();

	?>	
	<div style="display: inline-block;" class="left-column content-area" id="primary"
	<?php
		global $user_ID;
		if (!strstr($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
			echo "style='position: relative !important; top: -200px !important;'";
		
	?>>
	<div style="width: 100% !important;">

			<?php if ((get_the_ID() != 28) || ($user_ID == 0))
		{
		echo "<main id='main' class='site-main' role='main'>";
		while ( have_posts() ) : the_post();

				get_template_part( 'content', 'page' );

			endwhile; // end of the loop. 

		echo "</main>";
		}
		if (($i == 1) && (strstr($_SERVER['HTTP_USER_AGENT'], 'Firefox')))
		echo "<div style='height: 71px !important; background: #17769b !important;'></div>";
		?>
	</div><!-- #primary --><?php
		echo "</div>
		<div id='secondary' class='widget-area' role='complementary'>";
 get_sidebar();
 echo "</div>
 </div>
 <footer id='colophon' class='site-footer' role=' role='contentinfo' style='position: relative; top: 50px;'>
		<div class='site-info' style='text-align: center;'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( '2014', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Дизайн: <a href="mailto:arhibober@gmail.com" rel="designer">arhobober</a>' ));
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->";
wp_footer();
echo "</body>
</html>";
		}
		}
		}
		}
	function submit_post1() {
        global $userdata;

        $errors = array();

        $title = trim ($_POST ["wpuf_post_title1"]);
        $content = trim( $_POST ["wpuf_post_content1"]);

        $tags = "";
        $cat = "";
        if (isset ($_POST ["wpuf_post_tags1"]))
		{
            $tags = wpuf_clean_tags ($_POST ["wpuf_post_tags1"]);
        }

        //if there is some attachement, validate them
        if (!empty ($_FILES ["wpuf_post_attachments1"]))
		{
            $errors = wpuf_check_upload();
        }

        if (empty ($title))
		{
            $errors[] = __("Ви стерли заголовок посту", "wpuf");
        }
		else {
            $title = trim (strip_tags ($title));
        }

        //validate cat
        if (wpuf_get_option ("allow_cats", "wpuf_frontend_posting", "on") == "on")
		{
            $cat_type = wpuf_get_option ("cat_type", "wpuf_frontend_posting", "normal");
            if (!isset ($_POST ["category"]))
			{
                $errors[] = __("Будь ласка, уберить категорію", "wpuf");
            }
			else
			if (($cat_type == "normal") && ($_POST ["category"][0] == "-1")) {
                $errors[] = __("Будь ласка, уберить категорію", "wpuf");
            }
			else
			{
                if (count ($_POST ["category"]) < 1 )
				{
                    $errors[] = __("Будь ласка, уберить категорію", "wpuf");
                }
            }
        }

        if ( empty( $content ) ) {
            $errors[] = __("Вікно для тексту порожне", "wpuf");
        } else {
            $content = trim ($content);
		$content1 [0] = $content;
		$content5 = "";
		for ($i = 0; $i < substr_count ($content, "youtu"); $i++)
			for ($i = 0; $i < substr_count ($content, "youtu"); $i++)
			if (strstr ($content1 [$i], "youtu"))
			{
				if (((strstr (strstr ($content1 [$i], "youtu"), " ")) && (strstr (strstr ($content1 [$i], "youtu"), "
")) && (stripos (strstr ($content1 [$i], "youtu"), " ") < stripos (strstr ($content1 [$i], "youtu"), "
"))) || ((strstr (strstr ($content1 [$i], "youtu"), " ")) && (!strstr (strstr ($content1 [$i], "youtu"), "
"))))
					$content2 = strstr (strstr ($content1 [$i], "youtu"), " ");
				if (((strstr (strstr ($content1 [$i], "youtu"), " ")) && (strstr (strstr ($content1 [$i], "youtu"), "
")) && (stripos (strstr ($content1 [$i], "youtu"), " ") > stripos (strstr ($content1 [$i], "youtu"), "
"))) || ((!strstr (strstr ($content1 [$i], "youtu"), " ")) && (strstr (strstr ($content1 [$i], "youtu"), "
"))))
					$content2 = strstr (strstr ($content1 [$i], "youtu"), "
");
				if ((!strstr (strstr ($content1 [$i], "youtu"), " ")) && (!strstr (strstr ($content1 [$i], "youtu"), "
")))				
					$content2 = "";
				if (((strstr (strstr ($content1 [$i], "youtu", true), " ")) && (strstr (strstr ($content1 [$i], "youtu", true), "
")) && (strrpos (strstr ($content1 [$i], "youtu", true), " ") > strrpos (strstr ($content1 [$i], "youtu", true), "
"))) || ((strstr (strstr ($content1 [$i], "youtu", true), " ")) && (!strstr (strstr ($content1 [$i], "youtu", true), "
"))))
				{
					$content3 = substr (strstr ($content1 [$i], "youtu", true), 0, strlen (strstr ($content1 [$i], "youtu", true)) - strlen (strrchr (strstr ($content1 [$i], "youtu", true), " ")))." ";					
					$content4 = strstr (strstr ($content1 [$i], "youtu"), " ", true);
				}
				if (((strstr (strstr ($content1 [$i], "youtu", true), " ")) && (strstr (strstr ($content1 [$i], "youtu", true), "
")) && (strrpos (strstr ($content1 [$i], "youtu", true), " ") < strrpos (strstr ($content1 [$i], "youtu", true), "
"))) || ((!strstr (strstr ($content1 [$i], "youtu", true), " ")) && (strstr (strstr ($content1 [$i], "youtu", true), "
"))))
				{
					$content3 = substr (strstr ($content1 [$i], "youtu", true), 0, strlen (strstr ($content1 [$i], "youtu", true)) - strlen (strrchr (strstr ($content1 [$i], "youtu", true), "
")))."
";					
					$content4 = strstr (strstr ($content1 [$i], "youtu"), "				
", true);
				}
				if ((!strstr (strstr ($content1 [$i], "youtu", true), " ")) && (!strstr (strstr ($content1 [$i], "youtu", true), "
")))
				{
					$content3 = "";
					$content4 = strstr ($content1 [$i], "youtu");
				}
				if (strstr ($content4, ".be/"))
					$adress = substr ($content4, 9, 11);
				if (strstr ($content4, "embed"))
					$adress = substr ($content4, 18, 11);
				if (strstr ($content4, "v="))
					$adress = substr ( strstr ($content4, "v="), 2, 11);
				$content1 [$i + 1] = $content2;
				$content5 = $content5.$content3."<iframe width='420' height='315' src='//www.youtube.com/embed/".$adress."' frameborder='0' allowfullscreen autoplay='0'></iframe>";
			}
		if (strstr ($content, "youtu"))
		{
			$content5 = $content5.$content2;
			$content = $content5;
		}
        }

        if ( !empty( $tags ) ) {
            $tags = explode( ',', $tags );
        }

        //process the custom fields
        $custom_fields = array();

        $fields = wpuf_get_custom_fields();
        if ( is_array( $fields ) ) {

            foreach ($fields as $cf) {
                if ( array_key_exists( $cf['field'], $_POST ) ) {

                    if ( is_array( $_POST [$cf ['field']] ) ) {
                        $temp = implode(',', $_POST [$cf ['field']]);
                    } else {
                        $temp = trim( strip_tags( $_POST [$cf ['field']] ) );
                    }
                    //var_dump($temp, $cf);

                    if ( ( $cf['type'] == 'yes' ) && !$temp ) {
                        $errors[] = sprintf( __( '"%s" is missing', 'wpuf' ), $cf['label'] );
                    } else {
                        $custom_fields[$cf['field']] = $temp;
                    }
                } //array_key_exists
            } //foreach
        } //is_array
        //post attachment
        $attach_id = isset( $_POST['wpuf_featured_img'] ) ? intval( $_POST['wpuf_featured_img'] ) : 0;

        $errors = apply_filters( 'wpuf_edit_post_validation', $errors );

        if ( !$errors ) {

            //users are allowed to choose category
            if ( wpuf_get_option( 'allow_cats', 'wpuf_frontend_posting', 'on' ) == 'on' ) {
                
			switch ($_POST ["category"])
			{
				case "Поезія":
					$post_category = 2;
					break;
				case "Проза":
					$post_category = 3;
					break;
				case "Живопис і фотографія":
					$post_category = 4;
					break;
				case "Музика":
					$post_category = 5;
					break;
				case "Відео":
					$post_category = 6;
					break;
				case "Щоденник":
					$post_category = 8;
					break;
			}
            } else {
                $post_category = array( wpuf_get_option( 'default_cat', 'wpuf_frontend_posting' ) );
            }
			global $user_ID;			
			global $wpdb;
			$sqlstr = "SELECT meta_value from wp_usermeta where meta_key='primary_blog' and user_id=".$user_ID;	
			$sites = $wpdb->get_results ($sqlstr, ARRAY_A);
			$sqlstr = "SELECT path from wp_blogs where blog_id=".$sites [0]["meta_value"];	
			$path = $wpdb->get_results ($sqlstr, ARRAY_A);
			$sqlstr = "SELECT post_date, post_name from wp_".$sites [0]["meta_value"]."_posts where ID=".$_POST ["post_id1"];	
			$pathes = $wpdb->get_results ($sqlstr, ARRAY_A);
			
			if ($_FILES ["avatar"]["name"] != "")
{
if ($_FILES ["avatar"]["size"] > 1048756)
        {
          echo ("<p align='center'>Розмір фотографії перевищує один мегабайт</p>");
          exit;
        }
        // Проверяем загружен ли файл
        if(is_uploaded_file ($_FILES ["avatar"]["tmp_name"]))
        {
          // Если файл загружен успешно, перемещаем его
          // из временной директории в конечную
          move_uploaded_file ($_FILES ["avatar"]["tmp_name"],
            "D:/xampp/htdocs/wpmu31/PHOTO".$sites [0]["meta_value"]."_".$_POST ["post_id1"].substr ($_FILES ["avatar"]["name"],
            strlen ($_FILES ["avatar"]["name"]) - 4, 4));
          echo "<p align='center'>Фотографія завантажена успішно.</p>";
        }	
        else
        {
          echo "<p align='center'>Помилка завантаження фотографії.</p>";
          exit;
        } 
		}
		$i = 0;		
		$hdl1 = opendir ("photos");
    $content1 = "";
    while ($file = readdir ($hdl1))
    {
      $pf = strstr ($file, "b", true);
      $pf1 = strstr (substr ($file, strlen ($pf), strlen ($file) - strlen ($pf)), "c", true);
      if ((strstr ($pf, $_POST ["post_id1"])) && (substr ($pf1, 1, strlen ($pf1) - 1) == $sites ["meta_value"][0]))
        $a [] = $file;
    }
    for ($i = 0; $i < sizeof ($a); $i++)
      $b [$i] = (integer)(substr (strstr ($a [$i], "c"), 1, strlen (strstr ($a [$i], "c")) - 1));
		if (count ($b) > o)
			sort ($b);
        for ($i = 0; $i < sizeof ($b); $i++)
		{
		if ($_FILES ["photo_post".$i]["size"] > 1048756)
        {
          echo "<p align='center'>Розмір фотографії перевищує один мегабайт</p>";
          exit;
        }
        // Проверяем загружен ли файл
        if(is_uploaded_file ($_FILES[ "photo_post".$i]["tmp_name"]))
        {
          // Если файл загружен успешно, перемещаем его
          // из временной директории в конечную
          move_uploaded_file ($_FILES ["photo_post".$i]["tmp_name"],
            "D:/xampp/htdocs/wpmu31/PHOTO".$sites [0]["meta_value"]."_".$_POST['post_id1']."_".$b [$i].substr ($_FILES ["photo_post".$i]["name"],
            strlen ($_FILES ["photo_post".$i]["name"]) - 4, 4));
          echo "<p align='center'>Фотографія завантажена успішно.</p>";
        }	
        else
        {
          echo "<p align='center'>Помилка завантаження фотографії.</p>";
          exit;
        }
		if ($i == 0)
			$content1 .= substr ($content, 0, $b [$i]);
		else
			$content1 .= substr ($content, $b [$i - 1], $b [$i] - $b [$i - 1]);
		$content1 .= "<img src = 'http://localhost/wpmu31/PHOTO".$sites [0]["meta_value"]."_".$_POST['post_id1']."_".$b [$i].substr ($_FILES ["photo_post".$i]["name"],
            strlen ($_FILES ["photo_post".$i]["name"]) - 4, 4)."'>";
		}
		$content1 .= substr ($content, $b [sizeof ($b) - 1], strlen ($content) - $b [sizeof ($b) - 1]);
		$content = $content1;
		
			$wpdb->update ("wp_".$sites [0]["meta_value"]."_posts", array ("post_title"=>$title, "post_content"=>$content, "post_modified" => date( 'Y-m-d H:i:s')), array ("ID" => trim ($_POST ["post_id1"])));
			$wpdb->update ("wp_".$sites [0]["meta_value"]."_term_relationships", array ("term_taxonomy_id"=>$post_category), array ("object_id"=>trim($_POST['post_id1'])));
			
			global $wpdb;
			$sqlstr = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$post1 ["blog_id"];		
		$photo_list = $wpdb->get_results($sqlstr, ARRAY_A);
			header ("Location: http://localhost".$path [0]["path"].substr ($pathes [0]["post_date"], 0, 4)."/".substr ($pathes [0]["post_date"], 5, 2)."/".substr ($pathes [0]["post_date"], 8, 2)."/".$pathes [0]["post_name"]);
            $post_update = array(
                'ID' => trim ($_POST ["post_id1"]),
                'post_title' => $title,
                'post_content' => $content,
                'post_category' => $post_category,
                'tags_input' => $tags
            );

            //plugin API to extend the functionality
            $post_update = apply_filters( 'wpuf_edit_post_args', $post_update );
            $post_id = wp_update_post( $post_update );
			
            echo '<div class="success">' . __( 'Пост оновлен успішно.', 'wpuf' ) . '</div>';

            if ( $post_id ) {

                //upload attachment to the post
                wpuf_upload_attachment( $post_id );

                //set post thumbnail if has any
                if ( $attach_id ) {
                    set_post_thumbnail( $post_id, $attach_id );
                }

                //add the custom fields
                if ( $custom_fields ) {
                    foreach ($custom_fields as $key => $val) {
                        update_post_meta( $post_id, $key, $val, false );
                    }
                }

                do_action( 'wpuf_edit_post_after_update', $post_id );
            }
        } else {
            echo wpuf_error_msg( $errors );
        }
    }
		?>	