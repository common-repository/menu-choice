<?php
function menu_choice_box_markup()
{
  wp_nonce_field(basename(__FILE__), "menu-choice-nonce");

      ?>
          <div>
            <p>
              Select what menu you would like displayed on this page
            </p>

              <br>

              <label for="menu-choice-dropdown">Select Menu
                <select name="selected-menu-choice">
                  <option></option>
                    <?php
                      //assign menu objects to variable and hide empty objects
                        $saved_choice = get_post_meta(get_the_ID(), "selected-menu-choice", true);
                        $menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
                        foreach($menus as $menu)
                        {
                            if($menu->name == $saved_choice)
                            {
                                ?>
                                    <option selected><?php echo esc_html($saved_choice); ?></option>
                                <?php
                            }
                            else
                            {
                                ?>
                                    <option><?php echo $menu->name; ?></option>
                                <?php
                            }
                        }
                    ?>
                </select>
              </label>
          </div>
      <?php
}

function add_menu_choice_meta_box()
{
  $args = array(
    'public' => true
  );
  $types = get_post_types($args);
  $types = array_diff($types, array('attachment'));
  foreach($types as $type){
    add_meta_box("menu_choice_box", "Menu Choice", "menu_choice_box_markup", $type , "side", 'default',  null);
  }
}

add_action("add_meta_boxes", "add_menu_choice_meta_box");

function save_menu_choice_meta_box($post_id, $post, $update)
{

if(isset($_POST["selected-menu-choice"])){
  $menu = sanitize_text_field($_POST["selected-menu-choice"]);
}
if(isset($_POST["menu-choice-nonce"])){
  $nonce = sanitize_text_field($_POST["menu-choice-nonce"]);
}

    if (!isset($nonce) || !wp_verify_nonce($nonce, basename(__FILE__))){
      return $post_id;
    }

    if(!current_user_can("edit_post", $post_id)){
      return $post_id;
    }

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE){
      return $post_id;
    }

    if(isset($menu))
    {
        $selected_menu_choice_value = $menu;
    }
    update_post_meta($post_id, "selected-menu-choice", $selected_menu_choice_value);

}

add_action("save_post", "save_menu_choice_meta_box", 10, 3);
?>
