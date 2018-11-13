<?php
	// Loads child theme textdomain
	load_child_theme_textdomain( CURRENT_THEME, CHILD_DIR . '/languages' );

	// Loads custom scripts.
	// require_once( 'custom-js.php' );











add_filter( 'cherry_stickmenu_selector', 'cherry_change_selector' );
function cherry_change_selector($selector) {
	$selector = 'header.header .header_block';
	return $selector;
}











add_filter( 'cherry_slider_params', 'child_slider_params' );
function child_slider_params( $params ) {
    $params['minHeight'] = '"100px"';
    $params['height'] = '"43.24%"';
return $params;
}














/**
 * Service Box
 *
 */
if (!function_exists('service_box_shortcode')) {

	function service_box_shortcode( $atts, $content = null, $shortcodename = '' ) {
		extract(shortcode_atts(
			array(
				'title'        => '',
				'subtitle'     => '',
				'icon'         => '',
				'icon_link'    => '',
				'text'         => '',
				'btn_text'     => '',
				'btn_link'     => '',
				'btn_size'     => '',
				'target'       => '',
				'custom_class' => '',
		), $atts));

		$output =  '<div class="service-box '.$custom_class.'">';

		if($icon != 'no'){
			$icon_url = CHERRY_PLUGIN_URL . 'includes/images/' . strtolower($icon) . '.png' ;
			if( defined ('CHILD_DIR') ) {
				if(file_exists(CHILD_DIR.'/images/'.strtolower($icon).'.png')){
					$icon_url = CHILD_URL.'/images/'.strtolower($icon).'.png';
				}
			}
			if ( empty( $icon_link ) ) {
				$output .= '<figure class="icon"><img src="'.$icon_url.'" alt="" /></figure>';
			} else {
				$output .= '<figure class="icon"><a href="' . esc_url( $icon_link ) . '"><img src="' . $icon_url . '" alt="" /></a></figure>';
			}
		}

		$output .= '<div class="service-box_body">';

		if ($btn_link!="") {
			if ($title!="") {
				$output .= '<h2 class="title"><a href="'.$btn_link.'" target="'.$target.'">';
				$output .= $title;
				$output .= '</a></h2>';
			}
		} else {
			if ($title!="") {
				$output .= '<h2 class="title">';
				$output .= $title;
				$output .= '</h2>';
			}
		}

		if ($subtitle!="") {
			$output .= '<h5 class="sub-title">';
			$output .= $subtitle;
			$output .= '</h5>';
		}
		if ($text!="") {
			$output .= '<div class="service-box_txt">';
			$output .= $text;
			$output .= '</div>';
		}
		if ($btn_link!="" and $btn_text!="") {
			$output .=  '<div class="btn-align"><a href="'.$btn_link.'" title="'.$btn_text.'" class="btn btn-inverse btn-'.$btn_size.' btn-primary " target="'.$target.'">';
			$output .= $btn_text;
			$output .= '</a></div>';
		}
		$output .= '</div>';
		$output .= '</div><!-- /Service Box -->';

		$output = apply_filters( 'cherry_plugin_shortcode_output', $output, $atts, $shortcodename );

		return $output;
	}
	add_shortcode('service_box', 'service_box_shortcode');

}












/**
 * Banner
 *
 */
