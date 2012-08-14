<?= $this->Html->script('http://code.jquery.com/jquery-latest.min.js',array('inline' => false));  ?>
<?= $this->element('jwindowCrop')?>
<?= $this->Form->create('Image', array('action' => 'crop')); ?>

<? 
if (!empty($images)) {
    foreach ($images as $id_img => $img){
        echo $this->Crop->ThumbInterface($img, $id_img, $image_directory);
    }
}
?>
<?= $this->Form->end('Create thumb');?>
