<?php
class Employeepermission extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    function item_permission_employee($id){
        
        $this->db->select()->from('itempermission')->where('id',$id);
        $sql=$this->db->get();
        return $sql->result();
        
     }
      function emp_permission_employee($id){
        
        $this->db->select()->from('employeepermission')->where('id',$id);
        $sql=$this->db->get();
       
        return $sql->result();
     }
      function edit_employee($id){
       $this->db->select()->from('employeedetails')->where('id',$id);
        $sql=$this->db->get();
       
        return $sql->result();
   }
   function update_permission($item,$emp,$id){
       $item_per=array('permission'=>$item);
        $emp_per=array('permission'=>$emp);
        $this->db->where('emp_id',$id);
        $this->db->update('itempermission',$item_per);
        $this->db->where('emp_id',$id);
        $this->db->update('employeepermission',$emp_per);
   }
    function adda_default_permission($id){
          $item_per=array('permission'=>'0000','emp_id'=>$id);
          $emp_per=array('permission'=>'0000','emp_id'=>$id);
          $this->db->insert('itempermission',$item_per);
        
          $this->db->insert('employeepermission',$emp_per);
        
    }
    
}
?>