if ( !function_exists( 'banner_shortcode' ) ) {

	function banner_shortcode( $atts, $content = null, $shortcodename = '' ) {
		extract( shortcode_atts(
			array(
				'img'          => '',
				'banner_link'  => '',
				'title'        => '',
				'text'         => '',
				'btn_text'     => '',
				'target'       => '',
				'custom_class' => ''
		), $atts));

		// Get the URL to the content area.
		$content_url = untrailingslashit( content_url() );

		// Find latest '/' in content URL.
		$last_slash_pos = strrpos( $content_url, '/' );

		// 'wp-content' or something else.
		$content_dir_name = substr( $content_url, $last_slash_pos - strlen( $content_url ) + 1 );

		$pos = strpos( $img, $content_dir_name );

		if ( false !== $pos ) {

			$img_new = substr( $img, $pos + strlen( $content_dir_name ), strlen( $img ) - $pos );
			$img     = $content_url . $img_new;

		}

		$output =  '<div class="banner-wrap '.$custom_class.'">';
		if ($img !="") {
			$output .= '<figure class="featured-thumbnail">';
			if ($banner_link != "") {
				$output .= '<a href="'. $banner_link .'" title="'. $title .'"><img src="' . $img .'" title="'. $title .'" alt="" /></a>';
			} else {
				$output .= '<img src="' . $img .'" title="'. $title .'" alt="" />';
			}
			$output .= '</figure>';
		}

		$output .= '<div class="caption">';

		if ($title!="") {
			$output .= '<h5>';
			$output .= $title;
			$output .= '</h5>';
		}
		if ($text!="") {
			$output .= '<p>';
			$output .= $text;
			$output .= '</p>';
		}
		if ($btn_text!="") {
			$output .=  '<div class="link-align banner-btn"><a href="'.$banner_link.'" title="'.$btn_text.'" class="btn btn-link" target="'.$target.'">';
			$output .= $btn_text;
			$output .= '</a></div>';
		}

		$output .= '</div>';

		$output .= '</div><!-- .banner-wrap (end) -->';

		$output = apply_filters( 'cherry_plugin_shortcode_output', $output, $atts, $shortcodename );

		return $output;
	}
	add_shortcode('banner', 'banner_shortcode');

}
















/**
 * Carousel OWL
 */
