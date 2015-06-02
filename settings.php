<?php

/*
=====================================================================================================
 # Custom POST FIELDS SETUP TO HIDE THE TITLE OF THE PAGES IN SINGULAR POSTS IF CHECKED
======================================================================================================
*/

if (!class_exists('wp_login_logout_pages')) {

	class wp_login_logout_pages {

	public function __construct() {
		add_action('add_meta_boxes', array($this, 'wp_login_logout_pages_init'));
      	add_action('save_post', array($this, 'wp_login_logout_pages_save'));
      	add_action( 'init', array( $this, 'wp_login_logout_pages_option_implement' ));


	}

    public function wp_login_logout_pages_init() {
      add_meta_box( 
        'Protection Options',
        'Protection Option',
        array($this, 'wp_login_logout_pages_box'),
        'page',
        'side',
        'high'
      );
    }

    public function wp_login_logout_pages_box() {
    	global $post;  	
    	function check_option_checked($data) {
    		global $post;
    		$checked = get_post_meta($post->ID, 'wp_login_logout_pages_option', true);
    		if ($checked == $data) {
    			return 'checked';
    		}
    	}
    	
    	echo '
    		 <input type="radio" name="wp_login_logout_pages_option" value = "1" class="widefat" '.check_option_checked(1).'/>
    		 <label><strong>Enable For Logged in Users Only</strong></label><hr/>
    		 <input type="radio" name="wp_login_logout_pages_option" value = "2" class="widefat" '.check_option_checked(2).'/>
    		 <label><strong>Enable For Public</strong></label><hr/><p></p>
             <label><strong>Redirect Login Url</strong></label>
             <input type="url" name="wp_login_logout_pages_redirect" value="'. get_post_meta($post->ID, 'wp_login_logout_pages_redirect',true).'" class="widefat" />
             
    		';
    }

    public function wp_login_logout_pages_save($post_id) {
    	update_post_meta($post_id, 'wp_login_logout_pages_option', $_POST['wp_login_logout_pages_option']);
        update_post_meta($post_id, 'wp_login_logout_pages_redirect', esc_url($_POST['wp_login_logout_pages_redirect']));
    }

    public function wp_login_logout_pages_option_implement() {
        global $post;
        
        $checked = get_post_meta($post->ID, 'wp_login_logout_pages_option', true);

        if ($checked == 2) {

    	}
    	else {
    	
    	add_action( 'wp_head', array( $this, 'wp_login_logout_pages_check' ),3000);

    	}
        
        
    }

    public function wp_login_logout_pages_check() {
    	global $post;
        $post_id = $POST->ID;

    	if ( is_user_logged_in() ) {
 
    	}
    	else {
            $checked = get_post_meta($post->ID, 'wp_login_logout_pages_option', true);
            $redirect_url = get_post_meta($post->ID, 'wp_login_logout_pages_redirect', true);
            if ($checked == 1) {
                if (empty($redirect_url)) {
                    wp_redirect(wp_login_url(get_permalink()));  
                }
                else {
                    wp_redirect( esc_url($redirect_url));     
                }
                
            }
            else {

            }
    		
    	}


	}

        

    }

    $wp_login_logout_pages = new wp_login_logout_pages();
}

?>