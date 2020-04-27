<?php
if (! function_exists('wp_cpm_custom_slider')) {
	function wp_cpm_custom_slider() {
        $pasal_ecommerce_settings = pasal_ecommerce_get_theme_options();

            $get_featured_posts = new WP_Query(array('posts_per_page' => 5, 'post_type' => 'slider', 'orderby' => 'date',));

				echo '<div class="main-slider clearfix"> <div class="layer-slider">';

					$i=0;
				while ($get_featured_posts->have_posts()):$get_featured_posts->the_post();
				global $post;

			     $slider_btntxt = get_post_meta($post->ID,'wp_custom_post_slider_btntxt', true);
			     $slider_btnlnk = get_post_meta($post->ID,'wp_custom_post_slider_link', true);

				$attachment_id = get_post_thumbnail_id();
			if(!empty($attachment_id)){
				$image_attributes = wp_get_attachment_image_src($attachment_id,'full'); }
							$i++;
							$title_attribute       	 	 = apply_filters('the_title', get_the_title($post->ID));
							$excerpt               	 	 = substr(get_the_excerpt(), 0 , 160);
							if (1 == $i) {$classes   	 = "slides show-display";} else { $classes = "slides hide-display";}
					?>
					<div class="<?php echo esc_attr($classes); ?>">
						<div class="image-slider clearfix" title="<?php the_title('', '', false); ?>" style="background-image:url(<?php echo esc_url($image_attributes[0]); ?>)">
							<article class="slider-content clearfix">
					<?php

						if ($title_attribute != '') {
							echo '<h2 class="slider-title"><a href="'.esc_url(get_permalink()).'" title="'.the_title('', '', false).'" rel="bookmark">'.esc_html(get_the_title()).'</a></h2><!-- .slider-title -->';
						}

						if ($excerpt != '') {
							echo '<div class="slider-text">';
							echo '<p>'.esc_html($excerpt).' </p></div><!-- end .slider-text -->';
						}
						if (($slider_btntxt && $slider_btnlnk) != '') {
						echo '<div class="slider-buttons">';
						echo '<a title='.'"'.esc_html(get_the_title()). '"'. ' '.'href="'.esc_url($slider_btnlnk).'"'.' class="btn-default">'.esc_html__($slider_btntxt, 'pasal-ecommerce').'</a>';
						echo '</div><!-- end .slider-buttons -->';}
						echo '</article><!-- end .slider-content --> ';
					// if ($image_attributes) {
						echo '</div><!-- end .image-slider -->';
					// }
					echo '</div><!-- end .slides -->';
				endwhile;

				wp_reset_postdata();
				echo '</div>	  <!-- end .layer-slider -->
						<a class="slider-prev" id="prev2" href="#"><i class="fa fa-angle-left"></i></a> <a class="slider-next" id="next2" href="#"><i class="fa fa-angle-right"></i></a>
	  					<nav class="slider-button"> </nav> <!-- end .slider-button -->
					</div> <!-- end .main-slider -->';




	}
}

