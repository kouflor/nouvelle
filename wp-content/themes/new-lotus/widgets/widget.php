<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('ABSPATH'))
    exit;

class Kopa_Widget_Media extends Kopa_Widget {

    public function __construct() {
        $this->widget_cssclass = 'kopa-media-widget';
        $this->widget_description = __('Display videos playlist', 'new-lotus');
        $this->widget_id = 'kopa_video_playlist';
        $this->widget_name = __('Kopa Video Playlist', 'new-lotus');

        $all_cats = get_categories();
        $categories = array();
        $categories[''] = __('---Select categories---', 'new-lotus');
        foreach ($all_cats as $cat) {
            $categories[$cat->term_id] = $cat->name;
        }

        $all_tags = get_tags();
        $tags = array();
        $tags[''] = __('---Select tags---', 'new-lotus');
        foreach ($all_tags as $tag) {
            $tags[$tag->term_id] = $tag->name;
        }

        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => __('', 'new-lotus'),
                'label' => __('Title', 'new-lotus')
            ),
            'categories' => array(
                'type' => 'multiselect',
                'std' => '',
                'label' => __('Categories', 'new-lotus'),
                'options' => $categories,
                'size' => '5',
            ),
            'relation' => array(
                'type' => 'select',
                'label' => __('Relation', 'new-lotus'),
                'std' => 'OR',
                'options' => array(
                    'AND' => __('AND', 'new-lotus'),
                    'OR' => __('OR', 'new-lotus'),
                ),
            ),
            'tags' => array(
                'type' => 'multiselect',
                'std' => '',
                'label' => __('Tags', 'new-lotus'),
                'options' => $tags,
                'size' => '5',
            ),
            'orderby' => array(
                'type' => 'select',
                'std' => 'date',
                'label' => __('Order by', 'new-lotus'),
                'options' => array(
                    'ID' => __('Post id', 'new-lotus'),
                    'title' => __('Title', 'new-lotus'),
                    'date' => __('Date', 'new-lotus'),
                    'rand' => __('Random', 'new-lotus'),
                    'comment_count' => __('Number of comments', 'new-lotus'),
                ),
            ),
            'order' => array(
                'type' => 'select',
                'std' => 'DESC',
                'label' => __('Ordering', 'new-lotus'),
                'options' => array(
                    'ASC' => __('ASC', 'new-lotus'),
                    'DESC' => __('DESC', 'new-lotus'),
                ),
            ),
            'posts_per_page' => array(
                'type' => 'number',
                'std' => '4',
                'label' => __('Number of posts', 'new-lotus'),
                'min' => '1',
            ),
            'timestamp' => array(
                'type' => 'select',
                'std' => '',
                'label' => __('Timestamp (ago)', 'new-lotus'),
                'options' => array(
                    '' => __('-- Select --', 'new-lotus'),
                    '-1 week' => __('1 week', 'new-lotus'),
                    '-2 week' => __('2 weeks', 'new-lotus'),
                    '-3 week' => __('3 weeks', 'new-lotus'),
                    '-1 month' => __('1 months', 'new-lotus'),
                    '-2 month' => __('2 months', 'new-lotus'),
                    '-3 month' => __('3 months', 'new-lotus'),
                    '-4 month' => __('4 months', 'new-lotus'),
                    '-5 month' => __('5 months', 'new-lotus'),
                    '-6 month' => __('6 months', 'new-lotus'),
                    '-7 month' => __('7 months', 'new-lotus'),
                    '-8 month' => __('8 months', 'new-lotus'),
                    '-9 month' => __('9 months', 'new-lotus'),
                    '-10 month' => __('10 months', 'new-lotus'),
                    '-11 month' => __('11 months', 'new-lotus'),
                    '-1 year' => __('1 year', 'new-lotus'),
                    '-2 year' => __('2 years', 'new-lotus'),
                    '-3 year' => __('3 years', 'new-lotus'),
                    '-4 year' => __('4 years', 'new-lotus'),
                    '-5 year' => __('5 years', 'new-lotus'),
                    '-6 year' => __('6 years', 'new-lotus'),
                    '-7 year' => __('7 years', 'new-lotus'),
                    '-8 year' => __('8 years', 'new-lotus'),
                    '-9 year' => __('9 years', 'new-lotus'),
                    '-10 year' => __('10 years', 'new-lotus'),
                ),
            ),
        );
        parent::__construct();
    }

    /**
     * widget function.
     *
     * @see WP_Widget
     * @access public
     * @param array $args
     * @param array $instance
     * @return void
     */
    public function widget($args, $instance) {

        if ($this->get_cached_widget($args))
            return;

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
        $query_args_new = kopa_build_query($instance);

        $r = new WP_Query($query_args_new);
        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }
        if ($r->have_posts()) {
            $index = 0;
            while ($r->have_posts()) {
                $r->the_post();
                if (0 == $index) {
                    ?>
                    <div class="item latest-post">
                        <div class="video-wrapper">
                            <?php
                            $aVideo = kopa_content_get_video(get_the_content());
                            if (isset($aVideo[0])) {
                                $video = $aVideo[0];

                                if (isset($video['shortcode'])) {
                                    echo do_shortcode($video['shortcode']);
                                }
                            } else {
                                ?>
                                <a href="<?php the_permalink(); ?>" class="img-responsive">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        echo kopa_the_image(get_the_ID(), get_the_title(), 420, 315, true);
                                    } else {
                                        echo '<img src="' . get_template_directory_uri() . '/images/sample/sample_420x315.gif" alt="no thumbnail">';
                                    }
                                    ?>
                                </a>
                                <?php
                            }
                            ?>

                        </div>
                    </div>
                    <!-- item -->
                    <?php
                } else {
                    ?>
                    <div class="item item<?php echo $index; ?>">
                        <h4 class="post-title"><span><i class="fa fa-youtube-play"></i></span><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    </div>
                    <?php
                }
                $index++;
            }
            wp_reset_postdata();
        }
        echo $after_widget;
        $content = ob_get_clean();
        echo $content;
        $this->cache_widget($args, $content);
    }

}

