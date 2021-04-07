<?php
session_start();
include("../dbconnection/dbconnection.php");
include("../model/slider.php");
$slider = new Slider();

switch($_POST['action']){

   case "save_main_slider":

       $slider->name = $_POST['name'];
	
  if($slider->uploadLogo($_FILES)){

      $slider->logo = $slider->uploadLogo($_FILES);
  }
  else{
    
    $_SESSION['message'] = "<div class='alert alert-danger'>Invalid File format</div>";
    header("Location:../add_main_brand.php");
    exit();
  }


       $slider->status = $_POST['status'];
	
	$save = $slider->save();
	
    if($save)
        	 {
        	 	$_SESSION['message'] = "<div class='alert alert-success'>Save brand successfully!</div>";
        	 }
        	 else{
        	 	$_SESSION['message'] = "<div class='alert alert-danger'>Unable to save!</div>";
        	 }

        	 header("Location:../add_main_slider.php");

     break;

   case "update_main_slider":

       $slider->name = $_POST['name'];
       $slider->status = $_POST['status'];
       $upslider = $slider->update($_POST['id']);


   if(!empty($_FILES['logo']['name'])){

       $slider->logo = $slider->uploadLogo($_FILES);
      $update_logo = $slider->update_logo($_POST['id']);
      @unlink("../uploads/mainslider/".$_POST['old_logo']);
   }
   
   if($upslider){
                $_SESSION['message'] = "<div class='alert alert-success'>Update brand successfully!</div>";
             }
             else{
                $_SESSION['message'] = "<div class='alert alert-danger'>Unable to Update!</div>";
             }
   header("Location:../update_main_slider.php?id=".$_POST['id']);
   
     break;

   case "delete_main_slider":
   
     $delete = $slider->delete($_POST['id']);
	 
	 if($delete)
        	 {
        	 	$_SESSION['message'] = "<div class='alert alert-success'>delete brand successfully!</div>";
        	 }
        	 else{
        	 	$_SESSION['message'] = "<div class='alert alert-danger'>Unable to delete!</div>";
        	 }

        	 header("Location:../main_slider_list.php");
	 
    
     break;

  default:

  header("Location:../login.php");

}





?>