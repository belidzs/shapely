<?php

/**
 * Flexible Top Posts Widget
 * Flexible Theme
 */
class flexible_recent_posts extends WP_Widget {

  function __construct() {

    $widget_ops = array('classname' => 'flexible-recent-posts', 'description' => esc_html__("Widget to show recent posts", 'flexible'));
    parent::__construct('flexible_recent_posts', esc_html__('Flexible Recent Posts', 'flexible'), $widget_ops);
  }

  function widget($args, $instance) {
    extract($args);
    $title = isset($instance['title']) ? $instance['title'] : esc_html__('recent Posts', 'flexible');
    $limit = isset($instance['limit']) ? $instance['limit'] : 5;

    echo $before_widget;
    echo $before_title;
    echo $title;
    echo $after_title;

    /**
     * Widget Content
     */
    ?>

    <!-- recent posts -->
    <div class="recent-posts-wrapper nolist">

      <?php
      $featured_args = array(
          'posts_per_page' => $limit,
          'ignore_sticky_posts' => 1
      );

      $featured_query = new WP_Query($featured_args);

      if ($featured_query->have_posts()) : ?>
      
        <ul class="link-list recent-posts"><?php
            
          while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
          
            <?php if (get_the_content() != '') : ?>

              <!-- content -->
              <li class="post-content">
                <a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
                <span class="date"><?php echo get_the_date('d M , Y'); ?></span>
              </li>
              <!-- end content -->

            <?php endif; ?>

          <?php endwhile; ?>
        </ul><?php
          
      endif;
      wp_reset_query();
      ?>

    </div> <!-- end posts wrapper -->

    <?php
    echo $after_widget;
  }

  function form($instance) {

    if (!isset($instance['title']))
      $instance['title'] = esc_html__('recent Posts', 'flexible');
    if (!isset($instance['limit']))
      $instance['limit'] = 5;
    ?>

    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title', 'flexible') ?></label>

      <input  type="text" value="<?php echo esc_attr($instance['title']); ?>"
              name="<?php echo $this->get_field_name('title'); ?>"
              id="<?php $this->get_field_id('title'); ?>"
              class="widefat" />
    </p>

    <p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php esc_html_e('Limit Posts Number', 'flexible') ?></label>

      <input  type="text" value="<?php echo esc_attr($instance['limit']); ?>"
              name="<?php echo $this->get_field_name('limit'); ?>"
              id="<?php $this->get_field_id('limit'); ?>"
              class="widefat" />
    <p>

    <?php
  }

}
?>