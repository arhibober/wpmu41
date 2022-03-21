<?php
/**
 * Confirms that the activation key that is sent in an email after a user signs
 * up for a new blog matches the key for that user and then displays confirmation.
 *
 * @package WordPress
 */

define( 'WP_INSTALLING', true );

/** Sets up the WordPress Environment. */
require( dirname(__FILE__) . '/wp-load.php' );

require( dirname( __FILE__ ) . '/wp-blog-header.php' );

if ( !is_multisite() ) {
	wp_redirect( site_url( '/wp-login.php?action=register' ) );
	die();
}

if ( is_object( $wp_object_cache ) )
	$wp_object_cache->cache_enabled = false;

// Fix for page title
$wp_query->is_404 = false;

/**
 * Fires before the Site Activation page is loaded.
 *
 * @since 3.0
 */
do_action( 'activate_header' );

/**
 * Adds an action hook specific to this page that fires on wp_head
 *
 * @since MU
 */
function do_activate_header() {
    /**
     * Fires before the Site Activation page is loaded, but on the wp_head action.
     *
     * @since 3.0
     */
    do_action( 'activate_wp_head' );
}
add_action( 'wp_head', 'do_activate_header' );

/**
 * Loads styles specific to this page.
 *
 * @since MU
 */
function wpmu_activate_stylesheet() {
	?>
	<style type="text/css">
		form { margin-top: 2em; }
		#submit, #key { width: 90%; font-size: 24px; }
		#language { margin-top: .5em; }
		.error { background: #f66; }
		span.h3 { padding: 0 8px; font-size: 1.3em; font-family: "Lucida Grande", Verdana, Arial, "Bitstream Vera Sans", sans-serif; font-weight: bold; color: #333; }
	</style>
	<?php
}
add_action( 'wp_head', 'wpmu_activate_stylesheet' );

get_header();
?>

<div id="content" class="widecolumn">
	<?php if ( empty($_GET['key']) && empty($_POST['key']) ) { ?>

		<h2><?php _e('Activation Key Required') ?></h2>
		<form name="activateform" id="activateform" method="post" action="<?php echo network_site_url('wp-activate.php'); ?>">
			<p>
			    <label for="key"><?php _e('Activation Key:') ?></label>
			    <br /><input type="text" name="key" id="key" value="" size="50" />
			</p>
			<p class="submit">
			    <input id="submit" type="submit" name="Submit" class="submit" value="<?php esc_attr_e('Activate') ?>" />
			</p>
		</form>

	<?php } else {

		$key = !empty($_GET['key']) ? $_GET['key'] : $_POST['key'];
		$result = wpmu_activate_signup($key);
		if ( is_wp_error($result) ) {
			if ( 'already_active' == $result->get_error_code() || 'blog_taken' == $result->get_error_code() ) {
			    $signup = $result->get_error_data();
				?>
				<h2>Ви вже запросили активацію!</h2>
				<?php
				echo '<p class="lead-in">
				У меті безпечності на цій сторінці Вам надається право побачити свій новий пароль тільки один раз. Якщо Ви тоді його не записали, вкористуйтесь, будь ласка, стандартинм сервісом для відновленя паролю.
				</p>';
			} else {
				?>
				<h2><?php _e('An error occurred during the activation'); ?></h2>
				<?php
			    echo '<p>'.$result->get_error_message().'</p>';
			}
		} else {
			extract($result);
			$url = get_blogaddress_by_id( (int) $blog_id);
			$user = get_userdata( (int) $user_id);
			?>
			<h2><?php _e('Вітаємо Вас, Ваш сайт вже актівен!'); ?></h2>

			<div id="signup-welcome">
				<p><span class="h3"><?php _e('Логін:'); ?></span> <?php echo $user->user_login ?></p>
				<p><span class="h3"><?php _e('Пароль:'); ?></span> <?php echo $password; ?></p>
			</div>

			<?php if ( $url != network_home_url('', 'http') ) : ?>
				<p class="view"><?php printf( __('Ви можете <a href="%1$s" style="color: #3C96C9">перейти до стрічки свого блогу</a>'), $url, $url . 'wp-login.php' ); ?></p>
			<?php else: ?>
				<p class="view"><?php printf( __('Ви можете <a href="%1$s">зайти на сайт</a> чи <a href="%2$s">перейти до свого профайлу</a>.' ), network_site_url('wp-login.php', 'login'), network_home_url() ); ?></p>
			<?php endif;
		}
	}
	?>
</div>
<script type="text/javascript">
	var key_input = document.getElementById('key');
	key_input && key_input.focus();
</script>
<?php get_footer(); ?>
