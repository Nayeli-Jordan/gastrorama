<?php get_header(); 

global $post;
    $id = $post->ID;
     echo do_shortcode('[kadence_slider id="'.$id.'"]');
     
	get_footer(); ?>
            		