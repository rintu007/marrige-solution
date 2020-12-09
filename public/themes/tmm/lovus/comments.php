<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package lovus
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	

	<?php if ( have_comments() ) : ?>
		<div class="list-comments">
			<h3><?php comments_number( esc_html__('0 Comments', 'lovus'), esc_html__('1 Comment', 'lovus'), esc_html__('% Comments', 'lovus') ); ?></h3>
		    <ul class="commentlist">
					<?php wp_list_comments('callback=lovus_theme_comment'); ?>
				<?php
					// Are there comments to navigate through?
					if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				?>
					<nav class="navigation comment-navigation" role="navigation">		   
						<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'lovus' ) ); ?></div>
						<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'lovus' ) ); ?></div>
		                <div class="clearfix"></div>
					</nav><!-- .comment-navigation -->
				<?php endif; // Check for comment navigation ?>

				<?php if ( ! comments_open() && get_comments_number() ) : ?>
					<p class="no-comments"><?php esc_html_e( 'Comments are closed.' , 'lovus' ); ?></p>
				<?php endif; ?>	
		    </ul>
		</div>		
	<?php endif; ?>	

	<div class="comment-form-warp">
	<?php
		$aria_req = ( $req ? " aria-required='true'" : '' );
        $comment_args = array(
                'id_form' => 'reply-form',                                
                'title_reply'=> esc_html__('Add a Comment', 'lovus'),
                'fields' => apply_filters( 'comment_form_default_fields', array(
                    'author' => '<div class="c-author"><input id="author" name="author" id="name" class="contact-input" type="text" value="" placeholder="'. esc_html__( 'Your Name', 'lovus' ) .'" /></div>',
                    'email' => '<div class="c-email"><input id="author" name="email" id="name" class="contact-input" type="text" value="" placeholder="'. esc_html__( 'Your Email', 'lovus' ) .'" /></div>',
                ) ),                                
                 'comment_field' => '<div class="c-mess"><textarea name="comment" '.$aria_req.' id="comment-message" class="textarea-contact" placeholder="'. esc_html__( 'Your Comment', 'lovus' ) .'" ></textarea></div>',
                 'label_submit' => esc_html__( 'Post Comment', 'lovus' ),
                 'comment_notes_before' => '',
                 'comment_notes_after' => '',   
                 'class_submit'      => 'ot-btn border-dark btn-contact',            
	        )
	    ?>
	    <?php comment_form($comment_args); ?>
	</div>
</div>	

<!-- #comments -->
