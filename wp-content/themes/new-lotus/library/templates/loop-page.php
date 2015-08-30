
<?php
global $kopa_setting;
if ( is_page(get_the_ID()) && have_posts() ) {
    while ( have_posts() ) {
        the_post(); ?>

<?php ?>
    <article class="kopa-single-page" id="page-<?php the_ID(); ?>">
    
        <?php the_content(); ?>
    </article>

    <?php wp_link_pages( array(
            'before'      => '<div class="page-links">',
            'after'       => '</div>',
            'link_before' => '<span>',
            'link_after'  => '</span>',
        ) );
        ?>
    
    <?php comments_template(); ?>
    
<?php } // endwhile
} // endif
?>