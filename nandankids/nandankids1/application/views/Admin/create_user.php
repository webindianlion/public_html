
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
        <script type="text/javascript" src="<?php echo base_url(); ?>Resources/js/jquery.validate.min.js" nonce="2726c7f26c"></script>        
        <script type="text/javascript" src="<?php echo base_url(); ?>Resources/js/validate-methods.min.js" nonce="2726c7f26c"></script>
        <script nonce="2726c7f26c">
            
			$(document).ready(function () {
                managePostTable = $("#manageUserTable").DataTable({
                    "ajax": BASE_URL + 'GetAllUser',
                    "order": []
                });
            });
			
			/*var BASE_URL = "<?php echo base_url(); ?>";
            var manageUserTable;
            $(document).ready(function () {
                manageUserTable = $("#manageUserTable").DataTable({
                    "ajax": BASE_URL + 'GetAllUser',
                    "order": []
                });
                 $("#manageUserTable").dataTable().fnDestroy();
            });*/

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
                                <?php
                                if ($this->session->flashdata('validaion_error')) {
                                    foreach ($this->session->flashdata('validaion_error') as $error) {
                                        if ($error != "") {
                                            ?>
                                            <div class="alert alert-danger" role="alert" style="height:50px;"><?php
                                                if ($error != "") {
                                                    print_r($error);
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <script nonce="2726c7f26c">
                                            $(".alert-danger").fadeOut(5000);
                                        </script>

                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <h4 class="card-title float-left">Create User</h4>                           
                            <?php //echo validation_errors(); ?>
                            <br>
                            <div class="row">
                                <div class="col-md-12 pad0">
                                    <form id="create_user" name="create_user" method="POST"  action="<?php echo base_url(); ?>Admin/UserController/create_user"  enctype="multipart/form-data" class="my-form create-input-box" autocomplete="off">
                                        <div class="row">
											<?php if ($this->session->flashdata('error_duplicate') != '') { ?>
												<div class="alert alert-danger" role="alert" style="height:50px;border-style: solid;
													border-color: red; font-size: 13px; line-height: 2;"><?php echo $this->session->flashdata('error_duplicate'); ?></div>
												<script nonce="2726c7f26c">
													$(".alert-danger").fadeOut(5000);
												</script>
											<?php } ?>
											
                                            <div class="col-md-12 pad0">
                                                <div class="form-group">
                                                    <label for="email">Email Id<span class="error">*</span>:</label>
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" autocomplete="off" >

                                                    <?php
//                                                    if ($this->session->flashdata('validaion_error')) {
//                                                        foreach ($this->session->flashdata('validaion_error') as $error) {
//                                                            print_r($error);
//                                                        }
//                                                    }
                                                    ?>
                                                    <?php // echo form_error('email');   ?>
                                                </div>
                                                <div class="form-group">
                                                    <label for="role_name">Role Name<span class="error">*</span>:</label>
                                                    <select class="form-control custom-select" name="role_name" id="role_name">
                                                        <option value="" disabled="disabled" selected="">Select Role</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="Client User">Client User</option>
                                                    </select>
                                                    <?php //echo form_error('role_name');    ?>
                                                </div>
                                                <div class="form-group" id="Password_div" style="display:none;">
                                                    <label for="password">Password<span class="error">*</span>:</label>
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" autocomplete="off">
                                                    <span toggle="#password-field" class="fa fa-lg fa-eye field-icon toggle-password"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status">Status:</label>
                                                    <select class="form-control custom-select" name="status" id="status">
                                                        <option value="active" selected="">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>

                                                <input type="hidden" name="token_id" value="<?php echo $this->session->userdata('csrf_unq_token'); ?>" >

                                                <div class="form-group width100 text-center">
                                                    <button type="submit" class="btn btn-primary">Save User</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive m-t-40">
                                <table id="manageUserTable" class="table table-bordered table-striped">
                                    <thead class="bg-inverse text-white">
                                        <tr>
                                            <th class="s-number">S.NO.</th>                                               
                                            <th>Email Id</th>
                                            <th>Role Name</th>
                                            <th>Status</th>                                               
                                            <th class="act-btns">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            <!--</table>-->
        </div>
        <script nonce="2726c7f26c">
            var BASE_URL = "<?php echo base_url(); ?>";
            $(document).ready(function () {
                $('#role_name').on('change', function () {
                    if ($(this).val() == 'Admin') {
                        $('#Password_div').css('display', 'block');
                    } else {
                        $('#Password_div').css('display', 'none');
                    }
                });
                $("#create_user").validate({
                    rules: {
                        email: {
                            required: true,
                            email: true,
                            CheckEmailExist: true,
                        },
                        role_name: {
                            required: true,
                        },
                        password: {
                            required: true,
                            notEqualTo: '#email',
                            minlength: 8,
                            CheckStrongPasswordExist: true
                        },
                        status: {
                            required: true,
                        }
                    },
                    messages: {
                        email: {
                            required: "Please enter email.",
                            email: "Please enter valid email address.",
                            CheckEmailExist: "Email Id already exists.",
                        },
                        role_name: {
                            required: "Please select role name."
                        },
                        password: {
                            required: "Please enter Password.",
                            notEqualTo: "Password should not same as email id.",
                            minlength: "Password leghth minimum should 8 character.",
                            CheckStrongPasswordExist: "Password must contain at least 8 characters, including UPPER/lowercase,numbers and special character!"
                        },
                        status: {
                            required: "Please Select user status."
                        },
                    }
                });
                $.validator.addMethod("CheckEmailExist", function (value, element) {
                    var temp = $.ajax({
                        type: "POST",
                        url: BASE_URL + "CheckEmailExist",
                        async: false,
                        data: {email: $("#email").val()},
                        dataType: 'html',
                        'async': false,
                        success: function (data) {

                        }
                    });
                    return temp.responseText;
                }, "");

                $.validator.addMethod("CheckStrongPasswordExist", function (value, element) {
                    return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
                            && /[a-z]/.test(value) // has a lowercase letter
                            && /\d/.test(value) // has a digit
                            && /[A-Z]/.test(value) // has a upper case
                            && /[$@$!%*#?&]/.test(value) // has a special characters
//                             && /\w{8}/.test(value)  // has a leght
                }, "");
            })
        </script>
		
		<!-- START Bootstrap-Cookie-Alert -->
			<?php $this->load->view('template/admin_footer.php'); ?>
        <!-- ***** Footer Area End ***** -->
    </body>
</html>
