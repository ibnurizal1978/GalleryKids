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

        #pass-modal1 .modal-body {
            background: url('{{asset('front/img/zigzagbg1.png')}}');
            background-repeat: repeat;
            background-size: 50% auto;
        }

        #pass-modal1 p.subline {
            color: #000;
            font-size: 14px;
            width: 100%;
        }

        #pass-modal1 h2.formhding {
            color: #000;
            font-size: 18px;
        }

        #pass-modal1 h3.formhding {
            color: #000;
            font-size: 16px;
        }

        #pass-modal1 .form-control {
            min-width: 100% !important;
            margin-bottom: 30px;
        }

        #pass-modal1 .form-group {
            display: block;
        }
    </style>

@endsection

@section('alert')

    @include('layouts.alert')

@endsection


@section('content')


    @include('layouts.navbar')


    <main class="prbg">
        <div class="mt125 pr-content ">
            <div class="container">
                <div class="row page-content">

                    <div class="mysubmission col-md-12 col-sm-12 mt80">
                        <div class="toggleProfile">
                            <label class="switch">
                                <input type="checkbox" id="togglePR">
                                <span class="slider round"></span>

                            </label>
                            <label>Current: Parent Profile</label>
                            <span>Click on the switch to change profile</span>
                        </div>


                        <div class="col-md-12 prcont2">
                            <h3>{{Auth::user()['first_name']}} {{Auth::user()['last_name']}}</h3>
                            <br/>
                            <p>SELECT CURRENT CHILD USER:</p>
                            <ul>
                                @foreach($childrens as $children)
                                    <li class="childlist" dataid="{{$children['id']}}">
                                        <p>{{strip_tags($children['first_name'])}}</p>
                                        <p>{{strip_tags($children['last_name'])}}</p>
                                    <?php $amout = $submitManage = Modules\Points\Entities\PointManage::whereUserId( $children['id'] )->orderBy( 'created_at', 'DESC' )->get()->sum( 'points' );
                                    ?>
                                    <!--                                <p>{{$amout}} Points</p>-->
                                    </li>
                                @endforeach


                                <li class="addnew">
                                    <p>+</p>
                                    <p>Add New Child</p>
                                </li>
                            </ul>
                        </div>
                    </div>


                    <div class="mysubmission col-md-12 col-sm-12 ">
                        <div class="title-lines">
                            <h3 class="mt0">DETAILS</h3>
                        </div>

                        <div class="col-md-12 col-sm-12 myDetails">
                            <?php
                            $date = Auth::user()['created_at'];
                            $current = \Carbon\Carbon::now();

                            $type = '';
                            foreach ( $member->MembershipSummaries as $MembershipType ) {

                                if ( $MembershipType->Status == 'ACTIVE' ) {
                                    $Type        = $MembershipType->Type;
                                    $expire      = $MembershipType->ExpiryDate;
                                    $MemberSince = $MembershipType->ValidFrom;
                                }
                            }
							
                            $ids = [];
                            $user = Auth::user();
                            $childrens = $user->children;
                            foreach ( $childrens as $children ) {
                                $ids[] = $children['id'];
                            }
                            $amoutPoint = Modules\Points\Entities\PointManage::whereIn( 'user_id', $ids )->orderBy( 'created_at', 'DESC' )->get()->sum( 'points' );



                            ?>
                            <div class="detItem col-md-12 col-sm-12 ">
                                <div class="col-md-3 col-sm-12 col-xs-12">Membership Type</div>
                                <div
                                    class="col-md-9 col-sm-12 col-xs-12">{{$Type}}</div>
                            </div>

                            <div class="detItem col-md-12 col-sm-12 ">
                                <div class="col-md-3 col-sm-12 col-xs-12">Membership Since</div>
                                <div
                                    class="col-md-9 col-sm-12 col-xs-12">{{ date('d-M-y', strtotime($MemberSince)) }}</div>
                            </div>

                            <div class="detItem col-md-12 col-sm-12 ">
                                <div class="col-md-3 col-sm-12 col-xs-12">Membership Expiry</div>
                                {{--                            <div class="col-md-9 col-sm-12 col-xs-12">{{ date('d-M-y', strtotime($expire)) }}</div>--}}
                                <div
                                    class="col-md-9 col-sm-12 col-xs-12">{{ optional(Auth::user())->data->gpe_expires_at ? Auth::user()->data->gpe_expires_at->format('d-M-y') : 'N/A' }}</div>
                            </div>

                            <!--                        future functionality disabled for now only-->

                        <!--                        <div class="detItem col-md-12 col-sm-12 ">
                            <div class="col-md-3 col-sm-12 col-xs-12">Points</div>
                            <div class="col-md-9 col-sm-12 col-xs-12 lastDet">{{$point}}</div>
                        </div>



                        <div class="detItem col-md-12 col-sm-12 ">
                            <div class="col-md-3 col-sm-12 col-xs-12">Points expire </div>
                            @if($pointExpire)
                            <div class="col-md-9 col-sm-12 col-xs-12">{{ date('d-M-y', strtotime($pointExpire)) }}</div>
                            @else
                            <div class="col-md-9 col-sm-12 col-xs-12">---</div>
                            @endif

                            </div>-->
                        </div>

                    </div>


                </div>

            </div>
            <div class="bottomheight"></div>
        </div>
    </main>


    <style type="text/css">

        .avatars > input {
            display: none;
        }

        .avatars > input + img {
            cursor: pointer;
            border: 2px solid transparent;
        }

        .avatars > input:checked + img {
            border: 2px solid blue;
        }

    </style>

    <div id="avatar-modal" class="modal" role="dialog">
        <div class="preloader"></div>
        <div class="modal-dialog  modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <a class="cancel">X</a>
                <div class="modal-body login-blk">
                    <img src="{{asset('front/img/kidslogo2.png')}}" alt="">
                    <h2>Select Avatar</h2>
                    <div class="row">
                        @foreach($avatars as $avatar)
                            <div class="col-md-4">
                                <label class="avatars">
                                    <input type="radio" value="{{asset($avatar->image)}}" name="avatar"/>
                                    <img src="{{asset($avatar->image)}}" style="height: 150px;width: 150px;">
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-success upload_avatar">Upload</button>
                </div>
            </div>
        </div>
    </div>


    <div id="addchild-modal1" class="modal" role="dialog">
        <div class="preloader"></div>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body login-blk">
                    <a class="cancellogin"><img src="{{asset('front/img/close.png')}}"/></a>
                    <h2 class="formhding">Add Child</h2>
                    <p class="subline">On behalf of a family</p>


                    <div class="addedchild all">

                    </div>


                    <div class="addchild ">
                        <h3 class="addchildbtn">Add Child<a href="javascript:void(0)"><span class="plus">+</span><span
                                    class="minus">-</span></a></h3>

                        <div class="inneraccord">
                            <div class="form-group ">
                                <label class="formlabel">First Name</label>
                                <input type="text" name="Childfirstname" class="form-control forminput"/>
                            </div>
                            <div class="form-group ">
                                <label class="formlabel">Last Name</label>
                                <input type="text" name="Childlastname" class="form-control forminput"/>
                            </div>

                            <div class="form-group">
                                <label class="formlabel">Gender</label>

                                <select name="Childgender" class="gender form-control forminput genderinput">
                                    <option value="">Select</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                                <b class="Childgender error"></b>
                            </div>

                            <div class="form-group">
                                <label class="formlabel">Date of Birth</label>
                                <div class="dobblk">
                                    <select name="date" class="form-control forminput ddinput">
                                        <option value="" selected="" disabled="">Day</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">07</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                    </select>

                                    <select name="month" class="form-control forminput moninput">
                                        <option value="" selected="" disabled="">Month</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>

                                    <select name="year" class="form-control forminput yearinput">
                                        <option value="" selected="" disabled="">Year</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <button class="btn add-btn">Add</button>
                            </div>
                        </div>

                    </div>

                    <br/>
                    <p class="errorMessage"></p>

                    <div class="col-md-12 btnblock">
                        <button class="btn btn-login" id="dataSave">
                            <div class="txn">Confirm</div>
                            <div class="spinner">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                        </button>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div id="pass-modal1" class="modal" role="dialog">
        <div class="preloader"></div>
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body login-blk">
                    <a class="cancellogin"><img src="{{asset('front/img/close.png')}}"/></a>
                    <h2 class="formhding">Proceed to child profile</h2>
{{--                    <h3 class="formhding">An One-Time Password sent to your email.</h3>--}}
{{--                    <p class="subline">Please enter OTP code to proceed:</p>--}}
                    <h5 class="errorMessage"></h5>
{{--                    <div class="form-group">--}}
{{--                        <input type="text"--}}
{{--                               name="password"--}}
{{--                               class="form-control forminput"--}}
{{--                               id="passInput"--}}
{{--                        />--}}
{{--                        <b class="error"></b>--}}
{{--                    </div>--}}


                    <button class="btn btn-login PassConfirm">OK</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script src="{{asset('front/plugins/clipboard.min.js')}}"></script>

    <script>

        $(document).on("click", "a.removebtn", function () {
            $(this).parents(".child1").remove();
        });


        $(document).ready(function () {

            // var startyear = new Date().getFullYear() - 1;
            //
            // var endtyear = new Date().getFullYear() - 14;
            //
            // for (var i = startyear; i >= endtyear; i--) {
            //     var opp = "<option value='" + i + "'>" + i + "</option>";
            //     $(".yearinput").append(opp)
            // }


            $("#dataSave").click(function () {

                $(".errorMessage").empty();

                if ($("#addchild-modal1").find(".addedchild.all .child1").length == 0) {
                    $("#addchild-modal1").find(".errorMessage").append("<b style='color:red;' >At least One child is required.</b>")
                    return false;
                }

                $(this).prop("disabled", true);
                var formData = new FormData();


                $("#addchild-modal1").find(".addedchild.all .child1").each(function (index) {
                    var childdata = JSON.parse($(this).attr('data'));

                    formData.append('kids[' + index + '][firstname]', childdata.firstname);
                    formData.append('kids[' + index + '][lastname]', childdata.lastname);
                    formData.append('kids[' + index + '][gender]', childdata.gender);
                    formData.append('kids[' + index + '][dob]', childdata.dob);

                });
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    async: true,
                    url: '{{url()->route('memberson-add-kids')}}',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function (data) {
                        console.log(data)
                        window.location.reload();
                        $("#dataSave").prop("disabled", false);
                        $("#addchild-modal1").modal('hide');

                    },
                    error: function (data) {
                        console.log(data);
                        if (data.errors) {
                            $(".errorMessage").append("<b style='color:red;'>Something information is missing. Please try to fill the form again</b>");
                        }

                        $("#dataSave").prop("disabled", false);
                        return false;
                    }
                });

            });


            // $(".addchildbtn").click(function () {
            //     $(".addchild").toggleClass("active");
            // })

            $(".prcont2 ul li.childlist:first-child").addClass("active");


            $(".PassConfirm").click(function () {
                // $("#passInput").next("b").empty();
                $(".errorMessage").empty();
                    var childid = $(".prcont2 ul li.active").attr("dataid");
                    $(this).prop("disabled", true);

                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', childid);
                    $.ajax({
                        async: true,
                        {{--url: '{{route("studentLogin")}}',--}}
                        url: '{{url()->route('child-login')}}',
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        success: function (data) {
                            $(".errorMessage").append("<b style='color:green;'>" + data.message + "</b>");
                            window.location.reload(true);
                        },
                        error: function (data) {
                            $(".errorMessage").append("<b style='color:red;'>" + data.responseJSON.message + "</b>");
                            $(".PassConfirm").prop("disabled", false);
                            return false;
                        }
                    });

                // if ($("#passInput").val()) {
                //     var pass = $("#passInput").val();
                //
                //     formData.append('password', pass);
                //
                // } else {
                //     $("#passInput").next("b").append("<p>Please Enter Password</p>")
                // }
            })

            $(".prcont2 ul li.childlist").click(function () {
                $(this).addClass("active").siblings("li").removeClass("active");
            })


            $(".addnew").click(function () {

                $(".addedchild.all").empty();
                $("input[name='Childfirstname']").val('');
                $("input[name='Childlastname']").val('');
                $(".genderinput").val('');
                $(".ddinput").val('');
                $(".moninput").val('');
                $(".yearinput").val('');


                $("#addchild-modal1").modal({
                    backdrop: false
                })
            })
            $("#addchild-modal1").find(".cancellogin").click(function () {
                $("#addchild-modal1").modal('hide');
            })


            $("#togglePR").change(function () {
                $(".forminput").val("");
                $(".errorMessage").empty();
                // sendOTP();
                if ($(this).prop('checked') === true) {
                    $("#pass-modal1").modal({
                        backdrop: false
                    })
                }
            })

            $("#pass-modal1").find(".cancellogin").click(function () {
                $("#pass-modal1").modal('hide');
                $("#togglePR").prop('checked', false)
            })


            // $(".add-btn").click(function () {
            //     var fname = $(".inneraccord").find("input[name='firstname']").val();
            //     var lname = $(".inneraccord").find("input[name='lastname']").val();
            //     var date = $(".inneraccord").find(".ddinput").val();
            //     var month = $(".inneraccord").find(".moninput").val();
            //     var year = $(".inneraccord").find(".yearinput").val();

            //     console.log(fname, lname, date, month, year)
            //     if (fname && lname && date && month && year) {
            //         $(".addedchild").append("<div class='child1'>" +
            //                 "<h3>" + fname + " " + lname + "<a href='javascript:void(0)' class='addchildbtn removebtn'><img src='{{url('/front/img/close.png')}}'></a></h3>" +
            //                 "</div>")

            //         $(".inneraccord").find("input[name='firstname']").val('');
            //         $(".inneraccord").find("input[name='lastname']").val('');
            //         $(".inneraccord").find(".ddinput").val('');
            //         $(".inneraccord").find(".moninput").val('');
            //         $(".inneraccord").find(".yearinput").val('');
            //     }
            // })


            $(".add-btn").click(function () {

		$(".errorMessage").empty();
                var route = $(this).parents(".form-group").parents(".inneraccord");

                var fname = route.find("input[name='Childfirstname']").val();
                var lname = route.find("input[name='Childlastname']").val();
                var gender = route.find(".genderinput").val();
                var date = route.find(".ddinput").val();
                var month = route.find(".moninput").val();
                var year = route.find(".yearinput").val();


if(!validateName(route.find("input[name='Childfirstname']").val()) ){
    $("#addchild-modal1").find(".errorMessage").append("<b style='color:red;' >Please ensure only alphabets in the First and Last Name fields.</b>")
	//alert('please type alphabet');
    return false;

}

if(!validateName(route.find("input[name='Childlastname']").val()) ){
	       /* $(".addedchild.all").empty();
                $("input[name='Childfirstname']").val('');
                $("input[name='Childlastname']").val('');
                $(".genderinput").val('');
                $(".ddinput").val('');
                $(".moninput").val('');
                $(".yearinput").val(''); */

	$("#addchild-modal1").find(".errorMessage").append("<b style='color:red;' >Please ensure only alphabets in the First and Last Name fields.</b>")
    //alert('Please type alphabet');
    return false;

}

function validateName(name)
{
        re = /^[A-Za-z]+$/;
        return re.test(name);
}



                var dt = {
                    firstname: fname,
                    lastname: lname,
                    gender,
                    dob: date + "/" + month + "/" + year
                };

                console.log(fname, lname, date, month, year, gender)
                if (fname && lname && date && month && year && gender) {
                    $(this).parents(".addchild").prev(".addedchild.all").append("<div class='child1' data='" + JSON.stringify(dt) + "'>" +
                        "<h3>" + fname + " " + lname + "<a href='javascript:void(0)' class='addchildbtn removebtn'><img src='{{asset('front/img/close.png')}}'></a></h3>" +
                        "</div>")


                    route.find("input[name='Childfirstname']").val('');
                    route.find("input[name='Childlastname']").val('');
                    route.find(".genderinput").val('');
                    route.find(".ddinput").val('');
                    route.find(".moninput").val('');
                    route.find(".yearinput").val('');
                }
            })


            $(".unfavourite").click(function () {

                var reaction_id = $(this).attr('data-reaction-id');
                var parent_div = $(this).closest('.col-md-4');
                var formData = new FormData();
                var csrf = "{{csrf_token()}}";
                formData.append('_token', csrf);
                formData.append('reaction_id', reaction_id);


                $.ajax({
                    url: "{{route('reaction.delete')}}",
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (res) {
                        if (res.status == 'success') {
                            parent_div.remove();
                        } else {

                        }
                    },
                    error: function () {
                        console.log('error removing reacting');
                    }
                });


            });


            $(".prinput").change(function () {

                var formData = new FormData();
                var input = $(this);
                var file = input[0].files[0];
                var csrf = "{{csrf_token()}}";

                formData.append('profile', file);
                formData.append('_token', csrf);

                upload_profile_image(formData);

            });

            function upload_profile_image(formData) {

                $.ajax({
                    url: "{{route('user.profile.upload')}}",
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (res) {
                        $("#profile_image").attr('src', res);
                    },
                    error: function () {
                        console.log('error')
                    }
                });

            }

            var clipboard = new ClipboardJS('.share');

            clipboard.on('success', function (e) {
                alert("Link Copied to clipboard");
            });

            clipboard.on('error', function (e) {
                console.log(e);
            });

            $("#avatar").on('click', function () {
                $("#avatar-modal").modal("show");
            });

            $(".upload_avatar").click(function () {

                var avatar = $('input[name="avatar"]:checked').val();

                if (avatar) {

                    var formData = new FormData();
                    var csrf = "{{csrf_token()}}";
                    formData.append('avatar', avatar);
                    formData.append('_token', csrf);
                    upload_profile_image(formData);
                    $("#avatar-modal").modal("hide");

                }


            });

        });


        $(".archive").click(function () {

            var ele = $(this);
            var formData = new FormData();
            var csrf = "{{csrf_token()}}";
            formData.append('_token', csrf);
            formData.append('archive_type', ele.attr('data-type'));
            formData.append('archive_id', ele.attr('data-id'));

            $.ajax({
                url: "{{route('archive.add')}}",
                method: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                success: function (res) {
                    if (res.status == 'success') {
                        ele.parent().remove();
                    } else {

                    }
                },
                error: function () {
                    console.log('error reacting');
                }
            });

        });

        function sendOTP() {
            var formData = new FormData();
            var csrf = "{{csrf_token()}}";
            formData.append('_token', csrf);

            $.ajax({
                async: true,
                url: '{{route('profile-otp')}}',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    console.log(data);
                    // $(".errorMessage").append("<b style='color:green;'>" + data.message + "</b>");
                    // window.location.reload(true);
                },
                error: function (data) {
                    console.log(data);
                    // $(".errorMessage").append("<b style='color:red;'>" + data.responseJSON.message + "</b>");
                    // $(".PassConfirm").prop("disabled", false);
                    // return false;
                }
            });
        }

    </script>

@endsection

