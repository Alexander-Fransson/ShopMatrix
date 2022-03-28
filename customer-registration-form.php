<?php

namespace Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if( ! defined( 'ABSPATH' ) ) exit();

class CustomerRegistrationForm extends Widget_Base{

    /*-----------------------
    Obligatory charaktristiks
    -----------------------*/

    public function get_name() {
        return  'customer-registration-form';
    }

    public function get_title() {
        return esc_html__( 'Customer Registration Form', 'customer-registration-form' );
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

        //getting value of element

        function get_searched_string($the_string){

            if(empty($_GET[$the_string])){

                return '';
            }
            else{
                return  $_GET[$the_string];
            }
        }

        if(!isset($_POST['submit-customer-post']))
        {
            ?>

                <form action="https://shopmatrix54.com/become-customer/" method="post" id="customer-registration-form" >

                    <label for="company-name">company name:</label>
                    <input type="text" id="company-name" name="companyname">

                    <label for="company-email">company email:</label>
                    <input type="email" id="companyemail" name="companyemail">

                    <label for="company-phone">company phone number:</label>
                    <input type="number" id="companyphone" name="companyphone">

                    <input type="submit" name="submit-customer-post" id="submit-customer-post" value="submit">

                </form>

            <?php
        }

        if(isset($_POST['submit-customer-post']))
        {

            //creating a post with the variables

            $new_post = [
                'post_title' => $_POST['companyname'],
                'post_author' => get_current_user_id(),
                'post_type' => 'customers',
                'post_status' => 'publish',
            ];

            $post_id = wp_insert_post( $new_post);   
            
            update_field('email', $_POST['companyemail'] , $post_id);
            update_field('phonenumber', $_POST['companyphone'] , $post_id);
            update_field("remainingtransaktions", 1, $post_id);

            $wp_user_object = new \WP_User(get_current_user_id());

            $current_user = wp_get_current_user(); 
            $role = (array) $current_user->roles ;

            try {
                //code...
                if(isset($role[1])){

                    if($role[1] != 'administrator' || $role[1] != 'customer'){
                        $wp_user_object->set_role('customer');
                    }
                }

            } catch (\Throwable $th) {
                //throw $th;

                echo(json_encode($role));
            }
            
            mail("shopmatrix54@gmail.com", "Check out my POST", "The post " . $_POST['companyname'] . " now exists. \n \n Set its ESG score!");

            ?>
            
           <form action="https://shopmatrix54.com/services/">
               <input id="to-services-we-go" type="submit" value="go to services">
           </form>
            <?php

        }

    }

}