register_widget('Kopa_Widget_Media');

class Kopa_Widget_Accordions extends Kopa_Widget {

    public function __construct() {
        $this->widget_cssclass = 'kopa-accordion-widget';
        $this->widget_description = __('Display popular articles, recent articles and most comment articles', 'new-lotus');
        $this->widget_id = 'kopa_accordions_playlist';
        $this->widget_name = __('Kopa Accordions', 'new-lotus');

        $this->settings = array(
            'popular_title' => array(
                'type' => 'text',
                'std' => __('POPULAR', 'new-lotus'),
                'label' => __('Popular title', 'new-lotus')
            ),
            'comment_title' => array(
                'type' => 'text',
                'std' => __('COMMENT', 'new-lotus'),
                'label' => __('Comment title', 'new-lotus')
            ),
            'latest_title' => array(
                'type' => 'text',
                'std' => __('RECENT', 'new-lotus'),
                'label' => __('Latest title', 'new-lotus')
            ),
            'order' => array(
                'type' => 'select',
                'std' => 'DESC',
                'label' => __('Ordering', 'new-lotus'),
                'options' => array(
                    'ASC' => __('ASC', 'new-lotus'),
                    'DESC' => __('DESC', 'new-lotus'),
                ),
            ),
            'posts_per_page' => array(
                'type' => 'number',
                'std' => '5',
                'label' => __('Number of posts', 'new-lotus'),
                'min' => '1',
            ),
            'timestamp' => array(
                'type' => 'select',
                'std' => '',
                'label' => __('Timestamp (ago)', 'new-lotus'),
                'options' => array(
                    '' => __('-- Select --', 'new-lotus'),
                    '-1 week' => __('1 week', 'new-lotus'),
                    '-2 week' => __('2 weeks', 'new-lotus'),
                    '-3 week' => __('3 weeks', 'new-lotus'),
                    '-1 month' => __('1 months', 'new-lotus'),
                    '-2 month' => __('2 months', 'new-lotus'),
                    '-3 month' => __('3 months', 'new-lotus'),
                    '-4 month' => __('4 months', 'new-lotus'),
                    '-5 month' => __('5 months', 'new-lotus'),
                    '-6 month' => __('6 months', 'new-lotus'),
                    '-7 month' => __('7 months', 'new-lotus'),
                    '-8 month' => __('8 months', 'new-lotus'),
                    '-9 month' => __('9 months', 'new-lotus'),
                    '-10 month' => __('10 months', 'new-lotus'),
                    '-11 month' => __('11 months', 'new-lotus'),
                    '-1 year' => __('1 year', 'new-lotus'),
                    '-2 year' => __('2 years', 'new-lotus'),
                    '-3 year' => __('3 years', 'new-lotus'),
                    '-4 year' => __('4 years', 'new-lotus'),
                    '-5 year' => __('5 years', 'new-lotus'),
                    '-6 year' => __('6 years', 'new-lotus'),
                    '-7 year' => __('7 years', 'new-lotus'),
                    '-8 year' => __('8 years', 'new-lotus'),
                    '-9 year' => __('9 years', 'new-lotus'),
                    '-10 year' => __('10 years', 'new-lotus'),
                ),
            ),
        );
        parent::__construct();
    }

