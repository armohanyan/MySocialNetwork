@if(Session::has('info'))
<div class="alert alert-success mt-5" role="alert">
    {{ Session::get('info')     }}
</div>

@endif