jQuery(document).ready(function ($) {
    $(".reaction-button").click(function () {
        const reaction = $(this).data("reaction");

        $.post(prp_ajax.ajax_url, {
            action: "prp_handle_reaction",
            reaction: reaction,
            post_id: prp_ajax.post_id
        }, function (response) {
            $("#reaction-response").html(response);
        });
    });
});
