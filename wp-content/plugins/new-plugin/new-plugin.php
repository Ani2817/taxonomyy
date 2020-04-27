<?php
/*
plugin name:Ani plugin
description:this is a simple plugin for purpose of learning
version:1.0.0
author:Anirudh pandey

*/
////SHORT CODE STARTED//
define("SLIDER_PLUGIN_PLUGIN_DIR_PATH",plugin_dir_path(__FILE__));

add_shortcode("anirudh","Slider_plugin_1");
add_shortcode("anirudh1","Slider_plugin_2");
add_shortcode("anirudh2","Slider_plugin_3");

function slider_main($author)
{
    ob_start();
        $condition = array(
    "post_type"=>"slider",
    "post_status"=>"publish",
    "author" => $author
    );   
    $the_query = new WP_Query($condition);

    if($the_query->have_posts()){

        echo "<div class=\"slider_class_ani\">";

        while($the_query->have_posts()){
            $the_query->the_post();
            echo "<div>";
            echo '<h3>'.get_the_title().'</h3>';
            global $post;

            if(get_the_post_thumbnail($post->ID))
            {
                // Image to display

                echo get_the_post_thumbnail($post->ID);

            }

            the_content();
            echo "</div>";
        }

        echo "</div>";

        wp_reset_postdata();// restore our original post data

    }

    $retData = ob_get_clean();
    return $retData;
}

function Slider_plugin_1(){
    return slider_main(1);
}

function Slider_plugin_2(){
    return slider_main(2);
}

function Slider_plugin_3(){
    return slider_main(3);   
}

function ani_scripts(){


//functionss

//css
    wp_enqueue_style('main_file',plugin_dir_url(__FILE__));
    wp_enqueue_style('style_file',plugin_dir_url(__FILE__).'slick.css');
    wp_enqueue_style('stylesecond_file',plugin_dir_url(__FILE__).'slick-theme.css');
    wp_enqueue_style('slider css file',plugin_dir_url(__FILE__).'ani_slider_css.css');
    wp_enqueue_style('Slick Carousal','//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');

    //js

    wp_enqueue_script('jquery-1.11.0.min.js' , '//code.jquery.com/jquery-1.11.0.min.js');
    wp_enqueue_script('jquery-migrate-1.2.1.min.js', '//code.jquery.com/jquery-migrate-1.2.1.min.js');
    wp_enqueue_script('slick.min.js', plugin_dir_url(__FILE__).'slick.min.js');
     wp_enqueue_script('slick_ani_slider.js', plugin_dir_url(__FILE__).'slick_ani_slider.js');


}
add_action("wp_enqueue_scripts","ani_scripts");




add_action( 'init', 'ani_book_init' );

function ani_book_init() {
        $labels = array(
                'name'               => __( 'silder' ),
                'singular_name'      => __( 'slides' ),
                'menu_name'          => __( 'slider'),
                'name_admin_bar'     => __( 'Book' ),
                'add_new'            => __( 'Add New'),
                'add_new_item'       => __( 'Add New slider' ),
                'new_item'           => __( 'New slides' ),
                'edit_item'          => __( 'Edit slider' ),
                'view_item'          => __( 'View slider' ),
                'all_items'          => __( 'All Slides' ),
                'search_items'       => __( 'Search slider' ),
                'parent_item_colon'  => __( 'Parent slider:'),
                'not_found'          => __( 'No slider found.'),
                'not_found_in_trash' => __( 'No slider found in Trash.')
        );

        $args = array(
                'labels'             => $labels,
                'description'        => __( 'Description.', 'your-plugin-textdomain' ),
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 'book' ),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => null,
                'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
        );

        register_post_type( 'slider', $args );
}

function wpl_owt_cpt_register_metabox(){

        add_meta_box("cpt-id","producer details","wpl_owt_cpt_producer_call","book","side","high");
        
}

add_action("add_meta_boxes","wpl_owt_cpt_register_metabox");

