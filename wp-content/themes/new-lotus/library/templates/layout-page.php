<?php 
    get_header(); 
    global $kopa_setting;
    $sidebar = array();
    if ( isset($kopa_setting['sidebars']) ) {
        $sidebar =  $kopa_setting['sidebars'];
    }
?>
<section id="main-content">
    <div class="container">
        <div class="clearfix">
            <section id="main-col" class="pull-left">
                <?php kopa_breadcrumb(); ?>
                <?php get_template_part( 'library/templates/loop', 'page' ); ?>
            </section>
            <?php if (is_active_sidebar($sidebar['position_1']) ) { ?>
            <section id="sidebar" class="widget-area-1 pull-left">
                 <?php dynamic_sidebar($sidebar['position_1']); ?>
            </section>
            <?php } ?>
        </div>
    </div>
</section>
<!-- main content -->
<?php get_footer(); ?>