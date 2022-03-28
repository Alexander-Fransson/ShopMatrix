<?php

namespace Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if( ! defined( 'ABSPATH' ) ) exit();

class SearchYourPosts extends Widget_Base{

    /*-----------------------
    Obligatory charaktristiks
    -----------------------*/

    public function get_name() {
        return  'search-your-posts';
    }

    public function get_title() {
        return esc_html__( 'Search Your Posts', 'search-your-posts' );
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

        /*----------
        search field
        ----------*/

        function placeholder(){

            if(empty($_GET["post-searchbar"])){
                return "Search for product name";
            }
            else{
                return $_GET["post-searchbar"];
            }
        }

        function get_searched_string(){

            if(empty($_GET["post-searchbar"])){

                return '';
            }
            else{
                return  $_GET["post-searchbar"];
            }
        }

        $search_for = "";

        echo '<form action="https://shopmatrix54.com/services/#input-container" method="get" id="input-container">

            <button type="submit" class="search-button"> 
                <div class="search-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>    
                    </svg>
                </div>
            </button>
            
            <input type="text" name="post-searchbar" id="post-searchbar" placeholder="' . placeholder() . '">
                
        </form>';
        
        /*----------------------------
        Get the posts via custom query
        ----------------------------*/

        $logged_in_user =  get_current_user_id();
        $search_for = get_searched_string();

        $args = [
            'post_type' => 'products',
            'author' => $logged_in_user,
            'posts_per_page' => -1,
            's' => $search_for,
        ];

        $query = new \WP_Query($args);

        while($query->have_posts()): $query->the_post();

            if(isset($_POST['delete-' . get_the_ID()]))
            {
                wp_delete_post(get_the_ID());

            }else{

                echo '

                <div class="omni-contentia">
                
                    <a class="postlink" href="' . get_permalink() . '"target=\_blank\">
                    
                        <div class="product-image-container">
                            <img src="' . get_the_post_thumbnail_url( $query->ID) . '">
                        </div>

                        <div class="product-link">'
                                . get_the_title() . 
                        '</div>                
                        
                    </a>

                    <div class="delete-container">
                        <form action="https://shopmatrix54.com/services/#input-container" method="post" >
                            <input type="submit" value="x" name="delete-'. get_the_ID() .'" class="delete-post">
                        </form>
                    </div>

                </div>
                ';

            }

            
            
        endwhile; wp_reset_query();  

        
    }

}


