
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
        <link rel="stylesheet" href="<?php echo base_url(); ?>Resources/js/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>Resources/css/jquery.dataTables.min.css">
        <script nonce="2726c7f26c">
            var BASE_URL = "<?php echo base_url(); ?>";
            var managePostTable;
            //function removePost(post_id) {
                 $(document).on('click', '.removePost', function(){
                    var post_id=$(this).attr("id");
                if (post_id) {
                    // click on remove button
                    $("#removeBtn").unbind('click').bind('click', function () {
                        $.ajax({
                            url: BASE_URL + 'DeletePost',
                            type: 'post',
                            data: {post_id: post_id},
                            dataType: 'json',
                            success: function (response) {
                                if (response.success == true) {
                                    $(".Messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                                            '</div>');
                                    // refresh the table
                                    managePostTable.ajax.reload(null, false);
                                    // close the modal
                                    $("#deletePosttModal").modal('hide');
                                    setTimeout(function () {
                                        $('.Messages').empty();
                                    }, 2000);
                                } else {
                                    $(".Messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                            '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                                            '</div>');
                                     $("#deletePosttModal").modal('hide');
                                    setTimeout(function () {
                                        $('.Messages').empty();
                                    }, 2000);
                                }
                            }
                        });
                    }); // click remove btn
                }
            })
            $(document).ready(function () {
                managePostTable = $("#managePostTable").DataTable({
                    "ajax": BASE_URL + 'GetAllPost',
                    "order": []
                });
            });
        </script>
        
        <div class="page-wrapper">
            <!--code for header admin section -->
            <section>				
                <a href="<?php echo base_url() . 'posts/index'; ?>"> </a>
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
							<h4 class="card-title float-left">Manage Post</h4> 
                            <br>
                            <div class="table-responsive m-t-40">
                                <table id="managePostTable" class="table table-bordered table-striped">
                                    <thead class="bg-inverse text-white">
                                        <tr>
                                            <th class="ctab1">S.NO.</th>
                                            <th class="ctab2">Post Title</th>
                                            <th class="ctab3">Affected Platforms</th>
                                            <th class="ctab4">Attack Type</th>
                                            <th class="ctab5">Business Type</th>                                               
                                            <th class="ctab6">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>           
            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog" id="deletePosttModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><span class="glyphicon glyphicon-trash"></span> Delete Post</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>Do you really want to delete this post?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn inner-btn1" data-dismiss="modal">No</button>   
                        <button type="submit" class="btn inner-btn" id="removeBtn">Yes</button>
                    </div>
                    <!--</form>-->
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
		
		<!-- START Bootstrap-Cookie-Alert -->
		<?php $this->load->view('template/admin_footer.php'); ?>
        <!-- ***** Footer Area End ***** -->
</body>
</html>

