<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_groups extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    function get_user_groups(){
        $this->db->select()->from('user_groups');
        $sql=$this->db->get();
        return $sql->result(); 
    }
    function set_user_groups($id,$depa_id,$branch_id){
        $this->db->select()->from('user_groups')->where('id',$depa_id);
            $sql=$this->db->get();
            foreach ($sql->result() as $row) {
                $name= $row->dep_name ;
            }
        $data=array('emp_id'=>$id,
                    'depart_name'=>$name,
                    'depart_id'=>$depa_id,
                    'branch_id'=>$branch_id);
                $this->db->insert('users_X_user_groups',$data);
    }
    function get_user_depart($id){
        $this->db->select()->from('users_X_user_groups')->where('emp_id',$id);
        $sql=  $this->db->get();
       
            return $sql->result();
    }
    function get_all_user_depart($id){
        $this->db->select()->from('users_X_user_groups')->where('emp_id',$id);
        $sql=  $this->db->get();
        $j=0;
        foreach ($sql->result() as $row)
            {
                
             $data[$j] = $row->depart_name;
             $j++;
            }
            return $data;
    }
    function get_all_user_groupsg(){
        $this->db->select()->from('user_groups');
        $sql=  $this->db->get();
        $j=0;
        foreach ($sql->result() as $row)
            {
                
             $data[$j] = $row->dep_name;
             $j++;
            }
            return $data;
    
}
function delete_user_depart($id){
    $this->db->where('emp_id',$id);
    $this->db->delete('users_X_user_groups');
}
function get_user_groups_count($branch){
   $this->db->where('branch_id',$branch);
   $this->db->where('active_status',0);
   $this->db->from('user_groups_X_branchs');
   return $this->db->count_all_results();
}
 public function get_user_groups_details($limit,$start,$brnch) {
        $this->db->limit($limit, $start);  
        $this->db->where('branch_id',$brnch);
        $this->db->where('active_status',0);
        $query = $this->db->get('user_groups_X_branchs');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
           }          
   }
   function get_user_groups_admin_count($branch){
            $this->db->where('branch_id ',$branch);
            $this->db->where('delete_status',0);
            $this->db->from('user_groups');
            return $this->db->count_all_results();
   }
   function get_user_groups_admin_details($limit,$start,$branch){
       $this->db->limit($limit, $start); 
       $this->db->where('delete_status',0);
       $this->db->where('branch_id ',$branch);
        $query = $this->db->get('user_groups');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
           }
   }
   function  add_user_groups($depart,$bid){
       $data=array('dep_name'=>$depart,
                   'branch_id'=>$bid
           );
       $this->db->insert('user_groups',$data);
        $id=$this->db->insert_id();
       return $id;
   }
   function set_branch_user_groups($id,$branch_id){
       $data=array('branch_id'=>$branch_id,
                    'user_group_id'=>$id);
                $this->db->insert('user_groups_X_branchs',$data);
   }
   function delete_user_groups($id){
       $data=array('active_status'=>1);
       $this->db->where('id',$id);             
       $this->db->update('user_groups',$data);
       $this->db->where('depart_id',$id);             
       $this->db->update('users_X_user_groups',$data);
       $this->db->where('user_group_id ',$id);             
       $this->db->update('user_groups_X_branchs',$data);
             
   }
   function delete_item_permission($id){
        $this->db->where('depart_id',$id);
        $this->db->delete('item_X_page_permissions');
   }
   function delete_user_permission($id){
        $this->db->where('depart_id',$id);        
        $this->db->delete('user_X_page_X_permissions');
   }
   function delete_branch_permission($id){
        $this->db->where('depart_id',$id);        
        $this->db->delete('branch_per');
   }
    function delete_depart_permission($id){
        $this->db->where('depart_id',$id);        
        $this->db->delete('user_groups_X_page_X_permissions');
   }
   function delete_depart_branch($id){
       $this->db->where('user_group_id',$id);
       $this->db->delete('user_groups_X_branchs');
   }
   function get_user_deprtment($id){
       $this->db->select()->from('user_groups_X_branchs')->where('branch_id',$id);
        $sql=  $this->db->get();
        $j=0;
        foreach ($sql->result() as $row) {
                $this->db->select()->from('user_groups')->where('id',$row->user_group_id);
                $sql=  $this->db->get();
              
                foreach ($sql->result() as $row) {            
             $data[$j] = $row->dep_name  ;
            
            } $j++;
        }
            return $data;
       
   }
   function get_user_deprtment_id($id){
       $this->db->select()->from('user_groups_X_branchs')->where('branch_id',$id);
        $sql=  $this->db->get();
        $j=0;
        foreach ($sql->result() as $row) {
                $this->db->select()->from('user_groups')->where('id',$row->user_group_id);
                $sql=  $this->db->get();
              
                foreach ($sql->result() as $row) {            
             $data[$j] = $row->id  ;
            
            } $j++;
        }
            return $data;
       
   }
   function get_user_seleted_depa($d_id){
       $this->db->select()->from('user_groups')->where('id',$d_id);
                $sql=  $this->db->get();              
                foreach ($sql->result() as $row) {            
             $data = $row->dep_name  ;            
            }
            return $data;
   }
   function get_seleted_user_groups_details($id){
       $this->db->select()->from('user_groups')->where('id',$id);
       $sql=$this->db->get();
       return $sql->result();
   }
    function update_user_groups($id,$depart){
       $data=array('dep_name'=>$depart);
       $this->db->where('id',$id);
       $this->db->update('user_groups',$data);       
       $value=array('depart_name'=>$depart);
       $this->db->where('depart_id',$id);
       $this->db->update('users_X_user_groups',$value);
   }
   function activate_user_groups($id){
       $data=array('active_status'=>0);
       $this->db->where('id',$id);             
       $this->db->update('user_groups',$data);
       $this->db->where('depart_id',$id);             
       $this->db->update('users_X_user_groups',$data);
       $this->db->where('user_group_id ',$id);             
       $this->db->update('user_groups_X_branchs',$data);
   }
   function deactivate_user_groups($id){
        $data=array('active_status'=>1);
       $this->db->where('id',$id);             
       $this->db->update('user_groups',$data);
       $this->db->where('depart_id',$id);             
       $this->db->update('users_X_user_groups',$data);
       $this->db->where('user_group_id ',$id);             
       $this->db->update('user_groups_X_branchs',$data);
   }
   function delete_user_groups_for_admin($id){
       $data=array('delete_status'=>1,'active_status'=>1);
       $this->db->where('id',$id);             
       $this->db->update('user_groups',$data);
       $this->db->where('depart_id',$id);             
       $this->db->update('users_X_user_groups',$data);
       $this->db->where('user_group_id ',$id);             
       $this->db->update('user_groups_X_branchs',$data);
   }
}
?>
