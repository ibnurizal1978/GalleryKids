<html><head>
    <meta charset="utf-8">
    <title>Invoice</title>
</head>
<body style="position: relative;width: 21cm;height: 29.7cm;margin: 0 auto;color: #555555;background: #fff;font-size: 14px;font-family: sans-serif;">

    <table style="
    background: #fff;
    width: 100%;
" cellspacing="0">
        <thead style="
    width: 100%;
">
            <tr>
                <td style="
    width: 14px;
"></td>
                <td><img src="{{asset('front/img/kidslogo2.png')}}" style="
    width: 157px;
    margin-top: 10px;
    margin-bottom: 10px;
"></td>
            </tr>

        </thead>
    <tbody>
        <tr>
            <td colspan="2" style="width:100%"><img src="{{asset('front/img/monthtemp.png')}}" style="width:100%"/></td>
        </tr>
    </tbody>


    </table>
    <table style="
    width: 73%;
    margin: auto;
">
        <tbody>
            <tr>
                <td colspan="2">
                    <p style="
    margin-top: 50px;
    color: #000;
    font-size: 15px;
    line-height: 21px;
    font-family: sans-serif;
          ">Look! <span style="
    min-width: 50px;
    display: inline-block;
    border-bottom: 2px solid #000;
"></span> {{$data->name}} has made these accomplishments!</p>
                    
                </td>
            </tr>

<tr>
    <td>
    <h3 style="
    color: #000;
    font-size: 24px;
    font-family: sans-serif;
">Summary of kayler kwek</h3>
    <p style="
    margin-bottom: 40px;
    color: #000;
    font-family: sans-serif;
    font-size: 16px;
">{{$data->points}} Points | Level 1</p>
    <p style="
    color: #000;
    font-family: sans-serif;
    font-size: 16px;
    margin: 0px;
    line-height: 24px;
">No. of Reactions<span> :{{$data->reaction}}</span></p>
    <p style="
    color: #000;
    font-family: sans-serif;
    font-size: 16px;
    margin: 0px;
    line-height: 24px;
">No. of Submissions (Shares)<span> :{{$data->Submissions}}</span></p>
    <p style="
    color: #000;
    font-family: sans-serif;
    font-size: 16px;
    margin: 0px;
    line-height: 24px;
">No. of Questions Posted<span> :{{$data->Questions}}</span></p>
    <p style="
    color: #000;
    font-family: sans-serif;
    font-size: 16px;
    margin: 0px;
    line-height: 24px;
">No. of Login/Visit<span> :{{$data->Visit}}</span></p>

</td>
    <td style="
    text-align: right;
">
    <img src="{{$data->image}}" style="
    width: 200px;
    height: 200px;
    background: #ddd;
    border-radius: 50%;
    overflow: hidden;
    margin-bottom: 50px;
    margin-top: 30px;
">
    </td>
</tr>

                <tr style="
    margin-top: 50px;
">
                    <td style="
    border-top: 1px solid rgb(185 23 30 / 32%);
" colspan="2"><p style="
    margin-top: 40px;
    color: #000;
    font-size: 15px;
    line-height: 21px;
    font-family: sans-serif;
">Continue exploring <a href="#" style="
    color: #d02231;
    font-size: 15px;
    font-weight: bold;
    text-decoration: none;
">www.gallerykids.com.sg</a> to discover the stories behind art, and collect your virtual badges!</p></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <a href="{{url('/')}}" style="
    padding: 13px 20px;
    display: block;
    margin: 50px auto;
    text-align: center;
    background: #d02231;
    border-radius: 25px;
    color: #fff;
    font-weight: bold;
    font-size: 20px;
    width: 210px;
">Continue the journey</a>
                    </td>
                </tr>
                <tr>
                    <td style="
    text-align: center;
" colspan="2">  <img src="{{asset('front/img/letsart.png')}}" style="width:100%"/>
                    </td>
                </tr>
                <tr>
                    <td style="
" colspan="2"></td>
                </tr>

        </tbody>

    </table>
<table style="
    width: 100%;
" cellspacing="0">
    <tbody><tr>
        <td style="width:100%;
">
    <img src="{{asset('front/img/plbottom.png')}}" style="width: 100%">
</td>
    </tr>
</tbody></table>
    <table style="
    background: #d02231;
    width: 100%;
">
        <tfoot style="
">
            <tr>
                <td colspan="5" style="text-align: center;">
                    <p style="
    color: #fff;
    font-size: 12px;
    margin-top: 40px;
    max-width: 460px;
    margin: auto;
    padding-top: 40px;
    line-height: 16px;
">This email was sent to {{$data->email}}, We encourage you to stay signed up so you'll always know what is going on!</p>
                    <p style="
    color: #fff;
    font-size: 12px;
    margin-top: 40px;
    max-width: 460px;
    margin: auto;
    padding-top: 18px;
    line-height: 16px;
">Do you want fewer (or more) updates from us? <a href="#" style="
    color: #fff;
">Update your email preferences.</a></p>
                    <p style="
    color: #fff;
    font-size: 12px;
    margin-top: 40px;
    max-width: 460px;
    margin: auto;
    padding-top: 19px;
    line-height: 16px;
"><a href="#" style="
    color: #fff;
">www.nationalgallery.sg</a></p>
                    <p style="
    color: #fff;
    font-size: 12px;
    margin-top: 40px;
    max-width: 460px;
    margin: auto;
    line-height: 21px;
    padding-bottom: 50px;
">1 St Andrew's Rd. Singapore 178957</p>
                </td>
            </tr>
            
            <tr style="
                    width: 240px;
                    display: block;
                    margin: auto;
                    ">
                    <td style="
                        text-align: center;
                        width: 46px;
                        "><a href="https://www.facebook.com/nationalgallerysg" target="_blank"><img src="{{asset('front/img/Icons/social-media/facebook.png')}}" style="
                                       width: 24px;
                                       margin: 0px 10px;
                                       "></a></td>
                    <td style="
                        text-align: center;
                        width: 46px;
                        "><a href="https://www.instagram.com/nationalgallerysingapore/" target="_blank"><img src="{{asset('front/img/Icons/social-media/logo.png')}}" style="
                                       width: 24px;
                                       margin: 0px 10px;
                                       "></a></td>
                    <td style="
                        text-align: center;
                        width: 46px;
                        "><a href="https://twitter.com/natgallerysg" target="_blank"><img src="{{asset('front/img/Icons/social-media/twitter.png')}}" style="
                                       width: 24px;
                                       margin: 0px 10px;
                                       "></a></td>
                    <td style="
                        text-align: center;
                        width: 46px;
                        "><a href="https://www.youtube.com/user/nationalgallerysg" target="_blank"><img src="{{asset('front/img/Icons/social-media/youtube.png')}}" style="
                                       width: 24px;
                                       margin: 0px 10px;
                                       "></a></td>
                    <td style="
                        text-align: center;
                        width: 46px;
                        "><a href="https://www.tripadvisor.com.sg/Attraction_Review-g294265-d8077179-Reviews-National_Gallery_Singapore-Singapore.html" target="_blank"><img src="{{asset('front/img/Icons/social-media/tripadvisor.png')}}" style="
                                       width: 24px;
                                       margin: 0px 10px;
                                       "></a></td>
                </tr>
        <tr>
            <td colspan="5" style="
    text-align: center;
    color: #fff;
    font-size: 12px;
    padding: 20px 0px;
">
                <p>© 2020 All Rights Reserved</p>
            </td>
        </tr>
        </tfoot>
    
    </table>


</body></html>