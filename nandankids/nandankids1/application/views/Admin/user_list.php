
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
    
        <script src="<?php echo base_url(); ?>Resources/js/jquery.dataTables.min.js" nonce="2726c7f26c"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>Resources/css/jquery.dataTables.min.css">
        <script nonce="2726c7f26c">
            var BASE_URL = "<?php echo base_url(); ?>";
            var manageUserTable;
            $(document).ready(function () {
                manageUserTable = $("#manageUserTable").DataTable({
                    "ajax": BASE_URL + 'GetAllUser',
                    "order": []
                });
            });
        </script>
        
        <div class="page-wrapper">
            <!--code for header admin section -->
            <section>				
                <a href="<?php echo base_url() . 'posts/index'; ?>"></a>
            </section>
			<hr style="border: 1px solid black;"><br />
            <div class="container-fluid">				

                <div class="col-12 col-md-11 m-auto section-padding-20-50 pad0">
                    <div class="card">
                        <div class="card-body">
                            <div class="Messages">
                                <?php if ($this->session->flashdata('success') != '') { ?>
                                    <div class="alert alert-success" role="alert" style="height:50px;"><?php echo $this->session->flashdata('success'); ?></div>
                                    <script nonce="2726c7f26c">
                                        $(".alert-success").fadeOut(10000);
                                    </script>
                                <?php } ?>
                                <?php if ($this->session->flashdata('error') != '') { ?>
                                    <div class="alert alert-danger" role="alert" style="height:50px;"><?php echo $this->session->flashdata('error'); ?></div>
                                    <script nonce="2726c7f26c">
                                        $(".alert-danger").fadeOut(10000);
                                    </script>
                                <?php } ?>
                            </div>
                            <!--<a href="<?php echo base_url(); ?>Admin/UserController/create">Create User</a>-->
                            <div class="table-responsive m-t-40">
                                <table id="manageUserTable" class="table table-bordered table-striped">
                                    <thead class="bg-inverse text-white">
                                        <tr>
                                            <th>S.NO.</th>                                               
                                            <th>Email Id</th>
                                            <th>Role Name</th>
                                            <th>Status</th>                                               
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </table>
    </div>		
</div>

<!-- START Bootstrap-Cookie-Alert -->
<?php $this->load->view('template/admin_footer.php'); ?>
<!-- ***** Footer Area End ***** -->
</body>
</html>
