<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Blue River
 */

include "../../../wp-includes/template.php";
include "../../../wp-includes/plugin.php";
include "../../../wp-includes/general-template.php";
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
	
		global $switched;		
		global $wpdb;
		$table_prefix = $wpdb->base_prefix;
		$blog_list = get_blog_list( 0, 'all' ); 		
		$output = '';
		foreach ($blog_list as $blog)
		{
				        $sqlstr = " SELECT ".$blog['blog_id']." as blog_id, id, post_date_gmt from ".$table_prefix.$blog['blog_id']."_posts  where post_status = 'publish' and post_type = 'post' ORDER BY post_modified_gmt desc ";	
		$post_list = $wpdb->get_results($sqlstr, ARRAY_A);
		foreach ($post_list as $post) 
		{
			$txt = '<b style="font-size: 16px;">{title}</b>';
			
			
			$p = get_blog_post($post["blog_id"], $post["id"]);	
			
			$ex = $p->post_excerpt;
			if (!isset($ex) || trim($ex) == '')
				$ex = mb_substr(strip_tags($p->post_content), 0, 65) . '...';
			
			$txt = str_replace('{title}', '<a href="' .get_blog_permalink($post["blog_id"], $post["id"]).'">'.$p->post_title.'</a>' , $txt);
			$output .=  $txt."<br/>";
			}
			  }
		
		$output .=  $wpdb->print_error();	
	echo "<h2>Всі нові пости сайту<h2/>".
		$output;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php echo "div id='secondary' class='widget-area' role='complementary' style='position: relative; top: 0px;'>";
get_sidebar(); ?>
<?php get_footer(); ?>