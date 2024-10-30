<?php

add_action( 'widgets_init', 'menu_choice_widget_init' );

function menu_choice_widget_init() {
    register_widget( 'menu_choice_widget' );
}

class menu_choice_widget extends WP_Widget
{

    public function __construct()
    {
        $widget_details = array(
            'classname' => 'menu_choice_widget',
            'description' => 'Add the Menu Choice widget to your widget area.'
        );

        parent::__construct( 'menu_choice_widget', 'Menu Choice', $widget_details );

    }

    /**
  	 * Outputs the content for the current Custom Menu widget instance.
  	 *
  	 * @since 3.0.0
  	 * @access public
  	 *
  	 * @param array $args     Display arguments including 'before_title', 'after_title',
  	 *                        'before_widget', and 'after_widget'.
  	 * @param array $instance Settings for the current Custom Menu widget instance.
  	 */
  	public function widget( $args, $instance ) {
      wp_nav_menu( array(
        'menu' => get_post_meta(get_the_ID(), "selected-menu-choice", true)
      ) );
  	}

}
