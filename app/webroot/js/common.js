function loadPiece(href,divName) {
    $(divName).load(href, {}, function(){

        var divPaginationLinks = divName+" .pagination a,"+divName+" .paging a";
        $(divPaginationLinks).click(function() {
            var thisHref = $(this).attr("href");
            loadPiece(thisHref,divName);
            return false;
        });
    });
}