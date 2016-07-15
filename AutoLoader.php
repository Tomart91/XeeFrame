<?php
/**
 * Autoloader plików 
 * Na podstawie przestrzeni klasy odnajduje plik w folderach 
 */
spl_autoload_register(function ($class_name) {

	$folders = explode('\\' ,$class_name);
	$path =  ROOT_DIR .'/'. implode('/',$folders) . '.php';
	if(file_exists($path)){
		require_once $path;
	} else {
		require_once('libraries/Twig/Autoloader.php');
	}
});
