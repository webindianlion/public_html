
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ReCaptcha V3</title>

</head>
<body>
<!-- define('SITE_KEY', '6LdmOvoZAAAAAKUCJsdxeCXPHLxWp-uPVUNKVADK');
 define('SECRET_KEY', '6LdmOvoZAAAAACyFgyf1gDwBmbaoz9wRSCCkqTwo'); -->
    <form action="/" method="POST" id="demo-form">
        <input type="text" name="name" /><br />
        
        <!-- <input type="submit" value="Submit" /> -->
        <button class="g-recaptcha" 
        data-sitekey="6LdmOvoZAAAAAKUCJsdxeCXPHLxWp-uPVUNKVADKk" 
        data-callback='onSubmit' 
        data-action='submit'>Submit</button>
    </form>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        function onSubmit(token) {
            document.getElementById("demo-form").submit();
        }
    </script>
</body>
</html>