    public function widget($args, $instance) {

        if ($this->get_cached_widget($args))
            return;

        ob_start();
        extract($args);

        $number_id = rand();
        echo $before_widget;

        $tab_args = array();


        if ($instance['popular_title']) {
            $tab_args[] = array(
                'label' => $instance['popular_title'],
                'orderby' => 'popular',
            );
        }

        if ($instance['latest_title']) {
            $tab_args[] = array(
                'label' => $instance['latest_title'],
                'orderby' => 'date',
            );
        }

        if ($instance['comment_title']) {
            $tab_args[] = array(
                'label' => $instance['comment_title'],
                'orderby' => 'comment_count',
            );
        }
        if (!empty($tab_args)) {
            ?>
            <div class="widget-content">
                <div class="panel-group kopa-accordion" id="accordion-<?php echo $number_id; ?>">
                    <?php
                    foreach ($tab_args as $key => $tab) {
                        $instance['orderby'] = $tab['orderby'];
                        $query_args_new = kopa_build_query($instance);
                        $r = new WP_Query($query_args_new);
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion-<?php echo $number_id; ?>" href="#collapse-<?php echo $key; ?>-<?php echo $number_id; ?>"><?php echo $tab['label']; ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse-<?php echo $key; ?>-<?php echo $number_id; ?>" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <?php if ($r->have_posts()) { ?>

                                        <ul class="list-unstyled">
                                            <?php
                                            while ($r->have_posts()) {
                                                $r->the_post();
                                                ?>
                                                <li class="item">
                                                    <a href="<?php the_permalink(); ?>" class="post-thumb img-responsive">
                                                        <?php
                                                        if (has_post_thumbnail()) {
                                                            echo kopa_the_image(get_the_ID(), get_the_title(), 60, 60, true);
                                                        } else {
                                                            echo '<img src="' . get_template_directory_uri() . '/images/sample/sample_60x60.gif" alt="no thumbnail">';
                                                        }
                                                        ?>
                                                    </a>
                                                    <div class="post-caption">
                                                        <span class="post-meta">
                                                            <span class="post-date"><?php echo get_the_date(get_option('date_format')); ?> </span>
                                                        </span>
                                                        <h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        <?php wp_reset_postdata(); ?>    
                                        </ul>
                <?php } ?>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }


        echo $after_widget;
        $content = ob_get_clean();
        echo $content;
        $this->cache_widget($args, $content);
    }

}

register_widget('Kopa_Widget_Accordions');

class Kopa_Widget_Advertisement extends Kopa_Widget {

    public function __construct() {
        $this->widget_cssclass = 'kopa-ads-widget';
        $this->widget_description = __('Show advertisement', 'new-lotus');
        $this->widget_id = 'kopa_ads_widget';
        $this->widget_name = __('Kopa Advertisement', 'new-lotus');

        $this->settings = array(
            'image_url' => array(
                'type' => 'upload',
                'std' => '',
                'label' => __('Upload Image', 'new-lotus')
            ),
            'image_title' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Image Title (Show when hover on the image)', 'new-lotus')
            ),
            'image_link' => array(
                'type' => 'text',
                'std' => '',
                'label' => __('Image Link', 'new-lotus')
            ),
            'target' => array(
                'type' => 'checkbox',
                'std' => 1,
                'label' => __('Open link in a new tab', 'new-lotus')
            ),
        );
        parent::__construct();
    }

    /**
     * widget function.
     *
     * @see WP_Widget
     * @access public
     * @param array $args
     * @param array $instance
     * @return void
     */
    public function widget($args, $instance) {

        if ($this->get_cached_widget($args))
            return;

        ob_start();
        extract($args);
        echo $before_widget;

        if (!empty($instance['image_url'])) {
            $target = '_self';
            if (1 == $instance['target']) {
                $target = '_blank';
            }
            // crop image
            if (!empty($instance['image_url'])) {
                echo '<div class="widget-content"><a href="' . esc_url($instance['image_link']) . '" target="' . $target . '" title="' . $instance['image_title'] . '" class="img-responsive"><img src="' . $instance['image_url'] . '" alt="' . $instance['image_title'] . '" title="' . $instance['image_title'] . '" /></a></div>';
            }
        }

        echo $after_widget;

        $content = ob_get_clean();

        echo $content;

        $this->cache_widget($args, $content);
    }

}

register_widget('Kopa_Widget_Advertisement');

class Kopa_Widget_Social extends Kopa_Widget {

    public function __construct() {
        $this->widget_cssclass = 'kopa-social-widget';
        $this->widget_description = __('Show social link', 'new-lotus');
        $this->widget_id = 'kopa-social-widget';
        $this->widget_name = __('Kopa social link', 'new-lotus');

        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => 'Social Network',
                'label' => __('Social Network', 'new-lotus')
            ),
            'description' => array(
                'type' => 'textarea',
                'std' => '',
                'label' => __('Description', 'new-lotus')
            ),
        );
        parent::__construct();
    }

    /**
     * widget function.
     *
     * @see WP_Widget
     * @access public
     * @param array $args
     * @param array $instance
     * @return void
     */
    public function widget($args, $instance) {

        if ($this->get_cached_widget($args))
            return;

        ob_start();
        extract($args);
        $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
        echo $before_widget;
        if(!empty($title)){
            echo $before_title . $title . $after_title;
        }
        
        if(!empty($instance['description'])){
            echo '<span class="t-des">' . $instance['description'] . '</span>';
        }        
        echo '<div class="widget-content">' . kopa_social_links() . '</div>';

        echo $after_widget;

        $content = ob_get_clean();

        echo $content;

        $this->cache_widget($args, $content);
    }

}

