

<!DOCTYPE html>
<html>
<?php include './common/head.php' ?>
<body class="bodyContact">
    <?php include './common/topmenu.php' ?>
    <div class="container"> <br> <br> <br> <br><br> <br>
        <form action="./server.php" method="post" class="formContact">
        <h1>inWebService Customer Care</h1>
            <div class="form-group">
                <input type="text" name="cname" placeholder="Name" class="form-control" id="">
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" class="form-control" id="" aria-describedby="emailHelp">
            </div>        
            <div class="form-group">
                <input type="text" name="mobile" placeholder="Mobile" class="form-control" id="">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


</body>
</html>