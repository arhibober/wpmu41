<?php

/**
 * Add Post form class
 *
 * @author Tareq Hasan
 * @package WP User Frontend
 */
class WPUF_Add_Post {

    function __construct() {
        add_shortcode( 'wpuf_addpost', array($this, 'shortcode') );
    }

    /**
     * Handles the add post shortcode
     *
     * @param $atts
     */
    function shortcode( $atts ) {

        extract( shortcode_atts( array('post_type' => 'post'), $atts ) );

        ob_start();

        if ( is_user_logged_in() ) {
            $this->post_form( $post_type );
        } else {
            printf( __( "Доступ до цієї сторінки обмежен.", 'wpuf' ), wp_loginout( get_permalink(), false ) );
        }

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * Add posting main form
     *
     * @param $post_type
     */
    function post_form( $post_type ) {
		$is_submit = false;
        global $userdata;
        global $user_ID;

        $userdata = get_user_by( 'id', $userdata->ID );

        if ( isset( $_POST['wpuf_post_new_submit'] ) ) {
            $nonce = $_REQUEST['_wpnonce'];
            if ( !wp_verify_nonce( $nonce, 'wpuf-add-post' ) ) {
                wp_die( __( 'Cheating?' ) );
            }

            $this->submit_post();
			$is_submit = TRUE;
        }

        $info = __( "Піст додан успішно!", 'wpuf' );
        $can_post = 'yes';

        $info = apply_filters( 'wpuf_addpost_notice', $info );
        $can_post = apply_filters( 'wpuf_can_post', $can_post );
        $featured_image = wpuf_get_option( 'enable_featured_image', 'wpuf_frontend_posting', 'no' );

        $title = isset( $_POST['wpuf_post_title'] ) ? esc_attr( $_POST['wpuf_post_title'] ) : '';
        $description = isset( $_POST['wpuf_post_content'] ) ? $_POST['wpuf_post_content'] : '';

        if ( ($can_post == 'yes') && ($is_submit == false)) {
            ?>
            <div id="wpuf-post-area">
                <form id="wpuf_new_post_form" name="wpuf_new_post_form" action="" enctype="multipart/form-data" method="POST">
                    <?php wp_nonce_field( 'wpuf-add-post' ) ?>

                    <ul class="wpuf-post-form">

                        <?php do_action( 'wpuf_add_post_form_top', $post_type ); //plugin hook   ?>
                        <?php wpuf_build_custom_field_form( 'top' ); ?>

                        <?php //if ( $featured_image == 'yes' ) { ?>
                            <?php if ( current_theme_supports( 'post-thumbnails' ) ) { ?>
                                <li>
                                    <label for="post-thumbnail"><?php echo wpuf_get_option( 'ft_image_label', 'wpuf_frontend_posting', 'Аватар' ); ?></label>
                                    <div id="wpuf-ft-upload-container">
                                        <div id="wpuf-ft-upload-filelist"></div>
										<div>
<style>
.fileform { 
    background-color: #FFFFFF;
    border: 1px solid #CCCCCC;
    border-radius: 2px;
    cursor: pointer;
    height: 26px;
    overflow: hidden;
    position: relative;
    text-align: left;
    vertical-align: middle;
    width: 92px;
}
 
.fileform .selectbutton {
	padding: 5px !important;
    font-size: smaller !important;
    background-color: #3C96C9 !important;
    transition: #3A6EA5 0.3s ease-in-out 0s !important;
	color: #FFF !important;
	border: 0 !important;
	box-shadow: none !important;
	border-radius: 0 !important;
}
 
.fileform #upload{
    position:absolute; 
    top:0; 
    left:0; 
    width:100%; 
    -moz-opacity: 0; 
    filter: alpha(opacity=0); 
    opacity: 0; 
    font-size: 150px; 
    height: 30px; 
    z-index:20;
}
</style>

										<div class="fileform">
<div class="selectbutton" style="visibility: visible !important;">Завантажити</div>
                                        <input type='file' id='upload' name='avatar'></input>
										</div>
                                    </div>
                                    <div class="clear"></div>
                                </li>
                            <?php } else { ?>
                                <div class="info"><?php _e( 'Your theme doesn\'t support featured image', 'wpuf' ) ?></div>
                            <?php } ?>
                        <?php //} ?>

                        <li>
                            <label for="new-post-title">
                                <?php echo wpuf_get_option( 'title_label', 'wpuf_labels', 'Заголовок посту'  ); ?> <span class="required">*</span>
                            </label>
                            <input class="requiredField" type="text" value="<?php echo $title; ?>" name="wpuf_post_title" id="new-post-title" minlength="2">
                            <div class="clear"></div>
                            <p class="description"><?php echo stripslashes( wpuf_get_option( 'title_help', 'wpuf_labels' ) ); ?></p>
                        </li>

                        <?php if ( wpuf_get_option( 'allow_cats', 'wpuf_frontend_posting', 'on' ) == 'on' ) { ?>
                            <li>
                                <label for="new-post-cat">
                                    <?php echo wpuf_get_option( 'cat_label', 'wpuf_labels', 'Категорія' ); ?> <span class="required">*</span>
                                </label>

                                <div class="category-wrap" style="float:left;">
                                    <div id="lvl0">
                                        <?php
                                        $exclude = wpuf_get_option( 'exclude_cats', 'wpuf_frontend_posting' );
                                        $cat_type = wpuf_get_option( 'cat_type', 'wpuf_frontend_posting', 'normal' );
									echo "<select name='category'>
									<option id='6' selected>Щоденник</option>
									<option id='1'>Поезія</option>
									<option id='2'>Проза</option>
									<option id='3'>Живопис і фотографія</option>
									<option id='4'>Музика</option>
									<option id='5'>Відео</option>
									</select>";
                                        ?>
                                    </div>
                                </div>
                                <div class="loading"></div>
                                <div class="clear"></div>
                                <p class="description"><?php echo stripslashes( wpuf_get_option( 'cat_help', 'wpuf_labels' ) ); ?></p>
                            </li>
                        <?php } ?>

                        <?php do_action( 'wpuf_add_post_form_description', $post_type ); ?>
                        <?php wpuf_build_custom_field_form( 'description' ); ?>
						<li>
						<label>
							Завантажити фото
						</label>
						<input type="file" name="ill" id="ill"/><br/>
						</li>
                        <li>
                            <label for="new-post-desc">
                                <?php echo wpuf_get_option( 'desc_label', 'wpuf_labels', 'Текст посту' ); ?> <span class="required">*</span>
                            </label>

                            <?php
                            $editor = wpuf_get_option( 'editor_type', 'wpuf_frontend_posting' );
		global $wpdb;		
		$sqlstr = "SELECT max(ID) as max_id from wp_".$user_ID."_posts";		
		$max_id = $wpdb->get_results ($sqlstr, ARRAY_A);
                            
                                echo "<textarea name='wpuf_post_content' class='requiredField' id='new-post-desc' cols='60' rows='8' onClick='addPhoto (getCaret (this));'></textarea>
								<div id='dest'></div>";
			?>
			<script language="javascript">
			function addPhoto (caret)
			{
	var req = null;
	document.getElementById("dest").innerHTML = "Waiting...";
	
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();

	} else if (window.ActiveXObject) {
		try {
			req = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				req = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {
			}
		}
	}

	req.onreadystatechange = function() {
		if (req.readyState == 4) {
			if (req.status == 200) {
				document.getElementById("dest").innerHTML = req.responseText;
			} else {
				document.getElementById("dest").innerHTML = "Error: returned status code "
						+ req.status + " " + req.statusText;
			}
		}
	};
	var url = "http://localhost/wpmu41/addPhoto.php?caret=" + escape (caret);
	//alert ("Месяц: "+document.getElementById("m").value+", число: "+document.getElementById("n").value);
	req.open("GET", url, true);
	req.send(null);
}

  function getCaret(el)
  {
    if (el.selectionStart)
      return el.selectionStart;
    else
      if (document.selection)
      {
        el.focus();
        var r = document.selection.createRange();
        if (r == null)
          return 0;
        var re = el.createTextRange(),
        rc = re.duplicate();
        re.moveToBookmark(r.getBookmark());
        rc.setEndPoint('EndToStart', re);
        return rc.text.length;
      }
      return 0;
  }

			</script>

                            <div class="clear"></div>
                            <p class="description"><?php echo stripslashes( wpuf_get_option( 'desc_help', 'wpuf_labels' ) ); ?></p>
                        </li>

                        <?php
                        do_action( 'wpuf_add_post_form_after_description', $post_type );

                        $this->publish_date_form();
                        $this->expiry_date_form();

                        wpuf_build_custom_field_form( 'tag' );

                        if ( wpuf_get_option( 'allow_tags', 'wpuf_frontend_posting', 'on' ) == 'on' ) {
                            ?>
                            <?php
                        }

                        do_action( 'wpuf_add_post_form_tags', $post_type );
                        wpuf_build_custom_field_form( 'bottom' );
                        ?>

						<li>
                            <label>&nbsp;</label>
                            <input class="buttons" style="background-color: #3C96C9 !important; font-size: 12px !important; font-family: 'Berkshire Swash, comic',cursive !important;" type="submit" name="wpuf_new_post_submit" value="<?php echo esc_attr( wpuf_get_option( 'submit_label', 'wpuf_labels', 'Підтвердити' ) ); ?>">
                            <input type="hidden" name="wpuf_post_type" value="<?php echo $post_type; ?>" />
                            <input type="hidden" name="wpuf_post_new_submit" value="yes" />
                        </li>

                        <?php do_action( 'wpuf_add_post_form_bottom', $post_type ); ?>

                    </ul>
                </form>
            </div>
            <?php
        } else {
            echo '<div class="info">' . $info . '</div>';
        }
    }

    /**
     * Prints the post publish date on form
     *
     * @return bool|string
     */
    function publish_date_form() {
        $enable_date = wpuf_get_option( 'enable_post_date', 'wpuf_frontend_posting', 'off' );

        if ( $enable_date != 'on' ) {
            return;
        }

        $timezone_format = _x( 'Y-m-d G:i:s', 'timezone date format' );
        $month = date_i18n( 'm' );
        $month_array = array(
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'May',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Aug',
            '09' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec'
        );
        ?>
        <li>
            <label for="timestamp-wrap">
                <?php _e( 'Publish Time:', 'wpuf' ); ?> <span class="required">*</span>
            </label>
            <div class="timestamp-wrap">
                <select name="mm">
                    <?php
                    foreach ($month_array as $key => $val) {
                        $selected = ( $key == $month ) ? ' selected="selected"' : '';
                        echo '<option value="' . $key . '"' . $selected . '>' . $val . '</option>';
                    }
                    ?>
                </select>
                <input type="text" autocomplete="off" tabindex="4" maxlength="2" size="2" value="<?php echo date_i18n( 'd' ); ?>" name="jj">,
                <input type="text" autocomplete="off" tabindex="4" maxlength="4" size="4" value="<?php echo date_i18n( 'Y' ); ?>" name="aa">
                @ <input type="text" autocomplete="off" tabindex="4" maxlength="2" size="2" value="<?php echo date_i18n( 'G' ); ?>" name="hh">
                : <input type="text" autocomplete="off" tabindex="4" maxlength="2" size="2" value="<?php echo date_i18n( 'i' ); ?>" name="mn">
            </div>
            <div class="clear"></div>
            <p class="description"></p>
        </li>
        <?php
    }

    /**
     * Prints post expiration date on the form
     *
     * @return bool|string
     */
    function expiry_date_form() {
        $post_expiry = wpuf_get_option( 'enable_post_expiry', 'wpuf_frontend_posting' );

        if ( $post_expiry != 'on' ) {
            return;
        }
        ?>
        <li>
            <label for="timestamp-wrap">
                <?php _e( 'Expiration Time:', 'wpuf' ); ?><span class="required">*</span>
            </label>
            <select name="expiration-date">
                <?php
                for ($i = 1; $i <= 90; $i++) {
                    if ( $i % 2 != 0 ) {
                        continue;
                    }

                    printf( '<option value="%1$d">%1$d %2$s</option>', $i, __( 'days', 'wpuf' ) );
                }
                ?>
            </select>
            <div class="clear"></div>
            <p class="description"><?php _e( 'Post expiration time in day after publishing.', 'wpuf' ); ?></p>
        </li>
        <?php
    }

    /**
     * Validate the post submit data
     *
     * @global type $userdata
     * @param type $post_type
     */
    function submit_post() {
        global $userdata;

        $errors = array();

        //var_dump( $_POST );

        //if there is some attachement, validate them
        if ( !empty( $_FILES['wpuf_post_attachments'] ) ) {
            $errors = wpuf_check_upload();
        }

        $title = trim( $_POST['wpuf_post_title'] );
        $content = trim( $_POST['wpuf_post_content'] );

        $tags = '';
        if ( isset( $_POST['wpuf_post_tags'] ) ) {
            $tags = wpuf_clean_tags( $_POST['wpuf_post_tags'] );
        }

        //validate title
        if ( empty( $title ) ) {
            $errors[] = __( 'Empty post title', 'wpuf' );
        } else {
            $title = trim( strip_tags( $title ) );
        }

        //validate cat
        if ( wpuf_get_option( 'allow_cats', 'wpuf_frontend_posting', 'on' ) == 'on' ) {
            $cat_type = wpuf_get_option( 'cat_type', 'wpuf_frontend_posting', 'normal' );
            if ( !isset( $_POST['category'] ) ) {
                $errors[] = __( 'Please choose a category', 'wpuf' );
            } else if ( $cat_type == 'normal' && $_POST['category'][0] == '-1' ) {
                $errors[] = __( 'Please choose a category', 'wpuf' );
            } else {
                if ( count( $_POST['category'] ) < 1 ) {
                    $errors[] = __( 'Please choose a category', 'wpuf' );
                }
            }
        }

        //validate post content
        if ( empty( $content ) ) {
            $errors[] = __( 'Empty post content', 'wpuf' );
        } else {
            $content = trim( $content );$content1 [0] = $content;
		$content5 = "";
		for ($i = 0; $i < substr_count ($content, "youtu"); $i++)
			for ($i = 0; $i < substr_count ($content, "youtu"); $i++)
			if (strstr ($content1 [$i], "youtu"))
			{
				if (((strstr (strstr ($content1 [$i], "youtu"), " ")) && (strstr (strstr ($content1 [$i], "youtu"), "
")) && (stripos (strstr ($content1 [$i], "youtu"), " ") < stripos (strstr ($content1 [$i], "youtu"), "
"))) || ((strstr (strstr ($content1 [$i], "youtu"), " ")) && (!strstr (strstr ($content1 [$i], "youtu"), "
"))))
					$content2 = strstr (strstr ($content1 [$i], "youtu"), " ");
				if (((strstr (strstr ($content1 [$i], "youtu"), " ")) && (strstr (strstr ($content1 [$i], "youtu"), "
")) && (stripos (strstr ($content1 [$i], "youtu"), " ") > stripos (strstr ($content1 [$i], "youtu"), "
"))) || ((!strstr (strstr ($content1 [$i], "youtu"), " ")) && (strstr (strstr ($content1 [$i], "youtu"), "
"))))
					$content2 = strstr (strstr ($content1 [$i], "youtu"), "
");
				if ((!strstr (strstr ($content1 [$i], "youtu"), " ")) && (!strstr (strstr ($content1 [$i], "youtu"), "
")))				
					$content2 = "";
				if (((strstr (strstr ($content1 [$i], "youtu", true), " ")) && (strstr (strstr ($content1 [$i], "youtu", true), "
")) && (strrpos (strstr ($content1 [$i], "youtu", true), " ") > strrpos (strstr ($content1 [$i], "youtu", true), "
"))) || ((strstr (strstr ($content1 [$i], "youtu", true), " ")) && (!strstr (strstr ($content1 [$i], "youtu", true), "
"))))
				{
					$content3 = substr (strstr ($content1 [$i], "youtu", true), 0, strlen (strstr ($content1 [$i], "youtu", true)) - strlen (strrchr (strstr ($content1 [$i], "youtu", true), " ")))." ";					
					$content4 = strstr (strstr ($content1 [$i], "youtu"), " ", true);
				}
				if (((strstr (strstr ($content1 [$i], "youtu", true), " ")) && (strstr (strstr ($content1 [$i], "youtu", true), "
")) && (strrpos (strstr ($content1 [$i], "youtu", true), " ") < strrpos (strstr ($content1 [$i], "youtu", true), "
"))) || ((!strstr (strstr ($content1 [$i], "youtu", true), " ")) && (strstr (strstr ($content1 [$i], "youtu", true), "
"))))
				{
					$content3 = substr (strstr ($content1 [$i], "youtu", true), 0, strlen (strstr ($content1 [$i], "youtu", true)) - strlen (strrchr (strstr ($content1 [$i], "youtu", true), "
")))."
";					
					$content4 = strstr (strstr ($content1 [$i], "youtu"), "				
", true);
				}
				if ((!strstr (strstr ($content1 [$i], "youtu", true), " ")) && (!strstr (strstr ($content1 [$i], "youtu", true), "
")))
				{
					$content3 = "";
					$content4 = strstr ($content1 [$i], "youtu");
				}
				if (strstr ($content4, ".be/"))
					$adress = substr ($content4, 9, 11);
				if (strstr ($content4, "embed"))
					$adress = substr ($content4, 18, 11);
				if (strstr ($content4, "v="))
					$adress = substr ( strstr ($content4, "v="), 2, 11);
				$content1 [$i + 1] = $content2;
				$content5 = $content5.$content3."<iframe width='420' height='315' src='//www.youtube.com/embed/".$adress."' frameborder='0' allowfullscreen autoplay='0'></iframe>";
			}
		if (strstr ($content, "youtu"))
		{
			$content5 = $content5.$content2;
			$content = $content5;
		}
        }

        //process tags
        if ( !empty( $tags ) ) {
            $tags = explode( ',', $tags );
        }

        //post attachment
        $attach_id = isset( $_POST['wpuf_featured_img'] ) ? intval( $_POST['wpuf_featured_img'] ) : 0;

        //post type
        $post_type = trim( strip_tags( $_POST['wpuf_post_type'] ) );

        //process the custom fields
        $custom_fields = array();

        $fields = wpuf_get_custom_fields();
        if ( is_array( $fields ) ) {

            foreach ($fields as $cf) {
                if ( array_key_exists( $cf['field'], $_POST ) ) {

                    if ( is_array( $_POST[$cf['field']] ) ) {
                        $temp = implode(',', $_POST[$cf['field']]);
                    } else {
                        $temp = trim( strip_tags( $_POST[$cf['field']] ) );
                    }

                    //var_dump($temp, $cf);

                    if ( ( $cf['type'] == 'yes' ) && !$temp ) {
                        $errors[] = sprintf( __( '"%s" is missing', 'wpuf' ), $cf['label'] );
                    } else {
                        $custom_fields[$cf['field']] = $temp;
                    }
                } //array_key_exists
            } //foreach
        } //is_array

		$post_date_enable = wpuf_get_option( 'enable_post_date', 'wpuf_frontend_posting' );
        $post_expiry = wpuf_get_option( 'enable_post_expiry', 'wpuf_frontend_posting' );

        //check post date
        if ( $post_date_enable == 'on' ) {
            $month = $_POST['mm'];
            $day = $_POST['jj'];
            $year = $_POST['aa'];
            $hour = $_POST['hh'];
            $min = $_POST['mn'];

            if ( !checkdate( $month, $day, $year ) ) {
                $errors[] = __( 'Invalid date', 'wpuf' );
            }
        }

        $errors = apply_filters( 'wpuf_add_post_validation', $errors );


        //if not any errors, proceed
        if ( $errors ) {
            echo wpuf_error_msg( $errors );
            return;
        }

        $post_stat = wpuf_get_option( 'post_status', 'wpuf_frontend_posting' );
        $post_author = (wpuf_get_option( 'post_author', 'wpuf_frontend_posting' ) == 'original' ) ? $userdata->ID : wpuf_get_option( 'map_author', 'wpuf_frontend_posting' );

        //users are allowed to choose category
        if ( wpuf_get_option( 'allow_cats', 'wpuf_frontend_posting', 'on' ) == 'on' ) {                
			switch ($_POST ["category"])
			{
				case "Поезія":
					$post_category = 2;
					break;
				case "Проза":
					$post_category = 3;
					break;
				case "Живопис і фотографія":
					$post_category = 4;
					break;
				case "Музика":
					$post_category = 5;
					break;
				case "Відео":
					$post_category = 6;
					break;
				case "Щоденник":
					$post_category = 8;
					break;
			}
        } else {
            $post_category = array(wpuf_get_option( 'default_cat', 'wpuf_frontend_posting' ));
        }

            $month = $_POST ["mm"];
            $day = $_POST ["jj"];
            $year = $_POST ["aa"];
            $hour = $_POST ["hh"];
            $min = $_POST ["mn"];

            $post_date = mktime ($hour, $min, 59, $month, $day, $year);
            $my_post ["post_date"] = date ("Y-d-m H:i:s");

        //plugin API to extend the functionality
        
        //insert the post
		global $user_ID;
		global $wpdb;
		$sqlstr = "SELECT meta_value from wp_usermeta where meta_key='primary_blog' and user_id=".$user_ID;	
		$sites = $wpdb->get_results ($sqlstr, ARRAY_A);		
		$sqlstr = "SELECT path from wp_blogs where blog_id=".$sites [0]["meta_value"];	
		$path = $wpdb->get_results ($sqlstr, ARRAY_A);
		$sqlstr = "SELECT max(ID) as max_id from wp_".$sites [0]["meta_value"]."_posts";
		$max_id = $wpdb->get_results($sqlstr, ARRAY_A);
		/*$hdl1 = opendir ("photos");
    $content1 = "";
    while ($file = readdir ($hdl1))
    {
      $pf = strstr ($file, "b", true);
      $pf1 = strstr (substr ($file, strlen ($pf), strlen ($file) - strlen ($pf)), "c", true);
      if ((substr ($pf, 1, strlen ($pf) - 1) == $max_id [0]["max_id"] + 1) && (substr ($pf1, 1, strlen ($pf1) - 1) == $sites [0]["meta_value"]))
        $a [] = $file;
    }*/
    /*for ($i = 0; $i < sizeof ($a); $i++)
      $b [$i] = (integer)(substr (strstr ($a [$i], "c"), 1, strlen (strstr ($a [$i], "c")) - 1));
	  if (sizeof ($b) > 0)
			sort ($b);
        for ($i = 0; $i < sizeof ($b); $i++)
		{*/
	  //echo "hh";
	  if ($_FILES ["ill"]["name"] != "")
	  {
	    //echo "ii";
		if ($_FILES ["ill"]["size"] > 1048756)
        {
          echo "<p align='center'>Розмір фотографії перевищує один мегабайт</p>";
          exit;
        }
        // Проверяем загружен ли файл
        if (is_uploaded_file ($_FILES ["ill"]["tmp_name"]))
        {
          // Если файл загружен успешно, перемещаем его
          // из временной директории в конечную
          move_uploaded_file ($_FILES ["ill"]["tmp_name"],
            "D:/xampp/htdocs/wpmu41/PHOTO".$sites [0]["meta_value"]."_".($max_id [0]["max_id"] + 1).substr ($_FILES ["ill"]["name"],
            strlen ($_FILES ["ill"]["name"]) - 4, 4));
          echo "<p align='center'>Фотографія завантажена успішно.</p>";
        }	
        else
        {
          echo "<p align='center'>Помилка завантаження фотографії.</p>";
          exit;
        }
		$content1 = "";
		echo $_COOKIES ["cur_photo"];
		$content1 .= substr ($content, 0, file_get_contents ("cur_photo.txt"));
		$content1 .= "<p><img src = 'http://localhost/wpmu41/PHOTO".$sites [0]["meta_value"]."_".($max_id [0]["max_id"] + 1).substr ($_FILES ["ill"]["name"],
          strlen ($_FILES ["ill"]["name"]) - 4, 4)."'></p>";
		$content1 .= substr ($content, file_get_contents ("cur_photo.txt"), strlen ($content) - strlen (file_get_contents ("cur_photo.txt")));
		$content = $content1;
		unlink ("cur_photo.txt");
		}
		$wpdb->insert(
	"wp_".$sites [0]["meta_value"]."_posts",
	array ("ID" => ($max_id [0]["max_id"] + 1), 
            "post_title" => $title,  
            "post_name" => $title, 
            "post_content" => $content,
            "post_status" => "publish",
            "post_author" => $user_ID,
"post_date" => date ('Y-m-d H:i:s'),
"post_modified" => date ('Y-m-d H:i:s'),
"guid" => "http://localhost/wpmu41/".$sites [0]["meta_value"]."/?p=".($max_id [0]["max_id"] + 1)));
$wpdb->insert ("wp_".$user_ID."_term_relationships", array ("term_taxonomy_id"=>$post_category, "object_id"=>($max_id [0]["max_id"] + 1), "term_order"=>0));
if ($_FILES ["avatar"]["name"] != "")
{
if ($_FILES ["avatar"]["size"] > 1048756)
        {
          echo "<p align='center'>Розмір фотографії перевищує один мегабайт</p>";
          exit;
        }
        // Проверяем загружен ли файл
        if (is_uploaded_file($_FILES["avatar"]["tmp_name"]))
        {
          // Если файл загружен успешно, перемещаем его
          // из временной директории в конечную
          move_uploaded_file($_FILES["avatar"]["tmp_name"],
            "D:/xampp/htdocs/wpmu41/PHOTO".$user_ID."_".($max_id [0]["max_id"] + 1).substr ($_FILES ["avatar"]["name"],
            strlen ($_FILES ["avatar"]["name"]) - 4, 4));
          echo "<p align='center'>Фотографія завантажена успішно.</p>";
        }	
        else
        {
          echo "<p align='center'>Помилка завантаження фотографії.</p>";
          exit;
        } 
		};
	header ("Location: http://localhost".$path [0]["path"].substr (date ('Y-m-d H:i:s'), 0, 4)."/".substr (date ('Y-m-d H:i:s'), 5, 2)."/".substr (date ('Y-m-d H:i:s'), 8, 2)."/".$title);
    }

}

$wpuf_postform = new WPUF_Add_Post();