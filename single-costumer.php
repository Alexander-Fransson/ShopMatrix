<?php
/*Template Name: single costumer */

/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Astra
 * @since 1.0.0
*/

acf_form_head();

?><style>

    #fetured-logo{
        display: flex;
        justify-content: center;
        height:300px;
        object-fit: contain;
    }
	#page-title{
        display: flex;
        width: 100%;
        justify-content: center;
        margin-top: 40px;
    }
    #info-container{
        display:flex;
        flex-direction: row;
        justify-content: center;
        width: 100%;
    }
    .inner-info-container{
        display:flex;
        flex-direction: column;
        margin-top:10px;
    }
    #the-esg{
        padding-bottom: 30px;
    }
    #review-form{
        padding-top: 20px;
    }
    button, input[type="button"]{
        color: rgb(50, 50, 50);
        border-color: lightgrey;
        border-width: 1px;
    }
    button:hover, input[type="button"]:hover{
        background-color: rgb(15, 117, 15);
    }
    #midle-info{
        display: flex;
        height: 170px;
        width: 20%;
        justify-content: center;
        align-items: center;
    }
    #midle-info img{
        max-height: 100%;
        max-width: 100%;
    }

    @media(max-width: 1000px){
        #info-container{
            display:flex;
            width:100%;
            justify-content:center;
            align-items:center;
        }
        .inner-info-container{
            display:flex;
            margin-top:20px;
        }

    }

</style><?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
get_header(); 

$the_Price = get_field('price'); 
$the_address = get_field('shopaddress'); 
$the_url = get_field('shopurl'); 
$the_mail = get_field('email'); 
$the_number = get_field('phonenumber'); 
$the_suctrans = get_field('successfultransactions'); 
$the_remtrans = get_field('remainingtransaktions'); 
$the_esg = get_field('esgscore'); 
$the_usrev = get_field('userreviews'); 
$tumburl = get_the_post_thumbnail_url(get_the_ID());

if ( astra_page_layout() == 'left-sidebar' ) : 

	get_sidebar(); 

endif;

?><div id="primary" <?php astra_primary_class(); ?>>

	<?php

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

    if(isset($_GET['add-a-transaction']) && get_field('remainingtransaktions') > 0); 
    {
        $updated_transactions = get_field('successfultransactions') +1;
        $updated_purse = get_field('remainingtransaktions') -1;
        update_field('successfultransactions', $updated_transactions , get_the_ID());
        update_field('remainingtransaktions', $updated_purse , get_the_ID());
    }
    if(get_field('remainingtransaktions') < 0){

        update_field('remainingtransaktions', 0 , get_the_ID());
    }

	if(have_posts()): while (have_posts()): the_post();

        //updating amout of users that visited the page 
    
        ?><div id="info-container">

            <div id="midle-info"><?php

                if(isset($tumburl)){

                    echo'
                    
                    <img src="' . get_the_post_thumbnail_url(get_the_ID()) . '">
                    
                    ';
                }

            ?></div>

            <div id="left-info" class="inner-info-container"><?php

                if(isset($the_url)){

                    echo '

                    <a href="'. $the_url .'"> 
                        <p>'.$the_url.'</p>
                    </a>

                    ';
                }

                if(isset($the_esg)){

                    echo'

                    <h2 id="the-esg">ESG:'. esg_converter($the_esg) .'</h2>

                    ';
                }

                echo do_shortcode('[site_reviews_summary assigned_posts="'.get_the_ID().'" hide="bars"]');


            ?></div>

        </div><?php

        $settings = get_field('shopaddress');

        if(isset($the_address)){
        
            ?><div id="right-info" class="inner-info-container"><?php     
                
                if ( empty( $settings['address'] ) ) {
                    return;
                }

                if ( 0 === absint( $settings['zoom'] ) ) {
                    $settings['zoom'] = 10;
                }

                printf(
                    '<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=%s&amp;t=m&amp;z=%d&amp;output=embed&amp;iwloc=near"></iframe>',
                    urlencode( $settings['address'] ),
                    absint( $settings['zoom'])
                );  
                
            ?></div><?php

        }

        echo do_shortcode('[site_reviews_form assign_to="'.get_the_ID().'" id="review-form" hide="content,email,name,terms,title"]');

        
        if(get_current_user_id() == 1)
        {
            acf_form([
                'fields' => ['remainingtransaktions','_thumbnail_id','shopaddress','shopurl','email','phonenumber','esgscore'],
                'post_title' => true,
                'post_content' => true,
            ]);
        }
        
        else if(get_current_user_id() == get_the_author_meta('ID'))
        {
            acf_form([
                'fields' => ['remainingtransaktions','_thumbnail_id','shopaddress','shopurl','email','phonenumber'],
                'post_title' => true,
                'post_content' => false,
            ]);
        }


	endwhile;endif;?>

</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>