
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Community - Control Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
          <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg" style="background: #596dff !important">
        <div class="account-pages my-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6" style="text-align: center;margin-top: 100px;">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-md-12" style="padding:50px;">
                                        <div class="mx-auto mb-5">
                                           <h4>
                                               Community JobaajLearnings
                                           </h4>
                                        </div>


                                        <form action="#" class="authentication-form">
                                            <div class="form-group">
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="icon-dual" data-feather="mail"></i>
                                                        </span>
                                                    </div>
                                                    <input type="email" class="form-control"  id="txt_uname" placeholder="Enter Username">
                                                </div>
                                            </div>

                                            <div class="form-group mt-4">
                                              
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="icon-dual" data-feather="lock"></i>
                                                        </span>
                                                    </div>
                                                    <input id="txt_pwd" type="password" class="form-control" 
                                                        placeholder="Enter password">
                                                </div>
                                            </div>

                                            <div class="form-group mb-0 text-center">
                                                <button type="button" id="but_submit" class="btn btn-primary btn-block"> Log In
                                                </button>
                                            </div>
<br>
					<p class="login-box-msg" id="message"></p>



                                        </form>
                                      
                                    </div>
                                  
                                </div>
                                
                            </div> <!-- end card-body -->
                        </div>


                        <!-- end card -->

                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
    </body>
</html>


<script type="text/javascript">
	
	$("#txt_pwd").keypress(function(event) { 
            if (event.keyCode === 13) { 
                $("#but_submit").click(); 
            } 
        }); 


	
	$(document).ready(function(){
    $("#but_submit").click(function(){
                   
     $('#message').removeClass('ahashakeheartache');

        var username = $("#txt_uname").val().trim();
        var password = $("#txt_pwd").val().trim();

        if(username != "" && password != "" ){
            $.ajax({
                url:'fun/user_login.php',
                type:'post',
                dataType: 'json',
                data:{username:username,password:password},
                success:function(res){
                    var msg = "";
                    
                    if(res['0'] == 201){
                       
                        if(res['1']==1) 
                         window.location = "dashboard";
                         else 
                         window.location = "add-blog";
                        
                    }
                    else if(res['0'] == 400){
                         msg = "Status Inactive! Contact your Manager.";
                         
                    }
                    else{
                        msg = "Invalid username and password!";
                    }
                    $("#message").css('color','#e91e63');
                    $("#message").css('font-weight','600');
                    $("#message").css('font-size','18px');
                    $("#message").css('color','red');
                     $('#message').addClass('ahashakeheartache');
                    $("#message").html(msg);
                }
            });
        }
    });
});



</script>

<style type="text/css">
	.ahashakeheartache {
			-webkit-animation: kf_shake 0.4s 1 linear;
			-moz-animation: kf_shake 0.4s 1 linear;
			-o-animation: kf_shake 0.4s 1 linear;
		}
		@-webkit-keyframes kf_shake {
			0% { -webkit-transform: translate(30px); }
			20% { -webkit-transform: translate(-30px); }
			40% { -webkit-transform: translate(15px); }
			60% { -webkit-transform: translate(-15px); }
			80% { -webkit-transform: translate(8px); }
			100% { -webkit-transform: translate(0px); }
		}
		@-moz-keyframes kf_shake {
			0% { -moz-transform: translate(30px); }
			20% { -moz-transform: translate(-30px); }
			40% { -moz-transform: translate(15px); }
			60% { -moz-transform: translate(-15px); }
			80% { -moz-transform: translate(8px); }
			100% { -moz-transform: translate(0px); }
		}
		@-o-keyframes kf_shake {
			0% { -o-transform: translate(30px); }
			20% { -o-transform: translate(-30px); }
			40% { -o-transform: translate(15px); }
			60% { -o-transform: translate(-15px); }
			80% { -o-transform: translate(8px); }
			100% { -o-origin-transform: translate(0px); }
		}
</style>