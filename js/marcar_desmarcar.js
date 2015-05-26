$(function(){
 
$("#todos").click(function () {
$(".checkbox").attr("checked", this.checked);
});
 
$(".checkbox").click(function(){
 
if($(".checkbox").length == $(".checkbox:checked").length) {
$("#todos").attr("checked", "checked");
} 

    else {
$("#todos").removeAttr("checked");
}
 
});
});