Here is the list of Username <br>
@php $i = 1; @endphp
@foreach($children as $child)
{{$i++}}. {{$child->first_name}} {{$child->last_name}} -> {{$child->username}} <br>
@endforeach
@foreach($parents as $parent)
{{$i++}}. {{$parent->first_name}} {{$parent->last_name}} -> {{$parent->username}} <br>
@endforeach