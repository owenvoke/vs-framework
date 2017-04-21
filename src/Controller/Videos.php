<?php

namespace VS\Controller;

use VS\Routing\Router;
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

    public function show()
    {
        if (!$this->args['hash']) {
            Router::redirect();
        }
        $data = new \stdClass();
        $data->video = new Video($this->args['hash']);

        if (!$data->video->id) {
            $data->video = false;
        }
        $this->smarty->display(
            'videos/show.tpl',
            [
                'data' => $data
            ]
        );
    }

    public function display()
    {
        if (!$this->args['hash']) {
            Router::redirect();
        }
        $data = new Video($this->args['hash']);
        $file_path = ROOT_PATH . 'uploads' . DS . $data->hash . '.' . $data->file_type;

        if (file_exists($file_path)) {
            $video = fopen($file_path, 'rb');

            header("Content-Type: " . mime_content_type($file_path));
            header("Content-Length: " . filesize($file_path));

            fpassthru($video);
        }
    }

    public function thumb()
    {
        if (!$this->args['hash']) {
            Router::redirect();
        }
        $data = new Video($this->args['hash']);
        $file_path = ROOT_PATH . 'uploads' . DS . $data->hash . '.jpg';

        if (file_exists($file_path)) {
            $thumb = fopen($file_path, 'rb');

            header("Content-Type: image/jpeg");
            header("Content-Length: " . filesize($file_path));

            fpassthru($thumb);
        }
    }
}