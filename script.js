$(document).ready(function () {
    loadBinXTree();
    $("#newtree").click(function () {
        loadBinXTree();
    });
});
function loadBinXTree() {
    d = new Date();
    $("#binxtree").attr("src", "getsvg.php?" + d.getTime());
}