register_widget('Kopa_Widget_Social');

class Kopa_Widget_Lightbox_Carousel extends Kopa_Widget {

    public function __construct() {
        $this->widget_cssclass = 'kopa-small-thumb-lightbox-carousel';
        $this->widget_description = __('Kopa Lightbox Galleries', 'new-lotus');
        $this->widget_id = 'kopa-small-thumb-lightbox-carousel';
        $this->widget_name = __('Kopa Lightbox Galleries', 'new-lotus');

        $all_cats = get_categories();
        $categories = array();
        $categories[''] = __('---Select categories---', 'new-lotus');
        foreach ($all_cats as $cat) {
            $categories[$cat->term_id] = $cat->name;
        }

        $all_tags = get_tags();
        $tags = array();
        $tags[''] = __('---Select tags---', 'new-lotus');
        foreach ($all_tags as $tag) {
            $tags[$tag->term_id] = $tag->name;
        }

        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => __('Gallery posts', 'new-lotus'),
                'label' => __('Gallery posts', 'new-lotus')
            ),
            'categories' => array(
                'type' => 'multiselect',
                'std' => '',
                'label' => __('Categories', 'new-lotus'),
                'options' => $categories,
                'size' => '5',
            ),
            'relation' => array(
                'type' => 'select',
                'label' => __('Relation', 'new-lotus'),
                'std' => 'OR',
                'options' => array(
                    'AND' => __('AND', 'new-lotus'),
                    'OR' => __('OR', 'new-lotus'),
                ),
            ),
            'tags' => array(
                'type' => 'multiselect',
                'std' => '',
                'label' => __('Tags', 'new-lotus'),
                'options' => $tags,
                'size' => '5',
            ),
            'orderby' => array(
                'type' => 'select',
                'std' => 'date',
                'label' => __('Order by', 'new-lotus'),
                'options' => array(
                    'ID' => __('Post id', 'new-lotus'),
                    'title' => __('Title', 'new-lotus'),
                    'date' => __('Date', 'new-lotus'),
                    'rand' => __('Random', 'new-lotus'),
                    'comment_count' => __('Number of comments', 'new-lotus'),
                ),
            ),
            'order' => array(
                'type' => 'select',
                'std' => 'DESC',
                'label' => __('Ordering', 'new-lotus'),
                'options' => array(
                    'ASC' => __('ASC', 'new-lotus'),
                    'DESC' => __('DESC', 'new-lotus'),
                ),
            ),
            'posts_per_page' => array(
                'type' => 'number',
                'std' => '5',
                'label' => __('Number of posts', 'new-lotus'),
                'min' => '1',
            ),
            'timestamp' => array(
                'type' => 'select',
                'std' => '',
                'label' => __('Timestamp (ago)', 'new-lotus'),
                'options' => array(
                    '' => __('-- Select --', 'new-lotus'),
                    '-1 week' => __('1 week', 'new-lotus'),
                    '-2 week' => __('2 weeks', 'new-lotus'),
                    '-3 week' => __('3 weeks', 'new-lotus'),
                    '-1 month' => __('1 months', 'new-lotus'),
                    '-2 month' => __('2 months', 'new-lotus'),
                    '-3 month' => __('3 months', 'new-lotus'),
                    '-4 month' => __('4 months', 'new-lotus'),
                    '-5 month' => __('5 months', 'new-lotus'),
                    '-6 month' => __('6 months', 'new-lotus'),
                    '-7 month' => __('7 months', 'new-lotus'),
                    '-8 month' => __('8 months', 'new-lotus'),
                    '-9 month' => __('9 months', 'new-lotus'),
                    '-10 month' => __('10 months', 'new-lotus'),
                    '-11 month' => __('11 months', 'new-lotus'),
                    '-1 year' => __('1 year', 'new-lotus'),
                    '-2 year' => __('2 years', 'new-lotus'),
                    '-3 year' => __('3 years', 'new-lotus'),
                    '-4 year' => __('4 years', 'new-lotus'),
                    '-5 year' => __('5 years', 'new-lotus'),
                    '-6 year' => __('6 years', 'new-lotus'),
                    '-7 year' => __('7 years', 'new-lotus'),
                    '-8 year' => __('8 years', 'new-lotus'),
                    '-9 year' => __('9 years', 'new-lotus'),
                    '-10 year' => __('10 years', 'new-lotus'),
                ),
            ),
        );
        parent::__construct();
    }

    function widget($args, $instance) {
        if ($this->get_cached_widget($args))
            return;

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
        $query_args_new = kopa_build_query($instance);

        $r = new WP_Query($query_args_new);
        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        if ($r->have_posts()) {
            ?>
            <div class="widget-content">
                <ul class="list-unstyled">
                    <?php
                    while ($r->have_posts()) {
                        $r->the_post();
                        ?>
                        <li>
                            <h2 class="post-cat"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <?php
                                $attachment_ids = kopa_content_get_gallery_attachment_ids(get_the_content());
                                if ($attachment_ids) {
                            ?>
                                <div class="wrap-carousel">
                                    <div class="owl-carousel" >
                                            <?php foreach ($attachment_ids as $ids) { ?>
                                            <div class="item">
                                                <a href="<?php echo kopa_get_image_by_id($ids); ?>" class="group-colorbox">
                                                    <?php echo kopa_the_image($ids, 'gallery-' . $ids, 300, 217, true, true); ?>
                                                </a>
                                            </div>
                                            <?php } ?>
                                    </div>
                                </div>
                        <?php } ?>
                        </li>
                    <?php }
                    ?>
                </ul>
            </div>
            <?php
        }
        wp_reset_postdata();


        echo $after_widget;
        $content = ob_get_clean();
        echo $content;
        $this->cache_widget($args, $content);
    }

}

