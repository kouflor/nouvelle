<?php
global $kopa_setting;
$blog = array();
if ( isset($kopa_setting['sidebars']) ) {
    $blog =  $kopa_setting['sidebars'];
}

get_header();
?>
<section id="main-content">
    <div class="container">
        <div class="clearfix">
            <section id="main-col" class="pull-left">
                <?php
                $breadcrumb = kopa_get_option('breadcrumb_status');
                if('1'===$breadcrumb){
                    kopa_breadcrumb();
                }
                ?>
                <!-- kopa-breadcrumb -->
                
                <?php if(!is_search()){ 
                    if (is_active_sidebar($blog['position_2']) ) { ?>
                    <section class="widget-area-2">
                        <?php dynamic_sidebar($blog['position_2']); ?>            
                    </section>
                <?php } } ?>
                
                <?php get_template_part('library/templates/loop', 'blog');?>
            </section>
            <?php if (is_active_sidebar($blog['position_1']) ) { ?>
            <section id="sidebar" class="widget-area-1 pull-left">
                 <?php dynamic_sidebar($blog['position_1']); ?>
            </section>
            <?php } ?>
        </div>
    </div>
</section>
<!-- main content -->
<?php get_footer(); ?>