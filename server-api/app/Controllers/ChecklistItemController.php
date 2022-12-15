<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

use App\Models\ChecklistItemModel;

class ChecklistItemController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    protected $checklist;
    public function __construct()
    {
        $this->checklistitem = new ChecklistItemModel();
    }
    public function index()
    {
        $data = [
            'status' => true,
            'error' => null,
            'data' => $this->checklistitem->findAll()
        ];

        return $this->respond($data, 200);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $data = [
            'status' => true,
            'error' => null,
            'data' => $this->checklistitem->find($id)
        ];

        return $this->respond($data, 200);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $data = [
            'itemName' => $this->request->getVar('nameitem')
        ];

        $this->checklistitem->save($data);

        $response = [
            'status' => true,
            'error' => null,
            'messages' => [
                'success' => 'Berhasil menambah data'
            ]
        ];

        return $this->respondCreated($response);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $result = $this->checklist->find($id);
        if ($result) {
            $data = $this->request->getRawInput();
            $data['id'] = $id;
            $this->checklistitem->save($data);

            $response = [
                'status' => true,
                'error' => null,
                'messages' => [
                    'success' => 'Berhasil mengubah data'
                ]
            ];

            return $this->respondUpdated($response);
        } else {
            return $this->failNotFound("Tidak ditemukan ID : " . $id);
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $result = $this->checklistitem->find($id);
        if ($result) {
            $this->checklistitem->delete($id);
            $response = [
                'status' => true,
                'error' => null,
                'message' => [
                    'success' => 'Berhasil menghapus data dengan id: ' . $id
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Tidak ditemukan id: ' . $id);
        }
    }
}