if (!function_exists('wp_custom_post_slider_content')) {
function wp_custom_post_slider_content($atts = null){
     extract(shortcode_atts( array(
                'cat' => '',
                ), $atts )
        );

   $cat    = (!empty($cat)? $cat :'');


         if($cat != ''){
         $slider_arg = array(
                        'post_type' => 'slider',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'orderby' => 'menu_order date',
                        'order' => 'desc',
                         'tax_query' => array(
                                array(
                            'taxonomy' => 'slider_category',
                            'field' => 'term_id',
                            'terms' => $cat,
                            )
                        )
                    );}
                    else{
                       $slider_arg = array(
                        'post_type' => 'slider',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'orderby' => 'menu_order date',
                        'order' => 'desc',
                      );
                    } ?>

                <?php

            $slider_query = new WP_Query($slider_arg);

            ob_start();
            if ($slider_query->have_posts()):?>
             <div class="banner-wrapper">
            	<div class="row">
            		<div class="banner-slider"> <?php

                     while ($slider_query->have_posts()) : $slider_query->the_post();
                        global $post;
                     $slider_btntxt_one = get_post_meta($post->ID,'wp_custom_post_slider_btntxt', true);
			    	 $slider_btnlnk_one = get_post_meta($post->ID,'wp_custom_post_slider_link', true);

                        $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                        $url = $image_src[0];
                        if (!empty($image_src)) {
                            $image_style = "style='background-image:url(" . esc_url($url) . ")'"; ?>
                        <?php } else {
                            $image_style = "";
                        }
                        // $excerpt                     = substr(get_the_excerpt(), 0 , 160);
                        ?>
                    <div class="slider-item slider1" <?php echo wp_kses_post($image_style); ?>">
                        <div class="container">
                            <div class="banner-text-wrap">
                                <h2><?php the_title(); ?></h2>
                                <p><?php echo get_the_content(); ?></p>
                                 <?php if ($slider_btntxt_one): ?>
                                <a href="<?php echo esc_url($slider_btnlnk_one); ?>" class="btn btn-default"><?php echo esc_html($slider_btntxt_one) ?></a> <?php endif; ?>

                            </div>
                        </div>
                    </div>

                    <?php
                endwhile;
                    wp_reset_postdata();  ?>
                      </div>
            			</div>

                  </div>
   			<?php endif;
           			 wp_reset_query();
        			$output = ob_get_clean();
       				 return $output;


    }
    add_shortcode( 'slider', 'wp_custom_post_slider_content' );
    }


    if (!function_exists('wp_custom_post_testimonial_content')) {
	function wp_custom_post_testimonial_content($atts = null){
    extract(shortcode_atts( array(
                'posts_per_page' => '',
                'column'    => '',
                'cat'       => '',
                ), $atts )
        );
        $cat    = (!empty($cat)? $cat :'');
           $no_of_post    = (!empty($posts_per_page)? $posts_per_page :3);
           $no_of_column    = (!empty($column)? $column :3);

             if($no_of_column == 1){
            $column_class = 'one-testimonial';
           }elseif ($no_of_column == 2) {
             $column_class = 'two-testimonial';
           }elseif ($no_of_column == 3) {
             $column_class = 'three-testimonial';
           }
           else  {
             $column_class = 'three-testimonial';
         }
         if($cat != ''){
      $testimonial_arg = array(
                        'post_type' => 'testimonial',
                        'posts_per_page' => $no_of_post,
                        'post_status' => 'publish',
                        'orderby' => 'menu_order date',
                        'order' => 'desc',
                         'tax_query' => array(
                                array(
                            'taxonomy' => 'testimonial_category',
                            'field' => 'term_id',
                            'terms' => $cat,
                            )
                        )
                    );}
                    else{
                       $testimonial_arg = array(
                        'post_type' => 'slider',
                        'posts_per_page' => $no_of_post,
                        'post_status' => 'publish',
                        'orderby' => 'menu_order date',
                        'order' => 'desc',
                      );
                    }
    $testimonial_query = new WP_Query($testimonial_arg);
    ob_start();
	if ($testimonial_query->have_posts()):?>
  <div class="container">
      <div class="row">
          <div class="col-md-12">
              <div id="testimonial-slider" class="owl-carousel <?php echo $column_class ?>">

                      <?php while ($testimonial_query->have_posts()) : $testimonial_query->the_post();
                      global $post;
                       $testimonial_name = get_post_meta($post->ID,'wp_custom_post_testimonial_name', true);
  			    	 $testimonial_desig = get_post_meta($post->ID,'wp_custom_post_testimonial_designation', true);

                          $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'testimonial-image');
                          $url = $image_src[0];
                          if (!empty($image_src)) {
                              $image_style = esc_url($url) ?>
                          <?php } else {
                              $image_style = "";
                          }
                           $title_attribute     = the_title_attribute( 'echo=0' );
                    $thumbnail_id            = get_post_thumbnail_id( get_the_ID() );
                    $img_meta            = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
                    $img_alt             = ! empty( $img_meta ) ? $img_meta : $title_attribute;
                          $excerpt = substr(get_the_excerpt(), 0 , 200);?>
                  <div class="testimonial">

                      <div class="testimonial-content">
                          <p class="description">
                              <?php the_excerpt(); ?>
                          </p>
                          <h3 class="testimonial-title"><?php the_title(); ?></h3>

                          <?php if ($testimonial_desig): ?>
                          <small class="post"><?php echo esc_html($testimonial_desig) ?></small>
                      <?php endif; ?>
                      </div>
                      <div class="pic">
                          <img src="<?php echo wp_kses_post($image_style); ?>" alt="<?php echo esc_attr($img_alt); ?>">
                      </div>
                  </div>
                  <?php   endwhile;
                      wp_reset_postdata(); ?>
              </div>
          </div>
      </div>
  </div>
<?php
	 endif;
		wp_reset_query();
		$output = ob_get_clean();
		return $output;
}
add_shortcode( 'testimonial', 'wp_custom_post_testimonial_content' );
}

