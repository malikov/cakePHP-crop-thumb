<?
class CropHelper extends AppHelper{

    function thumbInterface($img, $id, $img_directory, $debug = null){
        //check if the array is build as it should be
        if (!isset($img_directory)) {
            return false;
        }
        if (!is_array($img) ){
            return false;
        }
        if (
            !isset($img['original_path']) ||
            !isset($img['append_to_path']) ||
            !isset($img['thumb_width']) ||
            !isset($img['thumb_height']) 
        
        ){
            return false;
        }

        //Is there in cakephp an elegant way to retrieve the / of the webroot?
        $img_path = WEBROOT_DIR."/".$img_directory."/";
        $img_path = str_replace('webroot', '', $img_path);

?>

        <img class="crop<?= $id ?>" id ="target3" alt="" src="<?= $img_path.$img['original_path'] ?>" />
        <input type ="hidden" name="Image[<?= $id ?>][name]" value="<?= $img['original_path'] ?>">
        <input type ="hidden" name="Image[<?= $id ?>][append]" value="<?= $img['append_to_path'] ?>">
        <input type ="hidden" name="Image[<?= $id ?>][crop_x]" value="">
        <input type ="hidden" name="Image[<?= $id ?>][crop_y]" value="">
        <input type ="hidden" name="Image[<?= $id ?>][crop_w]" value="">
        <input type ="hidden" name="Image[<?= $id ?>][crop_h]" value="">
        <input type ="hidden" name="Image[<?= $id ?>][dest_w]" value="<?= $img['thumb_width'] ?>">
        <input type ="hidden" name="Image[<?= $id ?>][dest_h]" value="<?= $img['thumb_height'] ?>">
<?
        if($debug == TRUE){
            $this->display_debug($id);
        }

        echo $this->_View->element('activeCrop',array('id_img' => $id,
                                                        'thumb_width' => $img['thumb_width'],
                                                        'thumb_height' => $img['thumb_height']
        ));

    }

    function display_debug($id_img){
?>
	<div id="results">
        <b>X</b>: <span id="<?= $id_img ?>crop_x"></span><br />
		<b>Y</b>: <span id="<?= $id_img ?>crop_y"></span><br />
		<b>W</b>: <span id="<?= $id_img ?>crop_w"></span><br />
		<b>H</b>: <span id="<?= $id_img ?>crop_h"></span><br />
	</div>

<?
    return true;
    }

}
?>
