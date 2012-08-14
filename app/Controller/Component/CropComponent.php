<?php
App::uses('File', 'Utility');

class CropComponent extends Component {

    var $image_directory = '';
    var $quality = '';
    var $msg = '';

    public function check_img($img){
        //debug($img);die;
        if (!is_array($img)) {
            $this->msg = "This is not an array";
            $this->log($this->msg);
            return false;
        }

        if (
            !isset($img['name']) ||
            !isset($img['append']) ||
            !isset($img['crop_x']) ||
            !isset($img['crop_y']) ||
            !isset($img['crop_w']) ||
            !isset($img['crop_h']) ||
            !isset($img['dest_w']) ||
            !isset($img['dest_h']) 
        ){
            $this->msg = "The given image array has not all the required params";
            $this->log($this->msg);
            return false;
        }
        return true;
    }

    public function create_thumb($img){
        //check if the img array is correct
        if (!$this->check_img($img)){
            $this->msg = "Image thumb array is not correct"; 
            $this->log($this->msg);
            return false;
        }

        //try to create the new file
        $orig_file_path = WWW_ROOT.$this->image_directory.DS.$img['name'];
        $orig_file = new File($orig_file_path);
        if (!$orig_file->exists()) {
            $this->msg = "File".$orig_file_path."doesn\'t exists";
            $this->log($this->msg);
            return false;
        }

        $file_parts = pathinfo($img['name']);
        $orig_file_ext = $file_parts['extension'];
        $orig_file_name = $file_parts['filename'];

        //try to create the new jpg thumb file, all the tumbs will be in jpg format
        $new_file_path = WWW_ROOT.$this->image_directory.DS;
        $new_file_path.= $orig_file_name."_".$img['append'].".jpg";
        $new_file = new File($new_file_path);
        $new_file->create($new_file_path);
        if (!$new_file->exists()) {
            $this->msg = "Impossible to create the file".$new_file_path;
            $this->log($this->msg);
        }
        
        //Try to create an image with the new file path, starting from the 
        //original one
        $src = $this->img_create_from_ext($orig_file_path, $orig_file_ext);
        if (!$src) {
            $this->msg = "Impossible to create an image with path:'".$new_file_path."'";
            $this->msg.= "and exension '".$orig_file_ext."'";
            $this->log($this->msg);
            return false;
        }

        //First, crop the image
        $dest = imagecreatetruecolor($img['crop_w'], $img['crop_h']);
        $copy = imagecopy($dest, $src, 0, 0, $img['crop_x'], $img['crop_y'], $img['crop_w'], $img['crop_h']);
        $crop = imagejpeg($dest, $new_file_path, $this->quality);
        if ((!$copy) || (!$crop)) {
            $this->msg = "Impossible to create the cropped image";
            $this->log($this->msg);
            return false;
        }

        //Second, scale the cropped image
        $tmpimg = imagecreatetruecolor($img['dest_w'], $img['dest_h']);
        imagecopyresampled( $tmpimg, $dest, 0, 0, 0, 0,$img['dest_w'], $img['dest_h'] ,$img['crop_w'], $img['crop_h']); 
        $thumb = imagejpeg( $tmpimg, $new_file_path, $this->quality);
        if (!$thumb) {
            $this->msg = "Impossible to create the scaled image starting from the cropped one";
            $this->log($this->msg);
            return false;
        } else {
            $this->msg = "Immmagine creata";
            $this->log($this->msg);
            //free memory
            imagedestroy($dest);
            imagedestroy($tmpimg);
            imagedestroy($src);
            return true;
        }
    }

    function img_create_from_ext($path, $ext){
        if (!isset($path) ){
            $this->msg = "The path is not set";
            $this->log($this->msg);
            return false;
        };
        if (!isset($ext) ){
            $this->msg = "File extension not set";
            $this->log($this->msg);
            return false;
        };
        if ($ext !== 'gif' && $ext !== 'jpg' && $ext !== 'png'){
            $this->msg = "Only these files extensions are allowed: gif, jpg, png";
            $this->log($this->msg);
            return false;
        };

        switch($ext){
            case "jpg":
                $src = imagecreatefromjpeg($path);
            break;
            case "png":
                $src = imagecreatefrompng($path);
            break;
            case "gif":
                $src = imagecreatefromgif($path);
            break;
        }
        return $src;
    }


}
