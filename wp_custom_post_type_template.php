<?php
/*
 * WordPress Template
 * Custom Post Type
 */

//Courses CPT
add_action('init', 'registerCustomCPT');
add_action("admin_init", "add_people_meta_box");
add_action('save_post', 'save_cpt_meta_details');

?>
<?php

//CREATE CUSTOM POST TYPE
function registerCustomCPT()
{
     $labels = array(
        'name' => _x('People\'s List', 'post type general name'),
        'singular_name' => _x('People', 'post type singular name'),
        'add_new' => _x('Add A Person', 'review item'),
        'add_new_item' => __('Add New Person'),
        'edit_item' => __('Edit Person'),
        'new_item' => __('New Person'),
        'view_item' => __('View Person'),
        'search_items' => __('Search People'),
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
        'supports' => array('title','thumbnail','editor')
        //'taxonomies' => array('category')
    );

    register_post_type('people', $args);

}//end function create Custom Post Type

function add_people_meta_box(){

    add_meta_box("people_meta_basic", "Basic Information", "people_basic_meta", "people", "normal", "high");

}//end function add_people_meta_box


//Course Basic Meta
function people_basic_meta()
{
    global $post;
    $custom=get_post_custom($post->ID);
    $grp_designation          =$custom['grp_designation'][0];
    $grp_user_name          =$custom['grp_user_name'][0];
    $grp_display_order          =$custom['grp_display_order'][0];


    ?>
    <style type="text/css">

        div#people_meta_variation
         {
            overflow: hidden;
             padding-bottom: 10px;
         }
         div#people_meta_basic
         {
             overflow: hidden;
             padding-bottom: 10px;
             background: rgba(0,0,0,0.1);
         }
         div#people_basic_meta
         {
             overflow: hidden;
             padding-bottom: 10px;
         }

         body.mceContentBody
         {
             background-color: white;
         }
     </style>
    <style type="text/css">
         div.meta-box
         {
             width:100%;
             float: left;
             overflow: hidden;
         }
         div.row
         {
             float: left;
             width: 98%;
             margin: 3px;
             padding: 5px;
             background: white;
             border-radius: 5px;
             -moz-border-radius: 5px;
             -webkit-border-radius: 5px;
         }
         div.title
         {
             float: left;
             width: 150px;
             margin-top:5px;
             font-weight: bold;
         }
        div.data
         {
             float: left;
             width: 550px;
             overflow: hidden;

         }
         select.toi
         {
             width: 150px;
         }
         span.hint
         {
             font-size: 11px;
             font-style: italic;
             color: gray;
             font-weight: normal;
         }
     </style>
    <div  class="meta-box">
        <div class="row">
            <div class="title"><label>Designation</label></div>
            <div class="data">
                <input type="text"  name="grp_designation" size="90"  value="<?php echo $grp_designation;?>"/>
            </div>
        </div><!--end row--><br/>

        <div class="row">
            <div class="title"><label>User Name</label></div>
            <div class="data">
                <input type="text" name="grp_user_name" size="90"  value="<?php echo $grp_user_name;?>"/>

            </div>
        </div><!--end row--><br/>

        <div class="row">
            <div class="title"><label>Display Order</label></div>
            <div class="data">
                <input type="text" name="grp_display_order" size="40"  value="<?php echo $grp_display_order;?>"/>

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


  update_post_meta($post_id, "grp_designation", $_POST["grp_designation"]);
  update_post_meta($post_id, "grp_user_name", $_POST["grp_user_name"]);
  update_post_meta($post_id, "grp_display_order", $_POST["grp_display_order"]);


} //end function save_Course_meta_details



//Custom Column Details
    add_action("manage_posts_custom_column",  "people_custom_columns");
    add_filter("manage_edit-people_columns", "people_edit_columns");

function people_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Name",
    "grp_designation" => "Designation",
      "grp_user_name"=>"User Name",
      "date"=>"Date"
  );

  return $columns;
}

function people_custom_columns($column){
  global $post;

  switch ($column) {
    case "grp_designation":
       echo get_post_meta($post->ID, 'grp_designation',true);
      break;
    case "grp_user_name":
      echo get_post_meta($post->ID, 'grp_user_name',true);
      break;
  }
}/*END FUNCTION portfolio_custom_columns*/

function get_the_person($id){
    $arg=array('post_type'=>'people','p'=>$id);
    $person=new WP_Query($arg);
    if($person->have_posts()){
        while($person->have_posts()):$person->the_post();
        ?>
        <div class="person_box">
            <div class="personal_content">
                <hgroup>
                    <h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                    <h3><?php echo get_post_meta(get_the_id(),'grp_designation',true);?></h3>
                </hgroup>
                <?php the_excerpt();?>
            </div>
            <div class="personal_photo">
                <a href="<?php the_permalink();?>"><?php echo get_the_post_thumbnail(get_the_id(),array(110,110));?></a>
            </div>
            <div class="person_view_profile" style="margin-bottom: 10px;float: left;display: block;width: 100%;margin-left: 20px;">
                <a href="<?php the_permalink();?>">⇢ View Profile</a>
            </div>

        </div>

        <?php
        endwhile;
    }//end if
}  //end function
?>