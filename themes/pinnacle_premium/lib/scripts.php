<?php
/**
 * Enqueue scripts and stylesheets
 *
 */

function kadence_scripts() {
  wp_enqueue_style('pinnacle_theme', get_template_directory_uri() . '/assets/css/pinnacle.css', false, '164');
  global $pinnacle; if(isset($pinnacle['skin_stylesheet']) && !empty($pinnacle['skin_stylesheet'])) {$skin = $pinnacle['skin_stylesheet'];} else { $skin = 'default.css';} 
 wp_enqueue_style('pinnacle_skin', get_template_directory_uri() . '/assets/css/skins/'.$skin.'', false, null);

if (is_child_theme()) {
   wp_enqueue_style('pinnacle_child', get_stylesheet_uri(), false, null);
  } 
  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
  wp_register_script('modernizr', get_template_directory_uri() . '/assets/js/vendor/modernizr-2.7.0.min.js', false, null, false);
  wp_register_script('pinnacle_plugins', get_template_directory_uri() . '/assets/js/min/kt_plugins.min.js', false, '164', true);
  wp_register_script('pinnacle_main', get_template_directory_uri() . '/assets/js/kt_main.js', false, '164', true);
  wp_enqueue_script('jquery');
  wp_enqueue_script('modernizr');
  wp_enqueue_script('pinnacle_plugins');
  if(isset($pinnacle["smooth_scrolling"]) && $pinnacle["smooth_scrolling"] == '1') { 
     wp_register_script('pinnacle_smoothscroll', get_template_directory_uri() . '/assets/js/min/nicescroll-min.js', false, null, true);
     wp_enqueue_script('pinnacle_smoothscroll');
  } else if(isset($pinnacle["smooth_scrolling"]) && $pinnacle["smooth_scrolling"] == '2') { 
    wp_register_script('pinnacle_smoothscroll', get_template_directory_uri() . '/assets/js/min/smoothscroll-min.js', false, null, true);
    wp_enqueue_script('pinnacle_smoothscroll');
  }
  wp_enqueue_script('pinnacle_main');

  if((isset($pinnacle['infinitescroll']) && $pinnacle['infinitescroll'] == 1) || (isset($pinnacle['blog_infinitescroll']) && $pinnacle['blog_infinitescroll'] == 1) || (isset($pinnacle['blog_cat_infinitescroll']) && $pinnacle['blog_cat_infinitescroll'] == 1)) {
    wp_register_script('infinite_scroll', get_template_directory_uri() . '/assets/js/min/jquery.infinitescroll.min.js', false, null, true);
    wp_enqueue_script('infinite_scroll');
  }

  if(class_exists('woocommerce')) {
    if(isset($pinnacle['product_radio']) && $pinnacle['product_radio'] == 1) {
      wp_deregister_script('wc-add-to-cart-variation');
      wp_register_script( 'wc-add-to-cart-variation', get_template_directory_uri() . '/assets/js/min/add-to-cart-variation-radio.min.js' , array( 'jquery' ), false, '163', true );
       wp_localize_script( 'wc-add-to-cart-variation', 'wc_add_to_cart_variation_params', apply_filters( 'wc_add_to_cart_variation_params', array(
        'i18n_no_matching_variations_text' => esc_attr__( 'Sorry, no products matched your selection. Please choose a different combination.', 'woocommerce' ),
        'i18n_unavailable_text'            => esc_attr__( 'Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce' ),
        ) ) );
      wp_enqueue_script( 'wc-add-to-cart-variation');
    } else {
      wp_register_script( 'kt-wc-add-to-cart-variation', get_template_directory_uri() . '/assets/js/min/kt-add-to-cart-variation-min.js' , array( 'jquery' ), false, '162', true );
      wp_enqueue_script( 'kt-wc-add-to-cart-variation');
    }

  if(isset($pinnacle['product_quantity_input']) && $pinnacle['product_quantity_input'] == 1) {
      function kt_get_wc_version() {return defined( 'WC_VERSION' ) && WC_VERSION ? WC_VERSION : null;}
      function kt_is_wc_version_gte_2_3() {return kt_get_wc_version() && version_compare(kt_get_wc_version(), '2.3', '>=' );}
      if (kt_is_wc_version_gte_2_3() ) {
        wp_register_script( 'wcqi-js', get_template_directory_uri() . '/assets/js/min/wc-quantity-increment.min.js' , array( 'jquery' ), false, '122', true );
        wp_enqueue_script( 'wcqi-js' );
      }
    }
  }

}
add_action('wp_enqueue_scripts', 'kadence_scripts', 100);


/**
 * Add Respond.js for IE8 support of media queries
 */
function pinnacle_ie_support_header() {
    echo '<!--[if lt IE 9]>'. "\n";
    echo '<script src="' . esc_url( get_template_directory_uri() . '/assets/js/vendor/respond.min.js' ) . '"></script>'. "\n";
    echo '<![endif]-->'. "\n";
}
add_action( 'wp_head', 'pinnacle_ie_support_header', 15 );


function kadence_google_analytics() { 
  global $pinnacle; 
  if(isset($pinnacle['google_analytics']) && !empty($pinnacle['google_analytics'])) { ?>
    <!-- Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', '<?php echo $pinnacle['google_analytics']; ?>', 'auto');
ga('send', 'pageview');
</script>
<!-- End Google Analytics -->
  <?php
  }
}
add_action('wp_head', 'kadence_google_analytics', 20);