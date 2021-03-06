<?php
/**
 * Template for displaying post featured image.
 */
global $post, $kt_feat_width;
$swidth = get_post_meta( $post->ID, '_kad_posthead_width', true );
$height = get_post_meta( $post->ID, '_kad_gallery_posthead_height', true );
	if (!empty($swidth)) {
		$slidewidth = $swidth;
	} else {
		$slidewidth = apply_filters('pinnacle_defualt_posthead_width', $kt_feat_width);
	} 
	if (!empty($height)) {
		$slideheight = $height; 
	} else {
		$slideheight = apply_filters('pinnacle_defualt_posthead_height', 400);
	}
	?>
 <section class="postfeat carousel_outerrim loading">
            <div id="post-carousel-gallery" class="fredcarousel fadein-carousel" style="overflow:hidden; height: <?php echo esc_attr($slideheight);?>px">
                <div class="gallery-carousel kad-light-wp-gallery initimagecarousel" data-carousel-container="#post-carousel-gallery" data-carousel-transition="300" data-carousel-height="<?php echo esc_attr($slideheight);?>" data-carousel-auto="true" data-carousel-speed="7000" data-carousel-id="postimgcarousel_<?php echo esc_attr($post->ID);?>">
                  <?php
                      $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
                          if(!empty($image_gallery)) {
                            $attachments = array_filter( explode( ',', $image_gallery ) );
                              if ($attachments) {
                                foreach ($attachments as $attachment) {
                                      $attachment_url = wp_get_attachment_url($attachment , 'full');
                                $image = aq_resize($attachment_url, null, $slideheight, false, false);
                                  if(empty($image)) {
                                    $image = array();
                                    $image[0] = $attachment_url;
                                    $image[1] = 400;
                                    $image[2] = $slideheight;
                                  }
                                  echo '<div class="carousel_gallery_item" style="float:left; margin: 0 5px; width:'.esc_attr($image[1]).'px; height:'.esc_attr($image[2]).'px;">';
                                  echo '<a href="'.esc_url($attachment_url).'" data-rel="lightbox">';
                                  echo '<img src="'.esc_url($image[0]).'" width="'.esc_attr($image[1]).'" height="'.esc_attr($image[2]).'" itemprop="image" alt="'.esc_attr(get_post_field('post_excerpt', $attachment)).'"/></a></div>';
                                }
                              }
                          }?>   
            </div> <!--post gallery carousel-->
            <div class="clearfix"></div>
              <a id="prevport-postimgcarousel_<?php echo esc_attr($post->ID);?>" class="prev_carousel kt-icon-arrow-left" href="#"></a>
              <a id="nextport-postimgcarousel_<?php echo esc_attr($post->ID);?>" class="next_carousel kt-icon-arrow-right" href="#"></a>
          </div> <!--fredcarousel-->
        </section>