if (!function_exists('wp_custom_post_callout_section')) {
	function wp_custom_post_callout_section($atts = null){
     extract(shortcode_atts( array(
                'posts_per_page' => '',
                'column'    => '',
                'cat'       => '',
                ), $atts )
        );
     $cat    = (!empty($cat)? $cat :'');
           $no_of_post    = (!empty($posts_per_page)? $posts_per_page :3);
           $no_of_column    = (!empty($column)? $column :'col-md-4 col-sm-6');

           if($no_of_column == 2){
            $column_class = 'col-md-6 col-sm-6';
           }elseif ($no_of_column == 3) {
             $column_class = 'col-md-4 col-sm-6';
           }elseif ($no_of_column == 4) {
             $column_class = 'col-md-3 col-sm-6';
           }
           elseif ($no_of_column == 'col-md-4 col-sm-6') {
             $column_class = 'col-md-4 col-sm-6';
         }

    if($cat != ''){
    $callout_arg = array(
                'post_type' => 'callout',
                'posts_per_page' => $no_of_post,
                'post_status' => 'publish',
                'orderby' => 'menu_order date',
                'order' => 'desc',
                'tax_query' => array(
                            array(
                            'taxonomy' => 'callout_category',
                            'field' => 'term_taxonomy_id',
                            'terms' => $cat,
                            )
                        )
            ); }else{
         $callout_arg = array(
                'post_type' => 'callout',
                'posts_per_page' => $no_of_post,
                'post_status' => 'publish',
                'orderby' => 'menu_order date',
                'order' => 'desc',
            );
    }
    $callout_query = new WP_Query($callout_arg);
    ob_start();
 if ($callout_query->have_posts()):?>
<div class="element-margin">
<div class="container">
    <div class="row">

                    <?php while ($callout_query->have_posts()) : $callout_query->the_post();
                    global $post;
                     $callout_icon = get_post_meta($post->ID,'wp_custom_post_callout_icon', true);

                     $excerpt = substr(get_the_excerpt(), 0 , 100);
                          ?>
        <div class="<?php echo esc_attr($column_class); ?>">
            <div class="serviceBox service-layout2">
                <div class="service-icon">
                      <?php if ($callout_icon):
                  echo   '<i class="'.$callout_icon.'"></i>';
                    endif ; ?>
                </div>
                <a href="<?php the_permalink();?>"><h3 class="title"><?php the_title(); ?></h3> </a>
                <p class="description">
                    <?php echo esc_attr($excerpt); ?>
                </p>
            </div>
        </div>
        <?php   endwhile;
        wp_reset_postdata(); ?>



    </div>
</div>
</div>
	<?php
     endif;
        wp_reset_query();
        $output = ob_get_clean();
        return $output;
}
add_shortcode( 'callout', 'wp_custom_post_callout_section' );
}

if (!function_exists('wp_custom_post_clients_section')) {
    function wp_custom_post_clients_section($atts = null){
        extract(shortcode_atts( array(
                'posts_per_page' => '',
                'cat'            => '',
                ), $atts )
        );
         $cat    = (!empty($cat)? $cat :'');
         $clint_count    = (!empty($posts_per_page)? $posts_per_page :5);
         if($cat != ''){
         $client_arg = array(
                        'post_type' => 'client',
                        'posts_per_page' => $clint_count,
                        'post_status' => 'publish',
                        'orderby' => 'menu_order date',
                        'order' => 'desc',
                         'tax_query' => array(
                                array(
                            'taxonomy' => 'client_category',
                            'field' => 'term_id',
                            'terms' => $cat,
                            )
                        )
                    );}
                    else{
                       $client_arg = array(
                        'post_type' => 'client',
                        'posts_per_page' => $clint_count,
                        'post_status' => 'publish',
                        'orderby' => 'menu_order date',
                        'order' => 'desc',
                      );
                    }
    $clint_query = new WP_Query($client_arg);
    ob_start();
   if ($clint_query->have_posts()):?>
     <div class="element-margin">
    <div class="container">
        <div class="row">
            <div class="client-slider">


                    <?php while ($clint_query->have_posts()) : $clint_query->the_post();
                     $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                        $url = $image_src[0];
                        if (!empty($image_src)) {
                            $image_style = esc_url($url) ?>
                        <?php } else {
                            $image_style = "";
                        }
                      $title_attribute     = the_title_attribute( 'echo=0' );
                      $thumbnail_id            = get_post_thumbnail_id( get_the_ID() );
                      $img_meta            = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
                      $img_alt             = ! empty( $img_meta ) ? $img_meta : $title_attribute; ?>
            <div class="client-item">
                <img src="<?php echo wp_kses_post($image_style); ?>" alt="<?php echo esc_attr($img_alt); ?>">
            </div>
            <?php   endwhile;
            wp_reset_postdata(); ?>
        </div>
    </div>
</div>
</div>
<?php
     endif;
        wp_reset_query();
        $output = ob_get_clean();
        return $output;
}
add_shortcode( 'client', 'wp_custom_post_clients_section' );
}

