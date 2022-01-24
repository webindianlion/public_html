

<!DOCTYPE html>
<html>
<?php include './common/head.php' ?>
<body class="bodyContact">
    <?php include './common/topmenu.php' ?>
    <div class="containerr videoContainer"> 
        <div id="particles-js">
            <canvas class="particles-js-canvas-el" width="659" height="572"></canvas>
        </div>
        <div class="videoText d-flex flex-column justify-content-center align-items-center position-absolute h-100 container-fluid">
            <h1 class="">Contact Us @</h1>
            <p class="pt-2 text-decoration-underline">inweballservices@gmail.com</p>
        </div>
    </div>
    <section class="container contact py-5">
        <div class="row">
            <div class="col-lg-6 p-0 bg-dark d-flex justify-content-center align-items-center overflow-hidden">
                <img class="" src="./images/contact.jpg" alt="">
            </div>
            <div class="col-lg-6 bg-dark">
                <form action="./mail_server.php" method="post" class="formContact" id="formContact">
                <h1 class="text-white">Customer Care <br>(+91 9810272223)</h1>
                    <div class="form-group mb-2">
                        <input type="text" name="name" placeholder="Name" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <input type="email" name="email" placeholder="Email" class="form-control" required>
                    </div>        
                    <div class="form-group mb-2">
                        <input type="text" name="mobile" placeholder="Mobile" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <textarea name="umessage" placeholder="Your Message" cols="45" rows="3" class="form-control p-2"></textarea>
                    </div>
                    <!-- <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" /><br > -->
                    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                </form>
            </div>
        </div>
        
    </section>

    <?php include './common/footer.php' ?>

    <!-- <script src='https://www.google.com/recaptcha/api.js?render=6LdmOvoZAAAAAKUCJsdxeCXPHLxWp-uPVUNKVADK'></script> -->
    <!-- <script>
      grecaptcha.ready(function() {
      grecaptcha.execute('6LdmOvoZAAAAAKUCJsdxeCXPHLxWp-uPVUNKVADK', {action: 'submit'})
      .then(function(token) {
          //console.log(token);
          document.getElementById('g-recaptcha-response').value=token;
      });
      });
  </script> -->
  <script>
    jQuery('#formContact').trigger("reset");
  </script>
</body>
</html>