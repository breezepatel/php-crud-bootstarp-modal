<?php

namespace App\Controllers;

use App\Models\RegistrationModel;
use CodeIgniter\Controller;

class main extends BaseController
{

    public function index()
    {
        $model = new RegistrationModel();

        $data['users_detail'] = $model->orderBy('id', 'DESC')->findAll();

        return view('list', $data);
    }

    public function create() {

        $session = \Config\Services::session();
        helper('form');

        $data = [];

        if ($this->request->getPost()){

            $input = $this->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'age' => 'required|less_than[100]|greater_than[0]',
                'gender' => 'required',
                'number' => 'required|exact_length[10]',
                'email' => 'required|valid_email',
            ]);

            if ($input == true) {
                // Form validated successfully, so we can save values to database
                $model = new RegistrationModel();

                $model->save([
                    'first_name' => $this->request->getPost('first_name'),
                    'last_name' => $this->request->getPost('last_name'),
                    'age' => $this->request->getPost('age'),
                    'gender' => $this->request->getPost('gender'),
                    'number' => $this->request->getPost('number'),
                    'email' => $this->request->getPost('email')
                ]);

               $session->setFlashdata('success','Record hass been successfully .');

                return redirect()->to('/main');

            } else {
                // Form not validated successfully
                $data['validation'] = $this->validator;
            }
        }
        return view('create',$data);
    }


    public function edit($id = null)
    {

        $model = new RegistrationModel();

        $data = $model->where('id', $id)->first();

        if ($data) {
            echo json_encode(array("status" => true, 'data' => $data));
        } else {
            echo json_encode(array("status" => false));
        }
    }

    public function update()
    {

        helper(['form', 'url']);

        $model = new RegistrationModel();

        $id = $this->request->getVar('hdnuserId');

        $data = [
            'first_name' => $this->request->getVar('txtFirstName'),
            'last_name'  => $this->request->getVar('txtLastName'),
            'email'  => $this->request->getVar('txtEmailAddress'),
            'age'  => $this->request->getVar('txtAge'),
            'gender'  => $this->request->getVar('txtGender'),
            'number'  => $this->request->getVar('txtNumber'),
        ];

        $update = $model->update($id, $data);

        if ($update != false) {
            $data = $model->where('id', $id)->first();
            echo json_encode(array("status" => true, 'data' => $data));
        } else {
            echo json_encode(array("status" => false, 'data' => $data));
        }
    }

    public function delete($id = null)
    {
        $model = new RegistrationModel();
        $delete = $model->where('id', $id)->delete();

        if ($delete) {
            echo json_encode(array("status" => true));
        } else {
            echo json_encode(array("status" => false));
        }
    }
}