register_widget('Kopa_Widget_Lightbox_Carousel');

class Kopa_Widget_Article_List extends Kopa_Widget{
    
    public function __construct() {
        $this->widget_cssclass = 'kopa-posts-widget first-big';
        $this->widget_description = __('Kopa Article List', 'new-lotus');
        $this->widget_id = 'kopa-posts-widget';
        $this->widget_name = __('Kopa Article List', 'new-lotus');

        $all_cats = get_categories();
        $categories = array();
        $categories[''] = __('---Select categories---', 'new-lotus');
        foreach ($all_cats as $cat) {
            $categories[$cat->term_id] = $cat->name;
        }

        $all_tags = get_tags();
        $tags = array();
        $tags[''] = __('---Select tags---', 'new-lotus');
        foreach ($all_tags as $tag) {
            $tags[$tag->term_id] = $tag->name;
        }

        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => __('Life style', 'new-lotus'),
                'label' => __('Life style', 'new-lotus')
            ),
            'categories' => array(
                'type' => 'multiselect',
                'std' => '',
                'label' => __('Categories', 'new-lotus'),
                'options' => $categories,
                'size' => '5',
            ),
            'relation' => array(
                'type' => 'select',
                'label' => __('Relation', 'new-lotus'),
                'std' => 'OR',
                'options' => array(
                    'AND' => __('AND', 'new-lotus'),
                    'OR' => __('OR', 'new-lotus'),
                ),
            ),
            'tags' => array(
                'type' => 'multiselect',
                'std' => '',
                'label' => __('Tags', 'new-lotus'),
                'options' => $tags,
                'size' => '5',
            ),
            'orderby' => array(
                'type' => 'select',
                'std' => 'date',
                'label' => __('Order by', 'new-lotus'),
                'options' => array(
                    'ID' => __('Post id', 'new-lotus'),
                    'title' => __('Title', 'new-lotus'),
                    'date' => __('Date', 'new-lotus'),
                    'rand' => __('Random', 'new-lotus'),
                    'comment_count' => __('Number of comments', 'new-lotus'),
                ),
            ),
            'order' => array(
                'type' => 'select',
                'std' => 'DESC',
                'label' => __('Ordering', 'new-lotus'),
                'options' => array(
                    'ASC' => __('ASC', 'new-lotus'),
                    'DESC' => __('DESC', 'new-lotus'),
                ),
            ),
            'posts_per_page' => array(
                'type' => 'number',
                'std' => '5',
                'label' => __('Number of posts', 'new-lotus'),
                'min' => '1',
            ),
            'limit' => array(
                'type' => 'number',
                'std' => '55',
                'label' => __('Exerpt of posts', 'new-lotus'),
                'min' => '1',
            ),
            'timestamp' => array(
                'type' => 'select',
                'std' => '',
                'label' => __('Timestamp (ago)', 'new-lotus'),
                'options' => array(
                    '' => __('-- Select --', 'new-lotus'),
                    '-1 week' => __('1 week', 'new-lotus'),
                    '-2 week' => __('2 weeks', 'new-lotus'),
                    '-3 week' => __('3 weeks', 'new-lotus'),
                    '-1 month' => __('1 months', 'new-lotus'),
                    '-2 month' => __('2 months', 'new-lotus'),
                    '-3 month' => __('3 months', 'new-lotus'),
                    '-4 month' => __('4 months', 'new-lotus'),
                    '-5 month' => __('5 months', 'new-lotus'),
                    '-6 month' => __('6 months', 'new-lotus'),
                    '-7 month' => __('7 months', 'new-lotus'),
                    '-8 month' => __('8 months', 'new-lotus'),
                    '-9 month' => __('9 months', 'new-lotus'),
                    '-10 month' => __('10 months', 'new-lotus'),
                    '-11 month' => __('11 months', 'new-lotus'),
                    '-1 year' => __('1 year', 'new-lotus'),
                    '-2 year' => __('2 years', 'new-lotus'),
                    '-3 year' => __('3 years', 'new-lotus'),
                    '-4 year' => __('4 years', 'new-lotus'),
                    '-5 year' => __('5 years', 'new-lotus'),
                    '-6 year' => __('6 years', 'new-lotus'),
                    '-7 year' => __('7 years', 'new-lotus'),
                    '-8 year' => __('8 years', 'new-lotus'),
                    '-9 year' => __('9 years', 'new-lotus'),
                    '-10 year' => __('10 years', 'new-lotus'),
                ),
            ),
        );
        parent::__construct();
    }
    


    function widget($args, $instance){
        if ($this->get_cached_widget($args))
            return;

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
        $query_args_new = kopa_build_query($instance);

        $r = new WP_Query($query_args_new);
        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }
        
        if($r->have_posts()){
            ?>
            <div class="widget-content">
                <ul class="list-unstyled">
                    <?php 
                    $index=1;
                    while($r->have_posts()){
                        $r->the_post();
                        if(1 == $index){
                            ?>
                            <li class="item">
                                <a href="<?php the_permalink(); ?>" class="post-thumb img-responsive">
                                    <?php if(has_post_thumbnail()){
                                        echo kopa_the_image(get_the_ID(),get_the_title(),400,231,true);
                                    } else {
                                        echo '<img src="'.get_template_directory_uri().'/images/sample/sample_400x231.gif" alt="no thumbnail">';
                                    } ?>
                                </a>
                                <div class="post-caption">
                                    <span class="post-meta">
                                        <span class="post-date"><?php echo get_the_date(get_option('date_format')); ?> </span>
                                        <?php if(comments_open()){
                                            ?>
                                            <span class="post-comments">    
                                            <?php
                                            comments_popup_link( __('No comment','new-lotus'), __('1 comment','new-lotus'), __('% comments','new-lotus'));
                                            ?>
                                            </span>
                                            <?php
                                        } ?>
                                    </span>
                                    <h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <p><?php echo kopa_get_the_excerpt_for_widget('','',$instance['limit']); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="more-link"><?php _e('read more','new-lotus'); ?></a>
                                </div>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li class="item">
                                <a href="<?php the_permalink(); ?>" class="post-thumb img-responsive">
                                    <?php if(has_post_thumbnail()){
                                        echo kopa_the_image(get_the_ID(),get_the_title(),60,60,true);
                                    } else{
                                        echo '<img src="'.get_template_directory_uri().'/images/sample/sample_60x60.gif" alt="no thumbnail">';
                                    } ?>
                                </a>
                                <div class="post-caption">
                                    <span class="post-meta">
                                        <span class="post-date"><?php echo get_the_date(get_option('date_format')); ?> </span>
                                    </span>
                                    <h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                </div>
                            </li>
                            <?php
                        }
                        $index++;
                    } 
                    wp_reset_postdata();
                     ?>
                </ul>
            </div>
            <?php
        }
        
        wp_reset_postdata();
        echo $after_widget;
        $content = ob_get_clean();
        echo $content;
        $this->cache_widget($args, $content);
    }

}

