@extends('layouts.master')

@section('style')

    <style>
        .centernav {
            top: 70px;
            position: fixed;
            left: 0;
            right: 0;
            z-index: 9;
        }
        #uploadSource img {
            height: 80px;
            margin-top: -47px;
        }
        @media (max-width: 769px){
            .share-sub input[type='checkbox']~label {
                line-height: 18px;
                 padding-top: 12px;
            }
            .share-sub input[type='checkbox'] {
                width: 32px;
            }
        }
    </style>
@endsection

@section('content')


@include('layouts.navbar')


<main style="background-image:url({{asset('front/img/sh1bg.png')}})">
     <div class="contwrap sh" style="background-image:url('{{asset('front/img/shbottom2.png')}}')">
        <div id="create-content1" class="mt125">
            <div class="container">
                <div class="row">
                    <div class=" col-md-12 col-sm-12 page-content share-sub">

                        <div class="title-lines">
                            <h3 class="mt0">SHARE YOUR WORKS</h3>
                        </div>
                    
                       <form method="POST" class="latest-jobs-section" action="{{route('share.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12 form-group">
                                <div class="col-md-3">
                                    <label>Title</label>
                                </div>
                                <div class="col-md-9">
                                     <input type="text" id="name" class="form-control" name="name" value="{{old('name')}}" required=""> 
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <div class="col-md-3">
                                    <label>Description</label>
                                </div>
                                <div class="col-md-9">
                                     <textarea maxlength="50" name="description" required="" class="form-control" id="description" rows="8" >{{old('description')}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <div class="col-md-3">
                                    <label>Inspired by</label>
                                </div>
                                <div class="col-md-9">
                                     <input type="text" id="Inspired_by" class="form-control" name="Inspired_by" value="{{old('Inspired_by')}}" required=""> 
                                </div>
                            </div>


<!--                            <div class="col-md-12 form-group">
                                <div class="col-md-3">
                                    <label for="hashtags-column">#Hashtags</label>
                                </div>
                                <div class="col-md-3">
                                	{{--
                                    <input type="text" id="hashtags-column" data-role="tagsinput" class="form-control" name="hashtags" value="{{old('hashtags')}}" placeholder="Enter tags seperated by ," required=""> 
                                     <div class="addedval"> </div>
                                	--}}
                                	<input type="text"  class="form-control" name="hashtags[]" value="{{old('hashtags')}}" placeholder="" required="">
                                </div>
                                <div class="col-md-3">
                                	{{--
                                    <input type="text" id="hashtags-column" data-role="tagsinput" class="form-control" name="hashtags" value="{{old('hashtags')}}" placeholder="Enter tags seperated by ," required=""> 
                                     <div class="addedval"> </div>
                                	--}}
                                	<input type="text"  class="form-control" name="hashtags[]" value="{{old('hashtags')}}" placeholder="" required="">
                                </div>
                                
                            </div>-->

                             @guest

                             <div class="col-md-12 form-group">
                                <div class="col-md-3">
                                    <label>Full Name: (If not a member)</label>
                                </div>
                                <div class="col-md-9">
                                       <input type="text" id="full-name-column" class="form-control" name="non_member_name" value="{{old('non_member_name')}}" required=""> 
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <div class="col-md-3">
                                    <label>Age: (If not a member)</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="number" id="age-column" class="form-control" min="1" max="100" name="age" value="{{old('age')}}" required="">  
                                </div>
                            </div>

                               @endguest

                            <div class="col-md-12 form-group">
                                <div class="col-md-3">
                                    <label>Upload File</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="file" class="uploadinput" name="thumbnails[]" required="" multiple="" id="thumbnails" accept="image/*"/>
                                    <span class="uploadBtn">Upload here</span>
                                </div>
                                <div class="col-md-6">
                                    <h6 id="uploadSource">
                                        
                                    </h6>
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <div class="col-md-3">
                                
                                </div>
                                <div class="col-md-9" style="display: flex">
                                    <input type="checkbox" id="terms" style="margin-top: 0px;margin-right: 20px;" required="" />
                                    <label for="terms" style="font-size: 14px;">I agree with the <a href="javascript:void(0)" class="termspopcall">terms and conditions</a> for my submission.</label>
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <div class="col-md-3">
                                    
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-submitShare" type="submit"> Submit</button>
                                </div>
                            </div>
                        </form>
                            
                    </div> 
                </div>

            </div>
             <div class="bottomheight"></div>
        </div>
    </div>
</main>
  <div id="termsandcondition1" class="modal fade fontcss" role="dialog">
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


<script src="{{asset('front/plugins/clipboard.min.js')}}"></script>


<script type="text/javascript">
     $(document).ready(function(){
        $(".btn-submitShare").click(function(){
            if($("#name").val() && $("#description").val() && $("#Inspired_by").val() && $("#thumbnails").val() && ($("#terms").prop("checked") === true)){
                
                $(".submitpop").modal({backdrop:false})
//                return false
//                return true
            }
          
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



</script>

@endsection