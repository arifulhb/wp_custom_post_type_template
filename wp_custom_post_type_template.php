<?php
/*
 * WordPress Template
 * Custom Post Type
 */

//Courses CPT
add_action('init', 'registerCustomCPT');
add_action("admin_init", "add_cpt_meta_box");
add_action('save_post', 'save_cpt_meta_details');

?>
<?php

//CREATE CUSTOM POST TYPE
function registerCustomCPT()
{
     $labels = array(
        'name' => _x('Custom Post List', 'post type general name'),
        'singular_name' => _x('Custom Post', 'post type singular name'),
        'add_new' => _x('Add A Custom Post', 'review item'),
        'add_new_item' => __('Add New Custom Post'),
        'edit_item' => __('Edit Custom Post'),
        'new_item' => __('New Custom Post'),
        'view_item' => __('View Custom Post'),
        'search_items' => __('Search Custom Post'),
        'not_found' => __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        //'menu_icon' => get_template_directory_uri() . '/img/review-icon.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 5,
        'supports' => array('title','thumbnail','editor'),
        'taxonomies' => array('category','post_tag')
    );

    register_post_type('my_custom_post', $args);

}//end function create Custom Post Type

function add_cpt_meta_box(){

    add_meta_box("cpt_meta_basic", "Custom Post Type Information", "cpt_basic_meta", "my_custom_post", "normal", "high");

}//end function add_cpt_meta_box


//CPT Basic Meta
function cpt_basic_meta()
{
    global $post;
    $custom=get_post_custom($post->ID);
    $custom_field_1          =$custom['custom_field_1'][0];
    $custom_field_2          =$custom['custom_field_2'][0];
    $custom_field_3          =$custom['custom_field_3'][0];


    ?>

    <div  class="meta-box">
        <?php /*If you change the direectory, you need to change the link bellow*/?>
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_directory' ); ?>/wpcpt/wp_custom_post_type.css" />
        <div class="row">
            <div class="title"><label for="custom_field_1">Custom Field 1</label></div>
            <div class="data">
                <input type="text" id="custom_field_1" name="custom_field_1" value="<?php echo $custom_field_1;?>"/>
            </div>
        </div><!--end row--><br/>

        <div class="row">
            <div class="title"><label for ="custom_field_2">Custom Field 2</label></div>
            <div class="data">
                <input type="text" id="custom_field_2" name="custom_field_2" value="<?php echo $custom_field_2;?>"/>

            </div>
        </div><!--end row--><br/>

        <div class="row">
            <div class="title"><label for="custom_field_3">Custom Field 2</label></div>
            <div class="data">
                <input type="text" id="custom_field_3" name="custom_field_3"  value="<?php echo $custom_field_3;?>"/>

            </div>
        </div><!--end row--><br/>
        <div class="row">
            <div class="title"><label for="custom_field_3">&nbsp;</label></div>
            <div class="data">
                <p style="text-align: center;">Are you looking for adding <span class="item">Select Option</span>, <span class="item">Check box</span>, <span class="item">File Upload</span> options?<br/>
                    We are specialized in <a href="http://wordpress.org/" title="WordPress">WordPress</a> Theme Development. Contact Us.<br/><br/>
                    <a href="http://www.greentechcs.com" title="Contact Us for more">www.greentechcs.com</a></p>
            </div>
        </div><!--end row--><br/>

    </div><!--official name-->

    <?php

}//END Function people_basic_meta


/*Course Custom Post Type Custom Fields Save*/
function save_cpt_meta_details()
{
  global $post;

  $post_id = $post->ID;

    // to prevent metadata or custom fields from disappearing...
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
    return $post_id;


  update_post_meta($post_id, "custom_field_1", $_POST["custom_field_1"]);
  update_post_meta($post_id, "custom_field_2", $_POST["custom_field_2"]);
  update_post_meta($post_id, "custom_field_3", $_POST["custom_field_3"]);


} //end function save_Course_meta_details



//Custom Column Details
    add_action("manage_posts_custom_column",  "my_custom_post_custom_columns");
    add_filter("manage_edit-my_custom_post_columns", "my_custom_post_edit_columns");

function my_custom_post_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Name",
    "custom_field_1" => "Custom Field 1",
      "categories"=>"Categories",
      "tags"=>"Tags",
      "author"=>"Author",
      "date"=>"Date"
  );

  return $columns;
}

function my_custom_post_custom_columns($column){
  global $post;

  switch ($column) {
    case "custom_field_1":
      echo get_post_meta($post->ID, 'custom_field_1',true);
      break;
  case "category":
      break;
  case "post_tag":
      break;
  }
}/*END FUNCTION portfolio_custom_columns*/


?>