register_widget('Kopa_Widget_Article_List');

class Kopa_Widget_Feedburner_Subscribe extends Kopa_Widget {
    public function __construct() {
        $this->widget_cssclass = 'kopa-newletter-widget';
        $this->widget_description = __('Kopa newletter', 'new-lotus');
        $this->widget_id = 'kopa-newletter-widget';
        $this->widget_name = __('Kopa newletter', 'new-lotus');

        $this->settings = array(
            'feedburner_id' => array(
                'type' => 'text',
                'std' => __('', 'new-lotus'),
                'label' => __('Feedburner id', 'new-lotus')
            ),
            'placeholder' => array(
                'type' => 'text',
                'std' => __('Enter your email address ...', 'new-lotus'),
                'label' => __('Placeholder', 'new-lotus')
            ),
            'submit_btn' => array(
                'type' => 'text',
                'std' => __('Subcribe', 'new-lotus'),
                'label' => __('Text submit', 'new-lotus')
            ),
            
        );
        parent::__construct();
    }
    
    function widget( $args, $instance ) {
        if ($this->get_cached_widget($args))
            return;

        ob_start();
        extract($args);
        
        $feedburner_id = $instance['feedburner_id'];
        $submit_btn_text = ! empty( $instance['submit_btn'] ) ? $instance['submit_btn'] : __( 'Signup', 'new-lotus' );
        $placeholder = ! empty( $instance['placeholder'] ) ? $instance['placeholder'] : __( 'Enter your email address ...', 'new-lotus' );
        echo $before_widget;
       ?>
       
        
            <div class="widget-content">
                <form action="http://feedburner.google.com/fb/a/mailverify" method="post" class="form-news-letter" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $feedburner_id; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520'); return true;">
                    <input type="hidden" value="<?php echo esc_attr( $feedburner_id ); ?>" name="uri">

                        <input type="text" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" name="search-text" value="<?php echo $placeholder;?>" class="form-control" size="40">
                        <input type="submit" class="submit" value="<?php echo $submit_btn_text;?>">

                    <div id="newsletter-response"></div>
                </form>
            </div>
        <?php
        echo $after_widget;
        $content = ob_get_clean();
        echo $content;
        $this->cache_widget($args, $content);
    }
}

