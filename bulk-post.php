<?php

namespace Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if( ! defined( 'ABSPATH' ) ) exit();

class BulkPost extends Widget_Base{

    /*-----------------------
    Obligatory charaktristiks
    -----------------------*/

    public function get_name() {
        return  'bulk-post';
    }

    public function get_title() {
        return esc_html__( 'Bulk Post', 'bulk-post' );
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
                'default' => 'Bulk Product Post'
            ]
            );

        $this->end_controls_section();
    }   

    /*--------------
    The Frontest end
    --------------*/

    protected function render(){


        ?>
            <H2>
                Bulk Submit
            </H2>
            
            <form action="https://shopmatrix54.com/services/#bulk-post-form" id="bulk-post-form" enctype="multipart/form-data" method="post">
	            <p>
	                <label for="my_upload">Select csv file to upload:</label>
	                <input id="my_upload" name="my_upload" type="file">
	            </p>
	            <input type="submit" value="Upload Now" accept="csv">
	        </form>


        <?php 

        /*--------------------------------
        Making content of rows in csv file 
        --------------------------------*/

        if ($_SERVER['REQUEST_METHOD'] == 'POST') 
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
                    echo '<p>File Has Been Uploaded !</p>';

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
                        
                        update_field('price', $data[2], $post_id);
                        update_field('availability', $data[3], $post_id);
                        
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
