<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Blue River
 */

get_header();
 ?>
 <header>
				<h1 style="position: relative; top: 0px; color: #ffffff; font-family: Berkshire Swash,cursive;">
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							printf( __( 'Автор: %s', 'blue-river' ), '<span class="vcard">' . get_the_author() . '</span>' );

						elseif ( is_day() ) :
							printf( __( 'День: %s', 'blue-river' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
						{
							if (strstr ($_SERVER ["REQUEST_URI"], "/page/"))
							{
							switch (substr (strstr ($_SERVER ["REQUEST_URI"], "/page/", true), strlen (strstr ($_SERVER ["REQUEST_URI"], "/page". true)) - 2, 2))
							{
								case "01" :
									$month = "Січень";
									break;
								case "02" :
									$month = "Лютий";
									break;
								case "03" :
									$month = "Березень";
									break;
								case "04" :
									$month = "Квітень";
									break;
								case "05" :
									$month = "Травень";
									break;
								case "06" :
									$month = "Червень";
									break;
								case "07" :
									$month = "Липень";
									break;
								case "08" :
									$month = "Серпень";
									break;
								case "09" :
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
							$year = substr (strstr ($_SERVER ["REQUEST_URI"], "/page/", true), strlen (strstr ($_SERVER ["REQUEST_URI"], "/page". true)) - 7, 4);
							}
							else
							{
							switch (substr ($_SERVER ["REQUEST_URI"], strlen ($_SERVER ["REQUEST_URI"]) - 3, 2))
							{
								case "01" :
									$month = "Січень";
									break;
								case "02" :
									$month = "Лютий";
									break;
								case "03" :
									$month = "Березень";
									break;
								case "04" :
									$month = "Квітень";
									break;
								case "05" :
									$month = "Травень";
									break;
								case "06" :
									$month = "Червень";
									break;
								case "07" :
									$month = "Липень";
									break;
								case "08" :
									$month = "Серпень";
									break;
								case "09" :
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
							$year = substr ($_SERVER ["REQUEST_URI"], strlen ($_SERVER ["REQUEST_URI"]) - 8, 4);
							}
							echo "Місяць: ".$month." ".$year;
							}

						elseif ( is_year() ) :
							printf( __( 'Рік: %s', 'blue-river' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'blue-river' ) ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'blue-river' );

						elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
							_e( 'Galleries', 'blue-river');

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'blue-river');

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'blue-river' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'blue-river' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'blue-river' );

						elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
							_e( 'Statuses', 'blue-river' );

						elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
							_e( 'Audios', 'blue-river' );

						elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
							_e( 'Chats', 'blue-river' );

						else :
							_e( 'Archives', 'blue-river' );

						endif;
					?>
				</h1>
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
			if (is_category())
				echo "</header><!-- .page-header -->

	<section id='primary' class='content-area left-column' style='position: relative; top: -67px;'>
		<main id=main' class='site-main' role='main'>";
			else
				echo "</header><!-- .page-header -->

	<section id='primary' class='content-area left-column' style='position: relative; top: 3px;'>
		<main id=main' class='site-main' role='main'>";

		if ( have_posts() ) : ?>

			

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */global $post;
					global $blog_id;
				$sqlstr = "SELECT b.path, p.post_content, p.post_title, p.post_date, p.post_modified, p.post_name from wp_".$blog_id."_posts as p, wp_blogs as b where p.ID = ".($post->ID)." and b.blog_id=".$blog_id;	
		$post_list = $wpdb->get_results ($sqlstr, ARRAY_A);
		
	$sqlstr = "select term_id, slug, name from wp_".$post_list [0]["blog_id"]."_terms where term_id=(select term_taxonomy_id from wp_".$post_list [0]["blog_id"]."_term_relationships where object_id=".$post_list [0]["id"].")";
		$cat_list = $wpdb->get_results ($sqlstr, ARRAY_A);
					 if ((strstr ($post->post_content, "nggallery")) || (is_category()))
					 {
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
	background-color: #004369 !important;'>".
	substr ($post_list [0]["post_modified"], 8, 2).".".substr ($post_list [0]["post_modified"], 5, 2).
	"</div><div style='background-color: #ffffff;'>
					
					<article id='post-".$post->ID."' >	

	<header class='entry-header'>";
		
		echo "<h1 class='entry-title'><a href='http://localhost".$post_list [0]["path"].substr ($post_list [0]["post_date"], 0, 4)."/".substr ($post_list [0]["post_date"], 5, 2)."/".substr ($post_list [0]["post_date"], 8, 2)."/".$post_list [0]["post_name"]."' rel='bookmark'>".$post_list [0]["post_title"]."</a></h1>";
	if (!is_category())
		echo "<span class='cat-links'>
		<a href='http://localhost".$post_list [0]["path"]."/category/".$cat_list [0]["slug"]."/' title='".$cat_list [0]["name"]."'>".$cat_list [0]["name"]."</a>
		</span>";		
	echo "</header><!-- .entry-header -->
	<div class='thumb-container'>
		<a href='http://localhost".$post_list [0]["path"].substr ($post_list [0]["post_date"], 0, 4)."/".substr ($post_list [0]["post_date"], 5, 2)."/".substr ($post_list [0]["post_date"], 8, 2)."/".$post_list [0]["post_name"]."' title='".$post_list [0]["post_title"]."'>";
				get_post_thumbnail_id ($post->ID)."</a>";
	
				if (strstr ($post_list [0]["post_content"], "nggallery"))
				{
	$cont = $post_list [0]["post_content"];
	$cont1 = "";
	while (strstr ($cont, "nggallery"))
	{
		$cont = strstr ($cont, "[nggallery");
		global $wpdb;
		$sqlstr = "SELECT name from wp_".$blog_id."_ngg_gallery where gid=".substr (strstr ($cont, "]", true), 14, strlen (strstr ($cont, "]", true)) - 14);
		$gal_name = $wpdb->get_results ($sqlstr, ARRAY_A);
		$cont = substr (strstr ($cont, "]"), 1, strlen (strstr ($cont, "]")) - 1);
		$cont1 .= "<div style='display: inline !important;'>";
		$hdl1 = opendir ("../wpmu31/wp-content/uploads/sites/".$blog_id."/nggallery/".$gal_name [0]["name"]."/thumbs");
		while ($f = readdir ($hdl1))
		if (!strstr ($f, "_backup") && ($f != ".") && ($f != ".."))
			$cont1 .= "<span style='width: 100px !important;'><img src='http://localhost/wpmu31/wp-content/uploads/sites/".$blog_id."/nggallery/".$gal_name [0]["name"]."/thumbs/".$f."'></span>";
		$cont1 .= "</div>";
	}
	$cont1 .= $cont;
	echo "</a>
	</div><!-- .thumb-container -->	

	<div class='entry-summary' style='max-height: 600px !important; overflow: hidden !important;'>".$cont1."</div>";
		}
		else

				echo "</a>
	</div><!-- .thumb-container -->	

	<div class='entry-summary' style='max-height: 600px !important; overflow: hidden !important;'>".$post_list [0]["post_content"]."</div><!-- .entry-summary -->";
	echo "<footer class='entry-meta'>
	<div style='padding: 0 !important;'>
			<span class='comments-link' style='font-size: 12px;'><a href='http://localhost".$post_list [0]["path"].substr ($post_list [0]["post_date"], 0, 4)."/".substr ($post_list [0]["post_date"], 5, 2)."/".substr ($post_list [0]["post_date"], 8, 2)."/".$post_list [0]["post_name"]."/#respond'>";
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
		$sqlstr = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$blog_id;		
		$photo_list = $wpdb->get_results ($sqlstr, ARRAY_A);
		foreach ($photo_list as $post2)
		{
			if ($post2 ["user_id"] == $user_ID)
				$own_post = true;
			if (($user_ID != 0) && ($blog_id != 1) && ($own_post))
				echo "<form action='http://localhost/wpmu31/додати-новий-пост' method='post' style='display: inline !important;'>
				<input type='hidden' name='edit_id' value='".$post->ID."'/>
				<input type='hidden' name='blog_id' value='".$blog_id."'/>
				<input type='hidden' name='cat' value='".$cat_list [0]["term_id"]."'/>
				<input type='submit' value='Редагувати' class='buttons' style='height: 30px !important; font-size: 12px !important;'/>
				</form>
				<form action='http://localhost/wpmu31/додати-новий-пост' method='post' style='display: inline !important;'>
				<input type='hidden' name='remove_id' value='".$post->ID."'/>
				<input type='hidden' name='blog_id' value='".$blog_id."'/>
				<input type='submit' value='Видалити' class='buttons' style='height: 30px !important; font-size: 12px !important;'/>
				</form>";
				}

		echo "<div class='read-more' style='height: 30px !important; margin: 0px !important; float: right !important;'>
			<a href='http://localhost".$post_list [0]["path"].substr ($post_list [0]["post_date"], 0, 4)."/".substr ($post_list [0]["post_date"], 5, 2)."/".substr ($post_list [0]["post_date"], 8, 2)."/".$post_list [0]["post_name"]."'>Далі</a>
		</div>
		</div>
	</footer><!-- .entry-meta -->
</article>";
		if (strstr($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
		echo "<div style='height: 71px !important; background: #17769b !important;'></div>";
					 }
					else
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php blue_river_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php echo "<div id='secondary' class='widget-area' style='position: relative; top: -42px;'>";
get_sidebar(); ?>
</div>
<?php get_footer(); ?>