if (!function_exists('wp_custom_post_portfolio_section')) {
    function wp_custom_post_portfolio_section($atts = null){
    extract(shortcode_atts( array(
                'posts_per_page' => '',
                'column'    => '',
                'cat'       => '',
                ), $atts )
        );
      $cat    = (!empty($cat)? $cat :'');
           $no_of_post    = (!empty($posts_per_page)? $posts_per_page :3);
           $no_of_column    = (!empty($column)? $column : 3);

           if($no_of_column == 2){
            $column_class = 'col-md-6 col-sm-6';

           }elseif ($no_of_column == 3 || $no_of_column == '') {
             $column_class = 'col-md-4 col-sm-6';

           }elseif ($no_of_column == 4) {
             $column_class = 'col-md-3 col-sm-6';

           }elseif ($no_of_column == '1') {
             $column_class = 'col-md-12 col-sm-6';

         }else{
            $no_of_column == 3;
            $column_class = 'col-md-4 col-sm-6';
         }


     if($cat != ''){
     $portfolio_arg = array(
                'post_type' => 'portfolio',
                'posts_per_page' => $no_of_post,
                'post_status' => 'publish',
                'orderby' => 'menu_order date',
                'order' => 'desc',
                 'tax_query' => array(
                            array(
                            'taxonomy' => 'portfolio_category',
                            'field' => 'term_id',
                            'terms' => $cat,
                            )
                        )
                ); }else{
            $portfolio_arg = array(
                'post_type' => 'portfolio',
                'posts_per_page' => $no_of_post,
                'post_status' => 'publish',
                'orderby' => 'menu_order date',
                'order' => 'desc',
            );

     }
      $loop = 1;
    $portfolio_query = new WP_Query($portfolio_arg);
    ob_start();
   if ($portfolio_query->have_posts()):?>
     <div class="element-margin">
<div class="container">

        <?php while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
         global $post;
         $categories = get_the_terms( $post->ID, 'portfolio_category' );
               $cat_slug = !empty($categories[0]->name)? $categories[0]->name :'';

                     $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'portfolio-image');
                        $url = $image_src[0];
                        if (!empty($image_src)) {
                            $image_style = esc_url($url) ?>
                        <?php } else {
                            $image_style = "";
                        }
                    $title_attribute     = the_title_attribute( 'echo=0' );
                  $thumbnail_id            = get_post_thumbnail_id( get_the_ID() );
                  $img_meta            = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
                  $img_alt             = ! empty( $img_meta ) ? $img_meta : $title_attribute;
        echo(($loop % $no_of_column == 1 || $loop == 1) ? '<div class="row">' : '');?>
        <?php do_action('wp_custom_post_portfolio_before_container_list'); ?>
        <div class="<?php echo esc_attr($column_class); ?>">
        <?php do_action('wp_custom_post_portfolio_before_box_list'); ?>
            <div class="box">
                <?php do_action('wp_custom_post_portfolio_before_image_list'); ?>
                <img src="<?php echo wp_kses_post($image_style); ?>" alt="<?php echo esc_attr($img_alt); ?>">
                <?php do_action('wp_custom_post_portfolio_after_image_list'); ?>
                <div class="box-content">
                <?php do_action('wp_custom_post_portfolio_before_title_list'); ?>
                   <a href="<?php the_permalink();?>"> <h3 class="title"><?php the_title(); ?></h3> </a>
                <?php do_action('wp_custom_post_portfolio_before_after_list'); ?>
                      <?php if ( ! empty( $categories ) ): ?>
                    <span class="post"><?php echo esc_html($cat_slug) ?></span> <?php endif; ?>
                <?php do_action('wp_custom_post_portfolio_after_category_list'); ?>

                </div>
                <?php do_action('wp_custom_post_portfolio_after_box_list'); ?>
            </div>
            <?php do_action('wp_custom_post_portfolio_after_container_list'); ?>
        </div><?php
        echo(($loop % $no_of_column == 0 && $loop != 1) ? '</div>' : '');
                        $loop++;
        endwhile;
          wp_reset_postdata();
           // echo((($loop - 1) % 3 != 0) ? '</div>' : '');
        ?>
    </div>
</div>
<?php
  endif;
        wp_reset_query();
        $output = ob_get_clean();
        return $output;
}
add_shortcode( 'portfolio', 'wp_custom_post_portfolio_section' );
}

