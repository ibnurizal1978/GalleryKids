<div class="centernav">
     <div class="container">
        <ul>
            <li class="me1"><a href="{{url($tabs[0]['slug'])}}">{{$tabs[0]['display_name']}}</a></li>
            <li class="me2"><a href="{{url($tabs[1]['slug'])}}">{{$tabs[1]['display_name']}}</a></li>
            <!--<li class="me3"><a href="{{url($tabs[3]['slug'])}}">{{$tabs[3]['display_name']}}</a></li>-->
            <li class="me3"><a href="{{ route('/explore/new') }}">EXPLORE</a></li>
            <!--<li class="me4"><a href="{{url($tabs[2]['slug'])}}">{{$tabs[2]['display_name']}}</a></li>-->
            <li class="me4"><a href="{{ route('/play/new') }}">PLAY</a></li>
           <li class="me6"><a href="{{ route('keppelCentre')}}"> Keppel Centre for Art Education</a></li>
            <!--<li class="me5"><a href="{{url($tabs[4]['slug'])}}">{{$tabs[4]['display_name']}}</a></li>-->
            <li class="me5"><a href="{{ route('/festivals/new')}}">{{$tabs[4]['display_name']}}</a></li>
            

        </ul>
    </div>
</div>