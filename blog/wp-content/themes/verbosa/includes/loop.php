<?php
/**
 * Loop related functions
 *
 * @package verbosa
 */


/**
 * Sets the post excerpt length to the number of words set in the theme settings
 */
function verbosa_excerpt_length_words( $length ) {
	return absint( cryout_get_option('verbosa_excerptlength') );
}
/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 */
function verbosa_custom_excerpt_more() {
	if (! is_attachment()) { echo verbosa_continue_reading_link();}
}
/**
 * Returns a "Continue Reading" link for excerpts
 */
function verbosa_continue_reading_link() {
	$verbosa_excerptcont = cryout_get_option('verbosa_excerptcont');
	return '<a class="continue-reading-link" href="'. esc_url( get_permalink() ) . '"><span>' . wp_kses_post( $verbosa_excerptcont ) . '</span><i class="icon-arrow-right2"></i></a>';
}

add_filter( 'excerpt_length', 'verbosa_excerpt_length_words' );
add_action( 'cryout_post_excerpt_hook', 'verbosa_custom_excerpt_more',10 );
add_filter( 'the_content_more_link', 'verbosa_continue_reading_link' ); // 'More' tag


/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and verbosa_continue_reading_link().
 */
function verbosa_auto_excerpt_more( $more ) {
	return wp_kses_post( cryout_get_option( 'verbosa_excerptdots' ) );
}
add_filter( 'excerpt_more', 'verbosa_auto_excerpt_more' );


/**
 * Adds a "Continue Reading" link to post excerpts created using the <!--more--> tag.
 */
function verbosa_more_link($more_link, $more_link_text) {
	$verbosa_excerptcont = cryout_get_option('verbosa_excerptcont');
	$new_link_text = $verbosa_excerptcont;
	if (preg_match("/custom=(.*)/",$more_link_text,$m) ) {
		$new_link_text = $m[1];
	}
	$more_link = str_replace($more_link_text, $new_link_text, $more_link);
	$more_link = str_replace('more-link', 'continue-reading-link', $more_link);
	return $more_link;
}
add_filter('the_content_more_link', 'verbosa_more_link', 10, 2);


/**
 * Remove inline styles printed when the gallery shortcode is used.
 * Galleries are styled by the theme in style.css.
 */
function verbosa_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'verbosa_remove_gallery_css' );

/**
 * Posted in category
 */
if ( ! function_exists( ' verbosa_posted_category ') ) :
function verbosa_posted_category() {
	$verbosa_meta_category = cryout_get_option( 'verbosa_meta_category' );

	if ($verbosa_meta_category && get_the_category_list()) {
		echo '<span class="bl_categ"' . cryout_schema_microdata('category', 0) . '>
					<i class="icon-books icon-metas" title="'.__("Categories", "verbosa").'"></i>'
					. get_the_category_list( ' / ' ) .
				'</span>';
	}
} // verbosa_posted_category()
endif;

/**
 * Posted by author
 */
if ( ! function_exists( 'verbosa_posted_author' )) :
function verbosa_posted_author() {
	$verbosa_meta_author = cryout_get_option( 'verbosa_meta_author' );

	if ($verbosa_meta_author) {
		echo sprintf(
			'<span class="author vcard"' . cryout_schema_microdata('author', 0) . '>
				<i class="icon-pen icon-metas" title="'.__("Author", "verbosa").'"></i>
				<a class="url fn n" href="%1$s" title="%2$s"' . cryout_schema_microdata('author-url', 0) . '>
					<em' .  cryout_schema_microdata('author-name', 0) . '>%3$s</em>
				</a>
			</span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'verbosa' ), get_the_author() ),
			get_the_author()
		);
	}
} // verbosa_posted_author
endif;

/**
 * Posted date/time
 */
if ( ! function_exists( 'verbosa_posted_meta' ) ) :
function verbosa_posted_date() {
	$verbosa_meta_date = cryout_get_option( 'verbosa_meta_date' );
	$verbosa_meta_time = cryout_get_option( 'verbosa_meta_time' );

	if ($verbosa_meta_date || $verbosa_meta_time ) {
		$date = ''; $time = '';
		if ($verbosa_meta_date) {	$date = get_the_date(); }
		if ($verbosa_meta_time) {	$time = esc_attr( get_the_time() ); }

		?>

		<span class="onDate date" >
				<i class="icon-calendar icon-metas" title="<?php _e("Date", "verbosa") ?>"></i>
				<time class="published" datetime="<?php echo get_the_time('c') ?>" <?php cryout_schema_microdata('time') ?>>
					<?php echo $date . ( ($verbosa_meta_date && $verbosa_meta_time) ? ', ' : '' ) . $time ?>
				</time>
				<time class="updated" datetime="<?php echo get_the_modified_time('c')  ?>" <?php cryout_schema_microdata('time-modified') ?>></time>
		</span>
		<?php
	}

}; // verbosa_posted_date()
endif;

/**
 * Posted tags
 */
if ( ! function_exists( 'verbosa_posted_meta' ) ) :
function verbosa_posted_tags() {
	$verbosa_meta_tag = cryout_get_option( 'verbosa_meta_tag' );

	$tag_list = get_the_tag_list( '', ' / ' );
	if ($verbosa_meta_tag && $tag_list) { ?>
		<div class="entry-meta">
			<span class="footer-tags" <?php cryout_schema_microdata('tags') ?>>
				<i class="icon-bookmark icon-metas" title="<?php _e( 'Tagged','verbosa') ?>"></i>&nbsp;<?php echo $tag_list ?>
			</span>
		</div>
		<?php
	}

}; // verbosa_posted_tags()
endif;


