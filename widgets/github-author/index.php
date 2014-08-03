<?php

class NA_Widget_Github_Author extends WP_Widget {
  function __construct() {
    $widget_ops = array('classname' => 'widget_github_author', 'description' => __( "Author for the current NPM module") );
    parent::__construct('na-github-author', __('NPMAWESOME Githug Author'), $widget_ops);
    $this->alt_option_name = 'widget_github_author';

    add_action('save_post', array($this, 'flush_widget_cache'));
    add_action('deleted_post', array($this, 'flush_widget_cache'));
    add_action('switch_theme', array($this, 'flush_widget_cache'));
  }

  function widget($args, $instance) {
    $cache = array();
    if ( ! $this->is_preview() ) {
      $cache = wp_cache_get( 'widget_github_author', 'widget' );
    }

    if ( ! is_array( $cache ) ) {
      $cache = array();
    }

    if ( ! isset( $args['widget_id'] ) ) {
      $args['widget_id'] = $this->id;
    }

    if ( isset( $cache[ $args['widget_id'] ] ) ) {
      echo $cache[ $args['widget_id'] ];
      return;
    }

    ob_start();

    $github = npm_get_github_info();
    require(__DIR__.'/view.php');
    wp_enqueue_style('npmawesome-github-author', plugins_url('/widgets/github-author/style.css'));

    if ( ! $this->is_preview() ) {
      $cache[ $args['widget_id'] ] = ob_get_flush();
      wp_cache_set( 'widget_github_author', $cache, 'widget' );
    } else {
      ob_end_flush();
    }
  }

  function update( $new_instance, $old_instance ) {
    $this->flush_widget_cache();

    $alloptions = wp_cache_get( 'alloptions', 'options' );
    if ( isset($alloptions['widget_github_author']) )
      delete_option('widget_github_author');

    return $new_instance;
  }

  function flush_widget_cache() {
    wp_cache_delete('widget_github_author', 'widget');
  }

  function form( $instance ) {
  }
}

add_action('widgets_init', function() {
  register_widget('NA_Widget_Recent_Posts');
});
