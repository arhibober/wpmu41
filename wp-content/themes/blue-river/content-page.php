<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Blue River
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="z-index: 1000px important;">
	<header class="entry-header">
		<h1 class="entry-title" style="text-align: center; color: #004369"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content page-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'blue-river' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php edit_post_link( __( 'Редагувати', 'blue-river' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-## -->
