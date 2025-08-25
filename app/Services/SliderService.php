<?php 

namespace App\Services;

use App\Traits\UploadPhotos;


class SliderService{
    use UploadPhotos;
    public function deleteExistingSliderImage($existing_array, $new_array){
        $existing_array_of_image = array_column($existing_array, 'image') ?? [];
        if ($existing_array_of_image) {
            $new_upload = array_filter(array_column($new_array ?? [], 'image'));
            foreach ($existing_array_of_image as $slide) {
                if(isset($slide) && $slide !== ''){
                    if (!in_array($slide, $new_upload)) {
                        $this->deleteImage($slide);
                    }
                }
            }
        }
    }

    public function generateSliderArray($sliders){
        foreach($sliders ?? [] as $item){
            $item = (object)$item;
            
            $image = isset($item->image) && is_file($item->image) ? imageUpload($item->image) : "";

            $data[] = [
                'image' => is_file($item->image) ? $image : $item->image,
                'description' => $item->description,
                'position' => $item->position,
                'text' => $item->text,
                'link' => $item->link,
            ];
        }

        return $data ?? [];
    }
}