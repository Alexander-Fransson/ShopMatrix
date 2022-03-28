<?php

namespace Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if( ! defined( 'ABSPATH' ) ) exit();

class DisplayCustomerPost extends Widget_Base{

    /*-----------------------
    Obligatory charaktristiks
    -----------------------*/

    public function get_name() {
        return  'display-customer-post';
    }

    public function get_title() {
        return esc_html__( 'Display Customer Post', 'display-customer-post' );
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
        
        /*----------------------------
        Get the costumer via custom query
        ----------------------------*/

        $logged_in_user =  get_current_user_id();

        $args = [
            'post_type' => 'customers',
            'author' => $logged_in_user,
            'posts_per_page' => 1,
        ];

        $query = new \WP_Query($args);

        while($query->have_posts()): $query->the_post();
       
            //Render google map            
            /*
            $settings = get_field('shopaddress');

            if ( empty( $settings['address'] ) ) {
                return;
            }

            if ( 0 === absint( $settings['zoom'] ) ) {
                $settings['zoom'] = 10;
            }

            printf(
                '<div class="elementor-custom-embed"><iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=%s&amp;t=m&amp;z=%d&amp;output=embed&amp;iwloc=near"></iframe></div>',
                urlencode( $settings['address'] ),
                absint( $settings['zoom'])
		    );    

            echo '<p> city: ' . get_field('city') . '</p>';
            echo '<p> url:' . get_field('shopurl') . '</p>';
            echo '<p> email: ' . get_field('email') . '</p>';
            echo '<p> phone: ' . get_field('phonenumber') . '</p>';
            echo '<p> successful transactions: ' . get_field('successfultransactions') . '</p>';
            echo '<p> remaining transaktions: ' . get_field('remainingtransaktions') . '</p>';
            echo '<p> ESG score:' . get_field('esgscore') . '</p>';
            echo '<p> average satisfaction:' . get_field('userreviews') . '</p>';
            echo '<a class="postlink" href="' . get_permalink() . '"target=\_blank\"><h3>edit profile</h3></a>'; 
            */

            /*. do_shortcode('[forminator_form id="548"]') .*/
        
            echo '

            <div id="situation">
            
                <h2> successful advertisments: ' . get_field('successfultransactions') . '</h2>
                <h2> remaining advertisments: ' . get_field('remainingtransaktions') . '</h2>

            </div>
             
            <div class="visable-box">
                <div class="box-title">

                    <div class="svg-box">
                        <svg height="10" width="10" class"trianglero">
                            <polygon points="0,0 0,10 8,5" style="fill:black;stroke:black;stroke-width:1" />
                        </svg>
                    </div>

                    <h3>edit profile</h3>

                </div>

                <a class="profile-edit-link" href="' . get_permalink() . '"target=\_blank\">' . get_permalink() . '</a>
            </div>
            
            <div class="post-products-box">
                <div class="box-title">

                    <div class="svg-box">
                        <svg height="10" width="10" class"trianglero">
                            <polygon points="0,0 0,10 8,5" style="fill:black;stroke:black;stroke-width:1" />
                        </svg>
                    </div>

                    <h3>post product</h3>

                </div>

                <div class="profile-edit-link">

                    <form action="https://shopmatrix54.com/services/#post-one-product" method="get" id="post-one-product">

                        <label for="product_name">Name</label><br>
                        <input id="product_name" name="product_name" type="text"><br>

                        <label for="product_description">Description</label><br>
                        <textarea id="product_description" name="product_description" rows="5"></textarea><br>

                        <label for="product_price">Price in sek</label><br>
                        <input id="product_price" name="product_price" type="number"><br>

                        <label for="product_avail">Availability</label><br>
                        <input id="product_avail" name="product_avail" type="number"><br>

                        <label for="product_quant">Quantity to discount</label><br>
                        <input id="product_quant" name="product_quant" type="number"><br>

                        <label for="product_disc">Discounted price</label><br>
                        <input id="product_disc" name="product_disc" type="number"><br><br>

                        <button type="submit">Submit</button>

                    </form>

                </div>
            </div>

            <div class="post-product-box">
                <div class="box-title">

                    <div class="svg-box">
                        <svg height="10" width="10" class"trianglero">
                            <polygon points="0,0 0,10 8,5" style="fill:black;stroke:black;stroke-width:1" />
                        </svg>
                    </div>

                    <h3>post products</h3>

                </div>

                <div class="profile-edit-link">
            
                    <form action="https://shopmatrix54.com/services/#bulk-post-form" id="bulk-post-form" enctype="multipart/form-data" method="post">
                        <p>
                            <label for="my_upload">Select csv file to upload:</label>
                            <br>
                            <input id="my_upload" name="my_upload" type="file">
                        </p>
                        <input type="submit" value="Upload Now" accept="csv">
                    </form>
                   
                </div>
            </div>

            ';
                     
        endwhile; wp_reset_query();  

        /*----------
        Post product
        ----------*/

        if(isset($_GET['product_name'])){

            $product_nmae = $_GET['product_name'];

            if(isset($_GET['product_description'])){

                $product_description = $_GET['product_description'];
            }else {
                $product_description = '';
            }

            if(isset($_GET['product_price'])){

                $product_price = $_GET['product_price'];
            }else {
                $product_price = 0;
            }

            if(isset($_GET['product_avail'])){

                $product_avail = $_GET['product_avail'];
            }else {
                $product_avail = 0;
            }

            if(isset($_GET['product_quant'])){

                $product_quant = $_GET['product_quant'];
            }else {
                $product_quant = 0;
            }

            if(isset($_GET['product_disc'])){

                $product_disc = $_GET['product_disc'];
            }else {
                $product_disc = 0;
            }

            $product_args = [
                'post_title' => $product_nmae,
                'post_content' => $product_description,
                'post_author' => get_current_user_id(),
                'post_type' => 'products',
                'post_status' => 'publish',
            ];

            $product_id = wp_insert_post( $product_args);   
            
            if(isset($data[2])){update_field('price', $product_price, $product_id);}
            if(isset($data[3])){update_field('availability', $product_avail, $product_id);}
            if(isset($data[4])){update_field('offeramount', $product_quant, $product_id);}
            if(isset($data[5])){update_field('offerprice', $product_disc, $product_id);}
            
        }

        /*--------------------------------
        Making content of rows in csv file 
        --------------------------------*/

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['my_upload'])) 
        {
            if (is_uploaded_file($_FILES['my_upload']['tmp_name'])) 
            { 
                //First, Validate the file name

                if(empty($_FILES['my_upload']['name']))
                {
                    echo "<p>File name is empty!</p>";
                    exit;
                }

                $upload_file_name = $_FILES['my_upload']['name'];

                //Too long file name?

                if(strlen ($upload_file_name)>100)
                {
                    echo "<p>too long file name</p>";
                    exit;
                }

                //replace any non-alpha-numeric cracters in th file name

                $upload_file_name = preg_replace("/[^A-Za-z0-9 \.\-_]/", '', $upload_file_name);

                //set a limit to the file upload size

                if ($_FILES['my_upload']['size'] > 1000) 
                {
                    echo "<p>too big file</p>";
                    exit;        
                }

                //Save the file

                $dest=__DIR__.'/uploads/'.$upload_file_name;
                if (move_uploaded_file($_FILES['my_upload']['tmp_name'], $dest)) 
                {
                    //echo '<p>File Has Been Uploaded !</p>';

                    $open = fopen( __DIR__ ."/uploads/". $upload_file_name , "r");

                    $data = fgetcsv($open, 1000, ",");

                    //filling post-fiels with values in column
                    
                    while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
                    {
                        $new_post = [
                            'post_title' => $data[0],
                            'post_content' => $data[1],
                            'post_author' => get_current_user_id(),
                            'post_type' => 'products',
                            'post_status' => 'publish',
                        ];

                        $post_id = wp_insert_post( $new_post);   
                        
                        if(isset($data[2])){update_field('price', $data[2], $post_id);}
                        if(isset($data[3])){update_field('availability', $data[3], $post_id);}
                        if(isset($data[4])){update_field('offeramount', $data[4], $post_id);}
                        if(isset($data[5])){update_field('offerprice', $data[5], $post_id);}
                        
                    }
                    
                    fclose($open);

                } else {

                    echo '<p>something is wrong</p>';
                }

                //delete csv-file from uploades

                unlink(__DIR__.'/uploads/'.$upload_file_name);
            }
        }


        
    }

}