<?php

	/* Authenticate Login Users. */
	
	if(empty($this->session->userdata('user_email_id'))){
		
		echo '<p style="width:90%; border: 1px red solid; color:black; margin-left:50px; margin-top:10px;margin-bottom:10px; margin-right:50px; padding:40px;">404 - (access not allowed).</p>';
		die();
	}
	
	//FIRST lavel authentication.
	if(empty($this->session->userdata('updated_sess_id'))){
		echo '<p style="width:90%; border: 1px red solid; color:black; margin-left:50px; margin-top:10px;margin-bottom:10px; margin-right:50px; padding:40px;">404 - (access not allowed).</p>';
			die();
	}
	
	//Second Level as Session Management.
	if(!empty($this->session->userdata('user_email_id')) && !empty($this->session->userdata('updated_sess_id'))){
		
		$this->load->library("common");
		$validate_login_user = '';
		//$cur_session_Id  = session_id();
        $cur_session_Id  = $this->session->userdata('loggedIn_users_session');
		$sess_user_email = $this->session->userdata('user_email_id');
		$validate_login_user  = $this->common->is_session_authorized($sess_user_email, $cur_session_Id);
				
		//validate login member is it belonging to Admin Role only.
		$login_user_roles     = $this->common->login_member_user_roles();
		
		if(!empty($login_user_roles->role_name) && (strtolower($login_user_roles->role_name) !='admin')){
			echo '<p style="width:90%; border: 1px red solid; color:black; margin-left:50px; margin-top:10px;margin-bottom:10px; margin-right:50px; padding:40px;">404 - (access not allowed).</p>';
			die();
		}
		
		if($validate_login_user == 0){
			
			//this condition validates that both sessions are same or not
			$this->common->delete_user_session($this->session->userdata('user_email_id'));
			$this->session->sess_destroy();
			$this->load->helper('url');
			redirect(base_url('posts/index'));
		}
	}
	
		/* Authenticate Logn Users. */
	/*	
	if (!empty($this->session->userdata('user_email_id'))) {
		
		$this->db->select('user_id,email_id,role_name');
		$this->db->where('email_id', $this->session->userdata('user_email_id'));
		$this->db->where('status', 1);
		$this->db->where('is_deleted', 0);
		$response = $this->db->get('user');
		$response_main = $response->row();
		
		
		if(!empty($response_main->role_name) && $response_main->role_name !='Admin'){
			echo '<p style="width:90%; border: 1px red solid; color:black; margin-left:50px; margin-top:10px;margin-bottom:10px; margin-right:50px; padding:40px;">404 - (access not allowed).</p>';
			die();
		}
	}
	
	if (empty($this->session->userdata('user_email_id'))) {
		$this->session->sess_destroy();
		$this->load->helper('url');
		redirect(base_url('posts/index'));
	}*/
	
