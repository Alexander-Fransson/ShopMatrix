<?php
/**
 * @package produkteruru 
*/

/**
 * Plugin Name: produkteruru
 * Plugin URI: 
 * Description: Alouw costumers to create a list of products with names, prices, stockbools and descriptions.
 * Version: 1.0
 * Author: Alexander Fransson
 * Author URI: https://shopmatrix54.com
 * License: GPLv2 or later
 * Text Domain: produkteruru
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
*/

/*--------------
Initsierar filer 
--------------*/

if (! defined('ABSPATH')){
    die;
}

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php')){
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

function activate_produkteruru() {
    Inc\Base\Activate::activate();
}
register_activation_hook(__FILE__, 'activate_produkteruru');

function deactivate_produkteruru() {
    Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_produkteruru');

if (class_exists('Inc\\Init')){
    Inc\Init::register_services();
}

/*-------------------------------
Skapar Custom Post Type Produkter 
-------------------------------*/

function produkteruru_products_posttype(){
    $lables = array(
        'name' =>__( 'Products' , 'Post Type General Name' , 'products'),
        'singular_name' =>__( 'Products' , 'Post Type Singular Name' , 'products'),
        'menu_name' =>__( 'Products' , 'products'), 
        'name_admin_bar' =>__( 'Products' , 'products'), 
        'archives' =>__( 'Product Archives' , 'products'), 
        'attributes' => __('Product Atributes' , 'products'),
        'parent_item_colon' => __('Parent Product' , 'products'),
        'all_items' =>__( 'All Products' , 'products'), 
        'add_new_item' =>__( 'Add New Product' , 'products'), 
        'add_new' =>__( 'Add New' , 'products'), 
        'new_item' =>__( 'New Product' , 'products'), 
        'edit_item' =>__( 'Edit Product' , 'products'), 
        'update_item' =>__( 'Update Product' , 'products'), 
        'view_item' =>__( 'View Product' , 'products'), 
        'view_items' =>__( 'View Products' , 'products'), 
        'search_items' =>__( 'Search Products' , 'products'), 
        'not_found' =>__( 'Product Not Found' , 'products'), 
        'not_found_in_trash' =>__( 'Product Not Found In Trash' , 'products'), 
        'featured_image' =>__( 'Featured Image' , 'products'), 
        'set_featured_image' =>__( 'Set Featured Image' , 'products'), 
        'remove_featured_image' =>__( 'Remove Featured Image' , 'products'), 
        'use_featured_image' =>__( 'Use Featured Image' , 'products'), 
        'insert_into_item' =>__( 'Insert Into Product' , 'products'), 
        'uploaded_to_this_item' =>__( 'Uploaded To This Product' , 'products'), 
        'items_list' =>__( 'Products List' , 'products'), 
        'items_list_navigation' =>__( 'Product List Navigation' , 'products'), 
        'filter_items_list' =>__( 'Filter List Of Products' , 'products'), 
    );

    $args = array(
        'label' => __( 'Product' , 'products' ),
        'description' => __( 'Product Post With Name, Prise, Availabiltiy, Athor and Description' , 'products' ),
        'labels' => $lables,
        'menu_icon' => 'dashicons-editor-video',
        'supports' => array('title', 'editor',/* 'excerpt',*/ 'athor' , 'thumbnail' , /*'revisions' ,*/ 'custom-fields' ),
        'taxonomies' => array(),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'hierarchical' => false,
        'has_archive' => true,
        'exclude_from_search' => false,
        'show_in_rest' => true,
        'publicly_queriable' => true,
        'capability_type' => 'post',
        'rewrite' => array('slug' => 'products'),
    ); 

    register_post_type('products', $args);
    
}

add_action('init' , 'produkteruru_products_posttype' , 0 );

function produkteruru_rewrite_products_flush(){
    produkteruru_products_posttype();
    flush_rewrite_rules();
}

register_activation_hook( __FILE__ , 'produkteruru_rewrite_products_flush');

/*------------------------------
Gör så att WP hittar CP Template
------------------------------*/

add_filter( 'single_template', 'get_custom_post_type_template' );
 
function get_custom_post_type_template( $single_template ) {
    global $post;
 
    if ( 'products' === $post->post_type ) {
        $single_template = dirname( __FILE__ ) . '/templates/single-products.php';
    }
 
    return $single_template;
}

//slug = products


/*-------------------------
Visar custome fields i rest
-------------------------*/
function show_fields(){

    register_rest_field( 'products' , 'Price' , [
        'get_callback' => function() {return get_field('price');}
    ]);
    register_rest_field( 'products' , 'Availability' , [
        'get_callback' => function() {return get_field('availability');}
    ]);
    register_rest_field( 'products' , 'EditedImage' , [
        'get_callback' => function() {return get_field('_thumbnail_id');}
    ]);

}

add_action( 'rest_api_init' , 'show_fields');

/*-------------------------------
Skapar Custom Post Type Customers 
-------------------------------*/

function produkteruru_customers_posttype(){
    $lables = array(
        'name' =>__( 'Customers' , 'Post Type General Name' , 'customers'),
        'singular_name' =>__( 'Customers' , 'Post Type Singular Name' , 'customers'),
        'menu_name' =>__( 'Customers' , 'customers'), 
        'name_admin_bar' =>__( 'Customers' , 'customers'), 
        'archives' =>__( 'Customers Archives' , 'customers'), 
        'attributes' => __('Customers Atributes' , 'customers'),
        'parent_item_colon' => __('Parent Customer' , 'customers'),
        'all_items' =>__( 'All Customers' , 'customers'), 
        'add_new_item' =>__( 'Add New Customer' , 'customers'), 
        'add_new' =>__( 'Add New' , 'customers'), 
        'new_item' =>__( 'New Customers' , 'customers'), 
        'edit_item' =>__( 'Edit Customer' , 'customers'), 
        'update_item' =>__( 'Update Customer' , 'customers'), 
        'view_item' =>__( 'View Customer' , 'customers'), 
        'view_items' =>__( 'View Customers' , 'customers'), 
        'search_items' =>__( 'Search Customers' , 'customers'), 
        'not_found' =>__( 'Customer Not Found' , 'customers'), 
        'not_found_in_trash' =>__( 'Customer Not Found In Trash' , 'customers'), 
        'featured_image' =>__( 'Featured Image' , 'customers'), 
        'set_featured_image' =>__( 'Set Featured Image' , 'customers'), 
        'remove_featured_image' =>__( 'Remove Featured Image' , 'customers'), 
        'use_featured_image' =>__( 'Use Featured Image' , 'customers'), 
        'insert_into_item' =>__( 'Insert Into Customer' , 'customers'), 
        'uploaded_to_this_item' =>__( 'Uploaded To This Customer' , 'customers'), 
        'items_list' =>__( 'Customer List' , 'customers'), 
        'items_list_navigation' =>__( 'Customer List Navigation' , 'customers'), 
        'filter_items_list' =>__( 'Filter List Of Customers' , 'customers'), 
    );

    $args = array(
        'label' => __( 'Customers' , 'customers' ),
        'description' => __( 'Queriable customer post that contains company-name, shop-adress, website-url, company-email,
                              company-phonenumber, number of succesfull transactions, number of transactions left, company 
                              logo that is fetured image, ESG score, user reviews, list of product-posts that author is 
                              author to in editor and author id' , 'customers' ),
        'labels' => $lables,
        'menu_icon' => 'dashicons-editor-video',
        'supports' => array('title', 'editor',/* 'excerpt',*/ 'athor' , 'thumbnail' , /*'revisions' ,*/ 'custom-fields' ),
        'taxonomies' => array(),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 6,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'hierarchical' => false,
        'has_archive' => true,
        'exclude_from_search' => false,
        'show_in_rest' => true,
        'publicly_queriable' => true,
        'capability_type' => 'post',
        'rewrite' => array('slug' => 'customers'),
    ); 

    register_post_type('customers', $args);
    
}

add_action('init' , 'produkteruru_customers_posttype' , 0 );

function produkteruru_rewrite_customers_flush(){
    produkteruru_customers_posttype();
    flush_rewrite_rules();
}

register_activation_hook( __FILE__ , 'produkteruru_rewrite_customers_flush');

/*------------------------------
Gör så att WP hittar CP Template
------------------------------*/

add_filter( 'single_template', 'get_customer_post_type_template' );
 
function get_customer_post_type_template( $single_template ) {
    global $post;
 
    if ( 'customers' === $post->post_type ) {
        $single_template = dirname( __FILE__ ) . '/templates/single-costumer.php';
    }
 
    return $single_template;
}

/*-------------------------------------------------------------------
Uppdaterar customers-post-content när ny post skapas eller uppdateras
-------------------------------------------------------------------*/

add_action('save_post', 'update_customer_post_content' );

function update_customer_post_content($post_id){  
    
    if(get_post_type($post_id) == 'products'){
        //Get a string of all product names

        $args = [
            'post_type' => 'products',
            'author' =>  get_current_user_id(),
            'posts_per_page' => -1,
        ];

        $query = new \WP_Query($args);
        $products_string = '';

        while($query->have_posts()): $query->the_post();

            $products_string .= get_the_title() . " ";

        endwhile; wp_reset_query();  
                                        
        //Insert string into customers post content

        $args = [
            'post_type' => 'customers',
            'author' => get_current_user_id(),
            'posts_per_page' => 1,
        ];

        $query = new \WP_Query($args);

        while($query->have_posts()): $query->the_post();

            $my_post = array(
                'ID'           => get_the_ID(),
                'post_content' => $products_string,
            );
        
            wp_update_post( $my_post );
            
        endwhile; wp_reset_query();  
    }
}

add_action('delete_post', 'update_customer_post_content_when_deleting' );

function update_customer_post_content_when_deleting($post_id){  
    
    if(get_post_type($post_id) == 'products'){
        //Get a string of all product names

        $args = [
            'post_type' => 'products',
            'author' =>  get_current_user_id(),
            'posts_per_page' => -1,
        ];

        $query = new \WP_Query($args);
        $products_string = '';

        while($query->have_posts()): $query->the_post();

            //removes the deleeted posts from products_string
            if(get_the_ID() != $post_id)
            {
                $products_string .= get_the_title() . " ";
            }

        endwhile; wp_reset_query();  
                                        
        //Insert string into customers post content

        $args = [
            'post_type' => 'customers',
            'author' => get_current_user_id(),
            'posts_per_page' => 1,
        ];

        $query = new \WP_Query($args);

        while($query->have_posts()): $query->the_post();

            $my_post = array(
                'ID'           => get_the_ID(),
                'post_content' => $products_string,
            );
        
            wp_update_post( $my_post );
            
        endwhile; wp_reset_query();  
    }
}

/*---------------------------------------
Hide review form after submit with cookie 
---------------------------------------*/

add_filter('site-reviews/enqueue/public/inline-script/after', function ($javascript) {
    return $javascript."
    GLSR.Event.on('site-reviews/form/handle', function (response, formEl) {
        if (false !== response.errors) return;
        formEl.classList.add('glsr-hide-form');
        formEl.insertAdjacentHTML('afterend', '<p>' + response.message + '</p>');

        document.cookie = 'user=John; max-age=31622400'; // update only cookie named 'user'
    });
    try{

        if(document.cookie.split(';').some((item) => item.trim().startsWith('user='))){
            (function($){
                $('#review-form'). css('display', 'none');
            }(jQuery));
        }

    }catch(e){
        alert(e);
    }
    ";
});

/*-------------------
Send mail every month
-------------------*/
