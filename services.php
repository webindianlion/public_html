<!DOCTYPE html>
<html lang="en">
<?php include './common/head.php' ?>
<body class="home">

   <?php include './common/topmenu.php' ?>

    <div class="containerr videoContainer">
        <div id="particles-js">
            <canvas class="particles-js-canvas-el" width="659" height="472"></canvas>
        </div>
        <div class="videoText">
            <h1> inwebservice <span>  We are commited to assist our business clients to develop and maintain their websites. </span> </h1>            
        </div> 
                                          
    </div>

    
<section class="container">
    <div class="d-flex align-items-start">
    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</button>
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</buttona>
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</button>
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</button>
    </div>
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">Home</div>
        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">Profile</div>
        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">Messages</div>
        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">setting</div>
    </div>
    </div>
</section>

    <?php include './common/footer.php' ?>
</body>
</html>