// for team
if (!function_exists('wp_custom_post_team_section')) {
    function wp_custom_post_team_section($atts = null){
    extract(shortcode_atts( array(
                'posts_per_page' => '',
                'column'    => '',
                'cat'       => '',
                ), $atts )
        );
           $cat    = (!empty($cat)? $cat :'');
           $no_of_post    = (!empty($posts_per_page)? $posts_per_page :3);
           $no_of_column    = (!empty($column)? $column :'col-md-4 col-sm-6');

           if($no_of_column == 2){
            $column_class = 'col-md-6 col-sm-6';
           }elseif ($no_of_column == 3) {
             $column_class = 'col-md-4 col-sm-6';
           }elseif ($no_of_column == 4) {
             $column_class = 'col-md-3 col-sm-6';
           }elseif ($no_of_column == 'col-md-4 col-sm-6') {
             $column_class = 'col-md-4 col-sm-6';

         }


     if($cat != ''){
     $team_arg = array(
                'post_type' => 'team',
                'posts_per_page' => $no_of_post,
                'post_status' => 'publish',
                'orderby' => 'menu_order date',
                'order' => 'desc',
                'tax_query' => array(
                            array(
                            'taxonomy' => 'team_category',
                            'field' => 'term_id',
                            'terms' => $cat,
                            )
                        )
            ); }else{
            $team_arg = array(
                'post_type' => 'team',
                'posts_per_page' => $no_of_post,
                'post_status' => 'publish',
                'orderby' => 'menu_order date',
                'order' => 'desc',
            );
     }
    $team_query = new WP_Query($team_arg);
    ob_start();
   if ($team_query->have_posts()):?>
     <div class="element-margin">
<div class="container">
   <div class="row">
        <?php while ($team_query->have_posts()) : $team_query->the_post();
         global $post;
                     $team_name = get_post_meta($post->ID,'wp_custom_post_team_name', true);
                     $team_desig = get_post_meta($post->ID,'wp_custom_post_team_designation', true);
                     $facebook = get_post_meta($post->ID,'wp_custom_post_team_facebook', true);
                     $twitter = get_post_meta($post->ID,'wp_custom_post_team_twitter', true);
                     $linkedin = get_post_meta($post->ID,'wp_custom_post_team_linked', true);
                     $skype = get_post_meta($post->ID,'wp_custom_post_team_skype', true);
                     $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'team-image');
                        $url = $image_src[0];
                        if (!empty($image_src)) {
                            $image_style = esc_url($url) ?>
                        <?php } else {
                            $image_style = "";
                        }
                $title_attribute     = the_title_attribute( 'echo=0' );
                  $thumbnail_id            = get_post_thumbnail_id( get_the_ID() );
                  $img_meta            = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
                  $img_alt             = ! empty( $img_meta ) ? $img_meta : $title_attribute; ?>
        <div class="<?php echo esc_attr($column_class); ?>">
            <div class="our-team">
              <div class="team-img">
                    <img src="<?php echo wp_kses_post($image_style); ?>" alt="<?php echo esc_attr($img_alt); ?>">
                    <div class="social">
                        <ul><?php if ($facebook ): ?>
                            <li><a href="<?php echo esc_url($facebook ) ?>" class="fa fa-facebook"></a></li> <?php endif;
                            if ($twitter ): ?>
                            <li><a href="<?php echo esc_url($twitter ) ?>" class="fa fa-twitter"></a></li> <?php endif;
                             if ($linkedin ): ?>
                            <li><a href="<?php echo esc_url($linkedin ) ?>" class="fa fa-linkedin"></a></li> <?php endif;
                            if ($skype ): ?>
                            <li><a href="<?php echo esc_url($skype ) ?>" class="fa fa-skype"></a></li> <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="team-content">

                   <a href="<?php the_permalink();?>"> <h3 class="title"><?php the_title(); ?></h3> </a>
                      <?php if ($team_desig): ?>
                    <span class="post"><?php echo esc_html($team_desig) ?></span> <?php endif; ?>
                </div>
            </div>
        </div>

        <?php
        endwhile;
          wp_reset_postdata();
           // echo((($loop - 1) % 3 != 0) ? '</div>' : '');
        ?>
            </div>
    </div>
</div>
<?php
  endif;
        wp_reset_query();
        $output = ob_get_clean();
        return $output;
}
add_shortcode( 'team', 'wp_custom_post_team_section' );
}
