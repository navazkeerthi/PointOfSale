<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Permissions extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    function set_item_permission($item,$depart_id,$branch_id){
        $data=array('permission'=>$item,
                    'depart_id'=>$depart_id,
                    'branch_id'=>$branch_id);
        $this->db->insert('item_x_page_permissions',$data);
        
    }
    function set_user_permission($item,$depart_id,$branch_id){
        $data=array('permission'=>$item,
                    'depart_id'=>$depart_id,
                    'branch_id'=>$branch_id);
        $this->db->insert('user_x_page_x_permissions',$data);
        
    }
    function set_depart_permission($item,$depart_id,$branch_id){
        $data=array('permission'=>$item,
                    'depart_id'=>$depart_id,
                    'branch_id'=>$branch_id);
        $this->db->insert('user_groups_x_page_x_permissions',$data);
        
    }
     function set_branch_permission($item,$depart_id,$branch_id){
        $data=array('permission'=>$item,
                    'depart_id'=>$depart_id,
                    'branch_id'=>$branch_id);
        $this->db->insert('branch_x_page_x_permissions',$data);
        
    }
    function set_supplier_permission($item,$depart_id,$branch_id){
        $data=array('permission'=>$item,
                    'depart_id'=>$depart_id,
                    'branch_id'=>$branch_id);
        $this->db->insert('suppliers_x_page_permissions',$data);
        
    }
    function set_customer_permission($item,$depart_id,$branch_id){
        $data=array('permission'=>$item,
                    'depart_id'=>$depart_id,
                    'branch_id'=>$branch_id);
        $this->db->insert('customers_x_page_x_permissions',$data);
        
    }
    function set_item_kites_permission($item,$depart_id,$branch_id){
        $data=array('permission'=>$item,
                    'depart_id'=>$depart_id,
                    'branch_id'=>$branch_id);
        $this->db->insert('items_kits_x_page_x_permissions',$data);
        
    }
    function set_sales_permission($item,$depart_id,$branch_id){
        $data=array('permission'=>$item,
                    'depart_id'=>$depart_id,
                    'branch_id'=>$branch_id);
        $this->db->insert('sales_x_page_x_permission',$data);
        
    }
    
    function update_item_permission($item,$depart_id,$branch_id){
        $data=array('permission'=>$item);
        $this->db->where('depart_id ',$depart_id)->where('branch_id',$branch_id); 
        $this->db->update('item_x_page_permissions',$data);
        
    }
    function update_user_permission($item,$depart_id,$branch_id){
        $data=array('permission'=>$item);
        $this->db->where('depart_id ',$depart_id)->where('branch_id',$branch_id); 
        $this->db->update('user_x_page_x_permissions',$data);
        
    }
    function update_depart_permission($item,$depart_id,$branch_id){
        $data=array('permission'=>$item);
        $this->db->where('depart_id ',$depart_id)->where('branch_id',$branch_id); 
        $this->db->update('user_groups_x_page_x_permissions',$data);
        
    }
     function update_branch_permission($item,$depart_id,$branch_id){
        $data=array('permission'=>$item);
        $this->db->where('depart_id ',$depart_id)->where('branch_id',$branch_id); 
        $this->db->update('branch_x_page_x_permissions',$data);
        
    }
    function update_supplier_permission($item,$depart_id,$branch_id){
        $data=array('permission'=>$item);
        $this->db->where('depart_id ',$depart_id)->where('branch_id',$branch_id); 
        $this->db->update('suppliers_x_page_permissions',$data);
        
    }
    function update_customer_permission($item,$depart_id,$branch_id){
        $data=array('permission'=>$item);
        $this->db->where('depart_id ',$depart_id)->where('branch_id',$branch_id); 
        $this->db->update('customers_x_page_x_permissions',$data);
        
    }
    function update_item_kites_permission($item,$depart_id,$branch_id){
        $data=array('permission'=>$item);
        $this->db->where('depart_id ',$depart_id)->where('branch_id',$branch_id); 
        $this->db->update('items_kits_x_page_x_permissions',$data);
        
    }
    function update_sales_permission($item,$depart_id,$branch_id){
        $data=array('permission'=>$item);
        $this->db->where('depart_id ',$depart_id)->where('branch_id',$branch_id); 
        $this->db->update('sales_x_page_x_permission',$data);
        
    }
    
    function get_user_permission($id,$bid){
         $this->db->select()->from('user_x_page_x_permissions')->where('depart_id ',$id)->where('branch_id',$bid); 	 
                $sql=  $this->db->get();              
                foreach ($sql->result() as $row) {            
                $data = $row->permission    ;            
            } 
            return $data; 
    }
    function get_item_permission($id,$bid){
         $this->db->select()->from('item_x_page_permissions')->where('depart_id ',$id)->where('branch_id',$bid); 	 
                $sql=  $this->db->get();              
                foreach ($sql->result() as $row) {            
                $data = $row->permission    ;            
            } 
                return $data; 
    }
    function get_depart_permission($id,$bid){
         $this->db->select()->from('user_groups_x_page_x_permissions')->where('depart_id ',$id)->where('branch_id',$bid); 	 
                $sql=  $this->db->get();              
                foreach ($sql->result() as $row) {            
                $data = $row->permission    ;            
            } 
                return $data; 
    }
    function get_branch_permission($id,$bid){
         $this->db->select()->from('branch_x_page_x_permissions')->where('depart_id ',$id)->where('branch_id',$bid); 	 
                $sql=  $this->db->get();              
                foreach ($sql->result() as $row) {            
                $data = $row->permission    ;            
            } 
                return $data; 
    }
    function get_supplier_permissions($id,$bid){
         $this->db->select()->from('suppliers_x_page_permissions')->where('depart_id ',$id)->where('branch_id',$bid); 	 
                $sql=  $this->db->get();              
                foreach ($sql->result() as $row) {            
                $data = $row->permission    ;            
            } 
                return $data; 
    }
    function get_customer_permission($id,$bid){
         $this->db->select()->from('customers_x_page_x_permissions')->where('depart_id ',$id)->where('branch_id',$bid); 	 
                $sql=  $this->db->get();              
                foreach ($sql->result() as $row) {            
                $data = $row->permission    ;            
            } 
                return $data; 
    }
    function get_item_kites_permission($id,$bid){
         $this->db->select()->from('items_kits_x_page_x_permissions')->where('depart_id ',$id)->where('branch_id',$bid); 	 
                $sql=  $this->db->get();              
                foreach ($sql->result() as $row) {            
                $data = $row->permission    ;            
            } 
                return $data; 
    }
    function get_sales_permission($id,$bid){
         $this->db->select()->from('sales_x_page_x_permission')->where('depart_id ',$id)->where('branch_id',$bid); 	 
                $sql=  $this->db->get();              
                foreach ($sql->result() as $row) {            
                $data = $row->permission    ;            
            } 
                return $data; 
    }
}
?>