function wpl_owt_cpt_producer_call(){

        ?>

        <p>
                <label>song description:</label>
                <?php $Song_description=get_post_meta($post->ID,"wpl_producer_desc",true)?>
                <input type="text" value="<?php echo "$Song_description"; ?>" name="txtProducerdesc" placeholder="Song description"/>
        </p>
         <p>
                <label>Song lyrics:</label>
                <?php $Song_lyrics=get_post_meta($post->ID,"wpl_producer_lyrics",true)?>
                <input type="text" value="<?php echo "$Song_lyrics"; ?>" name="txtProducerlyrics" placeholder="song lyrics"/>
        </p>
        <?php
}


function wpl_owt_cpt_save_values($post_id,$post){

        $txtProducerdesc = isset($_POST['txtProducerdesc']) ? $_POST['txtProducerdesc']:"";
        
         $txtProducerlyrics = isset($_POST['txtProducerlyrics']) ? $_POST['txtProducerlyrics']:"";

        update_post_meta($post_id,"wpl_producer_desc",$txtProducerdesc);
          update_post_meta($post_id,"wpl_producer_lyrics",$txtProducerlyrics);
}


add_action("save_post","wpl_owt_cpt_save_values",10,2);


function wpl_owt_cpt_custom_columns($columns){

        $columns = array(
                "cb"=>"<input type='checkbox'/>",
                "title"=>"Song Title",
                "description"=>"Song Description",
               
                "lyrics"=>"Song Lyrics"

        );
        return $columns;
}

add_action("manage_book_posts_columns","wpl_owt_cpt_custom_columns");

function wpl_owt_cpt_custom_columns_data($column,$post_id){

        switch ($column) {
                case 'description':
                $Song_description=get_post_meta($post_id,"wpl_producer_desc",true);
                echo $Song_description;
                break;        
                 case 'lyrics':
                $song_lyrics=get_post_meta($post_id,"wpl_producer_lyrics",true);
                echo $song_lyrics;
                break;                
                }
}
add_action("manage_book_posts_custom_column","wpl_owt_cpt_custom_columns_data",10,2);

add_filter("manage_edit-book_sortable_columns","wpl_owt_cpt_sortable_columns");

function wpl_owt_cpt_sortable_columns($columns){

        $columns['description'] = "description";
        
        $columns['lyrics'] = "lyrics";
        return $columns;
}




//Category Taxonomy


function task_book_category_taxonomy(){
        $labels=array(
                'name'=>__('slider'),
                'singular_name'=>__('slider'),
                'menu_name'=>__('slider'),
                'all_items'=>__('All slide','book'),
                'parent_item'=>__('Parent slide','book'),
                'parent_item_colon'=>__('Parent slide:','book'),
                'new_item_name'=>__('New Item book','book'),
                'add_new_item'=>__('Add New slide','book'),
                'edit_item'=>__('Edit book','book'),
                'update_item'=>__('Update book','book'),
                'view_item'=>__('View book','book'),
                'separate_items_with_commas'=>__('Separate book with commas','book'),
                'add_or_remove_items'=>__('Add or Remove book','book'),
                'choose_from_most_used'=>__('Choose From the most','book'),
                'popular_items'=>__('Popular book','book'),
                'search_items'=>__('Search book','book'),
                'not_found'=>__('Not Found','book'),
                'no_terms'=>__('No Terms','book'),
                'items_list'=>__('book List','book'),
                'items_list_navigation'=>__('book List Navigation','book'),
        );
        $args=array(
                'labels'=>$labels,
                'hierarchical'=>true,
                'public'=>true,
                'show_ui'=>true,
                'show_admin_column'=>true,
                'show_in_nav_menus'=>true,
                'query_var'=>true,
                'rewrite'=>array('slug'=>'type'),
                
                'show_tagcloud'=>true
);
        register_taxonomy('slider',array('slider'),$args);
}
add_action('init','task_book_category_taxonomy');










