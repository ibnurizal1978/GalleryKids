@extends('layouts.master')

@section('style')
<style type="text/css">

.emolist{
display:none;    height: 23px;
    margin-top: 10px;
}

.emolist li{
list-style:none;    list-style: none;
    float: right;
    margin: 0px 3px;
    font-size: 26px;}
.emolist li:hover{
    transform: rotate(360deg);
    transition: 0.6s;
}span.msg {
    font-size: 16px;
    display: block;
    text-align: center;
    color: #0ba0d8;
}
#uploadSource img{
        height: 80px;
    margin-top: -47px;
}
 .centernav {
        background: #fbf7ec;
        top: 70px;
        position: fixed;
        left: 0;
        right: 0;
        z-index: 999;
    }
    main .create-content1:first-child{
    margin-top: 125px;
    }
  
    label.uploadBtn{
    background: #fff;
    color: #000;
    font-family: 'vegr',sans-serif;
    display: block;
    line-height: 50px;
    text-align: center;
    border-radius: 36px;
    border: 1px solid #e6e6e6;
}
</style>

@endsection

@section('content')

@include('layouts.navbar')
<!--<div class="centernav">
     <div class="container">
        <ul>
            <li class="me1"><a href="{{url($tabs[0]['slug'])}}">CREATE</a></li>
            <li class="me2"><a href="{{url($tabs[1]['slug'])}}">SHARE</a></li>
            <li class="me3"><a href="{{url($tabs[4]['slug'])}}">EXPLORE</a></li>
            <li class="me4"><a href="{{url($tabs[3]['slug'])}}">PLAY</a></li>
            <li class="me5"><a href="{{url($tabs[5]['slug'])}}">EXHIBITION</a></li>

        </ul>
    </div>
</div>-->

<script>
 function check() {
    checkBox = document.getElementById('terms');
    // Check if the element is selected/checked
    if(checkBox.checked) {
        // Respond to the result
        //alert("Checkbox checked!");
    }else{
        alert("Please read and agree to the terms and conditions.");
        checkBox.checked == false;
    }
 }
</script>


<main style="background-image:url({{asset('front/img/ex1bg.png')}});background-position: top;">
    <div class="contwrap exp" style="background-image:url('{{asset('front/img/exbottom2.png')}}')">
    <div id="explore-content1" class="mt125">
        <div class="container">
            <div class="row">

            @if(Session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session('success') }}
                    </div>
                    @endif

                <div class=" col-md-12 col-sm-12 page-content share-sub">
                    <div class="title-lines">
                        <h3 class="mt0">SUBMIT A QUESTION</h3>
                    </div>
                
                  <form method="POST" class="latest-jobs-section" action="{{route('question.store')}}" enctype="multipart/form-data" onsubmit="return checkForm(this);">
                                        @csrf

                        <div class="col-md-12 form-group">
                            <div class="col-md-3">
                                <label>Question</label>
                            </div>
                            <div class="col-md-9">
                                <textarea name="question" required="" class="form-control" id="question" rows="10" >{{old('question')}}</textarea>
                            </div>
                        </div>

                    

                        <div class="col-md-12 form-group">
                            <div class="col-md-3">
                                <label>Upload files</label>
                            </div>
                            <div class="col-md-3">
                               <!-- <input type="file" class="uploadinput" name="file"  id="thumbnails" accept="image/*"/>
                                <span class="uploadBtn">Upload here</span>-->
                                <label class="uploadBtn">
                                    <input type="file" class="uploadinput" name="file" id="thumbnails" accept="image/*" style="display: none;">
                                    Upload here
                                </label>
                            </div>
                            <div class="col-md-6">
                                <h6 id="uploadSource"></h6>
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <div class="col-md-3">
                            
                            </div>
                            <div class="col-md-9" style="display: flex">
                                <input type="checkbox" id="terms" required onchange="this.setCustomValidity(validity.valueMissing ? 'Please read and agree to the terms and conditions.' : '');" style="margin-top: 0px;margin-right: 20px;" />
                                <label for="terms" style="font-size: 14px;">I agree with the <a href="javascript:void(0)" class="termspopcall">terms and conditions</a> for my submission.</label>
                            </div>
                        </div>
                        @guest
                        <div class="col-md-12 form-group">
                            <div class="col-md-3">
                                <label>Full Name: (If Not A Member)</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" id="full-name-column" class="form-control" name="non_member_name" value="{{old('non_member_name')}}" required=""/>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="col-md-3">
                                <label>Age: (If Not A Member)</label>
                            </div>
                            <div class="col-md-3">
                                <input type="number" id="age-column" class="form-control" placeholder="Enter Age" min="1" max="100" name="age" value="{{old('age')}}" required="" />
                            </div>
                        </div>


                      @endguest

                        <div class="col-md-12 form-group">
                            <div class="col-md-3">
                                
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-submitExplore" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                        
                </div> 
            </div>

        </div>
    </div>
     <div class="bottomheight"></div>
