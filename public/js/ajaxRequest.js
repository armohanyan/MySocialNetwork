$(document).ready(function() {
    $("#likeButton").click(function(e){
        e.preventDefault();            

        $.ajax({
            url: "{{ route('get.like', $status->id )}}",
            type:'GET',
            dataType: 'html', 
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                const r = JSON.parse(response)
                if(r.status !== false){
                    $('.like-button-result').html(r.html);
                }
             
            }
        });
        
    });        
});