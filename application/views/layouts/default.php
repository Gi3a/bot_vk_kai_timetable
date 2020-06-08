<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">

        <title><?php echo $title; ?></title>
        <link rel="icon" href="/public/img/logo.jpg">
        
        <link rel="stylesheet" type="text/css" href="/public/css/style.css">
        <link rel="stylesheet" type="text/css" href="/public/css/mid.css">

        <script src="/public/js/jquery.js"></script>
        
        <script src="/public/js/ajax.js"></script>
        <script src="/public/js/swal.js"></script>
    </head>
    <body>
        <header>
            <?php if(isset($_SESSION['admin'])) {require_once 'application/views/templates/admin/nav.php';} ?>
        </header>
        <main>
            <?php echo $content; ?>
        </main>
    </body>
</html>
