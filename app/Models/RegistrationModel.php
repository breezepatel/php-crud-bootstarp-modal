<?php 
  
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
   
class RegistrationModel extends Model
{
    // protected $table = 'task1';
   
    // protected $allowedFields = ['first_name','last_name','address'];

    protected $table = 'task1';
    protected $allowedFields = ['name','age','gender','number','email'];
      
    public function __construct() {
        parent::__construct();
        //$this->load->database();
        $db = \Config\Database::connect();
        $builder = $db->table('users');
    }
      
    public function insert_data($data) {
        if($this->db->table($this->table)->insert($data))
        {
            return $this->db->insertID();
        }
        else
        {
            return false;
        }
    }
}