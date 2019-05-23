<?php
/**
 * Comments related functions - comments.php
 *
 * @package verbosa
 */

/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own verbosa_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 */
if ( ! function_exists( 'verbosa_comment' ) ) :
function verbosa_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback: ', 'verbosa' ); ?><?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'verbosa'), ' ' ); ?></p>
	<?php
		break;
		case '' :
		default :
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>"<?php cryout_schema_microdata('comment'); ?>>
	<article>
		<header class="comment-header vcard">
			<div class="comment-author" <?php cryout_schema_microdata('comment-author'); ?>>
				<?php echo get_avatar( $comment, 70, '', '', array('extra_attr' => cryout_schema_microdata('image', 0) )  ); ?>
				<?php printf(  '%s ', sprintf( '<span class="author-name fn"' . cryout_schema_microdata('author-name', 0) . '>%s</span>', get_comment_author_link() ) ); ?>
			</div> <!-- .comment-author -->
			<div class="comment-meta">
				<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<time datetime="<?php comment_time('c');?>" <?php cryout_schema_microdata('time');?>>

					<span class="comment-date">
						<?php /* translators: 1: date, 2: time */
						printf(  '%1$s ' . __('at', 'verbosa' ) . ' %2$s', get_comment_date(),  get_comment_time() ); ?>
					</span>
					<span class="comment-timediff">
						<?php printf( _x( '%1$s ago', '%s = human-readable time difference', 'verbosa' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
					</span>

				</time>
				</a>
				<?php edit_comment_link( __( '(Edit)', 'verbosa' ), ' ' ); ?>
			</div><!-- .comment-meta -->
			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array(
						'reply_text' => __('Reply', 'verbosa'),
						'depth' => $depth,
						'max_depth' => $args['max_depth'] ) ) );
				?>
			</div><!-- .reply -->
		</header><!-- .comment-header .vcard -->

		<div class="comment-body" <?php cryout_schema_microdata('text'); ?>>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<span class="comment-await"><em><?php _e( 'Your comment is awaiting moderation.', 'verbosa' ); ?></em></span>
				<br />
			<?php endif; ?>
			<?php comment_text(); ?>
		</div>

		<footer>
		</footer>
	</article>
		<?php

		break;
	endswitch; ?>

<?php
	// </li><!-- #comment-##  -->  closed by wp_comments_list()
} // verbosa_comment()
endif;



/**
 * Number of comments on loop post if comments are enabled.
 */
if ( ! function_exists( 'verbosa_comments_on' ) ) :
function verbosa_comments_on() {
	$verbosa_meta_comment = cryout_get_option( 'verbosa_meta_comment' );

		if (  ( comments_open() || get_comments_number() ) && ! post_password_required() && $verbosa_meta_comment && ! is_single()  ) :

            echo '<span class="comments-link"><i class="icon-bubbles4 icon-metas" title="' . __('Comments', 'verbosa') . '"></i><strong>';
            comments_popup_link(
                 __( 'Leave a comment', 'verbosa' ),
                sprintf( _n( 'One Comment', '%1$s Comments', get_comments_number(), 'verbosa' ), number_format_i18n( get_comments_number() ) ),
                sprintf( _n( 'One Comment', '%1$s Comments', get_comments_number(), 'verbosa' ), number_format_i18n( get_comments_number() ) ),
                '',
                ''
            );
            echo '</strong></span>';

		endif;
} // verbosa_comments_on()
endif;

/**
 * Adds microdata tags to comment link
 */
if ( ! function_exists( 'verbosa_comments_microdata' ) ) :
function verbosa_comments_microdata() {
	cryout_schema_microdata('comment-meta');
}// verbosa_comments_microdata()
endif;
add_filter( 'comments_popup_link_attributes', 'verbosa_comments_microdata' );


/*
 * Edit comments form
 * Removing labels and adding them as placeholders
 */
function verbosa_comments_form($arg) {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$arg =  array(

		'author' =>	'<p class="comment-form-author"><label for="author">' . __( 'Name', 'verbosa' ) .  ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
					'<input id="author" placeholder="'. esc_attr__( 'Name', 'verbosa' ) .'*" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
					'" size="30" maxlength="245"' . $aria_req . ' /></p>',

		'email' =>	'<p class="comment-form-email"><label for="email">' . __( 'Email', 'verbosa' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
					'<input id="email" placeholder="'. esc_attr__( 'Email', 'verbosa' ) . '*" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) .
					'" size="30"  maxlength="100" aria-describedby="email-notes"' . $aria_req . ' /></p>',

		'url' =>	'<p class="comment-form-url"><label for="url">' . __( 'Website', 'verbosa' ) . '</label>' .
					'<input id="url" placeholder="'. esc_attr__( 'Website', 'verbosa' ) .'" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) .
					'" size="30"  maxlength="200" /></p>',
		'cookies' => '<p class="comment-form-cookies-consent"><label for="wp-comment-cookies-consent">' .
					  '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" />' .
					   __( 'Save my name, email, and site URL in my browser for next time I post a comment.', 'verbosa' ) . '</label></p>',

	);

	return $arg;
} // verbosa_comments_form()

function verbosa_comments_form_textarea($arg) {
	$arg =
		'<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'verbosa' ) .
		'</label><textarea placeholder="'. _x( 'Comment', 'noun', 'verbosa' ) .'" id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
		'</textarea></p>';
	return $arg;
} // verbosa_comments_form_textarea()

/* hooks are located in cryout_master_hook() in core.php */

// FIN //
