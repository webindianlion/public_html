
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!empty($this->session->userdata('user_email_id'))) {
    //$this->load->view('template/common_header_admin.php');
} else {
    $this->session->sess_destroy();
    $this->load->helper('url');
    redirect(base_url('posts/index'));
}
?>
 <?php $this->load->view('template/admin_header.php');  //includes header for admin?>    
        <link rel="stylesheet" href="<?php echo base_url(); ?>Resources/css/jquery.dataTables.min.css">
        <script src="<?php echo base_url(); ?>Resources/js/jquery.dataTables.min.js" nonce="2726c7f26c"></script>
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>Resources/js/jquery.validate.min.js"></script>        
        <script type="text/javascript" src="<?php echo base_url(); ?>Resources/js/validate-methods.min.js"></script>-->
		
		<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.min.js" nonce="2726c7f26c"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/validation/change_password.js" nonce="2726c7f26c"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>custom/js/change_password.js" nonce="2726c7f26c"></script>
		
        <script nonce="2726c7f26c">
            var BASE_URL = "<?php echo base_url(); ?>";
            var manageUserTable;
            $(document).ready(function () {
                manageUserTable = $("#manageUserTable").DataTable({
                    "ajax": BASE_URL + 'GetAllUser',
                    "order": []
                });
                 $("#manageUserTable").dataTable().fnDestroy();
            });

            $("body").on('click', '.toggle-password', function () {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $("#password");
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }

            });
        </script>
        <style>
            .error{color: #ff0000;font-size: 11.5px !important;line-height: 2;margin-bottom: 0;}
            .container{
                margin: auto;
            }
        </style>

        
        <div class="page-wrapper">
            <!--code for header admin section -->
            <section>				
                <a href="<?php echo base_url() . 'posts/index'; ?>">                    
                </a>
            </section>
            <hr style="border: 1px solid black;"><br />
            <div class="container-fluid">
                <div class="col-12 col-md-11 m-auto section-padding-20-50 pad0">
                    <div class="card">
                        <div class="card-body create_form">
						
                            <div class="Messages">
								<?php
									if ($this->session->flashdata('success_forgotpassword') != '') { ?>
										<div class="alert alert-success" role="alert" style="height:50px; width:100%; text-align:center;">		<?php echo $this->session->flashdata('success_forgotpassword'); ?>
										</div>
										<script nonce="2726c7f26c">
											$(".alert-success").fadeOut(7000);
										</script>
										<?php 
									}
									?>
									<?php if ($this->session->flashdata('success') != '') { ?>
                                    <div class="alert alert-success" role="alert" style="height:50px;"><?php echo $this->session->flashdata('success'); ?></div>
                                    <script nonce="2726c7f26c">
                                        $(".alert-success").fadeOut(5000);
                                    </script>
                                <?php } ?>
                                <?php if ($this->session->flashdata('error') != '') { ?>
                                    <div class="alert alert-danger" role="alert" style="height:50px;"><?php echo $this->session->flashdata('error'); ?></div>
                                    <script nonce="2726c7f26c">
                                        $(".alert-danger").fadeOut(5000);
                                    </script>
                                <?php } ?>
                            </div>
							<div class="forgotpwd">
								<img src="<?php echo base_url(); ?>img/forgotpwd-icon.png" alt="Cyber Security Intelligence">
								<h3>Reset User Password</h3>					 
							</div>
                            <br>
                        <form class="form-horizontal form-material" id="change_password" name="change_password" method="POST" autocomplete="off">
						<!--@XSS Patch Awanti-->                            
							<div class="col-md-6 m-auto forgotpwd-box">
								<input type="hidden" id="user_id" name="user_id" value="<?php echo html_escape($this->session->userdata('id')); ?>" >
								<div class="form-group">
									<label class="col-md-12" for="email">Old Password:</label>
									<div class="col-md-12">
										<input type="password" name="oldpwd" id="oldpwd" value="" class="form-control form-control-line" placeholder="">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-12" for="email">New Password:</label>
									<div class="col-md-12">
										<input type="password" name="newpwd" id="newpwd" value="" class="form-control form-control-line" placeholder="">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-12" for="email">Re-Enter New Password:</label>
									<div class="col-md-12">
										<input type="password" name="renewpwd" id="renewpwd" value="" class="form-control form-control-line" placeholder="">
									</div>
								</div>
								<div class="form-group text-center">
									<input type="hidden" name="token_id" value="<?php echo $this->session->userdata('csrf_unq_token'); ?>" >
										<button type="submit" class="btn btn-primary forgot-btn" id="Change_pwd" name="Change_pwd">Submit</button>
								</div>
							</div>
                        </form>
                </div>
            </div>        
        </div> 
        </div> 
        </div> 
		<!-- ***** Footer Area Start ***** -->
        <footer class="fancy-footer-area fancy-bg-dark">    
			<div class="footer-copywrite-area">
				<div class="container h-100">
					<div class="row h-100">
						<div class="col-12 h-100">
							<div class="copywrite-content h-100 d-flex align-items-center justify-content-between">
								<!-- Copywrite Text -->
								<div class="copywrite-text">
									<p>
										Copyright
										&copy;<script nonce="2726c7f26c">document.write(new Date().getFullYear());</script> All rights reserved by <a href="www.varutra.com/" target="_blank">Infoshare Varutra </a></p>
									<p class="privacy"><a href="<?php echo base_url() . 'posts/Privacypolicy'; ?>" target="_blank"/>Privacy Policy</a></p>
								</div>
								<!-- Footer Nav -->              
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- ***** Footer Area End ***** -->
		<script src="<?php echo base_url(); ?>js/popper.min.js" nonce="2726c7f26c"></script>
        <script src="<?php echo base_url(); ?>js/waves.js" nonce="2726c7f26c"></script>
        <script src="<?php echo base_url(); ?>js/sidebarmenu.js" nonce="2726c7f26c"></script>
        <script src="<?php echo base_url(); ?>js/sticky-kit.min.js" nonce="2726c7f26c"></script>
        <script src="<?php echo base_url(); ?>js/custom.min.js" nonce="2726c7f26c"></script>
    </body>
</html>