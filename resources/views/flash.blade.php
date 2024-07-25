 @if($errors->any())

<div class="alert alert-danger alert-dismissible">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
@foreach($errors->all() as $message)

  {{$message}}<br>

@endforeach
</div>

 
@elseif (session()->has('error')) 

<div class="alert alert-danger alert-dismissible">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Error! </strong>{{session('error')}}
</div>

@elseif (session()->has('success'))

<div class="alert alert-success alert-dismissible">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Success! </strong>{{session('success')}}
</div>                

@elseif (session()->has('warning'))

<div class="alert alert-warning alert-dismissible">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Warning! </strong>{{session('warning')}}
</div> 

@endif