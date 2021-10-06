$(document).ready(function() {
    $(".likeButton").click(function(e){
        e.preventDefault(); 
        $route = $(this).data("id")   
        $self = $(this)
        $.ajax({
            url: $route, 
            type:'GET',
            dataType: 'html', 
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                const r = JSON.parse(response)       
                if(r.status !== false){
                $self.parent('#like-button-result').html(r.html)
                }
            }    
        });
        
    });        
});