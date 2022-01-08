<!doctype html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport"
         content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Contacts</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
   <style>
       body{
           padding-top: 3rem;
       }
       .container {
           width: 400px;
       }
   </style>
</head>
<body>
<div class="container">
       <h3>Контакты</h3>
       <form action="?controller=users&action=sendMail" method="post" enctype="multipart/form-data">
           <div class="row">
               <div class="field">
                   <label>Topic: <input type="text" name="subject"></label>
               </div>
           </div>
           <div class="row">
            <div class="field">
                <label>Text: <input type="text" name="text"></label>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label>Author: <input type="text" name="author"></label>
            </div>
        </div>
           <input type="submit" class="btn" value="Send">
       </form>
</div>
</body>
</html>