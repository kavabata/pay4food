function loadPiece(href,divName) {
    alert(href);
    $(divName).load(href, {}, function(){

        var divPaginationLinks = divName+" .pagination a";
        $(divPaginationLinks).click(function() {
            var thisHref = $(this).attr("href");
            loadPiece(thisHref,divName);
            return false;
        });
    });
}