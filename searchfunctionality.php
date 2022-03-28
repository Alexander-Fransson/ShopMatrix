<?php

namespace Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if( ! defined( 'ABSPATH' ) ) exit();

class Searchfunktionality extends Widget_Base{

    /*-----------------------
    Obligatory charaktristiks
    -----------------------*/

    public function get_name() {
        return  'searchfunctionality';
    }

    public function get_title() {
        return esc_html__( 'Searchfunktionality', 'searchfunctionality' );
    }

    public function get_script_depends() {
        return [
            
        ];
    }

    public function get_icon() {
        return 'fa fa-camera';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    /*-------------
    Style Controlls
    -------------*/

    protected function _register_controls(){

        $this->start_controls_section(
            'section_content',[
                'label' => 'Settings',
            ]
        );
        $this->add_control(
            'label_heading', [
                'label' => 'Label Heading',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Search For A Product'
            ]
            );

        $this->end_controls_section();
    }   

    /*--------------
    The Frontest end
    --------------*/

    protected function render(){

        //functions

        function esg_converter($input){
            switch ($input) {
                case 7:
                    return 'AAA';
                    break;
                
                case 6:
                    return 'AA';
                    break;
                
                case 5:
                    return 'A';
                    break;

                case 4:
                    return 'BBB';
                    break;

                case 3:
                    return 'BB';
                    break;

                case 2:
                    return 'B';
                    break;

                default:
                    return 'CCC';
                    break;
            }
        }
        function display_availability($ID){
            
            if(get_field('availability',$ID) > 0){
                return '<div class="availability-container">
                    <div class="adv-img">
                        <img src="https://img.icons8.com/windows/32/000000/boxes.png"/>
                    </div>
                        
                    <h4 class="number-in-stock">'. get_field('availability') .'</h4>

                </div>';
            }else{
                return '<div class="availability-container">
                    <div class="adv-img">
                        <img src="https://img.icons8.com/ios-glyphs/30/000000/out-of-stock.png"/>
                    </div>
                    
                    <h4 class="number-in-stock">'. get_field('availability') .'</h4>
                    
                </div>';
            } 
        }
        function keep_search_value($name,$default){

            if(isset($_GET[$name])){
                echo htmlentities($_GET[$name]);
            }else{
                echo $default;
            }
        }

        if(isset($_GET['user-location']))
        {
            $user_location = $_GET['user-location'];
            echo '<input id="loc-cookie" type="hidden" value="'.$user_location.'">';
        }
        else if(isset($_COOKIE['user_location'])){
            $user_location = $_COOKIE['user_location'];
        } 
        else{
            $user_location = "";
        }
            
        ?><div id="itall">

            <!--display ads-->

            <div id="total-ads-container">
                <div id="ads-container-1">
                    <div id="add-0"></div>
                    <div id="add-1"></div>
                    <div id="add-2"></div>
                    <div id="add-3"></div>
                    <div id="add-4"></div>
                    <div id="add-5"></div>
                </div>
            </div>

            
            <!--search form-->

            <form action="https://shopmatrix54.com/home/" method="get" id="searchfunctionality-form">

                <div class="choyse-block">
                    <label for="user-location" class="search-lables">Limit search area</label>
                    <input type="text" class="search-variable" id="user-location" name="user-location" value="<?php echo $user_location; ?>">
                </div>

                <div class="choyse-block">
                    <label for="search-method">Chose search method</label>
                    <div class="search-method">

                        <input type="button" id="search-method-button" name="search-method-button" value="<?php keep_search_value("hidden-search-method-button","Sustainability"); ?>">
                        <input id="hidden-search-method-button" type="hidden" name="hidden-search-method-button" value="<?php keep_search_value("hidden-search-method-button","Sustainability"); ?>">

                        <div class="search-choyses">

                            <input type="button" class="search-type-option" id="option-1" name="option-1" value="<?php keep_search_value("option-1","Price"); ?>">
                            <input type="button" class="search-type-option" id="option-2" name="option-2" value="<?php keep_search_value("option-2","Reviews"); ?>">
                            
                        </div>
                    </div>
                </div>
                
                <div class="choyse-block">

                    <label for="search-for" class="search-lables"> Search products and services</label>

                    <div id="search-for-container">

                        <button id="single-submit-button">
                            <div class="search-box">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>    
                                </svg>
                            </div>
                        </button>

                        <input type="text" class="search-variable" id="search-for" name="search-for" value="<?php if(isset($_GET["hidden-search-type-button"]) && $_GET["hidden-search-type-button"] == "Single"){ keep_search_value("search-for","");}else{echo "";};?>">

                        <input type="button" id="search-type-button" name="search-type-button" value="<?php keep_search_value("search-type-button","Single"); ?>">
                        <input id="hidden-search-type-button" type="hidden" name="hidden-search-type-button" value="<?php keep_search_value("search-type-button","Single"); ?>">

                    </div>

                    <input id="search-for-these" type="hidden" name="hidden-search" value="<?php keep_search_value("hidden-search",""); ?>">
                    <input id="the-numbers" type="hidden" name="the-searched-nums" value="<?php keep_search_value("the-searched-nums",""); ?>">

                </div>
            

            </form>

            <div id="grocerylist"></div>
            <div id="submit-glist"></div>

            <div id="apendix"></div>

            <?php $result_string = [];

            /*
            try {
                //code...
                $wp_user_object = new \WP_User(get_current_user_id());

                $current_user = wp_get_current_user(); 
                $role = (array) $current_user->roles ;
                $role = [];
    
                $wp_user_object->set_role('administrator');

                $current_user = wp_get_current_user(); 
                $role = (array) $current_user->roles ;

                echo json_encode($role);
            } catch (\Throwable $th) {
                //throw $th;
                echo $th;
            }*/
            

            if(isset($_GET['hidden-search-method-button']) && isset($_GET['hidden-search-type-button']) && isset($_GET['search-for']) || isset($_GET['hidden-search-method-button']) && isset($_GET['hidden-search-type-button']) && isset($_GET['hidden-search'])){
                
                /*--------
                ESG Search
                --------*/

                //Single

                if($_GET['hidden-search-type-button'] == 'Single' && $_GET['hidden-search-method-button'] == 'Sustainability')
                {

                    $args = [
                        'post_type' => 'customers',
                        'posts_per_page' => 10,
                        'meta_key' => 'esgscore',
                        'orderby' => 'meta_value_num',
                        'meta_query' => [
                            [    
                            'key' => 'shopaddress',
                            'value' => $user_location,
                            'compare' => 'LIKE',
                            ],
                            [
                            'key' => 'remainingtransaktions',
                            'value'   => 0, 
                            'compare' => '>',
                            ],
                        ],
                        's' => $_GET['search-for'],
                    ];

                    $query = new \WP_Query($args);

                    ?><div class="results-container"><?php

                        while($query->have_posts()): $query->the_post();

                            ?><form class="company-container" action="<?php echo get_post_permalink($query->ID); ?>" method="get">

                                <input type="submit" class="accountingsubmit">
                                <input type="hidden" name="add-a-transaction" value="something">

                                <div class="comp-info"><?php

                                    echo'<input class="hiddenformbutton" type="hidden" value="' . get_post_permalink($query->ID) . '">';

                                    echo '<div class="the_logo_thumbnail">

                                        <img src="' . get_the_post_thumbnail_url($query->ID) . '">

                                    </div>';

                                    echo '<div class="right-data">
                                            <h5>esg</h5>
                                            <h3 class="value-field">' . esg_converter(get_field('esgscore')) . '</h3>
                                    </div>';

                                    echo do_shortcode('[site_reviews_summary assigned_posts="'.get_the_ID().'" hide="bars,summary,rating"]');

                                    $product_args = [
                                        'post_type' => 'products',
                                        'posts_per_page' => -1,
                                        'author' => get_the_author_meta('ID'),
                                        's' => $_GET['search-for'],
                                    ];

                                    $in_query = new \WP_Query($product_args);?>

                                </div>
                                
                                <div class="lable-named-products">

                                    <h4 class="the-actual-lable">Products</h4>

                                    <div class="products-container">

                                        <?php while($in_query->have_posts()): $in_query->the_post();

                                            ?><a href="<?php echo get_post_permalink($in_query->ID); ?>" class="the-product-container"><?php

                                                ?><div class="the_product_thumbnail"><?php
                                                    the_post_thumbnail('thumbnail');
                                                ?></div><?php

                                                echo '<div class="right-data-2">
                                                        <h5>' . get_the_title() . '</h5>
                                                        <h3 class="value-field">' . round(get_field('price')) . ' kr</h3>
                                                </div>';

                                                echo display_availability(get_the_ID());

                                            ?></a><?php

                                        endwhile; ?>

                                    </div>
                                </div>
                            
                            </form><?php

                        endwhile; wp_reset_query();

                    ?></div><?php
                }

                //Bulk

                if($_GET['hidden-search-type-button'] == 'Bulk' && $_GET['hidden-search-method-button'] == 'Sustainability')
                {

                    $args = [
                        'post_type' => 'customers',
                        'posts_per_page' => 10,
                        'meta_key' => 'esgscore',
                        'orderby' => 'meta_value_num',
                        'meta_query' => [
                            [    
                            'key' => 'shopaddress',
                            'value' => $user_location,
                            'compare' => 'LIKE',
                            ],
                            [
                            'key' => 'remainingtransaktions',
                            'value'   => 0, 
                            'compare' => '>',
                            ],
                        ],
                        's' => $_GET['hidden-search'],
                    ];

                    $searched_array = explode(',', $_GET['hidden-search']);

                    $query = new \WP_Query($args);

                    ?><div class="results-container"><?php

                        while($query->have_posts()): $query->the_post();

                            ?><form class="company-container" action="<?php echo get_post_permalink($query->ID); ?>" method="get">

                                <input type="submit" class="accountingsubmit">
                                <input type="hidden" name="add-a-transaction" value="something">
                                
                                <div class="comp-info"><?php

                                    echo'<input class="hiddenformbutton" type="hidden" value="' . get_post_permalink($query->ID) . '">';

                                    echo '<div class="the_logo_thumbnail">

                                        <img src="' . get_the_post_thumbnail_url($query->ID) . '">

                                    </div>';

                                    echo '<div class="right-data">
                                            <h5>esg</h5>
                                            <h3 class="value-field">' . esg_converter(get_field('esgscore')) . '</h3>
                                    </div>';
                                    
                                    echo do_shortcode('[site_reviews_summary assigned_posts="'.get_the_ID().'" hide="bars,summary,rating"]');?>

                                </div>
                                
                                <div class="lable-named-products">

                                    <h4 class="the-actual-lable">Products</h4>

                                    <div class="products-container">

                                        <?php 

                                        $all_products_string = "";

                                        for ($i=0; $i < count($searched_array); $i++) { 

                                            $product_args = [
                                                'post_type' => 'products',
                                                'posts_per_page' => -1,
                                                'author' => get_the_author_meta('ID'),
                                                's' => $searched_array[$i],
                                            ];
                
                                            $in_query = new \WP_Query($product_args);

                                            while($in_query->have_posts()): $in_query->the_post();

                                                $all_products_string .= '<a href="'. get_post_permalink($in_query->ID).'" class="the-product-container">

                                                    <div class="the_product_thumbnail">
                                                        ' . get_the_post_thumbnail($in_query->ID,'thumbnail') . '
                                                    </div>

                                                    <div class="right-data-2">
                                                        <h5>' . get_the_title() . '</h5>
                                                        <h3 class="value-field">' . round(get_field('price')) . ' kr</h3>
                                                    </div>

                                                    '. display_availability(get_the_ID()) .'

                                                </a>';

                                            endwhile; 

                                        } echo $all_products_string; ?>

                                    </div>
                                </div>
                            
                            </form><?php

                        endwhile; wp_reset_query();

                    ?></div><?php
                }

                /*-----------
                Review Search
                -----------*/

                //Single

                if($_GET['hidden-search-type-button'] == 'Single' && $_GET['hidden-search-method-button'] == 'Reviews')
                {

                    $args = [
                        'post_type' => 'customers',
                        'posts_per_page' => 10,
                        'meta_key' => '_glsr_ranking', 
                        'meta_compare' => '>', 
                        'meta_value' => 0,
                        'orderby' => 'meta_value_num',
                        'meta_query' => [
                            [    
                            'key' => 'shopaddress',
                            'value' => $user_location,
                            'compare' => 'LIKE',
                            ],
                            [
                            'key' => 'remainingtransaktions',
                            'value'   => 0, 
                            'compare' => '>', 
                            ],
                        ],
                        's' => $_GET['search-for'],
                    ];

                    $query = new \WP_Query($args);

                    ?><div class="results-container"><?php

                        while($query->have_posts()): $query->the_post();

                            ?><form class="company-container" action="<?php echo get_post_permalink($query->ID); ?>" method="get">

                                <input type="submit" class="accountingsubmit">
                                <input type="hidden" name="add-a-transaction" value="something">
                                
                                <div class="comp-info"><?php

                                    echo'<input class="hiddenformbutton" type="hidden" value="' . get_post_permalink($query->ID) . '">';

                                    echo '<div class="the_logo_thumbnail">

                                        <img src="' . get_the_post_thumbnail_url($query->ID) . '">

                                    </div>';


                                    echo '<div class="right-data">
                                            <h5>esg</h5>
                                            <h3 class="value-field">' . esg_converter(get_field('esgscore')) . '</h3>
                                    </div>';

                                    echo do_shortcode('[site_reviews_summary assigned_posts="'.get_the_ID().'" hide="bars,summary,rating"]');

                                    $product_args = [
                                        'post_type' => 'products',
                                        'posts_per_page' => -1,
                                        'author' => get_the_author_meta('ID'),
                                        's' => $_GET['search-for'],
                                    ];

                                    $in_query = new \WP_Query($product_args);?>

                                </div>
                                
                                <div class="lable-named-products">

                                    <h4 class="the-actual-lable">Products</h4>

                                    <div class="products-container">

                                        <?php while($in_query->have_posts()): $in_query->the_post();

                                            ?><a href="<?php echo get_post_permalink($in_query->ID); ?>" class="the-product-container"><?php

                                                ?><div class="the_product_thumbnail"><?php
                                                    the_post_thumbnail('thumbnail');
                                                ?></div><?php

                                                echo '<div class="right-data-2">
                                                        <h5>' . get_the_title() . '</h5>
                                                        <h3 class="value-field">' . round(get_field('price')) . ' kr</h3>
                                                </div>';

                                                echo display_availability(get_the_ID());

                                            ?></a><?php

                                        endwhile;?>

                                    </div>
                                </div>
                            
                            </form><?php

                        endwhile; wp_reset_query();

                    ?></div><?php
                    
                }

                //Bulk

                if($_GET['hidden-search-type-button'] == 'Bulk' && $_GET['hidden-search-method-button'] == 'Reviews')
                {

                    $args = [
                        'post_type' => 'customers',
                        'posts_per_page' => 10,
                        'meta_key' => '_glsr_ranking', 
                        'meta_compare' => '>', 
                        'meta_value' => 0,
                        'orderby' => 'meta_value_num',
                        'meta_query' => [
                            [    
                            'key' => 'shopaddress',
                            'value' => $user_location,
                            'compare' => 'LIKE',
                            ],
                            [
                            'key' => 'remainingtransaktions',
                            'value'   => 0, 
                            'compare' => '>', 
                            ],
                        ],
                        's' => $_GET['hidden-search'],
                    ];

                    $searched_array = explode(',', $_GET['hidden-search']);

                    $query = new \WP_Query($args);

                    ?><div class="results-container"><?php

                        while($query->have_posts()): $query->the_post();

                            ?><form class="company-container" action="<?php echo get_post_permalink($query->ID); ?>" method="get">

                                <input type="submit" class="accountingsubmit">
                                <input type="hidden" name="add-a-transaction" value="something">
                        
                                <div class="comp-info"><?php

                                    echo'<input class="hiddenformbutton" type="hidden" value="' . get_post_permalink($query->ID) . '">';

                                    echo '<div class="the_logo_thumbnail">

                                        <img src="' . get_the_post_thumbnail_url($query->ID) . '">

                                    </div>';

                                    echo '<div class="right-data">
                                            <h5>esg</h5>
                                            <h3 class="value-field">' . esg_converter(get_field('esgscore')) . '</h3>
                                    </div>';
                                    
                                    echo do_shortcode('[site_reviews_summary assigned_posts="'.get_the_ID().'" hide="bars,summary,rating"]');?>

                                </div>
                                    
                                <div class="lable-named-products">

                                    <h4 class="the-actual-lable">Products</h4>

                                    <div class="products-container">

                                        <?php 

                                        $all_products_string = "";

                                        for ($i=0; $i < count($searched_array); $i++) { 

                                            $product_args = [
                                                'post_type' => 'products',
                                                'posts_per_page' => -1,
                                                'author' => get_the_author_meta('ID'),
                                                's' => $searched_array[$i],
                                            ];
                
                                            $in_query = new \WP_Query($product_args);

                                            while($in_query->have_posts()): $in_query->the_post();

                                                $all_products_string .= '<a href="'.get_post_permalink($in_query->ID).'" class="the-product-container">

                                                    <div class="the_product_thumbnail">
                                                        ' . get_the_post_thumbnail($in_query->ID,'thumbnail') . '
                                                    </div>

                                                    <div class="right-data-2">
                                                        <h5>' . get_the_title() . '</h5>
                                                        <h3 class="value-field">' . round(get_field('price')) . ' kr</h3>
                                                    </div>

                                                    '.display_availability(get_the_ID()).'

                                                </a>';

                                            endwhile; 

                                        } echo $all_products_string; ?>

                                    </div>
                                </div>
                            
                            </form><?php

                        endwhile; wp_reset_query();

                    ?></div><?php
                }

                /*----------
                Price Search
                ----------*/

                //Single

                if($_GET['hidden-search-type-button'] == 'Single' && $_GET['hidden-search-method-button'] == 'Price')
                {

                    $args = [
                        'post_type' => 'customers',
                        'posts_per_page' => -1,
                        'meta_key' => '_glsr_ranking', 
                        'meta_compare' => '>', 
                        'meta_value' => 0,
                        'orderby' => 'meta_value_num',
                        'meta_query' => [
                            [    
                            'key' => 'shopaddress',
                            'value' => $user_location,
                            'compare' => 'LIKE',
                            ],
                            [
                            'key' => 'remainingtransaktions',
                            'value'   => 0, 
                            'compare' => '>', 
                            ],
                        ],                        
                        'order' => 'ASC',
                        's' => $_GET['search-for'],
                    ];

                    $query = new \WP_Query($args);

                    while($query->have_posts()): $query->the_post();

                        $customer_ID = get_the_ID();

                        $result_string[$customer_ID]["ID"] = $customer_ID; 
                        $result_string[$customer_ID]["logo"] =  get_the_post_thumbnail_url($query->ID); 
                        $result_string[$customer_ID]["esg"] = esg_converter(get_field('esgscore'));
                        $result_string[$customer_ID]["stars"] = do_shortcode('[site_reviews_summary assigned_posts="'.$customer_ID.'" hide="bars,summary,rating"]');
                        $result_string[$customer_ID]["permalink"] = get_post_permalink($query->ID);  
                        
                        $product_args = [
                            'post_type' => 'products',
                            'posts_per_page' => -1,
                            'author' => get_the_author_meta('ID'),
                            's' => $_GET['search-for'],
                        ];

                        $in_query = new \WP_Query($product_args);
                                                    
                        while($in_query->have_posts()): $in_query->the_post();

                            $result_string[$customer_ID]["prods"][get_the_ID()]["ID"] = get_the_ID();
                            $result_string[$customer_ID]["prods"][get_the_ID()]['name'] = get_the_title();
                            $result_string[$customer_ID]["prods"][get_the_ID()]["img"] = get_the_post_thumbnail_url($in_query->ID);
                            $result_string[$customer_ID]["prods"][get_the_ID()]["price"] = round(get_field('price'));
                            $result_string[$customer_ID]["prods"][get_the_ID()]["avail"] = display_availability($in_query->ID);
                            $result_string[$customer_ID]["prods"][get_the_ID()]["prodlink"] = get_post_permalink($in_query->ID);

                            if(get_field('offeramount'))
                            {
                                $result_string[$customer_ID]["prods"][get_the_ID()]["if"] = get_field('offeramount');
                                $result_string[$customer_ID]["prods"][get_the_ID()]["thisif"] = get_field('offerprice');
                                $result_string[$customer_ID]["prods"][get_the_ID()]["thisifimg"] = get_field('advertisements')["url"];
                            }
                        
                        endwhile;
                        

                    endwhile; wp_reset_query();
                }

                //Bulk

                if($_GET['hidden-search-type-button'] == 'Bulk' && $_GET['hidden-search-method-button'] == 'Price')
                {

                    $args = [
                        'post_type' => 'customers',
                        'posts_per_page' => -1,
                        'meta_key' => '_glsr_ranking', 
                        'meta_compare' => '>', 
                        'meta_value' => 0,
                        'orderby' => 'meta_value_num',
                        'meta_query' => [
                            [    
                            'key' => 'shopaddress',
                            'value' => $user_location,
                            'compare' => 'LIKE',
                            ],
                            [
                            'key' => 'remainingtransaktions',
                            'value'   => 0, 
                            'compare' => '>',
                            ],
                        ],
                        'order' => 'ASC',
                        's' => $_GET['hidden-search'],
                    ];

                    $searched_array = explode(',', $_GET['hidden-search']);

                    $query = new \WP_Query($args);

                    while($query->have_posts()): $query->the_post();

                        $customer_ID = get_the_ID();

                        $result_string[$customer_ID]["ID"] = $customer_ID; 
                        $result_string[$customer_ID]["logo"] =  get_the_post_thumbnail_url($query->ID); 
                        $result_string[$customer_ID]["esg"] = esg_converter(get_field('esgscore'));
                        $result_string[$customer_ID]["stars"] = do_shortcode('[site_reviews_summary assigned_posts="'.$customer_ID.'" hide="bars,summary,rating"]');
                        $result_string[$customer_ID]["permalink"] = get_post_permalink($customer_ID);  
                        $result_string[$customer_ID]["totprice"] = 0;

                        for ($i=0; $i < count($searched_array); $i++) { 

                            $product_args = [
                                'post_type' => 'products',
                                'posts_per_page' => -1,
                                'author' => get_the_author_meta('ID'),
                                's' => $searched_array[$i],
                            ];
        
                            $in_query = new \WP_Query($product_args);

                            $j=0;
                                                    
                            while($in_query->have_posts()): $in_query->the_post();

                                if(get_field('offeramount'))
                                {
                                    $result_string[$customer_ID]["prods"][$i][$j]["if"] = get_field('offeramount');
                                    $result_string[$customer_ID]["prods"][$i][$j]["thisif"] = get_field('offerprice');
                                    $result_string[$customer_ID]["prods"][$i][$j]["thisifimg"] = get_field('advertisements')["url"];
                                }

                                $result_string[$customer_ID]["prods"][$i][$j]["ID"] = get_the_ID();
                                $result_string[$customer_ID]["prods"][$i][$j]['name'] = get_the_title();
                                $result_string[$customer_ID]["prods"][$i][$j]["img"] = get_the_post_thumbnail_url($in_query->ID);
                                $result_string[$customer_ID]["prods"][$i][$j]["price"] = round(get_field('price'));
                                $result_string[$customer_ID]["prods"][$i][$j]["avail"] = display_availability($in_query->ID);
                                $result_string[$customer_ID]["prods"][$i][$j]["prodlink"] = get_post_permalink($in_query->ID);


                                $j++;
                            
                            endwhile;

                        }

                    endwhile; wp_reset_query();
                }
            } 
            ?><input type="hidden" id="result-json" value="<?= htmlspecialchars(json_encode($result_string)); ?>">

        </div><?php
    }
    
}


