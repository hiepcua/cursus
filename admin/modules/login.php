<style type="text/css">
    .sign_in_up_bg {
        /*background: #f7f7f7 !important;*/
        padding-top: 100px;
        position: relative;
        width: 100%;
    }
    .sign_form {
        background: #fff;
        border-radius: 10px;
        padding: 50px 50px 30px;
        box-shadow: -0.083333333in 0.5pc 1.125pc -7px rgba(25,42,70,.13);
        flex: 1;
        float: left;
        width: 100%;
        margin-top: 0;
        text-align: center;
    }
    .login-btn {
        font-size: 14px;
        margin-top: 30px;
        font-weight: 400;
        font-family: 'Roboto', sans-serif;
        color: #fff;
        background: #ed2a26;
        border-radius: 20px;
        text-align: center;
        border: 0;
        width: 100%;
        height: 40px;
    }
    .sign_form input {
        padding-left: 4.2em!important;
        padding-right: 1em!important;
        height: 40px;
        font-size: 14px;
        font-weight: 400;
        font-family: 'Roboto', sans-serif;
        border-radius: 500rem;
    }
    .ui.form.checkbox_sign {
        text-align: left;
    }
    .ui.form.checkbox_sign {
        text-align: left;
    }
    .ui.checkbox {
        position: relative;
        display: inline-block;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        outline: 0;
        vertical-align: baseline;
        font-style: normal;
        min-height: 17px;
        font-size: 1rem;
        line-height: 17px;
        min-width: 17px;
    }
    .ui.form.checkbox_sign {
        text-align: left;
    }
    .sign_form {
        background: #fff;
        border-radius: 10px;
        padding: 50px 50px 30px;
        box-shadow: 0in 1pc 1.125pc -5px rgba(25,42,70,.13)
        flex: 1;
        float: left;
        width: 100%;
        margin-top: 0;
        text-align: center;
    }
    .ui.form input[type=checkbox], .ui.form textarea {
        vertical-align: top;
    }
    .ui.checkbox input[type=checkbox], .ui.checkbox input[type=radio] {
        cursor: pointer;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0!important;
        outline: 0;
        z-index: 3;
        width: 17px;
        height: 17px;
    }
    .ui.checkbox input.hidden {
        z-index: -1;
    }
    .sign_form input {
        padding-left: 4.2em!important;
        padding-right: 1em!important;
        height: 40px;
        font-size: 14px;
        font-weight: 400;
        font-family: 'Roboto', sans-serif;
        border-radius: 500rem;
    }
    .sign_form .header{
        margin-bottom: 50px;
    }
    .ui.checkbox input.hidden+label {
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .ui.checkbox.mncheck .box, .ui.checkbox.mncheck label {
        font-family: 'Roboto', sans-serif !important;
        color: #333;
        line-height: 20px;
    }
    .ui.checkbox.mncheck .box:before, .ui.checkbox.mncheck label:before {
        border-radius: 100%;
        width: 18px !important;
        height: 18px !important;
        margin-top: 1px;
    }
    .ui.checkbox .box:before, .ui.checkbox label:before {
        position: absolute;
        top: 0;
        left: 0;
        width: 17px;
        height: 17px;
        content: '';
        background: #fff;
        border-radius: .21428571rem;
        -webkit-transition: border .1s ease,opacity .1s ease,-webkit-transform .1s ease,-webkit-box-shadow .1s ease;
        transition: border .1s ease,opacity .1s ease,-webkit-transform .1s ease,-webkit-box-shadow .1s ease;
        transition: border .1s ease,opacity .1s ease,transform .1s ease,box-shadow .1s ease;
        transition: border .1s ease,opacity .1s ease,transform .1s ease,box-shadow .1s ease,-webkit-transform .1s ease,-webkit-box-shadow .1s ease;
        border: 1px solid #d4d4d5;
    }
    .ui.checkbox .box, .ui.checkbox label {
        cursor: auto;
        position: relative;
        display: block;
        padding-left: 1.85714em;
        outline: 0;
        font-size: 1em;
    }
    .ui.icon.input>i.icon:not(.link) {
        pointer-events: none;
    }
    .ui.input {
        position: relative;
        font-weight: 400;
        font-style: normal;
        color: rgba(0,0,0,.87);
    }
    .ui[class*="left icon"].input>i.icon {
        right: auto;
        left: 1px;
        border-radius: .28571429rem 0 0 .28571429rem;
    }
    .ui.icon.input>i.icon {
        cursor: default;
        position: absolute;
        line-height: 1;
        text-align: center;
        top: 12px;
        right: 0px;
        left: 10px;
        height: 100%;
        width: 2.67142857em;
        opacity: .5;
        border-radius: 0 .28571429rem .28571429rem 0;
        -webkit-transition: opacity .3s ease;
        transition: opacity .3s ease;
    }
</style>

<!------ Include the above in your HEAD tag ---------->
<section class="login-block sign_in_up_bg">
    <div class="container">
        <div class="row justify-content-lg-center justify-content-md-center">
            <div class="col-lg-6 col-md-8 login-sec">
                <div class="sign_form">
                    <div class="header">
                        <h2 class="text-center">Đăng nhập</h2>
                        <p>Log In to Your Account!</p>
                        <div class="mess" style="color: red"></div>
                    </div>
                    <form id="frmlogin" class="login-form" method="post" action="">
                        <div class="form-group ui left icon input">
                            <input type="text" name="txtuser" id="txt_email" class="form-control" required placeholder="Username">
                            <i class="fa fa-address-book icon uil" aria-hidden="true"></i>
                        </div>
                        <div class="form-group ui left icon input">
                            <input type="password" name="txtpass" id="txt_pass" class="form-control" required placeholder="Password">
                            <i class="fa fa-key icon uil" aria-hidden="true"></i>
                        </div>
                        <div class="ui form mt-30 checkbox_sign">
                            <div class="inline field">
                                <div class="ui checkbox mncheck">
                                    <input type="checkbox" name="" id="remember" tabindex="0" class="hidden">
                                    <label>Remember Me</label>
                                </div>
                            </div>
                        </div>
                        <button type="button" id='btn_login' class="btn login-btn">Đăng nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        function login(){
            var checked=$('#remember').is(':checked')?"yes":"no";
            var _url='<?php echo ROOTHOST;?>ajaxs/user/login.php';
            var _data={'user':$('#txt_email').val(),'pass':$('#txt_pass').val(),'remember':checked}
            $.post(_url,_data,function(req){
                if(req=='success') window.location.reload();
                else $('.mess').html(req);
            })
        }
        $('#txt_pass,#txt_email').keyup(function(e){
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code==13) {
                e.preventDefault();
                if($('#txt_email').val()!='' && $('#txt_pass').val()!=''){
                    login();
                }else{
                    $('.mess').html('Username or password is empty!');
                }
            }
        })
        $('#btn_login').click(function(){
            if($('#txt_email').val()!='' && $('#txt_pass').val()!=''){
                login();
            }else{
                $('.mess').html('Username or password is empty!');
            }
        })
    });
</script>
