<!DOCTYPE html>
<html lang="en">
<head>
    <title>BargePoller</title>
    <meta charset="utf-8">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!--[if le IE 9]><script src="lib/base64.js"></script><![endif]-->
    <script src="lib/aes.js">/* AES JavaScript implementation */</script>
    <script src="lib/aes-ctr.js">/* AES Counter Mode implementation */</script>
    <script src="lib/aes-ctr-file.js">/* encrypt/decrypt files */</script>



</head>
<body>
<script type="text/javascript" charset="utf-8">

    $(document).ready(function(){

        // encrypt listener
        $('#encrypt').click( function() {
            var t = new Date();
            var ciphertext = Aes.Ctr.encrypt($('#plaintext').val(), $('#password').val(), 256);
            $('#encrypt-time').html(((new Date() - t))+'ms');
            $('#cipher').val(ciphertext);
        });
        // decrypt listener
        $('#decrypt').click( function() {
            var t = new Date();
            var plain = Aes.Ctr.decrypt($('#cipher').val(), $('#password').val(), 256);
            $('#decrypt-time').html(((new Date() - t))+'ms');
            $('#plain').val(plain);
        });
    });
</script>
<form>
    <fieldset><legend>Functional demo</legend>
        <ul>
            <li>
                <label for="password">Password</label>
                <input type="text" name="password" id="password" value="WhatY0u$!ee" class="w12">
            </li>
            <li>
                <label for="plaintext">Plaintext</label>
                <textarea name="plaintext" id="plaintext" class="width-full">pssst ... đon’t tell anyøne!</textarea>
            </li>
            <li>
                <label><button type="button" name="encrypt" id="encrypt">Encrypt it</button></label>
                <textarea name="cipher" id="cipher" readonly class="width-full"></textarea>
                <output class="small grey" id="encrypt-time"></output>
            </li>
            <li>
                <label><button type="button" name="decrypt" id="decrypt">Decrypt it</button></label>
                <textarea name="plain" id="plain" readonly class="width-full"></textarea>
                <output class="small grey" id="decrypt-time"></output>
            </li>
        </ul>
    </fieldset>
</form>
</body>
</html>