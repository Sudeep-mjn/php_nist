<!-- <?php
require_once 'auth.php';
requireAuth();
?> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'NIST19 Admin Panel'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="assets/css/custom.css">
   
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#37517E'
                    }
                }
            }
        }
    </script>

</head>
<body class="bg-gray-100">
