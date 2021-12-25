
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
    
        <link rel="stylesheet" href="<?php echo base_url(); ?>Resources/css/jquery.dataTables.min.css" nonce="2726c7f26c">      
        <script src="<?php echo base_url(); ?>Resources/js/jquery.dataTables.min.js" nonce="2726c7f26c"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>Resources/js/jquery.validate.min.js" nonce="2726c7f26c"></script>            
        <script type="text/javascript" src="<?php echo base_url(); ?>Resources/js/validate-methods.min.js" nonce="2726c7f26c"></script>
        <style>
            .error{color: #ff0000;font-size: 11.5px !important;line-height: 2;margin-bottom: 0;}
            .container{
                margin: auto;
            }
        </style>
        <!-- end -->
        <script nonce="2726c7f26c">
            var BASE_URL = "<?php echo base_url(); ?>";
            var manageUserTable;
            $(document).ready(function () {
				
				$('#role_name').attr('disabled', true);
                manageUserTable = $("#manageUserTable").DataTable({
                    "ajax": BASE_URL + 'GetAllUser',
                    "order": []
                });
                $('#role_name').on('change', function () {
                    if ($(this).val() == 'Admin') {
                        $('#Password_div').css('display', 'block');
                    } else {
                        $('#Password_div').css('display', 'none');
                    }
                });

                $("#update_user").validate({
                    rules: {
                        email: {
                            required: true,
                            email: true,
                        },
//                        password: {
//                            required: true,
//                            notEqualTo: '#email',
//                            minlength: 8,
//                            CheckStrongPasswordExist: true,
//                        },
                        status: {
                            required: true,
                        }
                    },
                    messages: {
                        email: {
                            required: "Please enter email.",
                            email: "Please enter valid email address.",
                        },
//                        password: {
//                            required: "Please enter Password.",
//                            notEqualTo: "Password should not same as email id.",
//                            minlength: "Password leghth minimum should 8 character.",
//                            CheckStrongPasswordExist: "Password must contain at least 8 characters, including UPPER/lowercase,numbers and special character!"
//                        },
                        status: {
                            required: "Please Select user status."
                        },
                    }
                });
                $.validator.addMethod("CheckStrongPasswordExist", function (value, element) {
                    return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
                            && /[a-z]/.test(value) // has a lowercase letter
                            && /\d/.test(value) // has a digit
                            && /[A-Z]/.test(value) // has a upper case
                            && /[$@$!%*#?&]/.test(value) // has a special characters
                }, "");
            })
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
        
        <div class="page-wrapper">
            <!--code for header admin section -->
            <section>				
                <a href="<?php echo base_url() . 'posts/index'; ?>">  </a>
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
                            </div>
                            <h4 class="card-title float-left">Edit User</h4>
                            <br>
                            <div class="row">
                                <div class="col-md-12 pad0">
                                    <form id="update_user" name="update_user" method="POST"  action="<?php echo base_url(); ?>UpdateUser"  enctype="multipart/form-data" class="my-form">
                                        <div class="row">
                                            <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $user_id; ?>"  placeholder="">
                                            <?php
//                                            echo "<pre>";
//                                            
//                                            print_r($user_details);
                                            ?>
                                            <div class="col-md-8 m-auto create-input-box create-input-box-edituser">
                                                <div class="form-group">
                                                    <label for="email">Email Id<span class="error">*</span>:</label>
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" autocomplete="off" value="<?php echo $user_details[0]->email_id; ?>" readonly="true">
                                                </div>

                                                <div class="form-group">
                                                    <label for="role_name">Role Name<span class="error">*</span>:</label>
                                                    <select class="form-control custom-select" name="role_name" id="role_name">
                                                        <option value="" disabled="disabled" >Select Role</option>
                                                        <?php
                                                        if ($user_details[0]->role_name == "Admin") {
                                                            ?>
                                                            <option value="Admin" selected>Admin</option>
                                                            <option value="Client User">Client User</option>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <option value="Admin">Admin</option>
                                                            <option value="Client User" selected>Client User</option>
                                                            <?php
                                                        }
                                                        ?>
<!--                                                        <option value="Admin" <?php if ($user_details[0]->role_name == "Admin") echo 'selected'; ?>>Admin</option>
                                                   <option value="Client User" <?php if ($user_details[0]->role_name == "Client User") echo 'selected'; ?>>Client User</option>-->
                                                    </select>
                                                </div>
                                                <?php
                                                if ($user_details[0]->role_name == "Admin") {
                                                    $class = "display:block;";
                                                } else {
                                                    $class = "display:none;";
                                                }
                                                ?>
                                                <!--password removed by @ROOP -->
<!--                                                <div class="form-group" id="Password_div" style="<?php echo $class; ?>">
                                                    <label for="password">Password<span class="error">*</span>:</label>
                                                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $user_details[0]->password; ?>" autocomplete="off" placeholder="Enter Password">
                                                    <span toggle="#password-field" class="fa fa-lg fa-eye field-icon toggle-password"></span>
                                                </div>-->


                                                <div class="form-group">
                                                    <label for="status">Status:</label>
                                                    <select class="form-control custom-select" name="status" id="status">
                                                        <option value="active" <?php if ($user_details[0]->status == 1) echo 'selected'; ?>>Active</option>
                                                        <option value="inactive" <?php if ($user_details[0]->status == 0) echo 'selected'; ?>>Inactive</option>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="token_id" value="<?php echo $this->session->userdata('csrf_unq_token'); ?>" >

                                                <div class="form-group text-center"> <button type="submit" class="btn btn-primary">Update User</button></div>
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
                </div>
				
				<!-- START Bootstrap-Cookie-Alert -->
				<?php $this->load->view('template/admin_footer.php'); ?>
                <!-- ***** Footer Area End ***** -->
                </body>
                </html>
