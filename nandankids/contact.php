<!doctype html>
<html lang="en">
<?php include './common/head.php' ?>
<body class="home">

   <?php include './common/topmenu.php' ?>
    <main class="">      

    <section class="container contact m-auto  border-0 pb-0">
        <h3 class="mb-5">Contacts</h3>

        <div class="row">
            <div class="col textPart">
                <form action="./mail_server.php" method="post" name="form">
                    <input type="text" placeholder="Name" class="form-control mb-3" id="" name="uname" required > 
                    <!-- <input type="text" placeholder="Company Name" class="form-control mb-3" id="" name="cname" required > -->
                    <input type="email" placeholder="Email" class="form-control mb-3" id="" name="uemail" required >
                    <input type="text" placeholder="Phone Number" class="form-control mb-3" id="" name="uphone" required >
                    <textarea name="umessage" placeholder="Message" id="" rows="3" class="form-control w-100  mb-3"></textarea>
                    <input type="submit" name="submit" value="Submit"  class="btn btn-submit">                
                </form> 
            </div>
            <div class="col imgPart">
                <img src="./images/contact_img.jpg" alt="">
            </div>            
        </div>
                           
    </section>

    <section class="container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3628.828475752997!2d81.32445631483192!3d24.560588784196195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1s10%2F333%2C%20Janta%20College%20Rd%2C%20Anantpur%2C%20Arun%20Nagar%2C%20Ajigarha%2C%20Madhya%20Pradesh!5e0!3m2!1sen!2sin!4v1614777471718!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </section>
    </main>  

    <?php  include './common/footer.php' ?>
    
</body>
</html>
















