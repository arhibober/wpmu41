
<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Blue River
 */
?>
	
		<?php do_action( 'before_sidebar' );	
			global $blog_id;

	
		  
		  		    echo "<div class='login_box'>";

  global $user_ID, $user_identity, $user_level;

if ($user_ID == 0)
{

    echo "<form id='login' method='post' style='height: 226px;'>

      <p class='status_login'></p>

      <div class='line'>
        <i class='icon-user'></i>
        <input id='username' class='input_text' type='text' placeholder='Ваш логін' name='username' />
      </div>

      <div class='line'>
        <i class='icon-key'></i>
        <input id='password' class='input_text' type='password' placeholder='Ваш пароль' name='password' style='position: relative; top: 4px;'/>
      </div>

      <div class='line' style='display: none;'>
        <input name='rememberme' type='checkbox' id='my-rememberme' checked='checked' value='forever' />
      </div>

      <div class='line cf'>
        <input class='buttons' type='submit' value='Увійти' name='submit' style='position: relative; top: 30px; height: 30px;' /><br/><br/>
        <div class='login_link'>
          <a class='reg_link buttons' style='position: relative; top: 30px; height: 30px;' href='http://localhost/wpmu31/wp-signup.php'>Реестрація</a><br/><br/>
          <a class='buttons' style='position: relative; top: 32px; height: 30px;' href='http://localhost/wpmu31/wp-login.php?action=lostpassword'>Забули пароль?</a>
        </div>
      </div>";

      wp_nonce_field( 'ajax-login-nonce', 'security' );

    echo "</form>";
}
else
	echo "<div>
		<a href='".wp_logout_url( $_SERVER['REQUEST_URI'] )."'class='buttons'>Вийти з акаунту</a>
		</div>";

echo "</div><br/>";
			
		global $post;
		global $blog_id;				
		global $switched;		
		global $wpdb;
		$blog_list = get_blog_list( 0, 'all' ); 		
		$output = '';
		$own_post = false;
		$sqlstr = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$blog_id;		
		$posts2 = $wpdb->get_results($sqlstr, ARRAY_A);
		foreach ($posts2 as $post2)
			if ($post2 ["user_id"] == $user_ID)
				$own_post = true;
			if ($user_ID != 0)
			{			
				echo "<a href='http://localhost/wpmu31/додати-новий-пост/' style='margin-bottom: 250px !important;' class='buttons'>Додати новий пост</a><br/>
				<div style='position: relative !important; top: 25px !important;'>";
		}
