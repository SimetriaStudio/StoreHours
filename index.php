<?php
   // Core file holding all logic
   require_once('./core.php');

   // Helpre Functions
   require_once('./funcs/functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Hours in PHP</title>
   <link rel="stylesheet" href="/style.css">
</head>
<body>

   <div class="wrapper">
      <?php if($holidayObj !== null) { ?>
            <h3>Today is a Holiday!</h3>
            <p> <?php echo $salutation . '. ' . $globalMsg . '.'; ?> </p>
            <p>We are open today from <?php echo buildHours($holidayObj->open) . ' - ' . buildHours($holidayObj->close); ?>
            </p>
            <p> <?php echo $holidayObj->msg ?> </p>
      <?php } elseif($regObj !== null) { ?>
            <h3>Today is a Regular Day!</h3>
            <p> <?php echo $salutation . '. ' . $globalMsg . '.'; ?> </p>
            <p>We are open today from <?php echo buildHours($regObj->open) . ' - ' . buildHours($regObj->close); ?>
            </p>
            <p> <?php echo $regObj->msg ?> </p>
            <!-- Not Needed - For debugging purposes -->
            <small>Store: <?php echo $regObj->store; ?></small>
      <?php } else { ?>
            <img class="img-404" src="imgs/404.png">
            <h3 class="h3-404">Something has gone terribly wrong!</h3>
      <?php } ?>
   </div>

   <footer>
      <h1>Regular Store Hours:</h1>
      <?php
         foreach ($reguJSON as $k => $store) {
      ?>
         <div class="store-name">
            <?php echo ucwords($k) . ':'; ?>
         </div>
         <div class="footerWrapper">
            <?php
               foreach ($store as $key => $reg) {
            ?>
            <div>
               <p><strong><?php echo ucwords($key); ?></strong></p>
               <p><?php echo buildHours($reg->open) . ' - ' . buildHours($reg->close); ?> </p>
            </div>
            <?php
               }
            ?>
         </div>
      <?php
         }
      ?>
   </footer>

</body>
</html>
