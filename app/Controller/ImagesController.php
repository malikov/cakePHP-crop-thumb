<?
class ImagesController extends AppController{
    public $components = array('Crop'); 

    public function beforeFilter() {
        $this->Crop->image_directory = 'files'; //image thumbs folder, 
        //has to be in your webroot, has to be same folder of the orginal image file
        $this->Crop->quality = 90; // 0 for no compression at all, 100 for the best quality compression
    }

    public function crop(){
        $this->helpers[]= 'Crop';

        if (empty($this->request->data)) {
            $images = array(
                        array(
                            'original_path' => 'dock.jpg',
                            'append_to_path' => 'thumb_medium',//name to append to the original one
                            'thumb_width' => '300',//desidered thumb width
                            'thumb_height' => '300',//desidered thumb height
                        ),
                        array(
                            'original_path' => 'desert.jpg',
                            'append_to_path' => 'thumb',//name to append to the original one
                            'thumb_width' => '100',//desidered thumb width
                            'thumb_height' => '300',//desidered thumb height
                        )

            );
            $this->set('images', $images);
            $this->set('image_directory', $this->Crop->image_directory);
        } else {
            foreach($this->request->data['Image'] as $id => $img){
                if (!$this->Crop->create_thumb($img)) {
			        $this->Session->setFlash($this->Crop->msg);
                    return false;
                }
            }
			$this->Session->setFlash("Image cropped");
        }
    }

}
?>
