<?php if(have_posts()):?>
<div class="widget kopa-list-posts-widget">
    <div class="widget-content">
        <ul class="list-unstyled">
            <?php while(have_posts()):the_post();?>
            <li id="post-<?php the_ID(); ?>" <?php post_class( 'item' ); ?>>
                <a href="<?php the_permalink(); ?>" class="post-thumb pull-left img-responsive">
                    <?php if (has_post_thumbnail()) { ?>
                        <?php the_post_thumbnail(); ?>
                    <?php
                    } elseif ('1' === kopa_get_option('blog_thumbnail_status')) {
                        echo '<img src="' . get_template_directory_uri() . '/images/sample/sample_400x325.gif" alt="' . get_the_title() . '">';
                    }
                    ?>
                </a>
                <aside class="item-right post-caption">
                    <h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <div class="post-meta">
                        
                        <?php if ('1' === kopa_get_option('post_meta_date_status')) : ?>
                            <span class="post-date"><?php echo get_the_date(get_option('date_format')); ?> </span>
                        <?php endif; ?>
                        <?php if ('1' === kopa_get_option('post_meta_author_status')) : ?>
                            <span class="post-user"><?php _e('By', 'new-lotus'); ?> <?php the_author_posts_link(); ?></span>
                        <?php endif; ?>
                    </div>
                    <p><?php echo kopa_get_the_excerpt_for_widget(get_the_excerpt(), get_the_content()); ?></p>
                    <?php if ('1' === kopa_get_option('post_readmore_status')) { ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="more-link"><?php _e('Read more', 'new-lotus'); ?></a>
                    <?php } ?>
                </aside>
            </li>
            <?php endwhile;  ?>
            
        </ul>
        
        <footer>
            <?php get_template_part('library/templates/template', 'pagination'); ?>
        </footer>
    </div>
</div>
<?php else:?>
<blockquote class="kopa-blockquote-1"><?php _e('Nothing Found...', 'new-lotus'); ?></blockquote>
<?php endif; ?>

