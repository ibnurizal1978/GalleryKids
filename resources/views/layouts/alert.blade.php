@if(session()->has('success'))
<div class="alert alert-success alert-dismissible show" role="alert">
  <strong>Success!</strong> {{session('success')}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

@elseif(session()->has('error'))

<div class="alert alert-danger alert-dismissible show" role="alert">
  <strong>Error!</strong> {{session('error')}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

@elseif($errors->any())

        
        @foreach($errors->all() as $message)
        
        <div class="alert alert-danger alert-dismissible show" role="alert">
		  <strong>Error!</strong> {{$message}}
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
        

        @endforeach
    
@elseif(session()->has('info'))

<div class="alert alert-info alert-dismissible show" role="alert">
	  <strong>Info!</strong> {{session('info')}}
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
</div>

@endif