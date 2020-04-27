
<?php

get_header();

$condition = array(
"post_type"=>"slider",
"post_status"=>"publish"
);
$the_query = new WP_Query($condition);

if($the_query->have_posts()){

    while($the_query->have_posts()){
        $the_query->the_post();
        echo '<h3>'.get_the_title().'</h3>';

        the_content();
    }

    wp_reset_postdata();// restore our original post data

}else{
	//no posts
}


get_footer();