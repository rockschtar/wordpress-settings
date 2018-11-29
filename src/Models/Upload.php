<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Settings\Models;


class Upload extends Field {

    private $upload_button_text = 'Upload';

    private $remove_button_text = 'Remove';

    /**
     * @return string
     */
    public function getUploadButtonText(): string {
        return $this->upload_button_text;
    }

    /**
     * @param string $upload_button_text
     * @return Upload
     */
    public function setUploadButtonText(string $upload_button_text): Upload {
        $this->upload_button_text = $upload_button_text;
        return $this;
    }

    /**
     * @return string
     */
    public function getRemoveButtonText(): string {
        return $this->remove_button_text;
    }

    /**
     * @param string $remove_button_text
     * @return Upload
     */
    public function setRemoveButtonText(string $remove_button_text): Upload {
        $this->remove_button_text = $remove_button_text;
        return $this;
    }

    

}