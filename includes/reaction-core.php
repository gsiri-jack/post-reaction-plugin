<?php


add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('prp-style', PRP_URL . 'style.css');
    wp_enqueue_script('prp-script', PRP_URL . 'script.js', ['jquery'], null, true);


    wp_localize_script('prp-script', 'prp_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'post_id' => get_queried_object_id()
    ]);
});


add_shortcode('post_reaction', function () {
    global $post;
    $post_id = $post->ID; 
  
    $like_count = (int) get_post_meta($post_id, 'reaction_like', true);
    $love_count = (int) get_post_meta($post_id, 'reaction_love', true);
    $wow_count  = (int) get_post_meta($post_id, 'reaction_wow', true);

    ob_start(); ?>
    <div class="reaction-container" data-post-id="<?php echo $post_id; ?>">
        <button class="reaction-button" data-reaction="like">👍 Like (<?php echo $like_count; ?>)</button>
        <button class="reaction-button" data-reaction="love">❤️ Love (<?php echo $love_count; ?>)</button>
        <button class="reaction-button" data-reaction="wow">😮 Wow (<?php echo $wow_count; ?>)</button>
        <div id="reaction-response"></div>
    </div>
    <?php return ob_get_clean();
});



add_action('wp_ajax_prp_handle_reaction', 'prp_handle_reaction');
add_action('wp_ajax_nopriv_prp_handle_reaction', 'prp_handle_reaction');

function prp_handle_reaction() {
    $post_id = intval($_POST['post_id']);
    $reaction = sanitize_text_field($_POST['reaction']);

    
    $meta_key = 'reaction_' . $reaction;
    $current_count = (int) get_post_meta($post_id, $meta_key, true);
    $new_count = $current_count + 1;

  
    update_post_meta($post_id, $meta_key, $new_count);

    
    $response = [
        'like' => (int) get_post_meta($post_id, 'reaction_like', true),
        'love' => (int) get_post_meta($post_id, 'reaction_love', true),
        'wow'  => (int) get_post_meta($post_id, 'reaction_wow', true),
    ];

    wp_send_json($response);
}
