$(document).ready(function(){
    $("form").on("submit", function(e){
        e.preventDefault();
        var data = {
            email: $("#email").val(),
            sum: $("#sum").val()
        };
        $.post( "getData.php", data, function(data) {
            alert(data);
        });
    })
});