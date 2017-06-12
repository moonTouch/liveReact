<?php 
session_start(); 

// Connection to database
include('db_connect.php'); 

// Cut audio files names length
function cutString($txt, $long = 25){
    if(strlen($txt) <= $long) return $txt;
    $txt = substr($txt, 0, $long);
    return $txt . ' (...)';
}

// Select all from buttons and store in datas variable
$request = $db->query('SELECT * FROM buttons'); 
$datas = $request->fetchAll();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>LiveReact</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="css/style.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    </head>
 
    <body class="container">

        <!-- Images will be displayed here -->
        <div id="image"></div>
        
        <section>

            <h1>LiveReact <small>by MoonTouch</small></h1>

            <hr>
        </section>
        
        <section>
            <!-- Alert box if errors exists -->
            <?php 
            if(isset($_SESSION['errors'])) {
                foreach($_SESSION['errors'] as $error ){
                    echo "<div class='alert alert-warning'>$error</div>";
                }
                unset($_SESSION['errors']);
            }
            ?>

            <!-- Alert box if success upload exists -->
            <?php 
            if(isset($_SESSION['success'])) {
                foreach($_SESSION['success'] as $success ){
                    echo "<div class='alert alert-success'>$success</div>";
                }
                unset($_SESSION['success']);
            }
            ?>
        
            <div class="row">

                <div class="col-md-4">

                    <h2>Images et sons</h2>

                    <?php foreach($datas as $data) { 
                        if (!empty($data['audio_src'] && $data['image_src'])) { ?>
                            <button class="btn" data-audio="audios/<?php echo $data['audio_src']; ?>" data-image="images/<?php echo $data['image_src']; ?>"><img src="images/<?php echo $data['image_src']; ?>"></button>
                    <?php };
                     }; ?>
                    
                </div>

                <div class="col-md-4">

                    <h2>Images</h2>
                    
                    <?php foreach($datas as $data) { 
                        if ($data['audio_src'] == null && !empty($data['image_src'])) { ?>
                            <button class="btn" data-image="images/<?php echo $data['image_src']; ?>"><img src="images/<?php echo $data['image_src']; ?>"></button>
                    <?php };
                     }; ?>

                </div>

                <div class="col-md-4 audio">

                    <h2>Sons</h2>

                    <?php foreach($datas as $data) {
                        if (!empty($data['audio_src'])  && ($data['image_src']) == NULL) { ?>
                            <button class="btn" data-audio="audios/<?php echo $data['audio_src']; ?>"><?php echo cutString($data['audio_src']); ?></button>
                    <?php };
                     }; ?>
  
                </div> 

            </div>

            <hr>

        </section>    
        
        <section>

            <!-- Add items form -->
            <h2>Ajout de données :</h2>

            <form action="upload.php" method="post" enctype="multipart/form-data">

                <label for="img">Fichier image (max 2Mo):</label>
                <input id="img" type="file" name="img">

                <label for="audio">Fichier son (max 2Mo):</label>
                <input id="audio" type="file" name="audio">

                <input type="submit" name="submit" value="Envoyer">

            </form>

        </section>

        <!-- Jquery -->     
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <!-- TweenMax Js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.4/TweenMax.min.js"></script>
         <!-- Socket Js -->
        <script src="js/socket.js"></script>
        <!-- Bootstrap Js -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <!-- Socket io configuration and animations -->
        <script src="js/socket_config.js"></script>
 
    </body>
</html>