register_widget('Kopa_Widget_Feedburner_Subscribe');


class Kopa_Widget_Flickr extends Kopa_Widget {
    
    public function __construct() {
        $this->widget_cssclass = 'kopa-flickr-widget';
        $this->widget_description = __('Kopa flickr', 'new-lotus');
        $this->widget_id = 'kopa-flickr-widget';
        $this->widget_name = __('Kopa flickr', 'new-lotus');

        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => __('Photo on flickr', 'new-lotus'),
                'label' => __('Title', 'new-lotus')
            ),
            'flickr_id' => array(
                'type' => 'text',
                'std' => __('', 'new-lotus'),
                'label' => __('Flickr id', 'new-lotus')
            ),
            'limit' => array(
                'type' => 'text',
                'std' => __('6', 'new-lotus'),
                'label' => __('Limit', 'new-lotus')
            ),
            
        );
        parent::__construct();
    }
    

    function widget($args, $instance){
        if ($this->get_cached_widget($args))
            return;

        ob_start();
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __('RECENT ', 'new-lotus') : $instance['title'], $instance, $this->id_base);
        
        $id = $instance['flickr_id'];
        $limit = $instance['limit'];

        $out = '<div class="widget-content">';
        $out .= sprintf('<div class="flickr-wrap clearfix" data-user="%s" data-limit="%s">', $id, $limit);
        $out .= '<ul class="clearfix list-unstyled"></ul>';
        $out .= '</div></div>';
        echo $before_widget;
        if (!empty($title)) { 
             echo $before_title.$title.$after_title;
        }
        echo apply_filters('kopa_flickr_widget', $out);
        echo $after_widget;
        $content = ob_get_clean();
        echo $content;
        $this->cache_widget($args, $content);
    }

    
}

register_widget('Kopa_Widget_Flickr');


class Kopa_Widget_Sync_Carousel extends Kopa_Widget {

