<?php
/**
 * @package Blue River
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="width: 100% !important; margin-bottom: 70px !important; owerflow: hidden !important; border: 0px !important;">	

	<header class="entry-header">

		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="post-date">
				<?php the_time('d.m') ?>
			</div><!-- .post-date -->
		<?php endif; ?>
		
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		
	<span class="cat-links">
					<?php
					global $blog_id;
					global $wpdb;
					$sqlstr = "SELECT name from wp_".$blog_id."_terms where term_id=(select term_taxonomy_id from wp_".$blog_id."_term_relationships where object_id=".($post->ID).")";	
					$category = $wpdb->get_results ($sqlstr, ARRAY_A);
					$categories_list = get_the_category_list( __( ', ', 'blue-river' ) );
					//if ( $categories_list && blue_river_categorized_blog() )
					if (strlen ($category [0]["name"]) > 0)
						printf( __( '%1$s', 'blue-river' ), $category [0]["name"] ); ?>
				</span>
		
	</header><!-- .entry-header -->
	
	<div class="thumb-container">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		<?php if ( has_post_thumbnail() ) {
			the_post_thumbnail();
				} ?></a>
	</div><!-- .thumb-container -->	

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-meta">
		<div class="meta-group" style="display: inline !important; padding: 0 !important;">
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
				<?php
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( __( ', ', 'blue-river' ) );
					if ( $categories_list && blue_river_categorized_blog() ) :
				?>
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
		$sqlstr = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$blog_id;		
		$photo_list = $wpdb->get_results($sqlstr, ARRAY_A);
		foreach ($photo_list as $post2)
			if ($post2 ["user_id"] == $user_ID)
				$own_post = true;
			if (($user_ID != 0) && ($blog_id != 1) && ($own_post))
				echo "<form action='http://localhost/wpmu31/додати-новий-пост' method='post' style='display: inline !important;'>
				<input type='hidden' name='edit_id' value='".$post->ID."'>
				<input type='hidden' name='blog_id' value='".$blog_id."'>
				<input type='hidden' name='cat' value='".get_the_category($post->ID)[0]->term_id."'>
				<input type='submit' value='Редагувати' class='buttons' style='height: 30px !important; font-size: 12px !important;'>
				</form>
				<form action='http://localhost/wpmu31/додати-новий-пост' method='post' style='display: inline !important;'>
				<input type='hidden' name='remove_id' value='".$post->ID."'>
				<input type='hidden' name='blog_id' value='".$blog_id."'>
				<input type='submit' value='Видалити' class='buttons' style='height: 30px !important; font-size: 12px !important;'>
				</form>";?>
		</div><!-- .meta-group -->
		<div class="read-more" style="height: 30px !important; margin-top: 0px !important;">
			<a href="<?php the_permalink(); ?>" style="height: 30px !important; margin-top: 0px !important;"><?php esc_html_e( 'Далі', 'blue-river' ); ?></a>
		</div>	
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
