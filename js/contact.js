$(function() {
    $("#contact-form").validator(),
    $("#contact-form").on("submit", function(e) {
        if (!e.isDefaultPrevented()) {
            var t = "write_database.php"
            return $.ajax({
                type: "POST",
                url: t,
                data: $(this).serialize(),
                success: function(e) {
                    var t = "alert-" + e.type
                      , n = e.message
                      , r = '<div class="alert ' + t + ' alert-dismissable">' + n + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">OK</button>' + "</div>"
                    t && n && ($("#contact-form").find(".messages").html(r),
                    $("#contact-form")[0].reset())
                }
            }),
            !1
        }
    })
})