if ( !function_exists('shortcode_carousel_owl') ) {
	function shortcode_carousel_owl( $atts, $content = null, $shortcodename = '' ) {
		wp_enqueue_script( 'owl-carousel', CHERRY_PLUGIN_URL . 'lib/js/owl-carousel/owl.carousel.min.js', array('jquery'), '1.31', true );

		extract( shortcode_atts( array(
			'title'              => '',
			'posts_count'        => 10,
			'post_type'          => 'blog',
			'post_status'        => 'publish',
			'visibility_items'   => 5,
			'thumb'              => 'yes',
			'thumb_width'        => 220,
			'thumb_height'       => 180,
			'more_text_single'   => '',
			'categories'         => '',
			'excerpt_count'      => 15,
			'date'               => 'yes',
			'author'             => 'yes',
			'comments'           => 'no',
			'auto_play'          => 0,
			'display_navs'       => 'yes',
			'display_pagination' => 'yes',
			'custom_class'       => ''
		), $atts ) );

		$random_ID          = uniqid();
		$posts_count        = intval( $posts_count );
		$thumb              = $thumb == 'yes' ? true : false;
		$thumb_width        = absint( $thumb_width );
		$thumb_height       = absint( $thumb_height );
		$excerpt_count      = absint( $excerpt_count );
		$visibility_items   = absint( $visibility_items );
		$auto_play          = absint( $auto_play );
		$date               = $date == 'yes' ? true : false;
		$author             = $author == 'yes' ? true : false;
		$comments           = $comments == 'yes' ? true : false;
		$display_navs       = $display_navs == 'yes' ? 'true' : 'false';
		$display_pagination = $display_pagination == 'yes' ? 'true' : 'false';
		$itemcounter = 0;

		switch ( strtolower( str_replace(' ', '-', $post_type) ) ) {
			case 'blog':
				$post_type = 'post';
				break;
			case 'portfolio':
				$post_type = 'portfolio';
				break;
			case 'testimonial':
				$post_type = 'testi';
				break;
			case 'services':
				$post_type = 'services';
				break;
			case 'our-team':
				$post_type = 'team';
			break;
		}

		$get_category_type = $post_type == 'post' ? 'category' : $post_type.'_category';
		$categories_ids = array();
		foreach ( explode(',', str_replace(', ', ',', $categories)) as $category ) {
			$get_cat_id = get_term_by( 'name', $category, $get_category_type );
			if ( $get_cat_id ) {
				$categories_ids[] = $get_cat_id->term_id;
			}
		}
		$get_query_tax = $categories_ids ? 'tax_query' : '';

		$suppress_filters = get_option('suppress_filters'); // WPML filter

		// WP_Query arguments
		$args = array(
			'post_status'         => $post_status,
			'posts_per_page'      => $posts_count,
			'ignore_sticky_posts' => 1,
			'post_type'           => $post_type,
			'suppress_filters'    => $suppress_filters,
			"$get_query_tax"      => array(
				array(
					'taxonomy' => $get_category_type,
					'field'    => 'id',
					'terms'    => $categories_ids
					)
				)
		);

		// The Query
		$carousel_query = new WP_Query( $args );
		$output = '';

		if ( $carousel_query->have_posts() ) :

			$output .= '<div class="carousel-wrap ' . $custom_class . '">';
				$output .= $title ? '<h2>' . $title . '</h2>' : '';
				$output .= '<div id="owl-carousel-' . $random_ID . '" class="owl-carousel-' . $post_type . ' owl-carousel" data-items="' . $visibility_items . '" data-auto-play="' . $auto_play . '" data-nav="' . $display_navs . '" data-pagination="' . $display_pagination . '">';

				while ( $carousel_query->have_posts() ) : $carousel_query->the_post();
					$post_id         = $carousel_query->post->ID;
					$post_title      = esc_html( get_the_title( $post_id ) );
					$post_title_attr = esc_attr( strip_tags( get_the_title( $post_id ) ) );
					$format          = get_post_format( $post_id );
					$format          = (empty( $format )) ? 'format-standart' : 'format-' . $format;
					if ( get_post_meta( $post_id, 'tz_link_url', true ) ) {
						$post_permalink = ( $format == 'format-link' ) ? esc_url( get_post_meta( $post_id, 'tz_link_url', true ) ) : get_permalink( $post_id );
					} else {
						$post_permalink = get_permalink( $post_id );
					}
					if ( has_excerpt( $post_id ) ) {
						$excerpt = wp_strip_all_tags( get_the_excerpt() );
					} else {
						$excerpt = wp_strip_all_tags( strip_shortcodes (get_the_content() ) );
					}

					$output .= '<div class="item ' . $format . ' item-list-'.$itemcounter.'">';

						// post thumbnail
						if ( $thumb ) :

							if ( has_post_thumbnail( $post_id ) ) {
								$attachment_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
								$url            = $attachment_url['0'];
								$image          = aq_resize($url, $thumb_width, $thumb_height, true);

								$output .= '<figure>';
									$output .= '<a href="' . $post_permalink . '" title="' . $post_title . '">';
										$output .= '<img src="' . $image . '" alt="' . $post_title . '" />';
									$output .= '</a>';
								$output .= '</figure>';

							} else {

								$attachments = get_children( array(
									'orderby'        => 'menu_order',
									'order'          => 'ASC',
									'post_type'      => 'attachment',
									'post_parent'    => $post_id,
									'post_mime_type' => 'image',
									'post_status'    => null,
									'numberposts'    => 1
								) );
								if ( $attachments ) {
									foreach ( $attachments as $attachment_id => $attachment ) {
										$image_attributes = wp_get_attachment_image_src( $attachment_id, 'full' );
										$img              = aq_resize( $image_attributes[0], $thumb_width, $thumb_height, true );
										$alt              = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );

										$output .= '<figure>';
												$output .= '<a href="' . $post_permalink.'" title="' . $post_title . '">';
													$output .= '<img src="' . $img . '" alt="' . $alt . '" />';
											$output .= '</a>';
										$output .= '</figure>';
									}
								}
							}

						endif;

						$output .= '<div class="desc">';
							$output .= '<div class="inner">';

							// post date
							$output .= $date ? '<time datetime="' . get_the_time( 'Y-m-d\TH:i:s', $post_id ) . '">' . get_the_date() . '</time>' : '';

							// post author
							$output .= $author ? '<em class="author">&nbsp;<span>' . __('by ', CHERRY_PLUGIN_DOMAIN) . '</span>&nbsp;<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ).'">' . get_the_author_meta( 'display_name' ) . '</a> </em>' : '';

							// post comment count
							if ( $comments == 'yes' ) {
								$comment_count = $carousel_query->post->comment_count;
								if ( $comment_count >= 1 ) :
									$comment_count = $comment_count . ' <span>' . __( 'Comments', CHERRY_PLUGIN_DOMAIN ) . '</span>';
								else :
									$comment_count = $comment_count . ' <span>' . __( 'Comment', CHERRY_PLUGIN_DOMAIN ) . '</span>';
								endif;
								$output .= '<a href="'. $post_permalink . '#comments" class="comments_link">' . $comment_count . '</a>';
							}

							// post title
							if ( !empty($post_title{0}) ) {
								$output .= '<h5><a href="' . $post_permalink . '" title="' . $post_title_attr . '">';
									$output .= $post_title;
								$output .= '</a></h5>';
							}

							// post excerpt
							if ( !empty($excerpt{0}) ) {
								$output .= $excerpt_count > 0 ? '<p class="excerpt">' . wp_trim_words( $excerpt, $excerpt_count ) . '</p>' : '';
							}

							// post more button
							$more_text_single = esc_html( wp_kses_data( $more_text_single ) );
							if ( $more_text_single != '' ) {
								$output .= '<a href="' . get_permalink( $post_id ) . '" class="btn btn-primary" title="' . $post_title_attr . '">';
									$output .= __( $more_text_single, CHERRY_PLUGIN_DOMAIN );
								$output .= '</a>';
							}

							$output .= '</div>';
							$output .= '<div class="auxiliary"></div>';
						$output .= '</div>';
					$output .= '</div>';
					$itemcounter++;
				endwhile;
			$output .= '</div></div>';
		endif;

		// Restore original Post Data
		wp_reset_postdata();

		$output = apply_filters( 'cherry_plugin_shortcode_output', $output, $atts, $shortcodename );

		return $output;
	}
	add_shortcode( 'carousel_owl', 'shortcode_carousel_owl' );
}

















