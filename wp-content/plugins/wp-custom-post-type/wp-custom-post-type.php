<?php
/*
plugin name:Ani plugin
description:this is a simple plugin for purpose of learning
version:1.0.0
author:Anirudh pandey

*/


add_action( 'init', 'ani_book_init' );

function ani_book_init() {
        $labels = array(
                'name'               => __( 'Books' ),
                'singular_name'      => __( 'Book' ),
                'menu_name'          => __( 'Books'),
                'name_admin_bar'     => __( 'Book' ),
                'add_new'            => __( 'Add New'),
                'add_new_item'       => __( 'Add New Book' ),
                'new_item'           => __( 'New Book' ),
                'edit_item'          => __( 'Edit Book' ),
                'view_item'          => __( 'View Book' ),
                'all_items'          => __( 'All Books' ),
                'search_items'       => __( 'Search Books' ),
                'parent_item_colon'  => __( 'Parent Books:'),
                'not_found'          => __( 'No books found.'),
                'not_found_in_trash' => __( 'No books found in Trash.')
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

        register_post_type( 'book', $args );
}

function wpl_owt_cpt_register_metabox(){

        add_meta_box("cpt-id","producer details","wpl_owt_cpt_producer_call","book","side","high");
        add_meta_box("cpt-author","Choose author","wpl_owt_cpt_author_call","book","side","high");
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
                <label>Audio file:</label>
                <?php $audio_file=get_post_meta($post->ID,"wpl_producer_audio",true)?>
                <input type="file" value="<?php echo "$audio_file"; ?>" name="txtProduceraudio" placeholder="audio file"/>
        </p>
        <p>
                <label>Cover image:</label>
                <?php $Cover_image=get_post_meta($post->ID,"wpl_producer_image",true)?>
                <input type="file" value="<?php echo "$Cover_image"; ?>" name="txtProducerimage" placeholder="song lyrics"/>
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
         $txtProduceraudio = isset($_POST['txtProduceraudio']) ? $_POST['txtProduceraudio']:"";
         $txtProducerimage = isset($_POST['txtProducerimage']) ? $_POST['txtProducerimage']:"";
         $txtProducerlyrics = isset($_POST['txtProducerlyrics']) ? $_POST['txtProducerlyrics']:"";

        update_post_meta($post_id,"wpl_producer_desc",$txtProducerdesc);
        update_post_meta($post_id,"wpl_producer_audio",$txtProduceraudio);
         update_post_meta($post_id,"wpl_producer_image",$txtProducerimage);
          update_post_meta($post_id,"wpl_producer_lyrics",$txtProducerlyrics);
}


add_action("save_post","wpl_owt_cpt_save_values",10,2);


function wpl_owt_cpt_custom_columns($columns){

        $columns = array(
                "cb"=>"<input type='checkbox'/>",
                "title"=>"Song Title",
                "description"=>"Song Description",
                "audio_file"=>"Song Audio File",
                "image"=>"Cover image",
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
                 case 'audio_file':
                $song_audio=get_post_meta($post_id,"wpl_producer_audio",true);
                echo $song_audio;
                break;
                 case 'image':
                $image=get_post_meta($post_id,"wpl_producer_image",true);
                echo $image;
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
        $columns['audio_file'] = "audio_file";
        $columns['image'] = "image";
        $columns['lyrics'] = "lyrics";
        return $columns;
}

function wpl_owt_cpt_author_call(){
        ?>
        <div>
                <label>Select Author</label>
                <select name='ddauthor'>
                        <?php
                        $users = get_users(array(
                                "role"=>"author"
                        ));
                        $saved_author_id=get_post_meta($post->ID,"author_id_book",true);

                        foreach ($users as $index => $user) {
                                $selected='';
                                if($saved_author_id==$user->ID){
                                        $selected='selected="selected"';
                                }
                                ?>
                                <option value='<?php echo $user->ID ?>'>
                                        <?php echo $selected;  ?><?php echo $user->display_name ?></option>
                            <?php    
                        }
                        ?>
                       
                </select>
        </div>
        <?php
}


add_action("save_post","wpl_owt_save_author_book",10,2);

function wpl_owt_save_author_book($post_id,$post){

        $author_id = isset ($_REQUEST['ddauthor']) ? intval($_REQUEST['ddauthor']) :"";

        update_post_meta($post_id,"author_id_book",$author_id);
}




function task_book_taxonomy(){
        $labels=array(
                'name'=>__('books'),
                'singular_name'=>__('book'),
                'menu_name'=>__('tags-books'),
                'all_items'=>__('All book','book'),
                'parent_item'=>__('Parent book','book'),
                'parent_item_colon'=>__('Parent book:','book'),
                'new_item_name'=>__('New Item book','book'),
                'add_new_item'=>__('Add New book','book'),
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
                'hierarchical'=>false,
                'public'=>true,
                'show_ui'=>true,
                'show_admin_column'=>true,
                'show_in_nav_menus'=>true,
                'show_tagcloud'=>true,
);
        register_taxonomy('books',array('post'),$args);
}
add_action('init','task_book_taxonomy',0);
//Category Taxonomy


function task_book_category_taxonomy(){
        $labels=array(
                'name'=>__('books'),
                'singular_name'=>__('book'),
                'menu_name'=>__('category-books'),
                'all_items'=>__('All book','book'),
                'parent_item'=>__('Parent book','book'),
                'parent_item_colon'=>__('Parent book:','book'),
                'new_item_name'=>__('New Item book','book'),
                'add_new_item'=>__('Add New book','book'),
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
                'show_tagcloud'=>true,
);
        register_taxonomy('book',array('post'),$args);
}
add_action('init','task_book_category_taxonomy',0);



