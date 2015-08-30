<article id="post-<?php the_ID(); ?>" class="kopa-single-post">
    <?php 
    $post_thumbnail_status= kopa_get_option('post_thumbnail_status');
    if('1'===$post_thumbnail_status){
    if(has_post_thumbnail()){ ?>
    <div class="entry-thumb img-responsive">
        <?php
            the_post_thumbnail('full');
        ?>
    </div>
    <?php } } ?>
    <div class="article-content">
        <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <div class="clearfix">
                <div class="post-meta">
                    <?php
                        $post_date_status = kopa_get_option('post_date_status');
                        if('1' === $post_date_status) {
                    ?>
                    <span class="post-date"><?php echo get_the_date(kopa_get_option('date_format')); ?> </span>
                    <?php }?>
                    <?php
                        $post_author_status = kopa_get_option('post_dauthor_status');
                        if('1' === $post_author_status) {
                    ?>
                    <span class="post-user"><?php _e('By','new-lotus'); ?> <?php the_author_posts_link(); ?></span>
                    <?php }?>
                </div>
            </div>
        </header>
        <?php kopa_related_articles(); ?>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
        <footer class="entry-footer clearfix">
            <?php
            $args = array(
                'before'           => '<div class="page-links">',
                'after'            => '</div>',
                'link_before'      => '<span>',
                'link_after'       => '</span>',
                'next_or_number'   => 'number',
                'separator'        => ' ',
                'nextpagelink'     => __( 'Next page', 'new-lotus' ),
                'previouspagelink' => __( 'Previous page', 'new-lotus' ),
                'pagelink'         => '%',
                'echo'             => 1
            );
            wp_link_pages($args);
            $post_tag= kopa_get_option('post_tag_status');
            if('1'===$post_tag){
                kopa_the_tag(get_the_ID());
            }
            ?>
            
        </footer>
    </div>
    <?php get_template_part( 'library/templates/template', 'hreview' ); ?>
</article>
<?php 
    $post_navigation_status= kopa_get_option('post_navigation_status');
    if('1'===$post_navigation_status){
        kopa_post_navigation();
    }
?>




    