</div>
</main>
  <div id="termsandcondition1" class="modal fontcss" role="dialog">
            <div class="preloader" ></div>
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <!-- Modal content-->
                <div class="modal-content">
                    <a class=" termscancel"><img src="{{asset('front/img/close.png')}}"/></a>
                    <div class="modal-body para-blk">
                        <h3 class="poptitle">Gallery Kids! Submissions ("Submissions") Terms and Conditions</h3>
                        <p>The Gallery reserves the right and retains sole discretion over which Submissions it will publish </p>

                        <p>Participants agree that all Submissions are original and do not infringe on any third-party copyright or intellectual property. Participants are fully liable and responsible for their Submissions and for obtaining all necessary third-party permissions before submitting to the Gallery</p>

                        <p>Participants agree to grant the Gallery a non-exclusive, worldwide, perpetual, royalty-free right to reproduce, modify, edit, publish and distribute the Submissions digitally or physically and on any platforms including but not limited to the Gallery Kids! Website.</p>
                    </div>


                </div>
            </div>
        </div>

          <div class="modal fade submitpop" role="dialog">
                <div class="preloader" ></div>
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <!-- Modal content-->
                    <div class="modal-content-new modal-content">
                        <a class="okcancelbtn"><img src="{{asset('front/img/close.png')}}"/></a>
                        <div class="modal-body">
                          <h6>Thank you for your submission.</h6>
                          <p>We will keep you updated</p>
<!--                          <button class="okbtn">OK</button>-->
                        </div>
                    </div>
                </div>
            </div>

@endsection    

@section('script')
<script>

  document.getElementById("terms").setCustomValidity("Please read and agree to the terms and conditions.");

</script>

<script src="{{asset('front/plugins/clipboard.min.js')}}"></script>

{{--
<script src="{{url('ckeditor/ckeditor.js')}}"></script>
<script src="{{url('ckeditor/samples/js/sample.js')}}"></script>
<script>
  CKEDITOR.replace( 'question' );
</script>
--}}

<script>

    $(document).ready(function(){

        $(".btn-submitExplore").click(function(){
            /*if($("#question").val() && $("#terms").prop("checked",true)){
                $(".submitpop").modal({backdrop:false})
                return false
//                return true
                
            }else{
                alert('nging!');
                //return false;
            }*/
        })


        
        
        $(".termspopcall").click(function(){
            $("#termsandcondition1").modal('show')
        })
       
         $(".termscancel").click(function(){
            $("#termsandcondition1").modal('hide')
        })
    })
    
    var clipboard = new ClipboardJS('.share');

    clipboard.on('success', function(e) {
        alert("Link Copied to clipboard");
    });

    clipboard.on('error', function(e) {
        console.log(e);
    });

    $('.heart').click(function(){

        var session = "{{Auth::check()}}";
        var ele = $(this);

    if(session == '')
    {
        $("#login-modal").modal("show");
    }
    else
    {  
        $("#emolist-"+ele.attr("data-type")+"-"+ele.attr("data-id")).slideToggle();

    }       

    });

    $(".uploadinput").change(function(){
        $("#uploadSource").empty();
          const file = $(this)[0].files[0];
          const reader = new FileReader();

          reader.addEventListener("load", function () {
            // convert image file to base64 string
            $("#uploadSource").append("<img src='"+reader.result+"'/>")
          }, false);

          if (file) {
            reader.readAsDataURL(file);
          }
    })

   $('.shbtn').click(function(){

        var session = "{{Auth::check()}}";
        var ele = $(this);

        if(session == '')
        {
            $("#login-modal").modal("show");
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

    