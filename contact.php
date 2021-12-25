

<!DOCTYPE html>
<html>
<?php include './common/head.php' ?>
<body class="bodyContact">
    <?php include './common/topmenu.php' ?>
    <div class="containerr videoContainer"> 
        <div id="particles-js">
            <canvas class="particles-js-canvas-el" width="659" height="572"></canvas>
        </div>
        <form action="./mail_server.php" method="post" class="formContact">
        <h1>Customer Care <br>(+91 9810272223)</h1>
            <div class="form-group">
                <input type="text" name="name" placeholder="Name" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" class="form-control" required>
            </div>        
            <div class="form-group">
                <input type="text" name="mobile" placeholder="Mobile" class="form-control" required>
            </div>
            <div class="form-group">
                <textarea name="umessage" placeholder="Your Message" cols="45" rows="3" class="form-control p-2"></textarea>
            </div>
            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" /><br >
            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
        </form>
    </div>
    
    <?php include './common/footer.php' ?>

    <script src='https://www.google.com/recaptcha/api.js?render=6LdmOvoZAAAAAKUCJsdxeCXPHLxWp-uPVUNKVADK'></script>
    <script>
      grecaptcha.ready(function() {
      grecaptcha.execute('6LdmOvoZAAAAAKUCJsdxeCXPHLxWp-uPVUNKVADK', {action: 'submit'})
      .then(function(token) {
          //console.log(token);
          document.getElementById('g-recaptcha-response').value=token;
      });
      });
  </script>
</body>
</html>