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
get_header();?>

<?php
		if ($_GET ["edit_id"] > 0)
		{
		global $wpdb;
		global $blog_id;
		global $user_ID;
		$blog_list = get_blog_list ( 0, 'all'); 		
		$output = '';
		$own_post = false;
		echo false;
		$sqlstr = "SELECT meta_value from wp_usermeta where meta_key='primary_blog' and meta_value=".$user_ID;		
		$posts2 = $wpdb->get_results ($sqlstr, ARRAY_A);
		//echo $wpdb->print_error();
		foreach ($posts2 as $post2)
			if ($post2 ["meta_value"] == $_GET ["blog_id"])
				$own_post = true;
			if (($user_ID != 0) && ($own_post))
			{
echo "<div id='primary' class='content-area' style='background-color: #ffffff !important;'>
<main id='main' class='site-main' role='main'>";
		global $userdata;
		$sqlstr = "SELECT post_title, post_content from wp_".$_GET ["blog_id"]."_posts where ID=".$_GET ["edit_id"];		
		$posts = $wpdb->get_results($sqlstr, ARRAY_A);
		//echo $wpdb->print_error();
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
        if ( isset( $_POST['wpuf_edit_post_submit'] )) {
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
		
		$post_tags = wp_get_post_tags($_GET["edit_id"]);
        $tagsarray = array();
        foreach ($post_tags as $tag) {
            $tagsarray[] = $tag->name;
        }
        $tagslist = implode( ', ', $tagsarray );
        $categories = get_the_category($_GET["edit_id"]);
        $featured_image = wpuf_get_option( 'enable_featured_image', 'wpuf_frontend_posting', 'no' );
        ?>	
		<h2>Редагувати поточний пост</h2>
        <div id="wpuf-post-area1">	
            <form name="wpuf_edit_post_form" id="wpuf_edit_post_form" action="" enctype="multipart/form-data" method="POST">
                <?php wp_nonce_field( 'wpuf-edit-post' ) ?>
                <ul class="wpuf-post-form">

                    <?php do_action( 'wpuf_add_post_form_top', $curpost->post_type, $curpost ); //plugin hook      ?>
                    <?php wpuf_build_custom_field_form( 'top', true, $_GET["edit_id"]); ?>

                    

                    <li>
                        <label for="new-post-title1">
                            <?php echo wpuf_get_option( 'title_label', 'wpuf_labels', 'Заголовок' ); ?> <span class="required">*</span>
                        </label>
						<br/>
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
										
		$isAvatar = false;
		$dirct = "../wpmu31";
        $hdl = opendir ($dirct);
        while ($file = readdir ($hdl)) 
            if (strstr ($file, "PHOTO".$user_ID."_".$_GET["edit_id"].".") == true)
			{
				echo "<a href='http://localhost/wpmu31/remove_avatar.php?user=".$user_ID."&id=".$_GET["edit_id"]."'>Видалити аватар</a>";
				$isAvatar = true;
			}
		if (!$isAvatar)
			echo "<input name='avatar' type='file'/>";
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

							//echo $_GET ["edit_id"];
                            $cats = get_the_category (183);
							//echo $cats;
                            /*$selected = 0;
							echo $cats [0]->term_id;
                            if ( $cats ) {
								echo 0;
                                $selected = $cats [0]->term_id;
								echo $selected;
                            }*/
							$selected = $_GET ["cat"];
                            //var_dump( $cats );
                            //var_dump( $selected );
							echo $selected;
                            ?>
                            <div class="category-wrap" style="float:left;">
                                <div id="lvl01">
                                    <?php
									
									$cats = array ("Поезія", "Проза", "Живопис і фотографія", "Музика", "Відео", "Щоденник", "Інше");
									echo "<select name='category'>";
									for ($i = 0; $i < 7; $i++)
									{
										echo "<option id='".$i."'";
										if ($i == $_GET ["cat"] - 1)
											echo " selected";
										echo ">".$cats [$i]."</option>";
									}
									echo "</select>";
									
                                    /*if ( $cat_type == 'normal' ) {*/
                                        /*wp_dropdown_categories( 'show_option_none=' . __( '-- Увібрати --', 'wpuf' ) . '&hierarchical=1&hide_empty=0&orderby=name&name=category[]&id=cat&show_count=0&title_li=&use_desc_for_title=1&class=cat requiredField&exclude=' . $exclude . '&selected=' . $selected );*/
                                    /*} else if ( $cat_type == 'ajax' ) {
                                        wp_dropdown_categories( 'show_option_none=' . __( '-- Select --', 'wpuf' ) . '&hierarchical=1&hide_empty=0&orderby=name&name=category[]&id=cat-ajax&show_count=0&title_li=&use_desc_for_title=1&class=cat requiredField&depth=1&exclude=' . $exclude . '&selected=' . $selected );
                                    } else {
                                        wpuf_category_checklist ( $_GET ["edit_id"], false, 'category', $exclude);*/
                                    //}
                                    ?>
                                </div>
                            </div>
                            <div class="loading"></div>
                            <div class="clear"></div>
                            <p class="description"><?php echo stripslashes( wpuf_get_option( 'cat_help', 'wpuf_labels' ) ); ?></p>
                        </li>
                    <?php } ?>

                    <?php do_action( 'wpuf_add_post_form_description', $curpost->post_type, $curpost ); ?>
                    <?php wpuf_build_custom_field_form( 'description', true, $_GET ["edit_id"]); ?>

                    
                        
						<li>
                        <label for="new-post-desc">
                            <?php echo wpuf_get_option( 'desc_label', 'wpuf_labels', 'Текст посту' ); ?> <span class="required">*</span>
                        </label>

                        <?php
                        $editor = 'full';
                            ?>
                            <div style="float:left;">
                                <?php wp_editor( $content1, 'new-post-desc', array('textarea_name' => 'wpuf_post_content1', 'editor_class' => 'requiredField', 'teeny' => false, 'textarea_rows' => 8,), false); ?>
                            </div>
                    </li>

                    <?php do_action( 'wpuf_add_post_form_after_description', $curpost->post_type, $curpost ); ?>
                    <?php wpuf_build_custom_field_form( 'tag', true, $_GET["edit_id"]); ?>
					
					<br/>

                                            <li><br/><br/><br/><br/><br/><br><br/>
                            <label for="new-post-tags">
                                <?php echo wpuf_get_option( 'tag_label', 'wpuf_labels', 'Tеги' ); ?>
                            </label><br/>
                            <input type="text" name="wpuf_post_tags1" id="new-post-tags" value="<?php echo $tagslist; ?>">
                            <p class="description"><?php echo stripslashes( wpuf_get_option( 'tag_help', 'wpuf_labels' ) ); ?></p>
                            <div class="clear"></div>
                        </li>

                    

                    <li>
                        <label>&nbsp;</label>
                        <input class="wpuf_submit" type="submit" name="wpuf_edit_post_submit1" value="<?php echo esc_attr( wpuf_get_option( 'update_label', 'wpuf_labels', 'Оновити пост' ) ); ?>">
                        <input type="hidden" name="wpuf_edit_post_submit" value="yes" />
                        <input type="hidden" name="post_id1" value="<?php echo $_GET ["edit_id"]; ?>">
                    </li>
                </ul>
            </form>
        </div>


        <?php
		echo "</main></div><div id='secondary' class='widget-area' role='complementary' style='position: absolute; top: 229px; left: 831px;'>";
		
	
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
		<div class='site-info'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( 'Proudly powered by %s', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Theme: %1$s by %2$s.', 'blue-river' ), 'Blue River', '<a href="http://profiles.wordpress.org/vld7/" rel="designer">Vlad</a>' );
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->";
echo "<br/><br/><br/><br/><br/>9999";
$walker = new WPUF_Walker_Category_Checklist();

		$categories = (array) get_terms('category', array('get' => 'all'));

    echo '<ul class="wpuf-category-checklist">';
	/*$defaults = array(
		'descendants_and_self' => 0,
		'selected_cats' => false,
		'popular_cats' => false,
		'walker' => null,
		'taxonomy' => 'category',
		'checked_ontop' => true
	);
	$args = apply_filters( 'wp_terms_checklist_args', $args, $post_id );

	extract( wp_parse_args($args, $defaults), EXTR_SKIP );

	if ( empty($walker) || !is_a($walker, 'Walker') )
		$walker = new Walker_Category_Checklist;

	$descendants_and_self = (int) $descendants_and_self;

	$args = array('taxonomy' => $taxonomy);

	$tax = get_taxonomy($taxonomy);
	$args['disabled'] = !current_user_can($tax->cap->assign_terms);

	if ( is_array( $selected_cats ) )
		$args['selected_cats'] = $selected_cats;
	elseif ( $post_id )
		$args['selected_cats'] = wp_get_object_terms($post_id, $taxonomy, array_merge($args, array('fields' => 'ids')));
	else
		$args['selected_cats'] = array();

	if ( is_array( $popular_cats ) )
		$args['popular_cats'] = $popular_cats;
	else
		$args['popular_cats'] = get_terms( $taxonomy, array( 'fields' => 'ids', 'orderby' => 'count', 'order' => 'DESC', 'number' => 10, 'hierarchical' => false ) );

	if ( $descendants_and_self ) {
		$categories = (array) get_terms($taxonomy, array( 'child_of' => $descendants_and_self, 'hierarchical' => 0, 'hide_empty' => 0 ) );
		$self = get_term( $descendants_and_self, $taxonomy );
		array_unshift( $categories, $self );
	} else {
		$categories = (array) get_terms($taxonomy, array('get' => 'all'));
	}

	if ( $checked_ontop ) {
		// Post process $categories rather than adding an exclude to the get_terms() query to keep the query the same across all posts (for any query cache)
		$checked_categories = array();
		$keys = array_keys( $categories );

		foreach( $keys as $k ) {
			if ( in_array( $categories[$k]->term_id, $args['selected_cats'] ) ) {
				$checked_categories[] = $categories[$k];
				unset( $categories[$k] );
			}
		}

		// Put checked cats on top
		echo call_user_func_array(array(&$walker, 'walk'), array($checked_categories, 0, $args));
	}
	// Then the rest of them*/
	echo call_user_func_array(array(&$walker, 'walk'), array($categories, 0, array()));
    echo '</ul>';
echo get_the_category(183)[0]->term_id;
wpuf_category_checklist (183, true, 'category', $exclude);

wp_footer();
echo "</body>
</html>";
		}
		else
		{
			echo "Здається, Ви мали на увазі іншу сторінку.";
		echo "</main></div><div id='secondary' class='widget-area' role='complementary' style='position: absolute; top: 229px; left: 831px;'>";
		
	
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



	echo "<footer id='colophon' class='site-footer' role='contentinfo' style='position: relative; top: 550px;'>
		<div class='site-info'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( 'Proudly powered by %s', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Theme: %1$s by %2$s.', 'blue-river' ), 'Blue River', '<a href="http://profiles.wordpress.org/vld7/" rel="designer">Vlad</a>' );
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->";

echo "</body>
</html>";

		}
		}
else
{

	?><div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary --><?php
	switch (get_the_ID())
	{
	case 28:
rewind_posts();  
		global $switched;		
		global $wpdb;
		global $user_ID;
		if ($user_ID > 1)
		{
			$sqlstr = "SELECT path from wp_blogs where blog_id=(SELECT meta_value from wp_usermeta where meta_key='primary_blog' and meta_value=".$user_ID.")";		
			$sites = $wpdb->get_results ($sqlstr, ARRAY_A);
			if (strlen ($sites [0]["path"]) > 0)
			header ("Location: http://localhost".$sites [0]["path"]);
		}
		$table_prefix = $wpdb->base_prefix;
		$blog_list = get_blog_list( 0, 'all' ); 		
		$output = '';
		/*echo "fact".(($wpdb->get_results(" SELECT 7 as blog_id, id, post_date_gmt from wp_7_posts  where post_status = 'publish' and post_type = 'post' ORDER BY post_modified_gmt desc ", ARRAY_)))[0]);*/
		$j = 0;
		foreach ($blog_list as $blog)
		{
			if ($blog['blog_id'] != 1)
			{
			if ($j > 0)
				$sqlstr .= " union ";
				$sqlstr .= "SELECT b.path, b.blog_id, p.id, p.post_title, p.post_content, p.post_date_gmt, p.post_modified, p.guid from wp_".$blog['blog_id']."_posts as p, wp_blogs as b where p.post_status = 'publish' and p.post_type = 'post' and b.blog_id=".$blog['blog_id'];
			$j++;
			}			
		}
		$sqlstr.= " ORDER BY post_modified desc ";
		
		$post_list = $wpdb->get_results($sqlstr, ARRAY_A);
		//echo $wpdb->print_error();
		$i = 0;
		foreach ($post_list as $post) 
		{
		$i++;
		if ($i > 5)
			break;
			/*$txt = '<b style="font-size: 16px; color: #00cccc !important;">{title}</b>';
			$p = get_blog_post($post['blog_id'], $post["id"]);	
			
			$ex = $p->post_excerpt;
			if (!isset($ex) || trim($ex) == '')
				$ex = mb_substr(strip_tags($p->post_content), 0, 65) . '...';
			
			$txt = str_replace('{title}', '<a href="' .get_blog_permalink($post['blog_id'], $post["id"]).'" style="color: #00cccc !important;">'.$p->post_title.'</a>' , $txt);
			$output .=  $txt."<br/>";*/
			//the_post();
					echo "<div style='display: inline !important;'><div style='position: relative !important;";
					if ($i == 1)
						echo "top: 352px !important;";
					else
						echo "top: 70px !important;";
	echo "left: -70px !important;
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
	if ($i == 1)
		echo "<span style='position: relative !important; top: -345px !important;'> ";
	echo substr($post["post_modified"], 5, 2).".".substr($post["post_modified"], 8, 2);
	if ($i == 1)
		echo "</span>";
	echo "</div><div style='width: 700px; background-color: #ffffff; max-height: 600px !important; overflow: hidden !important;'>
					
					<article id='post-".$post["id"]."' >	

	<header class='entry-header'>";

		/*if ( 'post' == get_post_type() ) :
			echo "<div class='post-date'>";
				the_time('d.m');
			echo "</div><!-- .post-date -->";
		endif;*/
		
		echo "<h1 class='entry-title'><a href='".$post["guid"]."' rel='bookmark'>".$post["post_title"]."</a></h1>
		
	</header><!-- .entry-header -->
	
	<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Автор: ".substr ($post ["path"], 8, strlen ($post ["path"]) - 9)."</div>
	<div class='thumb-container'>
		<a href='".$post["post_title"]."' title='".$post["post_title"]."'>";
		/*if ( has_post_thumbnail() ) {
			the_post_thumbnail();
				}*/
				get_post_thumbnail_id($post["id"]);
				echo "</a>
	</div><!-- .thumb-container -->	

	<div class='entry-summary'>".$post["post_content"]."</div><!-- .entry-summary -->

	<footer class='entry-meta'>
		<div class='meta-group'>";
			if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search 
				
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( __( ', ', 'blue-river' ) );
					if ( $categories_list && blue_river_categorized_blog() ) :
				echo "<span class='cat-links'>";
					printf( __( 'Належить категоріям: %1$s', 'blue-river' ), $categories_list );
				echo "</span>";
				endif; // End if categories 
					/* translators: used between list items, there is a space after the comma */
					$tags_list = get_the_tag_list( '', __( ', ', 'blue-river' ) );
					if ( $tags_list ) :
				echo "<span class='tags-links'>";
					printf( __( 'Tagged %1$s', 'blue-river' ), $tags_list );
				echo "</span>";
				endif; 
				endif; 
				if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : 
			/*echo "<span class='comments-link'>".comments_popup_link( __( 'Залишити коментарій', 'blue-river' ), __( '1 Коментарій', 'blue-river' ), __( '% Коментаріїв', 'blue-river' ) )."</span>";*/
			endif;

			edit_post_link( __( 'Редагувати', 'blue-river' ), '<span class="edit-link">', '</span>' );
		echo "</div><!-- .meta-group -->
		<div class='read-more'>
			<a href='".$post["guid"]."'>Далі</a>
		</div>	
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
</div></div>";

			}
		
		$output .=  $wpdb->print_error();
		if ($user_ID == 0)
			echo "<div id='secondary' class='widget-area' role='complementary' style='position: absolute; top: 197px; left: 831px;'>";
		else
			echo "<div id='secondary' class='widget-area' role='complementary' style='position: absolute; top: 229px; left: 831px;'>";			
 get_sidebar();
 echo "</div>
 </div>
 <footer id='colophon' class='site-footer' role='contentinfo'>
		<div class='site-info'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( 'Proudly powered by %s', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Theme: %1$s by %2$s.', 'blue-river' ), 'Blue River', '<a href="http://profiles.wordpress.org/vld7/" rel="designer">Vlad</a>' );
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->";

wp_footer();
echo "</body>
</html>";
		break;
		case 40:
		echo "<div id='secondary' class='widget-area' role='complementary' style='position: absolute; top: 228px; left: 831px;'>";	
 get_sidebar();
 echo "</div>
 </div>
 <footer id='colophon' class='site-footer' role='contentinfo'>
		<div class='site-info'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( 'Proudly powered by %s', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Theme: %1$s by %2$s.', 'blue-river' ), 'Blue River', '<a href="http://profiles.wordpress.org/vld7/" rel="designer">Vlad</a>' );
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->";

wp_footer();
echo "</body>
</html>";
		break;
		default:
		echo "<div id='secondary' class='widget-area' role='complementary' style='position: absolute; top: 163px; left: 831px;'>";
 get_sidebar();
 echo "</div>
 </div>";
 echo "<footer id='colophon' class='site-footer' role='contentinfo' style='position: relative; top: 150px;'>
		<div class='site-info'>";
			do_action( 'blue_river_credits' );
			echo "<a href='http://wordpress.org/' rel='generator'>";
			printf( __( 'Proudly powered by %s', 'blue-river' ), 'WordPress' );
			echo "</a>
			<span class='sep'> | </span>";
			printf( __( 'Theme: %1$s by %2$s.', 'blue-river' ), 'Blue River', '<a href="http://profiles.wordpress.org/vld7/" rel="designer">Vlad</a>' );
		echo "</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->";
wp_footer();
echo "</body>
</html>";
		}
		}
	function submit_post1() {
		echo 99;
        global $userdata;

        $errors = array();

        $title = trim( $_POST['wpuf_post_title1'] );
        $content = trim( $_POST['wpuf_post_content1'] );

        $tags = '';
        $cat = '';
        if ( isset( $_POST['wpuf_post_tags1'] ) ) {
            $tags = wpuf_clean_tags( $_POST['wpuf_post_tags1'] );
        }

        //if there is some attachement, validate them
        if ( !empty( $_FILES['wpuf_post_attachments1'] ) ) {
            $errors = wpuf_check_upload();
        }

        if ( empty( $title ) ) {
            $errors[] = __( 'Ви стерли заголовок посту', 'wpuf' );
        } else {
            $title = trim( strip_tags( $title ) );
        }

        //validate cat
        if ( wpuf_get_option( 'allow_cats', 'wpuf_frontend_posting', 'on' ) == 'on' ) {
            $cat_type = wpuf_get_option( 'cat_type', 'wpuf_frontend_posting', 'normal' );
            if ( !isset( $_POST['category'] ) ) {
                $errors[] = __( 'Будь ласка, уберить категорію', 'wpuf' );
            } else if ( $cat_type == 'normal' && $_POST['category'][0] == '-1' ) {
                $errors[] = __( 'Будь ласка, уберить категорію', 'wpuf' );
            } else {
                if ( count( $_POST['category'] ) < 1 ) {
                    $errors[] = __( 'Будь ласка, уберить категорію', 'wpuf' );
                }
            }
        }

        if ( empty( $content ) ) {
            $errors[] = __( 'Вікно для тексту порожне', 'wpuf' );
        } else {
            $content = trim( $content );
				
		echo " t: ".$title." c: ".$content." ct: ".$cat_type;
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

                    if ( is_array( $_POST[$cf['field']] ) ) {
                        $temp = implode(',', $_POST[$cf['field']]);
                    } else {
                        $temp = trim( strip_tags( $_POST[$cf['field']] ) );
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
                
			switch ($_POST["category"])
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
				case "Інше":
					$post_category = 7;
					break;
			}
            } else {
                $post_category = array( wpuf_get_option( 'default_cat', 'wpuf_frontend_posting' ) );
            }
			echo " id: ".trim($_POST['post_id1'])." t: ".$title." cont: ".$content." cat: ".$post_category;
			global $wpdb;
			global $user_ID;
			/*$sqlstr_title = "UPDATE wp_".$user_ID."_posts set post_title=".$title." where ID=".trim($_POST['post_id1']);
			$sqlstr_content = "UPDATE wp_".$user_ID."_posts set post_content=".$content." where ID=".trim($_POST['post_id1']);
			echo "st: ".$sqlstr_title." sc: ".$sqlstr_content;
			/*$result_title = $wpdb->get_results ($sqlstr_title, ARRAY_A);
			$result_content = $wpdb->get_results ($sqlstr_content, ARRAY_A);
			$result_title = mysql_query($sqlstr_title) or die("Query failed");
			$result_content = mysql_query($sqlstr_content) or die("Query failed");
			$sites = $wpdb->get_results ($sqlstr, ARRAY_A);*/
			$wpdb->update("wp_".$user_ID."_posts", array ("post_title"=>$title, "post_content"=>$content, "post_modified" => date( 'Y-m-d H:i:s')), array ("ID"=>trim($_POST['post_id1'])));
			$wpdb->update("wp_".$user_ID."_term_relationships", array ("term_taxonomy_id"=>$post_category), array ("object_id"=>trim($_POST['post_id1'])));
			if ($_FILES ["avatar"]["name"] != "")
{
if ($_FILES ["avatar"]["size"] > 1048756)
        {
          echo ("<p align='center'>Розмір фотографії перевищує один мегабайт</p>");
          exit;
        }
        // Проверяем загружен ли файл
        if(is_uploaded_file($_FILES["avatar"]["tmp_name"]))
        {
          // Если файл загружен успешно, перемещаем его
          // из временной директории в конечную
          move_uploaded_file($_FILES["avatar"]["tmp_name"],
            "D:/xampp/htdocs/wpmu31/PHOTO".$user_ID."_".$_POST['post_id1'].substr ($_FILES ["avatar"]["name"],
            strlen ($_FILES ["avatar"]["name"]) - 4, 4));
          echo "<p align='center'>Фотографія завантажена успішно.</p>";
        }	
        else
        {
          echo "<p align='center'>Помилка завантаження фотографії.</p>";
          exit;
        } 
		}
			if (strlen ($sites [0]["path"]) > 0)
			header ("Location: http://localhost".$sites [0]["path"]);
            $post_update = array(
                'ID' => trim($_POST['post_id1']),
                'post_title' => $title,
                'post_content' => $content,
                'post_category' => $post_category,
                'tags_input' => $tags
            );

            //plugin API to extend the functionality
            $post_update = apply_filters( 'wpuf_edit_post_args', $post_update );
            $post_id = wp_update_post( $post_update );

            if ( $post_id ) {
                echo '<div class="success">' . __( 'Пост оновлен успішно.', 'wpuf' ) . '</div>';

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
	</div><!-- #secondary -->
	<script language="javascript">
	
  function getCaret(el)
  {
    if (el.selectionStart)
      return el.selectionStart;
    else
      if (document.selection)
      {
        el.focus();
        var r = document.selection.createRange();
        if (r == null)
          return 0;
        var re = el.createTextRange(),
        rc = re.duplicate();
        re.moveToBookmark(r.getBookmark());
        rc.setEndPoint('EndToStart', re);
        return rc.text.length;
      }
      return 0;
  }

	</script><?php
	

		
		$post_tags = wp_get_post_tags( $curpost->ID );
        $tagsarray = array();
        foreach ($post_tags as $tag) {
            $tagsarray[] = $tag->name;
        }
        $tagslist = implode( ', ', $tagsarray );
        $categories = get_the_category( $curpost->ID );
        $featured_image = wpuf_get_option( 'enable_featured_image', 'wpuf_frontend_posting', 'no' );
        ?>	
		<h2>Редагувати поточний пост<h2/>
        <div id="wpuf-post-area1">	
            <form name="wpuf_edit_post_form" id="wpuf_edit_post_form" action="" enctype="multipart/form-data" method="POST">
                <?php wp_nonce_field( 'wpuf-edit-post' ) ?>
                <ul class="wpuf-post-form">

                    <?php do_action( 'wpuf_add_post_form_top', $curpost->post_type, $curpost ); //plugin hook      ?>
                    <?php wpuf_build_custom_field_form( 'top', true, $curpost->ID ); ?>

                    

                    <li>
                        <label for="new-post-title1">
                            <?php echo wpuf_get_option( 'title_label', 'wpuf_labels', 'Заголовок' ); ?> <span class="required">*</span>
                        </label>
						<br/>
                        <input type="text" name="wpuf_post_title1" id="new-post-title1" minlength="2" value="<?php echo $post->post_title; ?>">
                        <div class="clear"></div>
                        <p class="description"><?php echo stripslashes( wpuf_get_option( 'title_help', 'wpuf_labels' ) ); ?></p>
                    </li>

                    <?php if ( wpuf_get_option( 'allow_cats', 'wpuf_frontend_posting', 'on' ) == 'on' ) { ?>
                        <li>
                            <label for="new-post-cat">
                                <?php echo wpuf_get_option( 'cat_label', 'wpuf_labels', 'Категорія' ); ?> <span class="required">*</span>
                            </label>

                            <?php
                            $exclude = wpuf_get_option( 'exclude_cats', 'wpuf_frontend_posting' );
                            $cat_type = wpuf_get_option( 'cat_type', 'wpuf_frontend_posting' );

                            $cats = get_the_category( $post->ID );
                            $selected = 0;
                            if ( $cats ) {
                                $selected = $cats[0]->term_id;
                            }
                            //var_dump( $cats );
                            //var_dump( $selected );
                            ?>
                            <div class="category-wrap" style="float:left;">
                                <div id="lvl01">
                                    <?php
                                    /*if ( $cat_type == 'normal' ) {
                                        wp_dropdown_categories( 'show_option_none=' . __( '-- Select --', 'wpuf' ) . '&hierarchical=1&hide_empty=0&orderby=name&name=category[]&id=cat&show_count=0&title_li=&use_desc_for_title=1&class=cat requiredField&exclude=' . $exclude . '&selected=' . $selected );
                                    } else if ( $cat_type == 'ajax' ) {
                                        wp_dropdown_categories( 'show_option_none=' . __( '-- Select --', 'wpuf' ) . '&hierarchical=1&hide_empty=0&orderby=name&name=category[]&id=cat-ajax&show_count=0&title_li=&use_desc_for_title=1&class=cat requiredField&depth=1&exclude=' . $exclude . '&selected=' . $selected );
                                    } else {*/
                                        wpuf_category_checklist( $post->ID, false, 'category', $exclude);
                                    //}
                                    ?>
                                </div>
                            </div>
                            <div class="loading"></div>
                            <div class="clear"></div>
                            <p class="description"><?php echo stripslashes( wpuf_get_option( 'cat_help', 'wpuf_labels' ) ); ?></p>
                        </li>
                    <?php } ?>

                    <?php do_action( 'wpuf_add_post_form_description', $curpost->post_type, $curpost ); ?>
                    <?php wpuf_build_custom_field_form( 'description', true, $curpost->ID ); ?>

                    <li>
                        <label for="new-post-desc">
                            <?php echo wpuf_get_option( 'desc_label', 'wpuf_labels', 'Текст посту' ); ?> <span class="required">*</span>
                        </label>

                        <?php
                        $editor = 'full';
                            ?>
                            <div style="float:left;">
                                <?php wp_editor( $post->post_content, 'new-post-desc', array('textarea_name' => 'wpuf_post_content1', 'editor_class' => 'requiredField', 'teeny' => false, 'textarea_rows' => 8,), false); ?>
                            </div>
                    </li>

                    <?php do_action( 'wpuf_add_post_form_after_description', $curpost->post_type, $curpost ); ?>
                    <?php wpuf_build_custom_field_form( 'tag', true, $curpost->ID ); ?>

                    <?php if ( wpuf_get_option( 'allow_tags', 'wpuf_frontend_posting' ) == 'on' ) { ?>
                        <li>
                            <label for="new-post-tags">
                                <?php echo wpuf_get_option( 'tag_label', 'wpuf_labels', 'Tеги' ); ?>
                            </label><br/>
                            <input type="text" name="wpuf_post_tags1" id="new-post-tags" value="<?php echo $tagslist; ?>">
                            <p class="description"><?php echo stripslashes( wpuf_get_option( 'tag_help', 'wpuf_labels' ) ); ?></p>
                            <div class="clear"></div>
                        </li>
                    <?php } ?>

                    

                    <li>
                        <label>&nbsp;</label>
                        <input class="wpuf_submit" type="submit" name="wpuf_edit_post_submit1" value="<?php echo esc_attr( wpuf_get_option( 'update_label', 'wpuf_labels', 'Оновити пост' ) ); ?>">
                        <input type="hidden" name="wpuf_edit_post_submit" value="yes" />
                        <input type="hidden" name="post_id1" value="<?php echo $post->ID; ?>">
                    </li>
                </ul>
            </form>
        </div>