?>
<!DOCTYPE html>
<html lang="zxx">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Title -->
        <title> Cyber Threat Post | Admin Home</title>
		<meta name="description" content="Cyber Threat Post" />
		<meta name="keywords" content="Security Threats, Internet Security, Online Security, Cyber Security Threats, Cyber Attacks, Online Threats, Recent Cyber Attacks, Cyber Threat Intelligence, Cyber Intelligence, Cyber Security Intelligence, Cyber Security News, Top Cyber Security Threats in 2020, Latest Cyber Security News, Cyber Security News Articles, Recent Cyber Attacks in India, Cyber Security Threat Blogs" />
		
		<meta name="author" content="Cyber Threat Post" />
		<meta name="publisher" content="Cyber Threat Post" />
		<meta name="owner" content="Cyber Threat Post" />
		<meta http-equiv="content-language" content="English" />
		<meta name="doc-type" content="Web Page" />
		<meta name="doc-rights" content="Copywritten Work" />
		<meta name="rating" content="All" />
		<meta name="distribution" content="Global" />
		<meta name="document-type" content="Public" />
		
        <!-- Favicon -->		
		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>img/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>img/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>img/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>img/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>img/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>img/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>img/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>img/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>img/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192" href="<?php echo base_url(); ?>img/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>img/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>img/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>img/favicon-16x16.png">
		
        <style type="text/css">

            .dropbtn {cursor: pointer;}
            .dropdown {
                position: relative;
                display: inline-block;
            }
			.dropbtn:before{content: "\f007";position: relative;
    font-family: FontAwesome;
    font-size: 14px;
    color: #e77817;
    padding-right: 6px;
    line-height: 1;
    vertical-align: middle;}
			.dropbtn:after{content: "\f0d7";position:absolute;font-family: FontAwesome;    font-size: 18px;
    color: #e77817;
        padding-left: 8px;
    margin-top: 7px;}
            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f1f1f1;
                min-width: 160px;
                overflow: auto;
                margin-top:30px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                right: 0;
                z-index: 1;
            }

            .dropdown-content a {
                color: black;
                padding: 7px 10px;
                text-decoration: none;
                display: block;
            }

            .dropdown a:hover {background-color: #ddd; color: black;}
            .show {display: block;}

            /* style for view button as hyperlink... */
        </style>
        <!-- Core Stylesheet -->
		<link rel="stylesheet" href="<?php echo base_url() . 'css/animate.css?' . time(); ?>" type="text/css" media="all" />
        <!-- <link rel="stylesheet" href="<?php echo base_url() . 'css/bootstrap.min.css?' . time(); ?>" type="text/css" media="all" /> -->
        <link rel="stylesheet" href="<?php echo base_url() . 'css/style.css?' . time(); ?>" type="text/css" media="all" />
        <link rel="stylesheet" href="<?php echo base_url() . 'css/responsive.css?' . time(); ?>" type="text/css" media="all" />
        <link rel="stylesheet" href="<?php echo base_url() . 'css/custom-thread.css?' . time(); ?>" type="text/css" media="all" />
        <link rel="stylesheet" href="<?php echo base_url() . 'css/font-awesome.min.css' ?>" type="text/css" media="all" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Responsive CSS -->
        <script>
            function searchFilter(page_num) {
                page_num = page_num ? page_num : 0;
                var keywords = $('#keywords').val();
                var sortBy = $('#sortBy').val();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>posts/ajaxPaginationData/' + page_num,
                    data: 'page=' + page_num + '&keywords=' + keywords + '&sortBy=' + sortBy,
                    beforeSend: function () {
                        $('.loading').show();
                        //alert('YESSSSS BEFORE');
                    },
                    success: function (html) {
                        $('#postList').html(html);
                        $('.loading').fadeOut("slow");
                        //alert('YESSSSS AFTER');
                    }
                });
            }
            /* Code related to popup */
        </script>
    </head>
    <body>
        <!-- ***** Header Area Start ***** -->
        <header class="header_area" id="header">
            <div class="container-fluid h-100">
                <div class="row h-100">
                    <div class="col-12 h-100">
                        <nav class="h-100 navbar navbar-expand-lg align-items-center LOGO-Header">
                            <a class="navbar-brand infoshare-logo" href="<?php echo base_url(); ?>">
                                <img src="<?php echo base_url(); ?>img/infoshare-logo.png" alt="Recent Cyber Attacks in India"/>
                            </a>
                            <a class="navbar-brand varutra-logo" href="https://www.varutra.com/" target="_blank"><img src="<?php echo base_url(); ?>img/logo.png" alt="Cyber Security Threats"/></a>
                            <!-- Username and Icon -->
                            <?php if (!empty($this->session->userdata('user_email_id')) && !empty($this->session->userdata('user_password')) && $this->session->userdata('user_password') != 'undefined' && $this->session->userdata('user_email_id') != 'undefined') { ?>				  
                                <div class="nav-area admin-area">						
                                    <h6 class="username">
                                        <a onclick="myFunction()" class="dropbtn">
                                            <?php echo $this->session->userdata('user_email_id'); ?>
                                        </a>
                                    </h6>
                                    <div class="dropdown">
                                        <div id="myDropdown" class="dropdown-content">
                                            <a href="<?php echo base_url() . 'CreateUser'; ?>" class="w3-bar-item w3-button"><span><i class="fa fa-users" aria-hidden="true"></i></span>Manage User
                                            </a>
                                            <a href="<?php echo base_url() . 'CreatePost'; ?>" class="w3-bar-item w3-button"><span><i class="fa fa-plus-circle" aria-hidden="true"></i></span>Add Post
                                            </a>
                                            <a href="<?php echo base_url() . 'ManagePost'; ?>" class="w3-bar-item w3-button"><span><i class="fa fa-pencil-square" aria-hidden="true"></i></span>Edit Post
                                            </a>
                                            <a href="<?php echo base_url() . 'Logout'; ?>/" class="w3-bar-item w3-button"><span><i class="fa fa-sign-out" aria-hidden="true"></i></span>Logout</a>
                                        </div>  
                                    </div>			
                                </div>
                            <?php } else if (!empty($this->session->userdata('user_email_id')) && $this->session->userdata('user_password') == 'undefined') {
                                ?>
                                <div class="nav-area">
                                    <h6 class="username">
                                        <i class="fa fa-user"></i><?php echo $this->session->userdata('user_email_id'); ?>
                                    </h6>
                                </div>
                            <?php } else { ?> 
                                <h6 class="username"></h6>
                                &nbsp;&nbsp;
                            <?php } ?>
                            <!--// Username and Icon -->
                        </nav>
                    </div>
                </div>
            </div>
        </header>

        <script>
            function myFunction() {
                document.getElementById("myDropdown").classList.toggle("show");
            }

// Close the dropdown if the user clicks outside of it
            window.onclick = function (event) {
                if (!event.target.matches('.dropbtn')) {
                    var dropdowns = document.getElementsByClassName("dropdown-content");
                    var i;
                    for (i = 0; i < dropdowns.length; i++) {
                        var openDropdown = dropdowns[i];
                        if (openDropdown.classList.contains('show')) {
                            openDropdown.classList.remove('show');
                        }
                    }
                }
            }

        </script>
        <!-- ***** Header Area End ***** -->
