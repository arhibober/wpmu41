<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Blue River
 */

get_header();
	echo "<div id='primary' class='content-area left-column'>
		<main id='main' class='site-main' role='main'>";
		

		while ( have_posts() ) : the_post();

			get_template_part( 'content', 'single' );

			blue_river_post_nav();

			
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
			

		 endwhile; // end of the loop.
echo "</main>
	</div>
	<div id='secondary' class='widget-area' role='complementary'>";
 get_sidebar(); ?>
<?php //get_footer(); ?>
<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Blue River
 */
?>

	</div><!-- #content -->
	</div>

	<footer id="colophon" class="site-footer" role="contentinfo" style="position: relative; top: 50px;">
		<div class="site-info" style="text-align: center;">
			<?php do_action( 'blue_river_credits' ); ?>
			<a href="http://wordpress.org/" rel="generator"><?php printf( __( '2014', 'blue-river' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Дизайн:  <a href="mailto:arhibober@gmail.com" rel="designer">arhibober</a>' )); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>