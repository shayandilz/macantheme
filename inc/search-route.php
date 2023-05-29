<?phpfunction register_new_search(){    register_rest_route('search/v1', 'search', array(        'methods' => WP_REST_Server::READABLE,        'callback' => 'GoldSearchResults'    ));}function GoldSearchResults($data){    $mainQuery = new WP_Query(array(        'post_type' => array('post'),        's' => sanitize_text_field($data['term']),        'category_name' => sanitize_text_field($data['category'])    ));    $mainResults = array(        'post' => array()    );    while ($mainQuery->have_posts()) {        $mainQuery->the_post();        if (get_post_type() == 'post') {            $content = get_the_content();            $content = wp_strip_all_tags($content);            $content = wp_trim_words($content, 24, '...'); // limit content to 24 words            $mainResults['post'][] = array(                'title' => get_the_title(),                'url' => get_the_permalink(),                'img' => get_the_post_thumbnail_url(),                'category' => get_the_category()[0]->name, // add category to result                'content' => $content            );        }    }    return $mainResults;}add_action('rest_api_init', 'register_new_search');