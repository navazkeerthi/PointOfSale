<?php class item_brands extends CI_Model{
     function __construct() {
         parent::__construct();
     }
     function brands_count_for_admin($bid){
            $this->db->where('delete_status',0);        
            $this->db->where('branch_id',$bid);         
            $this->db->from('brands');
            return $this->db->count_all_results();         
     }
     function get_brands_for_admin($limit, $start,$bid){
                $this->db->limit($limit, $start);            
                $this->db->where('delete_status',0);               
                $this->db->where('branch_id',$bid); 
                $query = $this->db->get('brands');
                return $query->result();
     }
     function get_brands($id){
         $this->db->select()->from('brands')->where('id',$id);
         $sql=  $this->db->get();
         return $sql->result();                 
     }
     function check_brands($name,$bid){
         $this->db->select()->from('brands')->where('branch_id',$bid)->where('name',$name)->where('delete_status',0);
         $sql=  $this->db->get();
         if($sql->num_rows()>0){
             return FALSE;
         }else{
             return TRUE;
         }
     }
     function update_brands($id,$name){
         $data=array('name'=>$name);
         $this->db->where('id',$id);
         $this->db->update('brands',$data);
     }
     
}
?>