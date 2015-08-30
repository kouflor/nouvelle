<?php
$kopa_setting = kopa_get_template_setting();
$footer_sidebar = array();
if ( isset($kopa_setting['sidebars']) ) {
    $footer_sidebar =  $kopa_setting['sidebars'];
}

// get options
$kopa_theme_options_copyright = kopa_get_option('kopa_theme_options_copyright', sprintf(__('Copyright %1$s - Kopasoft. All Rights Reserved.', 'new-lotus'), date('Y')));
$kopa_theme_options_copyright = htmlspecialchars_decode(stripslashes($kopa_theme_options_copyright));
?>

<?php
    if( is_active_sidebar($footer_sidebar['position_7']) ||
        is_active_sidebar($footer_sidebar['position_3']) ||
        is_active_sidebar($footer_sidebar['position_4']) || 
        is_active_sidebar($footer_sidebar['position_5']) || 
        is_active_sidebar($footer_sidebar['position_6'])
      ) {?>
        <section id="bottom-sidebar" class="container">
            <?php if ( is_active_sidebar($footer_sidebar['position_3']) ) { ?>
            <section class="top-bottom-sidebar widget-area-3">
                <?php dynamic_sidebar($footer_sidebar['position_3']); ?>            
            </section>
            <!-- top bottom sidebar -->
            <?php } ?>
            <div class="middle-bottom-sidebar">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <?php if (is_active_sidebar($footer_sidebar['position_4']) ) { ?>
                        <section class="widget-area-4">
                            <?php dynamic_sidebar($footer_sidebar['position_4']); ?>
                        </section>
                        <!-- widget area 4 -->
                        <?php } ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <?php if ( is_active_sidebar($footer_sidebar['position_5']) ) { ?>
                        <section class="widget-area-5">
                            <?php dynamic_sidebar($footer_sidebar['position_5']); ?>
                        </section>
                        <!-- widget area 5 -->
                        <?php } ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <?php if ( is_active_sidebar($footer_sidebar['position_6']) ) { ?>
                        <section class="widget-area-6">
                            <?php dynamic_sidebar($footer_sidebar['position_6']); ?>
                        </section>
                        <!-- widget area 6 -->
                        <?php } ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <?php if ( is_active_sidebar($footer_sidebar['position_7']) ) { ?>
                        <section class="widget-area-7">
                            <?php dynamic_sidebar($footer_sidebar['position_7']); ?>
                        </section>
                        <!-- widget area 7 -->
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- middle bottom sidebar -->
        </section>
    <?php }
?>

<footer id="kopa-footer" class="container">
    <div id="copy-right">
        <span>
            <?php
                echo wp_kses( $kopa_theme_options_copyright, array(
                    'strong' => array(),
                    'b' => array(),
                    'i' => array(),
                    'small' => array(),
                    'a' => array()
                ) );
            ?>
        </span>
    </div>
</footer>
<i class="fa fa-arrow-up back-to-top"></i>
<?php wp_footer(); ?>
</body>
</html>