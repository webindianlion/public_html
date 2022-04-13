<!DOCTYPE html>
<html lang="en">
<?php include './common/head.php' ?>
<body class="home">

    <div class="containerr videoContainer">
        <div id="particles-js">
            <canvas class="particles-js-canvas-el" width="659" height="472"></canvas>
        </div>
        <div class="videoText d-flex flex-column justify-content-center align-items-center position-absolute h-100 container-fluid">
        <h2 class="logo mb-4" style="color: #141526;background: #fff;padding: 5px;position: absolute;font-size: 24px;margin-left: 5px;top: 10px;border-radius: 2px;"> <a href="/"> <img src="./images/inwebservice-logo.png" alt="" style="width: 150px;"> </a> </h2>
        <p class="d-flex flex-wrap justify-content-center landing-page1-contact fs-5"> 
                <span class="me-5"><i class="fa fa-mobile me-3 text-warning"></i>+91 9810272223</span>
                <span class=""><i class="fa fa-envelope  me-3 text-warning"></i>inweballservices@gmail.com</span> </p>
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <h1 class=""> <span class="badge bg-primary m-1">E-Commerce Website</span> <span class="badge bg-secondary m-1">Responsive Website</span> </h1>
                        <p class="pt-2">Our all services are premium and Best in market</p>                        
                    </div>
                    <div class="carousel-item">
                        <h1 class=""><span class="badge bg-primary m-1">Premium Website Design</span><span class="badge bg-secondary m-1">@ Best Price </span> </h1>
                        <p class="pt-2">Our all services are premium and Best in market</p>                        
                    </div>
                    <div class="carousel-item">
                        <h1 class=""><span class="badge bg-primary m-1">SEO Consultation and Audit</span><span class="badge bg-secondary m-1">@ Free </span> </h1>
                        <p class="pt-2">Our all services are premium and Best in market</p>                        
                    </div>
                    <div class="carousel-item">
                        <h1 class=""><span class="badge bg-primary m-1">Fast Loading Website</span><span class="badge bg-secondary m-1">No Hidden Cost </span> </h1>
                        <p class="pt-2">Our all services are premium and Best in market</p>                        
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    <section class="whyWebsite py-5">
        <div class="container contact">
        <h3 class="ttl text-primary mb-3">Why to Choose Us?</h3>
            <div class="row flex flex-wrap">
                <div class="col-lg-6 overflow-hidden mt-2">
                    <div class="list-group p-0 fw-bold">
                        <a href="" class="list-group-item list-group-item-action list-group-item-primary"> Basic Website @2999/- </a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-warning"> WordPress Website @3999/- </a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-info"> Dynamic Website @4999/- </a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-success"> Ecommerce Website @5999/-</a>            
                        <a href="#" class="list-group-item list-group-item-action list-group-item-primary"> Responsive Website with Fast Loading speed. </a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-warning"> 2 Days Delivery </a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-info"> 100% Money Back Guarantee </a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-dark">  Lowest Price. No Hidden Cost</a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-success"> Full Support </a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-primary"> Premium Website Design </a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-warning"> Top Development in Industry </a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-dark"> Latest Technology </a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-info"> 100% Trusted Company </a>    
                </div>
                </div>
                <div class="col-lg-6 bg-dark p-4 mt-2 border rounded">
                    <h3 class="text-white mb-4">Get Offer Fast.</h3>
                    <form action="./mail_server.php" method="post" class="formContact" id="formContact">
                    
                        <div class="form-group mb-3">
                            <input type="text" name="name" placeholder="Name" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" name="email" placeholder="Email" class="form-control" required>
                        </div>        
                        <div class="form-group mb-3">
                            <input type="text" name="mobile" placeholder="Mobile" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <textarea name="umessage" placeholder="Your Message" cols="45" rows="3" class="form-control p-2"></textarea>
                        </div>
                        <!-- <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" /><br > -->
                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                    </form>
                </div>
            </div>        
        </div>
    </section>
    
    <section class="expertise py-5">
        <div class="container">
            <h3 class="ttl text-primary"> Our Expertise</h3>
            <p class="subTtl"> We are best in Industry for the following web development tasks. </p>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mt-3">
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="fas fa-laptop-code"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> PSD to HTML5 Conversion</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="fas fa-ruler-combined"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> Responsive Website Layout </h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="fa fa-layer-group"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> New Website Design and Development </h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="fa fa-digital-tachograph"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> Dynamic Website </h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="fab fa-wordpress"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> Wordpress Website </h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="fa fa-calculator"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> Web Applications</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="far fa-newspaper"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> Renew Website Design</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="fas fa-bug"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> Bug Fixing</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="fas fa-mail-bulk"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> Email Design & Development</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5">
        <h3 class="ttl text-primary"> Let's Get Started Today </h3>
        <p class="subTtl"> Simply Contact Us To Know More </p>
        <div class="row pt-3">
            <div class="text-center"><button class="btn btn-primary px-5" data-bs-toggle="modal" data-bs-target="#modelform"> Get Quote </button></div>
        </div>
    </section>
    <section class="py-5 technology">
        <div class="container">
            <h3 class="ttl text-white"> Technologies We Use</h3>
            <p class="subTtl text-white"> We use latest technologies in the market. </p>
            <div class="row">
                <div class="cardd col">
                    <p> HTML5 </p>
                </div>
                <div class="cardd col">
                    <p> CSS3 </p>
                </div>
                <div class="cardd col">
                    <p> JavaScript / ES6 </p>
                </div>
            </div>
            <div class="row">
                <div class="cardd col">
                    <p> jQuery </p>
                </div>
                <div class="cardd col">
                    <p> Angular </p>
                </div>
                <div class="cardd col">
                    <p> React </p>
                </div>
            </div>
            <div class="row">
                <div class="cardd col">
                    <p> PHP </p>
                </div>
                <div class="cardd col">
                    <p> Node </p>
                </div>
                <div class="cardd col">
                    <p> Mongo DB </p>
                </div>
                <div class="cardd col">
                    <p> MySQL DB </p>
                </div>
            </div>
        </div>
    </section>
   
    <section class="features py-5">
        <div class="container">
            <h3 class="ttl text-primary"> Features to add your website</h3>
            <p class="subTtl"> Simply Contact Us To Know More </p>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mt-3">
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="fas fa-laptop-code"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> Desktop/ Mobile Responsive</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="fas fa-ruler-combined"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> Logo + Favicon </h5>
                        </div>
                    </div>                            
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="fa fa-layer-group"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> Content & Graphics </h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="fa fa-digital-tachograph"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> Long Term Support </h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="fab fa-google"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> SEO </h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="fa fa-calculator"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> Contact Form </h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="far fa-newspaper"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> Google Business Listing </h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="fab fa-wordpress"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> Payment Gateway (Ecommerce) </h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="rounded-circle card-img mx-auto d-flex align-items-center justify-content-center mt-3"><i class="fab fa-wordpress"></i></div>
                        <div class="card-body border-0">
                            <h5 class="card-title text-center"> Order Tracking ( Ecommerce) </h5>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php include './common/footer1.php' ?>
    <?php include './model-form.php' ?>

</body>

</html>