/**
 * Post edit link for editors
 */
if ( ! function_exists( 'verbosa_posted_after' ) ) :
function verbosa_posted_after() {
	edit_post_link( __( 'Edit', 'verbosa' ), '<span class="edit-link icon-metas"><i class="icon-pencil2 icon-metas"></i> ', '</span>' );
	//cryout_post_footer_hook(); /* ?!? */

}; // verbosa_posted_after()
endif;

/**
 * Post format meta
 */
if ( ! function_exists( 'verbosa_meta_format' ) ) :
function verbosa_meta_format() {
	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format"><a href="%1$s"><i class="icon-%2$s" title="%3$s"></i></a></span>',
			esc_url( get_post_format_link( $format ) ),
			$format,
			get_post_format_string( $format )
		);
	}
} //verbosa_meta_format()
endif;

function verbosa_meta_infos() {
	add_action( 'cryout_post_meta_hook', 'verbosa_posted_author', 10 );
	add_action( 'cryout_post_meta_hook', 'verbosa_posted_date', 12 );
	add_action( 'cryout_post_meta_hook', 'verbosa_posted_category', 14);
	add_action( 'cryout_post_meta_hook', 'verbosa_comments_on', 16 );
	add_action( 'cryout_post_meta_hook', 'verbosa_posted_after', 99 );
	add_action( 'cryout_post_after_content_hook', 'verbosa_posted_tags' );
	add_action( 'cryout_post_footer_hook', 'verbosa_posted_tags' );

	add_action( 'cryout_meta_format_hook', 	'verbosa_meta_format' );
}
add_action('wp_head','verbosa_meta_infos');


/* Remove category from rel in category tags */
function verbosa_remove_category_tag( $text ) {
	$text = str_replace('rel="category tag"', 'rel="tag"', $text);
	return $text;
}
//add_filter( 'the_category', 'verbosa_remove_category_tag' );
//add_filter( 'get_the_category_list', 'verbosa_remove_category_tag' );


/**
 * Backup navigation
 */
if ( ! function_exists( 'verbosa_content_nav' ) ) :
function verbosa_content_nav( $nav_id ) {
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) : ?>

		<nav id="<?php echo $nav_id; ?>" class="navigation">
			<span class="nav-previous"><?php next_posts_link( '<i class="icon-arrow-left2"></i>' . __( 'Older posts', 'verbosa' ) ); ?></span>
			<span class="nav-next"><?php previous_posts_link(__( 'Newer posts', 'verbosa' ) . '<i class="icon-arrow-right2"></i>' ); ?></span>
		</nav><!-- #<?php echo $nav_id; ?> -->

	<?php endif;
}; // verbosa_content_nav()
endif;


/**
 * Adds a post thumbnail and if one doesn't exist the first post image is returned
 * @uses cryout_get_first_image( $postID )
 */
if ( ! function_exists( 'verbosa_set_featured_thumb' ) ) :
function verbosa_set_featured_thumb() {

	global $post;
	$verbosas = cryout_get_option( array('verbosa_fpost', 'verbosa_fauto', 'verbosa_falign') );

	if ( function_exists("has_post_thumbnail") && has_post_thumbnail() && $verbosas['verbosa_fpost']) {
		// has featured image
		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'verbosa-featured' );

	} elseif ( $verbosas['verbosa_fpost'] && $verbosas['verbosa_fauto'] && empty( $featured_image ) ) {
		// get the first image from post
		$featured_image = cryout_post_first_image( $post->ID, 'verbosa-featured' );

	} else {
		// featured image not enabled or not obtainable
		$featured_image = '';
	};

	if ( ! empty( $featured_image[0] ) ):
		$featured_image_url = esc_url( $featured_image[0] );
		$featured_image_w = $featured_image[1];
		$featured_image_h = $featured_image[2]; ?>
		<div class="post-thumbnail-container" <?php cryout_schema_microdata( 'image' ); ?>>
			<a href="<?php echo esc_url( get_permalink( $post->ID ) ) ?>" title="<?php echo esc_attr( get_post_field( 'post_title', $post->ID ) ) ?>"
				<?php cryout_echo_bgimage( $featured_image_url, 'post-featured-image' ) ?>>
			</a>
			<a class="responsive-featured-image" href="<?php echo esc_url( get_permalink( $post->ID ) ) ?>" title="<?php echo esc_attr( get_post_field( 'post_title', $post->ID ) ) ?>">
				<img class="post-featured-image" alt="<?php the_title_attribute();?>" <?php cryout_schema_microdata( 'url' ); ?> src="<?php echo $featured_image_url; ?>" />
			</a>

			<meta itemprop="width" content="<?php echo $featured_image_w; ?>">
			<meta itemprop="height" content="<?php echo $featured_image_h; ?>">
		</div>
	<?php
	endif; ?>
	<div class="featured-bar"></div>
<?php };
endif; // verbosa_set_featured_thumb()
if (cryout_get_option('verbosa_fpost')) add_action( 'cryout_featured_hook', 'verbosa_set_featured_thumb' );
if (cryout_get_option('verbosa_fspost')) add_action( 'cryout_singlefeatured_hook', 'verbosa_set_featured_thumb' );

/* FIN */
