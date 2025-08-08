jQuery(document).ready(function ($) {
    $(".reaction-button").click(function () {
        const reaction = $(this).data("reaction");
        const post_id = $(this).closest(".reaction-container").data("post-id");

        $.post(prp_ajax.ajax_url, {
            action: "prp_handle_reaction",
            reaction: reaction,
            post_id: post_id
        }, function (response) {
            if (response && typeof response === "object") {
                $(".reaction-button[data-reaction='like']").text(`👍 Like (${response.like})`);
                $(".reaction-button[data-reaction='love']").text(`❤️ Love (${response.love})`);
                $(".reaction-button[data-reaction='wow']").text(`😮 Wow (${response.wow})`);
                $("#reaction-response").html(`You reacted with: ${reaction.charAt(0).toUpperCase() + reaction.slice(1)}`);
            }
        }, "json");
    });
});
