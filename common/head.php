<?php

include "meta.php";

// Choice 2: If you want to make it little more dynamic
// Here you don't need to define any hardcoded variable at page level as everything will be considered from the URL being requested
$page_index = array_keys($meta);

foreach($page_index as $page)
{

    if ( strpos( strtoupper($_SERVER['REQUEST_URI']), $page ) !== false)
    {
        $title = $meta[$page]['title'];
        $keywords = $meta[$page]['keywords'];
        $description = $meta[$page]['description'];
        break;
    }
}
// Now you have your meta - use it the way you want
// echo $title;

?>

<head>

    <title><?php echo $title ?></title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />    
    
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Keywords" content="<?php echo $keywords; ?>" >
    <meta name="Description" content="<?php echo $description ?>">
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <link rel="shortcut icon" href="./images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="./images/favicon.ico" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">        
    
    <link rel="stylesheet" href="./css/bootstrap/bootstrap.min.css" >    

    <link rel="stylesheet" href="./css/aos.css" /> 
    <link rel="stylesheet" href="./css/style.css">   
    <link rel="stylesheet" href="./css/style_responsive.css">   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
</head>