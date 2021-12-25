<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
	
	echo $this->session->userdata('user_email_id') . "=EMAIL";
	die;
    if (!empty($this->session->userdata('user_email_id'))) {
        //$this->load->view('template/common_header_admin.php');
    } else {
        $this->session->sess_destroy();
        $this->load->helper('url');
        redirect(base_url('posts/index'));
    }
    ?>
<?php $this->load->view('template/admin_header.php');  //includes header for admin?>
        
        <link href="<?php echo base_url(); ?>Resources/css/jquery-ui.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>Resources/js/jquery-ui.js" nonce="2726c7f26c"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>Resources/js/jquery.validate.min.js" nonce="2726c7f26c"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>Resources/js/validate-methods.min.js" nonce="2726c7f26c"></script>
        <!-- end -->
        <style>
            .error{color: #ff0000;font-size: 11.5px !important;line-height: 2;margin-bottom: 0;}
        </style>
        <script nonce="2726c7f26c">
//Add more field
            $(document).ready(function () {
                var max_fields_limit = 10; //set limit for maximum input fields
                var x = 1; //initialize counter for text box
                $('.add_more_button').click(function (e) { //click event on add more fields button having class add_more_button
                    e.preventDefault();
                    if (x < max_fields_limit) { //check conditions
                        x++; //counter increment
                        $('.input_fields_container').append('<div><input type="text" name="post_ref_url[]" class="form-control ir-form"/><a href="#" class="btn btn-sm btn-danger ir-btn remove-btn"><i class="fa fa-minus-circle" aria-hidden="true"></i></a></div>'); //add input field
                    }
                });
                $('.input_fields_container').on("click", ".btn-danger", function (e) { //user click on remove text links
                    e.preventDefault();
                    $(this).parent('div').remove();
                    x--;
                })
                $(document).on("click", ".headline-check", function (e) {
                    var checked = $(this).find("input:checkbox").is(":checked");
                    if (checked) {
                        $('#end_date_div').css('display', 'block');
                        $('#headline_flag_hiddenvalue').val('1');
                    } else {
                        $('#end_date_div').css('display', 'none');
                        $('#headline_flag_hiddenvalue').val('0');
                    }
                });
                $(function () {
                    $("#post_end_date").datepicker();
                });
                $("#affected_platforms").change(function () {
                    if (this.value == 'Other') {
                        $('#aff_plat_other_div').css('display', 'block');
                    } else {
                        $('#aff_plat_other_div').css('display', 'none');
                    }
                });
                $("#dist_method").change(function () {
                    if (this.value == 'Other') {
                        $('#dist_method_other_div').css('display', 'block');
                    } else {
                        $('#dist_method_other_div').css('display', 'none');
                    }
                });
                $("#attack_type").change(function () {
                    if (this.value == 'Other') {
                        $('#attack_type_other_div').css('display', 'block');
                    } else {
                        $('#attack_type_other_div').css('display', 'none');
                    }
                });
                $("#attack_source").change(function () {
                    if (this.value == 'Other') {
                        $('#attack_source_other_div').css('display', 'block');
                    } else {
                        $('#attack_source_other_div').css('display', 'none');
                    }
                });
                $("#region").change(function () {
                    if (this.value == 'Others') {
                        $('#region_other_div').css('display', 'block');
                    } else {
                        $('#region_other_div').css('display', 'none');
                    }
                });
                $("#business_type").change(function () {
                    if (this.value == 'Others') {
                        $('#busi_type_other_div').css('display', 'block');
                    } else {
                        $('#busi_type_other_div').css('display', 'none');
                    }
                });
                $("#create_post").validate({
                    rules: {
                        post_title: {
                            required: true,
                        },
                        post_desc: {
                            required: true,
                        },
                        post_image: {
                            required: true,
                            extension: "jpg|jpeg",
                            file_name:true
                        },
						ioc: {
                            required: false,
                            extension: "xlsx|XLSX"
                        },
                        post_end_date: {
                            required: true,
                        },
                        aff_plat_other: {
                            required: true,
                        },
                        dist_method_other: {
                            required: true,
                        },
                        attack_type_other: {
                            required: true,
                        },
                        attack_source_other: {
                            required: true,
                        },
                        region_other: {
                            required: true,
                        },
                        busi_other: {
                            required: true,
                        },
//                        "post_ref_url[]": {
//                            required: true,
//                        },
//                        post_recomd: {
//                            required: true,
//                        },
//                        post_end_date: {
//                            required: true,
//                        },
                    },
                    messages: {
                        post_title: {
                            required: "Please enter post title.",
                        },
                        post_desc: {
                            required: "Please enter post description."
                        },
						 post_image: {
                            required: "Please select post image.",
                            extension: "Please select only jpg and jpeg file format.",
                        },
						ioc: {
                            extension: "Please select only xlsx file format.",
                        },
                        post_end_date: {
                            required: "Please select post end date.",
                        },
                        aff_plat_other: {
                            required: "Please enter other value affcted platform."
                        },
                        dist_method_other: {
                            required: "Please enter other value distrubution method."
                        },
                        attack_type_other: {
                            required: "Please enter other value attack type."
                        },
                        attack_source_other: {
                            required: "Please enter other value attack source."
                        },
                        region_other: {
                            required: "Please enter other value region."
                        },
                        busi_other: {
                            required: "Please enter other value business type."
                        },
//                        "post_ref_url[]": {
//                            required: "Please enter post referenace url.",
//                        },
//                        post_recomd: {
//                            required: "Please enter post recommendation."
//                        },
//                        post_end_date: {
//                            required: "Please select post end date."
//                        }
                    }
                });

                //validate file extension custom  method.
                //updated
                $.validator.addMethod("extension", function (value, element, param) {
                    param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
                    return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
                //updated
                }, "Please enter a value with a valid extension.");
                /**
                 * @Author:santhosh
                 * file name validation function
                 */
                $.validator.addMethod("file_name", function (value,element) {
                    if(value.search(/[!@#$%^&*()\_=+{};:,<>Â§~]/)>0)
                {
                 return false;
                }
                else
                {
                 return true;
                }
                }, "Upload the file without special characters.");
                /*end*/
            });
        </script>
        <style nonce="2726c7f26c">
            .headline-check{text-align:left;display: inline-block;}
            .headline-check .cust-check{padding-left: 22px;}
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
                            </div>
                            <h4 class="card-title float-left">Create Post</h4>
                            <br>
                            <form id="create_post" name="create_post" method="POST"  action="<?php echo base_url(); ?>AddPost"  enctype="multipart/form-data" class="my-form">
                                <div class="row">
                                    <div class="col-md-10 m-auto create-input-box create-input-box-edituser">
                                        <div class="form-group">
                                            <label for="post_title">Post Title<span class="error">*</span>:</label>
                                            <input type="text" class="form-control" id="post_title" name="post_title"   placeholder="Enter Title" autocomplete="off" value="<?php echo $this->session->userdata('post_title');?>" >
                                        </div>
                                        <div class="form-group">
                                            <label for="post_desc">Post Description<span class="error">*</span>:</label>
                                            <textarea class="form-control" id="post_desc" name="post_desc" placeholder="Post Description"><?php echo $this->session->userdata('post_desc');?></textarea>
                                        </div>
                                        <div class="form-group mb-30">
                                            <label for="">CVE-IDs:</label>
                                            <textarea class="form-control" id="cve_id" name="cve_id"  autocomplete="off" value="" placeholder="Enter CVE-ID"><?php echo $this->session->userdata('cve_id');?></textarea>
                                        </div>
                                        <div class="form-group">
										    <?php if ($this->session->flashdata('error_post_img') != '') { ?>
												<div class="alert alert-danger" role="alert" style="height:50px;border-style: solid;
													border-color: red; font-size: 12px; line-height: 2;"><?php echo $this->session->flashdata('error_post_img'); ?></div>
												<script nonce="2726c7f26c">
													$(".alert-danger").fadeOut(5000);
												</script>
											<?php } ?>
                                            <label for="" class="control-label">POST Image<span class="error">*</span>:</label><br />
											<input type="file" id="post_image" name="post_image" style="color:#000000 !important;"> <br />
											<br />
											<label style="color: #A70E84; font-size: 12px; line-height: 2; margin-bottom: 0;">
											{ Recommended size for image: 600 x 400 (width and height respectively), and will be less than 5 MB<br />
											Supporting image format will be (jpg,  jpeg,  JPG,  JPEG) }
											</label>
                                        </div>
										
                                        <div class="form-group mtop-20">
											<?php if ($this->session->flashdata('error_ioc_file') != '') { ?>
												<div class="alert alert-danger" role="alert" 
													style="border-style: solid !important;
													border-color: red !important; font-size: 12px; line-height: 2;">
													<?php echo $this->session->flashdata('error_ioc_file'); ?>
												</div>
												<script nonce="2726c7f26c">
													$(".alert-danger").fadeOut(13000);
												</script>
												
											<?php } ?>
                                            <label for="" class="control-label">IOC:</label><br />
                                            <input type="file" id="ioc" name="ioc">
											<br />
											<label style="color: #A70E84; font-size: 11.5px; line-height: 2; margin-bottom: 0;">
											{Supporting File format will be (xlsx) and will be less than 5 MB size}
											</label>
											
                                        </div>
                                        <div class="form-group mtop-20">
                                            <div class="input_fields_container ">
                                                <label for="post_ref_url">Post Reference URL:</label>
                                                <input type="text" name="post_ref_url[]" class="form-control ia-form" autocomplete="off">

                                                <button class="btn btn-sm btn-success ia-btn add_more_button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
										
                                        <div class="form-group">
                                            <label for="post_recomd">Post Recommendation:</label>
                                            <textarea class="form-control" id="post_recomd"  name="post_recomd" placeholder="Post Recommendation"><?php echo $this->session->userdata('cve_id');?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <span class="checkmark"></span> Post Headline:
                                            <div class="headline-check">
                                                <label class="cust-check">
                                                    <input type="checkbox" class="set" name="headline_flag" id="headline_flag" checked>
                                                    <input type="hidden"  name="headline_flag_hiddenvalue" id="headline_flag_hiddenvalue">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group"  id="end_date_div" >
                                            <label for="post_end_date">Post Headline End Date<span class="error">*</span>:</label>
                                            <input type="text" class="form-control" id="post_end_date" name="post_end_date" placeholder="Post Headline End Date" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="affected_platforms">Affected Platform(s) / Version(s):</label>
                                            <select class="form-control custom-select" name="affected_platforms" id="affected_platforms">
                                                <option value="" disabled="disabled" selected="">--Select--</option>
                                                <?php
                                                $affectedPlatform = $this->config->item('affectedPlatform');
                                                foreach ($affectedPlatform as $value) {
                                                    ?>
                                                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group" id="aff_plat_other_div" style="display:none;">
                                            <input type="text" class="form-control" id="aff_plat_other" name="aff_plat_other"  placeholder="Enter Value" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="dist_method">Distribution Method:</label>                                               
                                            <select class="form-control custom-select" name="dist_method" id="dist_method">
                                                <option value="" disabled="disabled" selected="">--Select--</option>
                                                <?php
                                                $distributionMethod = $this->config->item('distributionMethod');
                                                foreach ($distributionMethod as $value) {
                                                    ?>
                                                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group" id="dist_method_other_div" style="display:none;">
                                            <input type="text" class="form-control" id="dist_method_other" name="dist_method_other"  placeholder="Enter Value" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="attack_type">Attack Type:</label>
                                            <select class="form-control custom-select" name="attack_type" id="attack_type">
                                                <option value="" disabled="disabled" selected="">--Select--</option>
                                                <?php
                                                $attackType = $this->config->item('attackType');
                                                foreach ($attackType as $value) {
                                                    ?>
                                                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group" id="attack_type_other_div" style="display:none;">
                                            <input type="text" class="form-control" id="attack_type_other" name="attack_type_other"  placeholder="Enter Value" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="attack_source">Attack Source:</label>
                                            <select class="form-control custom-select" name="attack_source" id="attack_source">
                                                <option value="" disabled="disabled" selected="">--Select--</option>
                                                <?php
                                                $attackSource = $this->config->item('attackSource');
                                                foreach ($attackSource as $value) {
                                                    ?>
                                                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group" id="attack_source_other_div" style="display:none;">
                                            <input type="text" class="form-control" id="attack_source_other" name="attack_source_other"  placeholder="Enter Value" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="region">Region:</label>
                                            <select class="form-control custom-select" name="region" id="region">
                                                <option value="" disabled="disabled" selected="">--Select--</option>
                                                <?php
                                                $region = $this->config->item('region');
                                                foreach ($region as $value) {
                                                    ?>
                                                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div> 
                                        <div class="form-group" id="region_other_div" style="display:none;">
                                            <input type="text" class="form-control" id="region_other" name="region_other"  placeholder="Enter Value" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="business_type">Affected Business(s):</label>
                                            <select class="form-control custom-select" name="business_type" id="business_type">
                                                <option value="" disabled="disabled" selected="">--Select--</option>
                                                <?php
                                                $businessType = $this->config->item('businessType');
                                                foreach ($businessType as $value) {
                                                    ?>
                                                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div> 
                                        <div class="form-group" id="busi_type_other_div" style="display:none;">
                                            <input type="text" class="form-control" id="busi_other" name="busi_other"  placeholder="Enter Value" autocomplete="off">
                                        </div>
                                        <input type="hidden" name="token_id" value="<?php echo $this->session->userdata('csrf_unq_token'); ?>" >
                                        <div class="form-group text-center">
                                            <button type="submit" name="save1" value="save" class="btn btn-primary">Save Post</button>
                                            <button type="submit" name="publish1" value="publish" class="btn btn-primary">Publish Post</button>
                                        </div>
                                    </div>
                                </div>

                            </form>
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
