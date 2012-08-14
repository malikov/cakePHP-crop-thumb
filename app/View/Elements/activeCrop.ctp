<?= $this->Html->scriptBlock("
		$(function() {
			$('.crop".$id_img."').jWindowCrop({
				targetWidth: ".$thumb_width.",
				targetHeight: ".$thumb_height.",
				loadingText: 'loading..',
				onChange: function(result) {
                    $(\"input[name='Image[".$id_img."][crop_x]']\").val(result.cropX);
					$(\"input[name='Image[".$id_img."][crop_y]']\").val(result.cropY);
					$(\"input[name='Image[".$id_img."][crop_w]']\").val(result.cropW);
					$(\"input[name='Image[".$id_img."][crop_h]']\").val(result.cropH);
					$('#".$id_img."crop_x').text(result.cropX);
					$('#".$id_img."crop_y').text(result.cropY);
					$('#".$id_img."crop_w').text(result.cropW);
					$('#".$id_img."crop_h').text(result.cropH);
				}

			});
		});
");?>
