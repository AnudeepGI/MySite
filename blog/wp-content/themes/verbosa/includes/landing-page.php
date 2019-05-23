<?php
/**
 * Landing page functions
 * Used in front-page.php
 *
 * @package Verbosa	
 */

/**
 * slider builder
 */
if ( ! function_exists('verbosa_lpslider' ) ):
function verbosa_lpslider() {
	$options = cryout_get_option( array( 'verbosa_lpslider', 'verbosa_lpsliderimage', 'verbosa_lpslidertitle', 'verbosa_lpslidertext', 'verbosa_lpslidershortcode', 'verbosa_lpsliderserious', 'verbosa_lpslidercta1text', 'verbosa_lpslidercta1link', 'verbosa_lpslidercta2text', 'verbosa_lpslidercta2link'  ) );
	echo '<section class="lp-slider-overlay">';
	if ( $options['verbosa_lpslider'] )
		switch ( $options['verbosa_lpslider'] ):
			case 1:
				if ( is_numeric($options['verbosa_lpsliderimage']) ) {
					list( $image, ) = wp_get_attachment_image_src( $options['verbosa_lpsliderimage'], 'full' );
				} else {
					$image = $options['verbosa_lpsliderimage'];
				}
				verbosa_lpslider_output( array(
					'image' => $image,
					'title' => $options['verbosa_lpslidertitle'],
					'content' => $options['verbosa_lpslidertext'],
					'lpslidercta1text' => $options['verbosa_lpslidercta1text'],
					'lpslidercta1link' => $options['verbosa_lpslidercta1link'],
					'lpslidercta2text' => $options['verbosa_lpslidercta2text'],
					'lpslidercta2link' => $options['verbosa_lpslidercta2link'],
				) );
			break;
			case 2:
				?> <div class="lp-dynamic-slider"> <?php
				echo do_shortcode( $options['verbosa_lpslidershortcode'] );
				?> </div> <!-- lp-dynamic-slider --> <?php
			break;
			case 3:
				// header image
			break;
			case 4:
				?> <div class="lp-dynamic-slider"> <?php
					if ( ! empty( $options['verbosa_lpsliderserious'] ) ) {
						echo do_shortcode( '[serious-slider id="' . $options['verbosa_lpsliderserious'] . '"]' );
					}
				?> </div> <!-- lp-dynamic-slider --> <?php
			break;

			default:
			break;
		endswitch;
		echo '</section>';
} //  verbosa_lpslider()
endif;

/**
 * slider output
 */
if ( ! function_exists( 'verbosa_lpslider_output' ) ):
function verbosa_lpslider_output( $data ){

	extract($data); ?>

		<section class="lp-staticslider">
			<?php if ( ! empty( $image ) ) { ?>
				<img class="lp-staticslider-image" alt="<?php echo esc_attr( $title ) ?>" src="<?php echo esc_url( $image ); ?>">
			<?php } ?>
			<div class="staticslider-caption">
				<?php if ( ! empty( $title ) ) { ?> <h2 class="staticslider-caption-title"><?php echo do_shortcode( wp_kses_post( $title ) ) ?></h2><?php } ?>
				<?php if ( ! empty( $title ) && ! empty( $content ) )	{ ?><span class="staticslider-sep"></span><?php } ?>
				<?php if ( ! empty( $content ) ) { ?> <div class="staticslider-caption-text"><?php echo do_shortcode( wp_kses_post( $content ) ) ?></div><?php } ?>
				<?php if ( ! empty( $lpslidercta1text ) ) { echo '<a class="staticslider-button-1" href="' . esc_url( $lpslidercta1link ) . '">' . esc_html( $lpslidercta1text ) . '</a>'; } ?>
				<?php if ( ! empty( $lpslidercta2text ) ) { echo '<a class="staticslider-button-2" href="' . esc_url( $lpslidercta2link ) . '">' . esc_html( $lpslidercta2text ) . '</a>'; } ?>
			</div>
		</section><!-- .lp-staticslider -->

<?php
} // verbosa_lpslider_output()
endif;


/**
 * text area builder
 */
if ( ! function_exists( 'verbosa_lptext' ) ):
function verbosa_lptext( $what = 'one' ) {
	$pageid = cryout_get_option( 'verbosa_lptext' . $what );
	$pageid = cryout_localize_id( $pageid );
	if ( intval($pageid) > 0 ) {
		$page = get_post( $pageid );
		$data = array(
			'title' => apply_filters( 'verbosa_text_title', get_the_title( $pageid ), $pageid ),
			'text'	=> apply_filters( 'the_content', get_post_field( 'post_content', $pageid ) ),
			'class' => apply_filters( 'verbosa_text_class', '', $pageid ),
			'id' 	=> $what,
		);
		list( $data['image'], ) = wp_get_attachment_image_src( get_post_thumbnail_id( $pageid ), 'full' );
		verbosa_lptext_output( $data );
	}
} // verbosa_lptext()
endif;

/**
 * text area output
 */
if ( ! function_exists( 'verbosa_lptext_output' ) ):
function verbosa_lptext_output( $data ){ ?>
	<section class="lp-text <?php echo $data['class'] ?>" id="lp-text-<?php echo esc_attr( $data['id'] ); ?>"<?php if( ! empty( $data['image'] ) ) { ?> style="background-image: url( <?php echo esc_url( $data['image'] ); ?>);" <?php } ?> >
		<?php if( ! empty( $data['image'] ) ) { ?><div class="lp-text-overlay"></div><?php } ?>
			<div class="lp-text-inside">
				<?php if( ! empty( $data['title'] ) ) { ?><h2 class="lp-text-title"><?php echo do_shortcode( $data['title'] ) ?></h2><?php } ?>
				<?php if( ! empty( $data['text'] ) ) { ?><div class="lp-text-content"><?php echo do_shortcode( $data['text'] ) ?></div><?php } ?>
			</div>

	</section><!-- .lp-text-<?php echo esc_attr( $data['id'] ); ?> -->
<?php
} // verbosa_lptext_output()
endif;

/**
* page or posts output, also used when landing page is disabled
*/
if ( ! function_exists( 'verbosa_lpindex' ) ):
function verbosa_lpindex() {

	$verbosa_lpposts = cryout_get_option( 'verbosa_lpposts' );

	switch ($verbosa_lpposts) {

		case 2: // static page

			if ( have_posts() ) :
					?><section id="lp-page"> <div class="lp-page-inside"><?php
					get_template_part( 'content/content', 'page' );
					?></div> </section><!-- #lp-page --><?php
			endif;

		break;

		case 1: // posts

			if ( get_query_var('paged') ) $paged = get_query_var('paged');
			elseif ( get_query_var('page') ) $paged = get_query_var('page');
			else $paged = 1;
			$custom_query = new WP_query( array('posts_per_page'=>get_option('posts_per_page'),'paged'=>$paged) );

			if ( $custom_query->have_posts() ) :  ?>
				<section id="lp-posts"> <div class="lp-posts-inside">
				<div id="content-masonry" class="content-masonry" <?php cryout_schema_microdata( 'blog' ); ?>> <?php
					while ( $custom_query->have_posts() ) : $custom_query->the_post();
						get_template_part( 'content/content', get_post_format() );
					endwhile; ?>
				</div> <!-- content-masonry -->
				</div> </section><!-- #lp-posts -->
				<?php verbosa_pagination();
				wp_reset_postdata();
			else :
				get_template_part( 'content/content', 'notfound' );
			endif;

		break;
		case 0: // disabled
		default: break;
	}

} // verbosa_lpindex()
endif;

// FIN