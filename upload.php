<?php 
session_start();

//Connect to database
include('db_connect.php'); 


//Check extensions fo each file
$valid_img_extensions = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
$valid_audio_extensions = array( 'mp3' , 'wav');

function upload($file, $valid_extensions, $path_prefix, $index){

	// If errors, register message
	if ($file['error'] > 0) $_SESSION['errors'][] = "Erreur lors du transfert du fichier";
	
	// Extension check, register message if not valid
	$file_extension = strtolower(  substr(  strrchr($file['name'], '.')  ,1)  );
	if ( !in_array($file_extension, $valid_extensions) ) {
		$_SESSION['errors'][] = "Extension du fichier non valide";
	};

	// Check size
	if ($file["size"] <= 0) {
		$_SESSION['errors'][] = "Taille de l'image trop importante (max 2Mo)";
	};

	// If errors, redirects to index to display them
	if(isset($_SESSION['errors'])) {

		header('Location: index.php');	

	} else {

		// File name generator
		$file_name = $file['name'];

		// If folder doesn't exists, create it
		if(!file_exists($path_prefix)) {
			mkdir($path_prefix);
		};
		
		// Check if file name already exists in the folder. If so, add an uniqid and "-" in front of original filename
		if(file_exists($path_prefix . $file_name)) {

			$file_name = uniqid() . "-" . $file_name;
		};
		
		// Generate final path to move on
		$path = $path_prefix . $file_name;

		// Transfert file to folder
		$transfert = move_uploaded_file($_FILES[$index]['tmp_name'], $path);

		if($transfert) {
			// Return filename to insert in db
			return $file_name;

		} else {
			$_SESSION['errors'][] = "Erreur lors di transfert de l'image";
			header('Location: index.php');	
		}
		

	}
}


// If both image and audio are posted
if ($_FILES['img']['error'] !=4 && $_FILES['audio']['error'] != 4) {

	// Image transfert
	$image_file_name = upload($_FILES['img'], $valid_img_extensions, "images/", 'img');
	// audio transfert
	$audio_file_name = upload($_FILES['audio'], $valid_audio_extensions, "audios/", 'audio');

	//if in one of the two files
	if (!$image_file_name || !$audio_file_name) {

		$_SESSION['errors'][] = "Erreur lors du transfert des fichiers. Upload abandonné.";

	} else {
		// Insert in database
    	$query = $db->prepare("INSERT INTO buttons(image_src, audio_src) VALUES (:image_src, :audio_src)");
		$query->execute(array(
			"image_src" => $image_file_name,
			"audio_src" => $audio_file_name,
		));

		// Display a sucess message
		$_SESSION['success'][] = "Fichiers image et sons bien enregistrés";
		
	};

	
} else {

	// Check if file and errors exists
	if ($_FILES['img']['error'] !=4 ) {

		$image_file_name = upload($_FILES['img'], $valid_img_extensions, "images/", 'img');

		if ($image_file_name) {
	        
			$query = $db->prepare("INSERT INTO buttons(image_src) VALUES (:image_src)");
			$query->execute(array("image_src" => $image_file_name));
			$_SESSION['success'][] = "Fichier image bien enregistré";
			
		} else {

			$_SESSION['errors'][] = "Erreur lors du transfert de l'image";

		}
	};

	// Check if file and errors exists
	if ($_FILES['audio']['error'] != 4 ) {
		// $uploadFile = uploadFile($_FILES['audio'], "audios/", 'audio', 'audio_src');
		$file_name = upload($_FILES['audio'], $valid_audio_extensions, "audios/", 'audio');

		if ($file_name) {

			$query = $db->prepare("INSERT INTO buttons(audio_src) VALUES (:audio_src)");
			$query->execute(array("audio_src" => $file_name));
			$_SESSION['success'][] = "Fichier son bien enregistré";

		} else {

			$_SESSION['errors'][] = "Erreur lors du transfert du fichier son";

		}
	};

}

// Redirection to index if all is OK
header('Location: index.php');