    public function __construct() {
        $this->widget_cssclass = 'kopa-two-col-sync-carousel-3-widget';
        $this->widget_description = __('Display Sync Carousel', 'new-lotus');
        $this->widget_id = 'kopa-two-col-sync-carousel-widget';
        $this->widget_name = __('Kopa Sync Carousel', 'new-lotus');

        $all_cats = get_categories();
        $categories = array();
        $categories[''] = __('---Select categories---', 'new-lotus');
        foreach ($all_cats as $cat) {
            $categories[$cat->term_id] = $cat->name;
        }

        $all_tags = get_tags();
        $tags = array();
        $tags[''] = __('---Select tags---', 'new-lotus');
        foreach ($all_tags as $tag) {
            $tags[$tag->term_id] = $tag->name;
        }

        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => __('', 'new-lotus'),
                'label' => __('Title', 'new-lotus')
            ),
            'categories' => array(
                'type' => 'multiselect',
                'std' => '',
                'label' => __('Categories', 'new-lotus'),
                'options' => $categories,
                'size' => '5',
            ),
            'relation' => array(
                'type' => 'select',
                'label' => __('Relation', 'new-lotus'),
                'std' => 'OR',
                'options' => array(
                    'AND' => __('AND', 'new-lotus'),
                    'OR' => __('OR', 'new-lotus'),
                ),
            ),
            'tags' => array(
                'type' => 'multiselect',
                'std' => '',
                'label' => __('Tags', 'new-lotus'),
                'options' => $tags,
                'size' => '5',
            ),
            'orderby' => array(
                'type' => 'select',
                'std' => 'date',
                'label' => __('Order by', 'new-lotus'),
                'options' => array(
                    'ID' => __('Post id', 'new-lotus'),
                    'title' => __('Title', 'new-lotus'),
                    'date' => __('Date', 'new-lotus'),
                    'rand' => __('Random', 'new-lotus'),
                    'comment_count' => __('Number of comments', 'new-lotus'),
                ),
            ),
            'order' => array(
                'type' => 'select',
                'std' => 'DESC',
                'label' => __('Ordering', 'new-lotus'),
                'options' => array(
                    'ASC' => __('ASC', 'new-lotus'),
                    'DESC' => __('DESC', 'new-lotus'),
                ),
            ),
            'posts_per_page' => array(
                'type' => 'number',
                'std' => '4',
                'label' => __('Number of posts', 'new-lotus'),
                'min' => '1',
            ),
            'timestamp' => array(
                'type' => 'select',
                'std' => '',
                'label' => __('Timestamp (ago)', 'new-lotus'),
                'options' => array(
                    '' => __('-- Select --', 'new-lotus'),
                    '-1 week' => __('1 week', 'new-lotus'),
                    '-2 week' => __('2 weeks', 'new-lotus'),
                    '-3 week' => __('3 weeks', 'new-lotus'),
                    '-1 month' => __('1 months', 'new-lotus'),
                    '-2 month' => __('2 months', 'new-lotus'),
                    '-3 month' => __('3 months', 'new-lotus'),
                    '-4 month' => __('4 months', 'new-lotus'),
                    '-5 month' => __('5 months', 'new-lotus'),
                    '-6 month' => __('6 months', 'new-lotus'),
                    '-7 month' => __('7 months', 'new-lotus'),
                    '-8 month' => __('8 months', 'new-lotus'),
                    '-9 month' => __('9 months', 'new-lotus'),
                    '-10 month' => __('10 months', 'new-lotus'),
                    '-11 month' => __('11 months', 'new-lotus'),
                    '-1 year' => __('1 year', 'new-lotus'),
                    '-2 year' => __('2 years', 'new-lotus'),
                    '-3 year' => __('3 years', 'new-lotus'),
                    '-4 year' => __('4 years', 'new-lotus'),
                    '-5 year' => __('5 years', 'new-lotus'),
                    '-6 year' => __('6 years', 'new-lotus'),
                    '-7 year' => __('7 years', 'new-lotus'),
                    '-8 year' => __('8 years', 'new-lotus'),
                    '-9 year' => __('9 years', 'new-lotus'),
                    '-10 year' => __('10 years', 'new-lotus'),
                ),
            ),
        );
        parent::__construct();
    }

    /**
     * widget function.
     *
     * @see WP_Widget
     * @access public
     * @param array $args
     * @param array $instance
     * @return void
     */
    public function widget($args, $instance) {

        if ($this->get_cached_widget($args))
            return;

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
        $query_args_new = kopa_build_query($instance);

        $r = new WP_Query($query_args_new);
        echo $before_widget;
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }
        if ($r->have_posts()) { ?>               
            
            <div class="widget kopa-two-col-sync-carousel-3-widget">
                <div class="widget-content clearfix">
                    <div class="owl-carousel sync8">
                        <?php
                        while ($r->have_posts()) {
                            $r->the_post(); ?>
                            <div class="item">
                                <div class="post-thumb pull-left">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        echo kopa_the_image(get_the_ID(), get_the_title(), 60, 60, true);
                                    } else {
                                        echo '<img src="' . get_template_directory_uri() . '/images/sample/sample_60x60.gif" alt="no thumbnail">';
                                    }
                                    ?>
                                </div>
                                <aside class="item-right">
                                    <div class="post-meta">
                                        <span class="post-date"><?php echo get_the_date(get_option('date_format')); ?> </span>
                                        <span class="post-user">By <a href="#"><?php the_author(); ?></a></span>
                                    </div>
                                    <h4 class="post-title"><?php the_title(); ?></h4>
                                </aside>
                            </div>
                        <?php } ?>
                        
                    </div>
                    <div class="owl-carousel sync7">
                        <?php
                        while ($r->have_posts()) {
                            $r->the_post(); ?>
                        <div class="item">
                            <a href="<?php the_permalink(); ?>" class="post-thumb img-responsive">
                                <?php
                                if (has_post_thumbnail()) {
                                    echo kopa_the_image(get_the_ID(), get_the_title(), 490, 410, true);
                                } else {
                                    echo '<img src="' . get_template_directory_uri() . '/images/sample/sample_60x60.gif" alt="no thumbnail">';
                                }
                                ?>
                            </a>
                        </div>
                        <?php } ?>
                    </div>
            
                </div>
            </div>
            <?php
            wp_reset_postdata();
        }
        echo $after_widget;
        $content = ob_get_clean();
        echo $content;
        $this->cache_widget($args, $content);
    }

}

register_widget('Kopa_Widget_Sync_Carousel');
?>
