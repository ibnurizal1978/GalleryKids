@if(session()->has('success'))
<div class="alert alert-success" role="alert">
	<h4 class="alert-heading">Success</h4>
	<p class="mb-0">
	  {{session('success')}}
	</p>
</div>

@elseif(session()->has('error'))

<div class="alert alert-danger" role="alert">
	<h4 class="alert-heading">Error</h4>
	<p class="mb-0">
	  {{session('error')}}
	</p>
</div>

@elseif($errors->any())

        
        @foreach($errors->all() as $message)
        
        <div class="alert alert-danger" role="alert">
			<h4 class="alert-heading">Error</h4>
			<p class="mb-0">
			  {{$message}}
			</p>
		</div>
        

        @endforeach
    
@elseif(session()->has('info'))

<div class="alert alert-info" role="alert">
	<h4 class="alert-heading">Info</h4>
	<p class="mb-0">
	  {{session('info')}}
	</p>
</div>

@endif