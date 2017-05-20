<?php
require_once './models/replace_character.class.php';
require_once './controllers/replace_character.controller.php';

require_once('./smtp_mail/class.phpmailer.php');


class toolsController {
 
    function replacechar($var,$dbh){
        $replace_character = new replace_character();
        $replacecontroller = new replace_characterController($replace_character, $dbh);
        $var = $replacecontroller->replacechar($var);
        return $var;
    }
    function replacecharFind($var,$dbh){
        $replace_character = new replace_character();
        $replacecontroller = new replace_characterController($replace_character, $dbh);
        $var = $replacecontroller->replacecharFind($var);
        return $var;
    }
    function replacecharSave($var,$dbh){
        $replace_character = new replace_character();
        $replacecontroller = new replace_characterController($replace_character, $dbh);
        $var = $replacecontroller->replacecharSave($var);
        return $var;
    }
    function str_hex($string){
      $hex = "00";
      for ( $ix=0; $ix < strlen($string); $ix=$ix+1 ) {
        $char =  substr( $string, $ix, 1 );
        $ord = ord ( $char );
        if ( $ord < 16 ) {
          $hex .= '0'.dechex( $ord );
        }
        else {
          $hex .= dechex( $ord );
        }

        // add line break or space
        if ( $ix && ($ix % 16) == 15 ) {
          $hex .= "00";
        }
        else {
          $hex .= "00";
        }
      }

      // strip trailing space or linebreak
      return substr( $hex, 0, -2 );
  }
    
