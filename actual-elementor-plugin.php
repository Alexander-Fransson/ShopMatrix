<?php
/**
 * Plugin Name: Actual Elementor Plugin
 * Plugin URI: https://shopmatrix54.com
 * Description: custom elementor widgets
 * Version: 1.0.0
 * Author: Alexander Fransson
 * Author URI: https://shopmatrix54.com
 * Text Domain: actual-elementor-plugin
*/

if( ! defined( 'ABSPATH' ) ) exit();

final class Actual_Widget_Loader{

    /*----------------
    Singleton instance
    ----------------*/

    private static $_instance = null;

    public static function instance(){

        if(is_null(self::$_instance)){
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /*-------------------------
    Unnecesary complicated init
    -------------------------*/

    public function __construct(){

        add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ] );
    }

    public function on_plugins_loaded(){
        add_action( 'elementor/init', [ $this, 'init' ] );
    }

    public function init(){
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, "enqueue_scripts" ] );
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ], 99999 );
    }

    /*-------------------------------
    Include widgets and register them 
    -------------------------------*/

    public function init_widgets(){ 

        //initsiera widget filer
        require_once(__DIR__ . '/widgets/search-your-posts.php');
        require_once(__DIR__ . '/widgets/bulk-post.php');
        require_once(__DIR__ . '/widgets/customer-registration-form.php');
        require_once(__DIR__ . '/widgets/display-customer-post.php');
        require_once(__DIR__ . '/widgets/searchfunctionality.php');
        
        //initsiera classer i widget filer
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\SearchYourPosts());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\BulkPost());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\CustomerRegistrationForm());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\DisplayCustomerPost());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Searchfunktionality());

    }

    /*------------
    Enqueue styles
    ------------*/

    public function enqueue_scripts(){

        wp_register_style("better-css", plugins_url('/assets/style.css', __FILE__), [], false, "all");
        wp_enqueue_style("better-css");
    }

    /*--------
    Enqueue JS
    --------*/

    public function widget_scripts()
    {
        // # use WordPress Ajax at your frontend 

        // featured products
        wp_register_script( 'widget-1', plugins_url(  'assets/script.js', __FILE__ ), [ 'jquery' ] );
        wp_enqueue_script('widget-1');
    }

} 

Actual_Widget_Loader::instance();