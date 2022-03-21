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