  function smart_resize_image($file,
                              $string             = null,
                              $width              = 0, 
                              $height             = 0, 
                              $proportional       = false, 
                              $output             = 'file', 
                              $delete_original    = true, 
                              $use_linux_commands = false,
  							  $quality = 100
  		 ) {
                       
    if ( $height <= 0 && $width <= 0 ) return false;
    if ( $file === null && $string === null ) return false;
    # Setting defaults and meta
    $info                         = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
    $image                        = '';
    $final_width                  = 0;
    $final_height                 = 0;
    list($width_old, $height_old) = $info;
	$cropHeight = $cropWidth = 0;
    # Calculating proportionality
    if ($proportional) {
      if      ($width  == 0)  $factor = $height/$height_old;
      elseif  ($height == 0)  $factor = $width/$width_old;
      else                    $factor = min( $width / $width_old, $height / $height_old );
      $final_width  = round( $width_old * $factor );
      $final_height = round( $height_old * $factor );
    }
    else {
      $final_width = ( $width <= 0 ) ? $width_old : $width;
      $final_height = ( $height <= 0 ) ? $height_old : $height;
	  $widthX = $width_old / $width;
	  $heightX = $height_old / $height;
	  
	  $x = min($widthX, $heightX);
	  $cropWidth = ($width_old - $width * $x) / 2;
	  $cropHeight = ($height_old - $height * $x) / 2;
    }
    # Loading image to memory according to type
    switch ( $info[2] ) {
      case IMAGETYPE_JPEG:  $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);  break;
      case IMAGETYPE_GIF:   $file !== null ? $image = imagecreatefromgif($file)  : $image = imagecreatefromstring($string);  break;
      case IMAGETYPE_PNG:   $file !== null ? $image = imagecreatefrompng($file)  : $image = imagecreatefromstring($string);  break;
      default: return false;
    }
    
    
    # This is the resizing/resampling/transparency-preserving magic
    $image_resized = imagecreatetruecolor( $final_width, $final_height );
    if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
      $transparency = imagecolortransparent($image);
      $palletsize = imagecolorstotal($image);
      if ($transparency >= 0 && $transparency < $palletsize) {
        $transparent_color  = imagecolorsforindex($image, $transparency);
        $transparency       = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
        imagefill($image_resized, 0, 0, $transparency);
        imagecolortransparent($image_resized, $transparency);
      }
      elseif ($info[2] == IMAGETYPE_PNG) {
        imagealphablending($image_resized, false);
        $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
        imagefill($image_resized, 0, 0, $color);
        imagesavealpha($image_resized, true);
      }
    }
    imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);
	
	
    # Taking care of original, if needed
    if ( $delete_original ) {
      if ( $use_linux_commands ) exec('rm '.$file);
      else @unlink($file);
    }
    # Preparing a method of providing result
    switch ( strtolower($output) ) {
      case 'browser':
        $mime = image_type_to_mime_type($info[2]);
        header("Content-type: $mime");
        $output = NULL;
      break;
      case 'file':
        $output = $file;
      break;
      case 'return':
        return $image_resized;
      break;
      default:
      break;
    }
    
    # Writing image according to type to the output destination and image quality
    switch ( $info[2] ) {
      case IMAGETYPE_GIF:   imagegif($image_resized, $output);    break;
      case IMAGETYPE_JPEG:  imagejpeg($image_resized, $output, $quality);   break;
      case IMAGETYPE_PNG:
        $quality = 9 - (int)((0.9*$quality)/10.0);
        imagepng($image_resized, $output, $quality);
        break;
      default: return false;
    }
    return true;
  }
  
    function calculateAge($date1,$date2){
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        $hasil = $years." Thn ".$months." Bln";
    }

    

    function generate_image_thumbnail($source_image_path, $thumbnail_image_path)
    {
        list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
        switch ($source_image_type) {
            case IMAGETYPE_GIF:
                $source_gd_image = imagecreatefromgif($source_image_path);
                break;
            case IMAGETYPE_JPEG:
                $source_gd_image = imagecreatefromjpeg($source_image_path);
                break;
            case IMAGETYPE_PNG:
                $source_gd_image = imagecreatefrompng($source_image_path);
                break;
        }
        if ($source_gd_image === false) {
            return false;
        }
//         Large Image
        $newwidth=1024;
        $newheight=1024;
        $source_aspect_ratio = $source_image_width / $source_image_height;
        $thumbnail_aspect_ratio = $newwidth / $newheight;
        if ($source_image_width <= $newwidth && $source_image_height <= $newheight) {
            $thumbnail_image_width = $source_image_width;
            $thumbnail_image_height = $source_image_height;
        } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
            $thumbnail_image_width = (int) ($newheight * $source_aspect_ratio);
            $thumbnail_image_height = $newheight;
        } else {
            $thumbnail_image_width = $newwidth;
            $thumbnail_image_height = (int) ($newwidth / $source_aspect_ratio);
        }
        $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
        imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);
        imagejpeg($thumbnail_gd_image, $thumbnail_image_path, 90);
        imagedestroy($source_gd_image);
        imagedestroy($thumbnail_gd_image);

        return true;
    }
    
    function process_image_upload($field)
    {
        
        $tools= new toolsController();
        
        $temp_image_path = $_FILES[$field]['tmp_name'];
        $temp_image_name = $_FILES[$field]['name'];
        
        
        list(, , $temp_image_type) = getimagesize($temp_image_path);
        if ($temp_image_type === NULL) {
            return false;
        }
        switch ($temp_image_type) {
            case IMAGETYPE_GIF:
                break;
            case IMAGETYPE_JPEG:
                break;
            case IMAGETYPE_PNG:
                break;
            default:
                return false;
        }
        
        $uploaded_image_path = UPLOADED_IMAGE_ORIGINAL_DESTINATION . $temp_image_name;

        
        $thumbnail_image_path = UPLOADED_IMAGE_LARGE_DESTINATION . preg_replace('{\\.[^\\.]+$}', '.jpg', $temp_image_name);
        $result = $tools->generate_image_thumbnail($uploaded_image_path, $thumbnail_image_path);
//        
//        return $result ? array($uploaded_image_path, $thumbnail_image_path) : false;
    }
    
    function monthName($monthNo=null){
        $array_bulan = array(1=>'Januari','Februari','Maret', 'April', 'Mei', 'Juni','Juli','Agustus','September','Oktober', 'November','Desember');
        if($monthNo == NULL){
            $bulanName = $array_bulan[date('n')];
        } else {
            $bulanName = $array_bulan[$monthNo];
        }
        return $bulanName;
    }
    
    
    function sendMail($config,$dbh){
        $mail             = new PHPMailer();
        $mail->IsSMTP(); // telling the class to use SMTP
        //$mail->Host       = "mail.yourdomain.com"; // SMTP server
        $mail->Host       = $config['host']; // SMTP server
        $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)                                                   
        $mail->SMTPAuth   = true;                  // enable SMTP authentication        
        $mail->Port       = $config['port'];                    // set the SMTP port for the GMAIL server
        $mail->Username   = $config['username']; // SMTP account username
        $mail->Password   = $config['password'];        // SMTP account password
        
        
        $mail->SetFrom($config['from'], $config['fromname']);
        $mail->AddReplyTo($config['from'], $config['fromname']);
        $mail->Subject    = $config['subject'];
        
        
        foreach ($config['to'] as $address=>$name){
            $mail->AddAddress($address,$name);
        }
        
        $mail->AltBody    = ""; // optional, comment out and test

        $mail->MsgHTML($config['message']);

        //$address = $receipt;
        
        if($_FILES){
            $file_name        = $_FILES[$config['file_upload']]['name'];
            $mail->AddAttachment("./".$config['dir_upload']."/".$file_name);      // attachment
            $mail->AddAttachment("./".$config['dir_upload']."/".$file_name); // attachment
        }
        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo."~0";
          } else {              
        
            echo "Message sent!";
          }

    }
    function uploadImage($filesource, $formatnow){
        
        $target_dir = "uploads/";
        $target_file = $target_dir.$filesource;
        $target_large="images_large/".$formatnow;
        $target_medium="images_medium/".$formatnow;
        $target_small="images_small/".$formatnow;
        $target_small_bgt="images/".$formatnow;
        

        $resizedFile = $target_large .$filesource;  
        $this->smart_resize_image($target_file,null, 1024 , 800 , true , $resizedFile, false , false ,100);

        $resizedFile = $target_medium .$filesource;  
        $this->smart_resize_image($target_file,null, 800 , 600 , true , $resizedFile, false , false ,100);

        $resizedFile = $target_small .$filesource;  
        $this->smart_resize_image($target_file,null, 250 , 250 , true , $resizedFile, false , false ,100);
        
        $resizedFile = $target_small_bgt .$filesource;  
        $this->smart_resize_image($target_file,null, 32 , 32 , true , $resizedFile, false , false ,100);
        
        unlink($target_file);            
        }
        
    
}



?>
