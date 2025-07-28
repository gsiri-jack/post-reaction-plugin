<?php

// Enqueue JS + CSS
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('prp-style', PRP_URL . 'style.css');
    wp_enqueue_script('prp-script', PRP_URL . 'script.js', ['jquery'], null, true);

    // Pass AJAX URL + post ID
    wp_localize_script('prp-script', 'prp_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'post_id' => get_queried_object_id()
    ]);
});

// Shortcode to show reaction buttons
add_shortcode('post_reaction', function () {
    ob_start(); ?>
    <div class="reaction-container">
        <button class="reaction-button" data-reaction="like">👍 Like</button>
        <button class="reaction-button" data-reaction="love">❤️ Love</button>
        <button class="reaction-button" data-reaction="wow">😮 Wow</button>
        <div id="reaction-response"></div>
    </div>
    <?php return ob_get_clean();
});

// Handle AJAX
add_action('wp_ajax_prp_handle_reaction', 'prp_handle_reaction');
add_action('wp_ajax_nopriv_prp_handle_reaction', 'prp_handle_reaction');

function prp_handle_reaction() {
    $post_id = intval($_POST['post_id']);
    $reaction = sanitize_text_field($_POST['reaction']);

    // (Optional) Store in DB later
    echo "You reacted with: " . ucfirst($reaction);
    wp_die();
}
