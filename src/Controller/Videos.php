<?php

namespace VS\Controller;

use VS\User\Account;
use VS\Videos\Video;

class Videos extends Controller
{
    public function upload()
    {
        $data = new \stdClass();
        $data->can_upload = Account::auth();

        $data->title = $this->body['title'] ?? '';
        $data->description = $this->body['description'] ?? '';
        $data->category = (int)$data->category = $this->body['category'] ?? 1;
        $data->file = $this->files['video'] ?? [];
        $data->response = false;

        // Fetch category array of objects
        $data->categories = Video::categories();

        if ($data->title != '' && !empty($data->file)) {
            $data->response = Video::upload($data);
        }

        $this->smarty->display(
            'videos/upload.tpl',
            [
                'data' => $data
            ]
        );
    }
}