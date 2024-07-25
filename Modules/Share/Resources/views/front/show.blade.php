@extends('layouts.master')

@section('style')

<style type="text/css">

.emolist{
display:none;
    height: 23px;
        margin-top: -82px !important;
}

.emolist li{
list-style: none;
    float: right;
    margin: 0px 3px;
    font-size: 25px !important;
}
.emolist li:hover{
    transform: rotate(360deg);
    transition: 0.6s;
}span.msg {
    font-size: 15px;
    display: block;
    text-align: left;
    color: #0ba0d8;
    margin-top: -29px;
    padding-left: 10px;
}
.tab1sec,.tab2sec{
    display: none;
}
.tab1sec.active,.tab2sec.active{
    display: block
}  
.centernav {
    top: 70px;
    position: fixed;
    left: 0;
    right: 0;
    z-index: 9;
}
.modal-body .sharebtn {
    display: none;
}
.shlist {
      padding: 0px 15px;
    margin-top: -62px;
    width: auto;
}
.shlist li {
    margin: 0px 4px;
    font-size: 28px;
}
.sharebtn a {
    font-size: 22px;
    }
    .shlist i.fa.fa-facebook-square {
    font-size: 28px;
}
.shlist i.fa.fa-whatsapp {
    font-size: 28px;
}
.sharebtn {
       margin-top: 40px;
    margin-bottom: 100px;
}
</style>

@endsection

@section('content')


@include('layouts.navbar')

<main style="background-color:#ffe599">
    <div class="shareshowCont">
    
        <div class="container">
            <div class="row">
                <div class=" col-md-6 col-sm-12 col-md-offset-3 shareshowView">

                    <div class="shareshowImg">
                         @php $thumbnail = $share->thumbnails->shuffle()->first(); @endphp
                        <img src="{{asset($thumbnail['image'])}}" class="shareviewimage"/>
                    </div>
                    <div class="sharecont">
                            <h3 class="mt0">{{$share['name']}}</h3>
                            <?php
                               
                                $dateOfBirth = $share['user']['year_of_birth'];
                                $years = \Carbon\Carbon::parse('' . $share['user']['year_of_birth'] . '-01-01')->age;
                                ?>
                                <p>
                                @if($share['age'])
                                {{$share['age']}} Years Old<br/>
                                @else
                                {{$years}} Years Old<br/>
                                @endif

                            Inspired by: {{$share['Inspired_by']}}<br/>
                            {{$share['description']}}</p>

                           <!--  <div class="sharefooter">
                                <a href="#">Share</a>
                                <a href="#"><img src="img/icons/like.svg"></a>
                            </div> -->
                          
                           <!--  <div class="sharebtn">
                                        <a href="javascript:void(0);"  class="shbtn">Share</a>
                                       <a class="heartShow-{{$share->id}}" style="display: none">
                                            <img src="{{asset('front/img/Icons/liked.svg')}}">
                                        </a>
                                        @if(Auth::check() && $share->reactions->contains('user_id' , Auth::user()->id))
                                        <a href="javascript:void(0);"><img src="{{asset('front/img/Icons/liked.svg')}}"></a>
                                        @else
                                        <a href="javascript:void(0);" data-type="share" data-id="{{$share->id}}" class="heart dd"><img src="{{asset('front/img/Icons/like.svg')}}"></a>
                                        <ul id="emolist-share-{{$share->id}}" class="emolist">
                                          <li val="&#128561;">&#128561;</li>
                                          <li val="&#128546;">&#128546;</li>
                                          <li val="&#129322;">&#129322;</li>
                                          <li val="&#128526;">&#128526;</li>
                                        </ul>
                                        <span class="msg"></span>
                                        @endif
                                        <ul class="shlist">
                                            <li>  
                                                <a href="javascript:void(0);" class="share" data-clipboard-text="{{route('showShare',$share['id'])}}"><i class="fa fa-share-alt"></i></a>
                                            </li>

                                            <li> <a href="https://api.whatsapp.com/send?text={{$share->url}}" class="whatsapp" target="_blank"><img src="{{asset('front/img/wa.png')}}"></a></li>
                                            
                                            <li><a href="https://www.facebook.com/sharer.php?u={{$share->url}}" class="facebook" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>

                                            

                                        </ul>
                            </div> -->
                    </div>
                
                
                </div> 
            </div>

        </div>
        
    </div>
    
</main>



@endsection    

@section('script')
<script src="{{asset('front/plugins/clipboard.min.js')}}"></script>




<script type="text/javascript">
      var clipboard = new ClipboardJS('.share');

    clipboard.on('success', function(e) {
        alert("Link Copied to clipboard");
    });

    clipboard.on('error', function(e) {
        console.log(e);
    });

      $('.heart').click(function(event){

        event.stopPropagation();

        var session = "{{Auth::check()}}";
        var ele = $(this);

    if(session == '')
    {
        $("#firstloginmodal").modal("show");
    }
    else
    {  
        $("#emolist-"+ele.attr("data-type")+"-"+ele.attr("data-id")).slideToggle();

    }       

    });

      $('.shbtn').click(function (event) {

    //event.stopPropagation();

    var session = "{{Auth::check()}}";
    var ele = $(this);
    if (session == '')
    {
        $("#firstloginmodal").modal("show");
    }
    else
    {
        $(this).siblings(".shlist").slideToggle();
        $(".emolist").hide();
    }
});


  $(".emolist li").click(function(){

        var parent = $(this).parents("ul");

        var val = $(this).attr("val");

        var formData = new FormData();
        var csrf = "{{csrf_token()}}";
        formData.append('_token', csrf);
        formData.append('reaction', val);
        formData.append('reaction_type', parent.prev(".heart").attr('data-type'));
        formData.append('reaction_id', parent.prev(".heart").attr('data-id'));
var reaction_id = parent.prev(".heart").attr('data-id');
        $.ajax({
            url: "{{route('reaction.add')}}",
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            success: function(res){
                if(res.status == 'success')
                {    
                    parent.next(".msg").html("Your reaction is "+val).show();
                    parent.slideToggle();
                    parent.prev(".heart").hide();
                    $(".heartShow-" + reaction_id + "").show();
                }
                else
                {

                }    
            },
            error: function(){
                console.log('error reacting');
            }
        });
        

        
         
    })
</script>

@endsection