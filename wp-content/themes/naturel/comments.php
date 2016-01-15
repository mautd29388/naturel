<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h3 class="title comment-title"><?php echo get_comments_number_text(false, 'Comment (1)', 'Comments (%)'); ?></h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'mTheme' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'mTheme' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'mTheme' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>
	
		<ol class="comment-list">
		<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'avatar_size'=> 60,
				'callback' => 'm_wedding_comment',
			) );
		?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'mTheme' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'mTheme' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'mTheme' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // Check for comment navigation. ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'mTheme' ); ?></p>
	<?php endif; ?>

	<?php comment_form( array(
			'title_reply'          => __( 'Post a comment', 'mTheme' ),
			'title_reply_to'       => __( 'Post a comment to %s', 'mTheme' ),
			'comment_notes_before' => '',
			'comment_notes_after'  => '',
			'label_submit'         => __( 'Post Comment', 'mTheme' ),
			'submit_button'        => '<button class="hvr-rectangle-out" name="%1$s" type="submit" id="%2$s">%4$s</button>',
			'submit_field'         => '<p class="form-submit button">%1$s %2$s</p>',
			'comment_field'        => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="3" placeholder="Your message" required="required"></textarea></p>',
			'fields'			   => array (
											'author' => '<p class="comment-form-author"><input placeholder="Your name" id="author" name="author" type="text" value="' . esc_attr ( $commenter ['comment_author'] ) . '" required="required" /></p>',
											'email' => '<p class="comment-form-email"><input placeholder="Your email" id="email" name="email" type="email" value="' . esc_attr ( $commenter ['comment_author_email'] ) . '" required="required" /></p>' 
									)
		)); ?>

</div><!-- .comments-area -->