/**
 * Mini Post List
 *
 */
if (!function_exists('mini_posts_list_shortcode')) {

	function mini_posts_list_shortcode( $atts, $content = null, $shortcodename = '' ) {
		extract(shortcode_atts(array(
			'type'          => 'post',
			'numb'          => '3',
			'thumbs'        => '',
			'thumb_width'   => '',
			'thumb_height'  => '',
			'meta'          => '',
			'order_by'      => '',
			'order'         => '',
			'excerpt_count' => '0',
			'custom_class'  => ''
		), $atts));

		$template_url = get_template_directory_uri();

		// check what order by method user selected
		switch ($order_by) {
			case 'date':
				$order_by = 'post_date';
				break;
			case 'title':
				$order_by = 'title';
				break;
			case 'popular':
				$order_by = 'comment_count';
				break;
			case 'random':
				$order_by = 'rand';
				break;
		}

		// check what order method user selected (DESC or ASC)
		switch ($order) {
			case 'DESC':
				$order = 'DESC';
				break;
			case 'ASC':
				$order = 'ASC';
				break;
		}

		// thumbnail size
		$thumb_x = 0;
		$thumb_y = 0;
		if (($thumb_width != '') && ($thumb_height != '')) {
			$thumbs = 'custom_thumb';
			$thumb_x = $thumb_width;
			$thumb_y = $thumb_height;
		} else {
			switch ($thumbs) {
				case 'small':
					$thumb_x = 110;
					$thumb_y = 110;
					break;
				case 'smaller':
					$thumb_x = 90;
					$thumb_y = 90;
					break;
				case 'smallest':
					$thumb_x = 60;
					$thumb_y = 60;
					break;
			}
		}

			global $post;
			global $my_string_limit_words;

			// WPML filter
			$suppress_filters = get_option('suppress_filters');

			$args = array(
				'post_type'        => $type,
				'numberposts'      => $numb,
				'orderby'          => $order_by,
				'order'            => $order,
				'suppress_filters' => $suppress_filters
			);

			$posts = get_posts($args);
			$i = 0;

			$output = '<ul class="mini-posts-list '.$custom_class.'">';

			foreach($posts as $key => $post) {
				//Check if WPML is activated
				if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
					global $sitepress;

					$post_lang = $sitepress->get_language_for_element($post->ID, 'post_' . $type);
					$curr_lang = $sitepress->get_current_language();
					// Unset not translated posts
					if ( $post_lang != $curr_lang ) {
						unset( $posts[$key] );
					}
					// Post ID is different in a second language Solution
					if ( function_exists( 'icl_object_id' ) ) {
						$post = get_post( icl_object_id( $post->ID, $type, true ) );
					}
				}
				setup_postdata($post);
				$excerpt        = get_the_excerpt();
				$attachment_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
				$url            = $attachment_url['0'];
				$image          = aq_resize($url, $thumb_x, $thumb_y, true);
				$mediaType      = get_post_meta($post->ID, 'tz_portfolio_type', true);
				$format         = get_post_format();

					//$output .= '<div class="row-fluid">';
					$output .= '<li class="mini-post-holder clearfix list-item-'.$i.'">';

					//post thumbnail
					if ($thumbs != 'none') {

						if ((has_post_thumbnail($post->ID)) && ($format == 'image' || $mediaType == 'Image')) {

							$output .= '<figure class="a featured-thumbnail thumbnail '.$thumbs.'">';
							$output .= '<a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
							$output .= '<img src="'.$image.'" alt="'.get_the_title($post->ID).'" />';
							$output .= '</a></figure>';

						} elseif ($mediaType != 'Video' && $mediaType != 'Audio') {

							$thumbid = 0;
							$thumbid = get_post_thumbnail_id($post->ID);
							$images = get_children( array(
								'orderby'        => 'menu_order',
								'order'          => 'ASC',
								'post_type'      => 'attachment',
								'post_parent'    => $post->ID,
								'post_mime_type' => 'image',
								'post_status'    => null,
								'numberposts'    => -1
							) );

							if ( $images ) {

								$k = 0;
								//looping through the images
								foreach ( $images as $attachment_id => $attachment ) {
									//$prettyType = "prettyPhoto[gallery".$i."]";
									//if( $attachment->ID == $thumbid ) continue;

									$image_attributes = wp_get_attachment_image_src( $attachment_id, 'full' ); // returns an array
									$img = aq_resize($image_attributes[0], $thumb_x, $thumb_y, true);  //resize & crop img
									$alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
									$image_title = $attachment->post_title;

									if ( $k == 0 ) {
										if (has_post_thumbnail($post->ID)) {
											$output .= '<figure class="featured-thumbnail thumbnail">';
											$output .= '<a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
											$output .= '<img src="'.$image.'" alt="'.get_the_title($post->ID).'" />';
										} else {
											$output .= '<figure class="featured-thumbnail thumbnail '.$thumbs.'">';
											$output .= '<a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
											$output .= '<img  src="'.$img.'" alt="'.get_the_title($post->ID).'" />';
										}
									}
									$output .= '</a></figure>';
									$k++;
								}
							} elseif (has_post_thumbnail($post->ID)) {
								//$prettyType = 'prettyPhoto';
								$output .= '<figure class="featured-thumbnail thumbnail '.$thumbs.'">';
								$output .= '<a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
								$output .= '<img src="'.$image.'" alt="'.get_the_title($post->ID).'" />';
								$output .= '</a></figure>';
							}
							else {
								// empty_featured_thumb.gif - for post without featured thumbnail
								$output .= '<figure class="featured-thumbnail thumbnail '.$thumbs.'">';
								$output .= '<a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
								$output .= '<img src="'.$template_url.'/images/empty_thumb.gif" alt="'.get_the_title($post->ID).'" />';
								$output .= '</a></figure>';
							}
						} else {

							// for Video and Audio post format - no lightbox
							$output .= '<figure class="featured-thumbnail thumbnail '.$thumbs.'"><a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
							$output .= '<img src="'.$image.'" alt="'.get_the_title($post->ID).'" />';
							$output .= '</a></figure>';
						}
					}

						//mini post content
						$output .= '<div class="mini-post-content">';
							if ($meta == 'yes') {
								// mini post meta
								$output .= '<div class="mini-post-meta">';
									$output .= '<time datetime="'.get_the_time('Y-m-d\TH:i:s', $post->ID).'"> <span>' .get_the_date('m'). '<i>' . get_the_date('/d') . '</i>' . '</span></time>';
								$output .= '</div>';
							}
							$output .= '<h4><a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
								$output .= get_the_title($post->ID);
							$output .= '</a></h4>';
							$output .= cherry_get_post_networks(array('post_id' => $post->ID, 'display_title' => false, 'output_type' => 'return'));
							if($excerpt_count >= 1){
								$output .= '<div class="excerpt">';
									$output .= wp_trim_words($excerpt,$excerpt_count);
								$output .= '</div>';
							}
						$output .= '</div>';
						$output .= '</li>';
						$i++;

			} // end foreach
			wp_reset_postdata(); // restore the global $post variable

			$output .= '</ul><!-- .mini-posts-list (end) -->';

			$output = apply_filters( 'cherry_plugin_shortcode_output', $output, $atts, $shortcodename );

			return $output;
	}
	add_shortcode('mini_posts_list', 'mini_posts_list_shortcode');

}



















?>