?>
		<?php if ($blog_id != 1)
		{
			if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>
			<?php
		endif; // end sidebar widget area*/
		}
		else
		{
		echo "<aside id='search' class='widget widget_search'>";
				get_search_form();
		echo "</aside>";
		}
		if ($blog_id == 1)
		{
			echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=all_posts_abc&page1=0'><h2>Всі пости за алфавітом</h2></a>";
			global $switched;		
		global $wpdb;
		$table_prefix = $wpdb->base_prefix;
			
			$sqlstr = "SELECT blog_id, registered, last_updated from ".$table_prefix ."blogs where  public = 1	AND spam = 0 AND archived = '0' AND deleted = 0 AND blog_id != 1 ORDER BY registered desc";
		$blog_list_temp = $wpdb->get_results($sqlstr, ARRAY_A);
		echo $wpdb->print_error();
		$output = '';
			$blog_list = $blog_list_temp;
			
		$i = 0;
		foreach ($blog_list as $blog) {
		$i++;
			$txt = '<b>{title}</b>';			
			
			$title = '';$desc = '';$burl = '';$pcount = 0;$avatar = '';
			switch_to_blog($blog['blog_id']);					
				if (strpos($txt, '{title}') !== false || strpos($txt, '{title_txt}') !== false)
					$title = get_bloginfo('name');
				if (strpos($txt, '{description}') !== false)
					$desc = get_bloginfo('description');	
				$burl = get_bloginfo('url');
				if (strpos($txt, '{postcount}') !== false || (int)$min_post_count>0)
					$pcount = wp_count_posts()->publish;

				if (strpos($txt, '{avatar}') !== false)
					$avatar = get_avatar(get_bloginfo('admin_email'), $wgt_avsize);	
				
			restore_current_blog();
			
			
			
			if ((int)$min_post_count<=$pcount) {
			
				$output .=  $before_item;
				//@TODO add trailing shash only if in subdir mode 
				$txt = str_replace('{title}', '<a href="' . $burl .'/">'. $title .'</a><br/>' , $txt);
				$txt = str_replace('{more}', '<a href="' . $burl .'/">'.$wgt_mtext.'</a><br/>' , $txt);
				$txt = str_replace('{title_txt}', $title , $txt);
				$txt = str_replace('{reg}', date_i18n($wgt_dt, strtotime($blog['registered'])), $txt);
				$txt = str_replace('{last_update}', date_i18n($wgt_dt, strtotime($blog['last_updated'])), $txt);
				$txt = str_replace('{description}', $desc, $txt);
				$txt = str_replace('{postcount}', $pcount , $txt);
				$txt = str_replace('{comment_count}', $blog['comment_count'] , $txt);
				$txt = str_replace('{avatar}', $avatar , $txt);
				
				$output .=  $txt;
				if ($i > 4)
					break;
			}
		}
		
		$output .=  $wpdb->print_error();
		echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=all_blogs&page1=0'><h2>Нові блоги</h2></a>".$output;	
		global $switched;		
		global $wpdb;
		$table_prefix = $wpdb->base_prefix;
		$blog_list = get_blog_list( 0, 'all' ); 		
		$output = ''; 		
		$sqlstr = '';
		$i = 0;		
		$j = 0;
		foreach ($blog_list as $blog)
		{
			if ($blog['blog_id'] != 1)
			{
			if ($j > 0)
				$sqlstr .= " union ";
				$sqlstr .= "SELECT b.blog_id, p.id, p.post_date_gmt, p.post_modified from wp_".$blog['blog_id']."_posts as p, wp_blogs as b where p.post_status = 'publish' and p.post_type = 'post' and b.blog_id=".$blog['blog_id'];
			$j++;
			}			
		}
		$sqlstr.= " ORDER BY post_modified desc ";
		
		$post_list = $wpdb->get_results($sqlstr, ARRAY_A);
		foreach ($post_list as $post1) 
		{
			$txt = '<b style="font-size: 16px; color: #00cccc !important;">{title}</b>';
			$p = get_blog_post($post1['blog_id'], $post1["id"]);	
			
			$ex = $p->post_excerpt;
			if (!isset($ex) || trim($ex) == '')
				$ex = mb_substr(strip_tags($p->post_content), 0, 65) . '...';
			
			$txt = str_replace('{title}', '<a href="' .get_blog_permalink($post1['blog_id'], $post1["id"]).'">'.$p->post_title.'</a>' , $txt);
			$output .=  $txt."<br/>";
			$i++;
			if ($i > 4)
				break;
		}
		
		$output .=  $wpdb->print_error();
			echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=all_posts&page1=0'><h2>Нові пости</h2></a>".$output;
				
		global $wpdb;
		$table_prefix = $wpdb->base_prefix;
			
			$j = 0;
		$blog_list = get_blog_list (0, "all");
		$sqlstr1 = "";
		foreach ($blog_list as $blog)
		{
			if ($blog ['blog_id'] != 1)
			{
			if ($j > 0)
				$sqlstr1 .= " union ";
				$sqlstr1 .= "SELECT p.post_date from wp_".$blog ["blog_id"]."_posts as p, wp_blogs as b where p.post_status = 'publish' and p.post_type = 'post' and b.blog_id=".$blog ["blog_id"];
			$j++;
			}			
		}		
		$sqlstr1.= " ORDER BY post_date desc ";
		$month_list = $wpdb->get_results ($sqlstr1, ARRAY_A);
		echo "<h2>Загальний архів мережі</h2>";
		switch (substr ($month_list [0]["post_date"], 5, 2))
		{
			case "01":
				echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [0]["post_date"], 0, 4)."&month=".substr ($month_list [0]["post_date"], 5, 2)."&page1=0'Січень ".substr ($month_list [0]["post_date"], 0, 4)."</a><br/>";
				break;
			case "02":
				echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [0]["post_date"], 0, 4)."&month=".substr ($month_list [0]["post_date"], 5, 2)."&page1=0'>Лютий ".substr ($month_list [0]["post_date"], 0, 4)."</a><br/>";
				break;
			case "03":
				echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [0][$post_date], 0, 4)."&month=".substr ($month_list [0]["post_date"], 5, 2)."&page1=0'>Березень ".substr ($month_list [0]["post_date"], 0, 4)."</a><br/>";
				break;
			case "04":
				echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [0]["post_date"], 0, 4)."&month=".substr ($month_list [0]["post_date"], 5, 2)."&page1=0'>Квітень ".substr ($month_list [0]["post_date"], 0, 4)."</a><br/>";
				break;
			case "05":
				echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [0]["post_date"], 0, 4)."&month=".substr ($month_list [0]["post_date"], 5, 2)."&page1=0'>Травень ".substr ($month_list [0]["post_date"], 0, 4)."</a><br/>";
				break;
			case "06":
				echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [0]["post_date"], 0, 4)."&month=".substr ($month_list [0]["post_date"], 5, 2)."&page1=0'>Червень ".substr ($month_list [0]["post_date"], 0, 4)."</a><br/>";
				break;
			case "07":
				echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [0]["post_date"], 0, 4)."&month=".substr ($month_list [0]["post_date"], 5, 2)."&page1=0'>Липень ".substr ($month_list [0]["post_date"], 0, 4)."</a><br/>";
				break;
			case "08":
				echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [0]["post_date"], 0, 4)."&month=".substr ($month_list [0]["post_date"], 5, 2)."&page1=0'>Серпень ".substr ($month_list [0]["post_date"], 0, 4)."</a><br/>";
				break;
			case "09":
				echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [0]["post_date"], 0, 4)."&month=".substr ($month_list [0]["post_date"], 5, 2)."&page1=0'>Вересень ".substr ($month_list [0]["post_date"], 0, 4)."</a><br/>";
				break;
			case "10":
				echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [0]["post_date"], 0, 4)."&month=".substr ($month_list [0]["post_date"], 5, 2)."&page1=0'>Жовтень ".substr ($month_list [0]["post_date"], 0, 4)."</a><br/>";
				break;
			case "11":
				echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [0]["post_date"], 0, 4)."&month=".substr ($month_list [0]["post_date"], 5, 2)."&page1=0'>Листопад ".substr ($month_list [0]["post_date"], 0, 4)."</a><br/>";
				break;
			case "12":
				echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [0]["post_date"], 0, 4)."&month=".substr ($month_list [0]["post_date"], 5, 2)."&page1=0'>Грудень ".substr ($month_list [0]["post_date"], 0, 4)."</a><br/>";
				break;
		}
		for ($i = 1; $i < count ($month_list); $i++)
		{
		
			if ((substr ($month_list [$i]["post_date"], 5, 2) != substr ($month_list [$i - 1]["post_date"], 5, 2)) || (substr ($month_list [$i]["post_date"], 0, 4) != substr ($month_list [$i - 1]["post_date"], 0, 4)))			
			switch (substr ($month_list [$i]["post_date"], 5, 2))
			{
				case "01":
					echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [$i]["post_date"], 0, 4)."&month=".substr ($month_list [$i]["post_date"], 5, 2)."&page1=0'>Січень ".substr ($month_list [$i]["post_date"], 0, 4)."</a><br/>";
					break;
				case "02":
					echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [0]["post_date"], 0, 4)."&month=".substr ($month_list [$i]["post_date"], 5, 2)."&page1=0'>Лютий ".substr ($month_list [$i]["post_date"], 0, 4)."</a><br/>";
					break;
				case "03":
					echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [$i]["post_date"], 0, 4)."&month=".substr ($month_list [$i]["post_date"], 5, 2)."&page1=0'>Березень ".substr ($month_list [$i]["post_date"], 0, 4)."</a><br/>";
					break;
				case "04":
					echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [$i]["post_date"], 0, 4)."&month=".substr ($month_list [$i]["post_date"], 5, 2)."&page1=0'>Квітень ".substr ($month_list [$i]["post_date"], 0, 4)."</a><br/>";
					break;
				case "05":
					echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [$i]["post_date"], 0, 4)."&month=".substr ($month_list [$i]["post_date"], 5, 2)."&page1=0'>Травень ".substr ($month_list [$i]["post_date"], 0, 4)."</a><br/>";
					break;
				case "06":
					echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [$i]["post_date"], 0, 4)."&month=".substr ($month_list [$i]["post_date"], 5, 2)."&page1=0'>Червень ".substr ($month_list [$i]["post_date"], 0, 4)."</a><br/>";
					break;
				case "07":
					echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [$i]["post_date"], 0, 4)."&month=".substr ($month_list [$i]["post_date"], 5, 2)."&page1=0'>Липень ".substr ($month_list [$i]["post_date"], 0, 4)."</a><br/>";
					break;
				case "08":
					echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [$i]["post_date"], 0, 4)."&month=".substr ($month_list [$i]["post_date"], 5, 2)."&page1=0'>Серпень ".substr ($month_list [$i]["post_date"], 0, 4)."</a><br/>";
					break;
				case "09":
					echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [$i]["post_date"], 0, 4)."&month=".substr ($month_list [$i]["post_date"], 5, 2)."'&page1=0>Вересень ".substr ($month_list [$i]["post_date"], 0, 4)."</a><br/>";
					break;
				case "10":
					echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [$i]["post_date"], 0, 4)."&month=".substr ($month_list [$i]["post_date"], 5, 2)."&page1=0'>Жовтень ".substr ($month_list [$i]["post_date"], 0, 4)."</a><br/>";
					break;
				case "11":
					echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [$i]["post_date"], 0, 4)."&month=".substr ($month_list [$i]["post_date"], 5, 2)."&page1=0'>Листопад ".substr ($month_list [$i]["post_date"], 0, 4)."</a><br/>";
					break;
				case "12":
					echo "<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_archive&year=".substr ($month_list [$i]["post_date"], 0, 4)."&month=".substr ($month_list [$i]["post_date"], 5, 2)."&page1=0'>Грудень ".substr ($month_list [$i]["post_date"], 0, 4)."</a><br/>";
					break;
			}
		}
		echo "<h2>Жанри постів мережі</h2>
		<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_category&category=8&page1=0'>Щоденник</a><br/>
		<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_category&category=2&page1=0'>Поезія</a><br/>
		<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_category&category=3&page1=0'>Проза</a><br/>
		<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_category&category=4&page1=0'>Живопис і фотографія</a><br/>
		<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_category&category=5&page1=0'>Музика</a><br/>
		<a href='http://localhost/wpmu31/додати-новий-пост/?type=general_category&category=6&page1=0'>Відео</a>";
	}
	else
	{
		global $wpdb;
		global $blog_id;
		$sqlstr = "SELECT user_id from wp_usermeta where meta_key='primary_blog' and meta_value=".$blog_id;		
		$users = $wpdb->get_results($sqlstr, ARRAY_A);
		echo "<a href='http://localhost/wpmu31/додати-новий-пост?type=profile&user=".$users [0]["user_id"]."'>Про автора блогу</a>";
		}
		if ($user_ID != 0)
			{			
				echo "</div><div style='heigth: 25px'>&nbsp;</div>";
		}