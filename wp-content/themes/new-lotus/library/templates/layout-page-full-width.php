<?php
    get_header();
?>
 <section id="main-content">
<div class="container">
    <div class="clearfix">
        <section id="main-col" class="pull-left">

        <?php kopa_breadcrumb();?>
        <!-- breadcrumb -->

        <?php get_template_part( 'library/templates/loop', 'page' ); ?>

        </section>
        <!-- main-col -->
        
    </div>
</div>
 </section>

<?php get_footer(); ?>