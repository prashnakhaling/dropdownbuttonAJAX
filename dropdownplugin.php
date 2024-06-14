<?php
/**
 * Plugin Name: dropdownpractice
 * Plugin URI:
 * Description: Test
 * Version :0.1
 * Author: Code Pixelz Media
 * Author URI: 
 **/
/* Main Plugin File */




// Enqueue scripts and localize variables
function post_meta_enqueue_scripts() {
    wp_enqueue_script('post-number-meta-script', plugin_dir_url(__FILE__) . 'script.js', array('jquery'), '1.0', true);
    wp_localize_script('post-number-meta-script', 'post_number_meta_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'post_meta_enqueue_scripts');

// Handle AJAX request to save post meta
function post_number_meta_save_post_number() {
    if ( isset($_POST['selected_number']) && isset($_POST['post_id']) && wp_verify_nonce( $_POST['save_number_nonce_field'], 'save_number_nonce' ) ) {
        $selected_number = sanitize_text_field($_POST['selected_number']);
        $post_id = intval($_POST['post_id']);
        // Save selected number as post meta
        update_post_meta($post_id, 'selected_number', $selected_number);
        echo 'success';
    } else {
        echo 'error';
    }
    wp_die();
}
add_action('wp_ajax_save_post_number', 'post_number_meta_save_post_number');

// Create the dropdown and submit button
function create_dropdown($option) {
if(is_user_logged_in()){ 
    $option .= ' <form id= "number-form">
    <select id="select-number" name = "selected_number">
    <option value="">Select an option</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    </select>';
   $option .=' <input type= "submit" value= "submit">';
    $option .= wp_nonce_field( 'save_number_nonce', 'save_number_nonce_field', true, false );
    $option .= '<input type="hidden" name="post_id" value="' . get_the_ID() . '">';
}
return $option;
    
}
add_action( 'the_content', 'create_dropdown' );

