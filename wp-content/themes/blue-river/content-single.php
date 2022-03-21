<?php
/**
 * @package Blue River
 */
?>

<div class="single-post">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<div class="entry-meta">
			<?php 
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'blue-river' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'blue-river' ) );

			if (blue_river_categorized_blog() )
					$meta_text = __( ' %1$s', 'blue-river' );
					// end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink()
			); ?>
		<?php
		?>

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
				<input type='hidden' name='cat' value='".get_the_category ($post->ID)[0]->term_id."'>
				<input type='submit' value='Редагувати' class='buttons' style='height: 30px !important; font-size: 12px !important;'>
				</form>
				<form action='http://localhost/wpmu31/додати-новий-пост' method='post' style='display: inline !important;'>
				<input type='hidden' name='remove_id' value='".$post->ID."'>
				<input type='hidden' name='blog_id' value='".$blog_id."'>
				<input type='submit' value='Видалити' class='buttons' style='height: 30px !important; font-size: 12px !important;'>
				</form>";
		echo "</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class='entry-content'>";
		global $user_ID;
		global $post;
		$dirct = "../wpmu31";
        $hdl = opendir($dirct);
        while ($file = readdir ($hdl)) 
          if (strstr ($file, "PHOTO".$user_ID."_".$post->ID.".") == true)
			echo "<img src = 'http://localhost/wpmu31/".$file."' style='width: 200px;'/>";

		the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'blue-river' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

<div class="entry-meta">

<?php
	blue_river_posted_on();
?>
</div>
</article><!-- #post-## -->

</div><!-- .single-post 
