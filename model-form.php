<div class="modal fade" id="modelform" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="w-100 modal-title text-primary text-center" id="exampleModalLabel">For Best Price Quotation <br> +91 9810272223 </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="./mail_server.php" method="post" class="formContact">
                    <div class="form-group mb-2">
                        <input type="text" name="name" placeholder="Name" class="form-control" required="">
                    </div>
                    <div class="form-group mb-2">
                        <input type="email" name="email" placeholder="Email" class="form-control" required="">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" name="mobile" placeholder="Mobile" class="form-control" required="">
                    </div>
                    <div class="form-group mb-2">
                        <textarea name="umessage" placeholder="Your Message" cols="45" rows="3" class="form-control p-2"></textarea>
                    </div>
                    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>

