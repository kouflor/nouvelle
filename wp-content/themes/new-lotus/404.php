<?php
$kopa_setting = kopa_get_template_setting();
$sidebars = array();
if ( isset($kopa_setting['sidebars']) ) {
    $sidebars =  $kopa_setting['sidebars'];
}
get_header();
?>
<section id="main-content">
    <div class="container">
    <div class="clearfix">
        <section id="main-col" class="pull-left">
            <?php kopa_breadcrumb(); ?>
            <article class="kopa-single-page">
                <div class="clearfix">
                    <div class="entry-content">
                        <section class="error-404 clearfix">
                            <div class="left-col">
                                <p><?php _e('404','new-lotus'); ?></p>
                            </div><!--left-col-->
                            <div class="right-col">
                                <h1><?php _e('Page not found...','new-lotus'); ?></h1>
                                <p><?php _e('We\'re sorry, but we can\'t find the page you were looking for. It\'s probably some thing we\'ve done wrong but now we know about it we\'ll try to fix it. In the meantime, try one of this options:','new-lotus'); ?></p>
                                <ul class="arrow-list">
                                    <li><a href="javascript: history.go(-1);"><?php _e( 'Go back to previous page', 'new-lotus' ); ?></a></li>
                                    <li><a href="<?php echo esc_url( home_url() ); ?>"><?php _e( 'Go to homepage', 'new-lotus' ); ?></a></li>
                                </ul>
                            </div><!--right-col-->
                        </section><!--error-404-->
                    </div>
                </div>
            </article>
            <!-- kopa-single-post -->
        </section>
    </div>
</div>
</section>
<?php get_footer(); ?>
