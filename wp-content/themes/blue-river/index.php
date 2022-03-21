<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Blue River
 */

get_header();
global $blog_id;
global $user_ID;
$sqlstr = "SELECT path from wp_blogs where blog_id=".$blog_id;
$name = $wpdb->get_results ($sqlstr, ARRAY_A);
echo "<h1 style='position: relative; top: 0px; color: #ffffff; font-family: Berkshire Swash,cursive;'>".substr ($name [0]["path"], 8, strlen ($name [0]["path"]) - 9)."</h1>"; ?>

	<div id="primary" class="content-area left-column" style="position: relative; top: 3px;">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					global $post;
					global $blog_id;
				$sqlstr = "SELECT b.path, p.post_title, p.post_date, p.post_modified, p.post_name from wp_".$blog_id."_posts as p, wp_blogs as b where p.ID = ".($post->ID);	
		$post_list = $wpdb->get_results ($sqlstr, ARRAY_A);
					 if (strstr ($post->post_content, "nggallery"))
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
		
		echo "<h1 class='entry-title'><a href='http://localhost".$post_list [0]["path"].substr ($post_list [0]["post_date"], 0, 4)."/".substr ($post_list [0]["post_date"], 5, 2)."/".substr ($post_list [0]["post_date"], 8, 2)."/".$post_list [0]["post_name"]."' rel='bookmark'>".$post_list [0]["post_title"]."</a></h1>
		
	</header><!-- .entry-header -->
	<div class='thumb-container'>
		<a href='http://localhost".$post_list [0]["path"].substr ($post_list [0]["post_date"], 0, 4)."/".substr ($post_list [0]["post_date"], 5, 2)."/".substr ($post_list [0]["post_date"], 8, 2)."/".$post_list [0]["post_name"]."' title='".$post_list [0]["post_title"]."'>";
				get_post_thumbnail_id ($post->ID);
				echo "</a>
	</div><!-- .thumb-container -->	

	<div class='entry-summary' style='max-height: 600px !important; overflow: hidden !important;'>".the_content()."</div><!-- .entry-summary -->

	<footer class='entry-meta' style='positoion: relative; top: 50px;'>
		<div class='meta-group'>";
			if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search 
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( __( ', ', 'blue-river' ) );
					if ( $categories_list && blue_river_categorized_blog() ) :
				?>
				<span class="cat-links">
					<?php 
					printf( __( 'Належить категорії: %1$s', 'blue-river' ), $categories_list ); ?>
				</span>
				<?php endif; // End if categories ?>

				<?php
					/* translators: used between list items, there is a space after the comma */
					$tags_list = get_the_tag_list( '', __( ', ', 'blue-river' ) );
					if ( $tags_list ) :
				?>
				<span class="tags-links">
					<?php printf( __( 'Tagged %1$s', 'blue-river' ), $tags_list ); ?>
				</span>
				<?php endif; // End if $tags_list ?>
			<?php endif; // End if 'post' == get_post_type() ?>

			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="comments-link"><?php comments_popup_link( __( 'Залишити коментарій', 'blue-river' ), __( '1 Коментарій', 'blue-river' ), __( '% Коментаріїв', 'blue-river' ) ); ?></span>
			<?php endif; ?>

			<?php 
			
			global $post;
global $blog_id;
				
		global $switched;		
		global $wpdb;
		$blog_list = get_blog_list( 0, 'all' ); 		
		$output = '';
		$own_post = false;
		echo false;
		$sqlstr = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$blog_id;		
		$photo_list = $wpdb->get_results($sqlstr, ARRAY_A);
		foreach ($photo_list as $post2)
			if ($post2 ["user_id"] == $user_ID)
				$own_post = true;
			if (($user_ID != 0) && ($blog_id != 1) && ($own_post))
				echo "<a href='http://localhost/wpmu31/додати-новий-пост/?edit_id=".$post->ID."&blog_id=".$blog_id."&cat=".get_the_category($post->ID)[0]->term_id."'>Редагувати</a><br/>";?>
		</div><!-- .meta-group -->
		<div class="read-more">
			<a href="<?php the_permalink(); ?>"><?php esc_html_e( 'Далі', 'blue-river' ); ?></a>
		</div>	
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
</div></div>
<?php

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
	</div><!-- #primary -->

<?php echo "<div id='secondary' class='widget-area' role='complementary' style='position: relative; top: -42px;'>";
get_sidebar();
echo "</div>"; ?>
<?php get_footer(); ?>
