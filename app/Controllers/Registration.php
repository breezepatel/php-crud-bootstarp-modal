<?php 
namespace App\Controllers;

use App\Models\RegistrationModel;
use CodeIgniter\Controller;
   
class Registration extends BaseController
{
   
    public function index()
    {    
        $model = new RegistrationModel();
   
        $data['users_detail'] = $model->orderBy('id', 'DESC')->findAll();
          
        return view('list', $data);
    }    
  
   
    public function store()
    {  
        helper(['form', 'url']);
           
        $model = new RegistrationModel();
          
        $data = [
            'first_name' => $this->request->getVar('txtFirstName'),
            'last_name'  => $this->request->getVar('txtLastName'),
            'email'  => $this->request->getVar('txtEmailAddress'),
            'age'  => $this->request->getVar('txtAge'),
            'number'  => $this->request->getVar('txtNumber'),
            ];
        $save = $model->insert_data($data);

        if($save != false)
        {
            $data = $model->where('id', $save)->first();
            echo json_encode(array("status" => true , 'data' => $data));
        }
        else{
            echo json_encode(array("status" => false , 'data' => $data));
        }
    }
   

    public function edit($id = null)
    {
        
     $model = new RegistrationModel();
      
     $data = $model->where('id', $id)->first();
       
    if($data){
            echo json_encode(array("status" => true , 'data' => $data));
        }else{
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
            'number'  => $this->request->getVar('txtNumber'),
            ];
  
        $update = $model->update($id,$data);

        if($update != false)
        {
            $data = $model->where('id', $id)->first();
            echo json_encode(array("status" => true , 'data' => $data));
        }
        else{
            echo json_encode(array("status" => false , 'data' => $data));
        }
    }
   
    public function delete($id = null){
        $model = new RegistrationModel();
        $delete = $model->where('id', $id)->delete();
        
        if($delete)
        {
           echo json_encode(array("status" => true));
        }else{
           echo json_encode(array("status" => false));
        }
    }
}
  
?>