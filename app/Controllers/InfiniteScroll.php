<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class InfiniteScroll extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('infinite_scroll');
    }

    public function fetchData()
    {
        try {
            $contentModel = new \App\Models\ContentModel();
            $perPage = 10;
            $data = [
                'contents' =>$contentModel->paginate(10),
                'pager' => $contentModel->pager->getDetails(),
            ];

            return $this->respond($data, 200);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }
}
