$(function() {
    $('.edit-position').click(function(e) {
        var stickerPackId = $(this).attr('sticker-pack-id');

        $('#modal').modal('show');
        $('.destination-stickerpack-id').val(stickerPackId);
    });
});


function updateStickerPosition(e) {
    var sortableList = e.target;

    var newOrder = [];

    $(sortableList).children().each (function (i, item) {
        newOrder.push({
            id: $(item).data('id'),
            position: i+1
        })
    });

    $.post("/sticker-pack/setorder", {sticker_pack: $(sortableList).data('id'), order: newOrder}, function (data) {
        console.log(data);
    });
}