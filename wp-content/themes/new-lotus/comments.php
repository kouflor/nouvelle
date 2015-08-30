<?php
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
    die(__('Please do not load this page directly. Thanks!', 'new-lotus'));
}

// check if post is pwd protected
if ( post_password_required() ) {
    return;
} // endif check pwd

if ( have_comments() && comments_open() ) { ?>  
    <div id="comments" class="comment-area">
        <h3 class="comments-title"><?php comments_number(__('NO COMMENTS', 'new-lotus'), __('1 COMMENT', 'new-lotus'), __('% COMMENTS', 'new-lotus')); ?></h3>
        <ul class="comments-list">
            <?php
            wp_list_comments(array(
                'walker' => null,
                'style' => 'ul',
                'callback' => 'kopa_comments_callback',
                'end-callback' => null,
                'type' => 'all'
            ));
            ?>
        </ul>

        <?php 
        // whether or not display paginate comments link
        $prev_comments_link = get_previous_comments_link();
        $next_comments_link = get_next_comments_link();

        if ( '' !== $prev_comments_link . $next_comments_link ) { ?>
            <div class="pagination"><?php paginate_comments_links(); ?></div>
        <?php } // endif ?>
    </div>
<?php } elseif ( ! comments_open() && post_type_supports(get_post_type(), 'comments') ) {
    return;
} // endif



comment_form(kopa_comment_form_args());

/*
 * Comments call back function
 */
function kopa_comments_callback($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;

    if ( 'pingback' == get_comment_type() || 'trackback' == get_comment_type() ) { ?>

    <li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'comment' ); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <footer class="comment-meta">
                <div class="comment-author">
                    <h6><?php _e( 'Pingback', 'new-lotus' ); ?></h6>
                    <?php echo get_avatar( $comment->comment_author_email, 50 ); ?>
                    <?php if ( get_comment_author_url() ) { ?>
                    <a href="<?php comment_author_url(); ?>" class="fn"><?php echo get_comment_author(); ?></a>
                    <?php } else {
                    ?>
                    <b class="fn"><?php echo get_comment_author(); ?></b>
                    <?php
                } ?>
                </div>
                <div class="comment-metadata">

                    <time datetime="<?php echo get_comment_date(get_option('date_format')); ?>"><i class="fa fa-calendar"></i> <?php comment_date(get_option('date_format') ); ?></time>

                        <span class="edit-link">
                            <?php if ( current_user_can( 'moderate_comments' ) ) {
                            edit_comment_link( __( 'Edit', 'new-lotus' ) );
                        } ?>
                        </span>

                </div>
            </footer>
        </article>
    

    <?php } elseif ( 'comment' == get_comment_type() ) { ?>
                       
        <li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'comment' ); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <footer class="comment-meta">
                    <div class="comment-author">
                        <?php echo get_avatar( $comment->comment_author_email, 50 ); ?>
                        <?php if ( get_comment_author_url() ) { ?>
                        <a href="<?php comment_author_url(); ?>" class="fn"><?php echo get_comment_author(); ?></a>
                    <?php } else {
                        ?>
                        <b class="fn"><?php echo get_comment_author(); ?></b>
                        <?php
                    } ?>
                    </div>
                    <div class="comment-metadata">
                        
                        <time datetime="<?php echo get_comment_date(get_option('date_format')); ?>"><i class="fa fa-calendar"></i> <?php comment_date(get_option('date_format') ); ?></time>
                        
                        <span class="edit-link"> 
                            <?php if ( current_user_can( 'moderate_comments' ) ) {
                                edit_comment_link( __( 'Edit', 'new-lotus' ) );
                                echo ' / ';
                                } ?>  
                            <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                        </span>
                        
                    </div>
                </footer>
                
                <div class="comment-content">
                    
                <?php comment_text(); ?>
                
                
                </div><!--comment-body -->
            </article>
        
    <?php
    } // endif check comment type
}

function kopa_comment_form_args() {
    global $user_identity;
    $commenter = wp_get_current_commenter();
    $commeter_author = esc_attr($commenter['comment_author']);
    $commenter_author_email = esc_attr($commenter['comment_author_email']);
    $commenter_author_url = esc_attr($commenter['comment_author_url']);

    $fields = array(
        'author' => '<div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="form-group">
                    <input class="form-control valid" id="comment_name" name="author" value="'. $commeter_author . '" placeholder="' . __('Name (required)', 'new-lotus') . '" type="text">
                    </div>',
        'email' => '<div class="form-group">
                        <input class="form-control valid" id="comment_email" name="email" value="'. $commenter_author_email . '"  type="email" placeholder="' . __('Email (required)', 'new-lotus') .'">
                    </div>',
        'url'   => '<div class="form-group">
                    <input class="form-control" id="comment_url" type="text" name="url" value="' . $commenter_author_url .'" placeholder="' . __('Website', 'new-lotus') . '">
                    </div></div>',
    );

    if ( ! is_user_logged_in() ) {
        $comment_field = '<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">'.
            '<div class="form-group">'.
            '<textarea id="comment_message" class="form-control valid" name="comment" style="overflow:auto;resize:vertical ;" placeholder="' . __('Your comment (required)', 'new-lotus') . '"></textarea>'.
            '</div>'.
            '</div></div>';
    } else {
        $comment_field = '<div class="form-group"><textarea id="comment_message" class="form-control valid" name="comment" style="overflow:auto;resize:vertical ;" placeholder="' . __('Your comment (required)', 'new-lotus') . '"></textarea></div><div class="clear"></div>';
    }

    $args = array(
        'fields' => apply_filters('comment_form_default_fields', $fields),
        'comment_field' => $comment_field,
        'comment_notes_before' => '<p class="comment-notes">'.__('Your email address will not be published. Required fields are marked', 'new-lotus').' <span>( '.__('required', 'new-lotus') . ' )</span></p>',
        'comment_notes_after' => '',
        'id_form' => 'comments-form',
        'id_submit' => 'submit-comment',
        'title_reply' => __('LEAVE A REPLY', 'new-lotus'),
        // 'title_reply_to' => __('Reply to %s', 'new-lotus'),
        // 'cancel_reply_link' => '<span class="title-text">'.__('Cancel', 'new-lotus').'</span>',
        'label_submit' =>__('Post Comment', 'new-lotus'),
    );

    return $args;
}
