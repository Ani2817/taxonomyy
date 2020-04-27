<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://codethemes.co/
 * @since      1.0.0
 *
 * @package    Wp_Custom_Post_Type
 * @subpackage Wp_Custom_Post_Type/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Custom_Post_Type
 * @subpackage Wp_Custom_Post_Type/public
 * @author     Code Pixelz Media <info@codethemes.co>
 */
class Wp_Custom_Post_Type_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Custom_Post_Type_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Custom_Post_Type_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-custom-post-type-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Custom_Post_Type_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Custom_Post_Type_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-custom-post-type-public.js', array( 'jquery' ), $this->version, false );

	}

}

function wp_custom_post_type_team($template) {
	global $post;
	if($post->post_type == "team" || $post->post_type == "portfolio" || $post->post_type == "callout" || $post->post_type == "client" || $post->post_type == "testimonial"){
		if ($template !== locate_template(array("single-".$post->post_type.".php"))){
			return plugin_dir_path( __FILE__ ) . "templates/single-".$post->post_type.".php";
		}
	}
	return $template;
}

add_filter('single_template', 'wp_custom_post_type_team');

function wp_custom_post_type_archive_team($template) {
	global $post;
	if($post->post_type == "team" || $post->post_type == "portfolio" || $post->post_type == "callout" || $post->post_type == "client" || $post->post_type == "testimonial"){
		if ($template !== locate_template(array("archive-".$post->post_type.".php"))){
			return plugin_dir_path( __FILE__ ) . "templates/archive-".$post->post_type.".php";
		}
	}
	return $template;
}

add_filter('archive_template', 'wp_custom_post_type_archive_team');