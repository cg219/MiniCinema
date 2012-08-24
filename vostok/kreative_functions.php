<?
	
	
	$prefix = 'custom_';
	
	$fields = array(
		array(
			'label' => 'Thumbnail Image',
			'desc' => 'Thumbnail Image URL',
			'id' => $prefix . 'thumb',
			'type' => 'text'
		),
		array(
			'label' => 'Poster Image',
			'desc' => 'Poster Image URL',
			'id' => $prefix . 'poster',
			'type' => 'text'
		),
		array(
			'label' => 'Synopsis',
			'desc' => 'Synopsis',
			'id' => $prefix . 'synopsis',
			'type' => 'textarea'
		),
		array(
			'label' => 'Director',
			'desc' => 'Director',
			'id' => $prefix . 'director',
			'type' => 'text'
		),
		array(
			'label' => 'Producer',
			'desc' => 'Producer',
			'id' => $prefix . 'producer',
			'type' => 'text'
		),
		array(
			'label' => 'Writer',
			'desc' => 'Writer',
			'id' => $prefix . 'writer',
			'type' => 'text'
		),
		array(
			'label' => 'Cast',
			'desc' => 'Cast',
			'id' => $prefix . 'cast',
			'type' => 'text'
		),
		array(
			'label' => 'Official Website Link',
			'desc' => 'Website URL',
			'id' => $prefix . 'website',
			'type' => 'text'
		),
		array(
			'label' => 'Official Website',
			'desc' => 'Website Name',
			'id' => $prefix . 'website_name',
			'type' => 'text'
		),
		array(
			'label' => 'Video',
			'desc' => 'Video ID or Link',
			'id' => $prefix . 'video',
			'type' => 'text'
		)
		/*array(
			'label' => 'TextArea',
			'desc' => 'Description for the field',
			'id' => $prefix . 'textarea',
			'type' => 'textarea'
		),
		array(
			'label' => 'Checkbox Input',
			'desc' => 'Description for the field',
			'id' => $prefix . 'checkbox',
			'type' => 'checkbox'
		),
		array(
			'label' => 'Select Box',
			'desc' => 'Description for the field',
			'id' => $prefix . 'select',
			'type' => 'select',
			'options' => array(
				'one' => array(
					'label' => 'Option One',
					'value' => 'one'
				),
				'two' => array(
					'label' => 'Option Two',
					'value' => 'two'
				),
				'three' => array(
					'label' => 'Option Three',
					'value' => 'three'
				)
			)
		)*/
	);

	function add_custom_meta_box(){
		add_meta_box('custom_meta_box', 'Custom Meta Box', 'show_custom_meta_box', 'mini_video', 'normal', 'high');
	}
	
	function show_custom_meta_box(){
		global $fields, $post;
		
		echo '<input type="hidden" name="custom_meta_box_nonce" value="' . wp_create_nonce(basename(__FILE__)) . '" />';
		
		echo '<div class="custom-meta-box-area">';
		
		foreach( $fields as $field ){
			$meta = get_post_meta($post->ID, $field['id'], true);
			
			switch($field['type']){
				case 'text':
					echo '<input type="text" name="' .  $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" size="30" />';
					echo '<br />';
					echo '<span class="meta-description">' . $field['desc'] . '</span>';
				break;
				
				case 'textarea':
					echo '<textarea name="' .  $field['id'] . '" id="' . $field['id'] . '" cols="60" row="4">' . $meta . '</textarea>';
					echo '<br />';
					echo '<span class="meta-description">' . $field['desc'] . '</span>';
				break;
				
				case 'checkbox':
					echo '<input type="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '" ',$meta ? ' checked="checked"' : '',' />';
					echo '<label for="' . $field['id'] . '">' . $field['desc'] . '</label>';
				break;
				
				case 'select':
					echo '<select name="' . $field['id'] . '" id="' . $field['id'] . '">';
					foreach( $field['options'] as $option ){
						echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="' . $option['value'] . '">' . $option['label'] . '</option>';
					}
					echo '</select>';
					echo '<br />';
					echo '<label for="' . $field['id'] . '">' . $field['desc'] . '</label>';
				break;
			}
		}
		
		echo '</div>';
	}
	
	function save_custom_meta( $post_id ){
		global $fields;
		
		// verify nonce  
	    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))  
	        return $post_id;  
	    // check autosave  
	    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)  
	        return $post_id;  
	    // check permissions  
	    if ('page' == $_POST['post_type']) {  
	        if (!current_user_can('edit_page', $post_id))  
	            return $post_id;  
	        } elseif (!current_user_can('edit_post', $post_id)) {  
	            return $post_id;  
	    }  
	  
	    // loop through fields and save the data  
	    foreach ($fields as $field) {  
	        $old = get_post_meta($post_id, $field['id'], true);  
	        $new = $_POST[$field['id']];  
	        if ($new && $new != $old) {  
	            update_post_meta($post_id, $field['id'], $new);  
	        } elseif ('' == $new && $old) {  
	            delete_post_meta($post_id, $field['id'], $old);  
	        }  
	    } // end foreach
	}
	
	function create_post_type() {
		register_post_type( 'mini_video',
			array(
				'labels' => array(
					'name' => __( 'Short Films' ),
					'singular_name' => __( 'Short Film' )
				),
			'public' => true,
			'has_archive' => true,
			'taxonomies' => array('category', 'post_tag')
			)
		);
	}
	
	function my_admin_head() {
        echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/css/admin.css">';
    }

	add_action('admin_head', 'my_admin_head');
	add_action( 'init', 'create_post_type' );
	add_action('add_meta_boxes', 'add_custom_meta_box');
	add_action('save_post', 'save_custom_meta');
?>