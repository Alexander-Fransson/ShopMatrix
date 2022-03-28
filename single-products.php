<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Astra
 * @since 1.0.0
*/

acf_form_head();
?>

<style>
	#product-display{
		display: flex;
		flex-direction: row;
		width: 100%;
		justify-content: center;
	}
	#right-side-container{
		display: flex;
		flex-direction: column;
		margin-left: 50px;
		width:300px;
		align-items: start;
	}
	button, input[type="button"]{
		color: rgb(50, 50, 50);
		border-color: lightgrey;
		border-width: 1px;
	}
	button:hover, input[type="button"]:hover{
		background-color: rgb(15, 117, 15);
	}

	@media (max-width:900){

        #product-display{
			flex-direction: column;
		}
    }

</style>

<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
get_header(); 

$the_Price = get_field('price'); 
$the_Availability = get_field('availability'); 
$the_EditThumbnail = get_field('_thumbnail_id'); 
$the_offer = get_field('offeramount') . " for " . get_field('offerprice') . "kr";


if ( astra_page_layout() == 'left-sidebar' ) : 

	 get_sidebar(); 

endif; 

?>

<div id="primary" <?php astra_primary_class(); ?>>

	<?php
	if(have_posts()):
		while ( have_posts()):	the_post();?>

			<div id ="product-display">

				<div id="left-side-container">
					<p><?php the_post_thumbnail('medium');?></p>
				</div>

				<div id="right-side-container">

					<H4><?php the_title();?></H4>

					<div class="lower-block" id="Price"> 
						<?php if($the_Price): ?>
							<H1> <?php echo $the_Price . " kr"; ?></H1>
						<?php endif; ?>
					</div>

					<div class="lower-block">
						<h6><?php the_content();?></h6>
					</div>

					<div class="lower-block" id="Availability"> 
						<?php if($the_Availability): ?>
							<H5> <?php echo $the_Availability . " In Stock Now!"; ?></H5>
						<?php endif; ?>
					</div>

					<div class="lower-block" id="offer"> 
						<?php if(get_field('offeramount')): ?>
							<H5> <?php echo $the_offer; ?></H5>
						<?php endif; ?>
					</div>

				</div>

			</div>

			<?php
			if(get_current_user_id() == get_the_author_meta('ID') || get_current_user_id() == 1):

				echo '<h4> Settings </h4>';

				acf_form([
					'post_title' => true,
					'post_content' => true,
					'field_groups' => ['group_6184212a823ed'],
				]);

				echo '<h4> Offers </h4>';

				acf_form([
					'field_groups' => ['group_61cda8ea3d9fc'],
				]);
			endif;

		endwhile;
	endif;
	?>

	<!-- astra_primary_content_bottom(); --> 

</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>