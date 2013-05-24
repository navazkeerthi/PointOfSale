<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_groupsCI extends CI_Controller{
    function __construct() {
                parent::__construct();
                $this->load->helper('form');
                $this->load->helper('url');
                $this->load->library('unit_test');
                session_start();        
                $this->load->library('session');
                $this->load->helper(array('form', 'url'));
                $this->load->library('poslanguage'); 
                $this->load->library('form_validation');
                $this->poslanguage->set_language();
    }
    function index(){
        if(!isset($_SESSION['Uid'])){
                $this->load->view('template/header');
                $this->load->view('login');
                $this->load->view('template/footer');
        }else{
                $this->get_user_groups();
        }
    }
    function get_user_groups(){
        if($_SESSION['admin']==2){
            $this->load->model('user_groups');            
            $this->load->model('branch');
                $this->load->library("pagination");                
	        $config["base_url"] = base_url()."index.php/user_groupsCI/get_user_groups";
	        $config["total_rows"] = $this->user_groups->get_user_groups_admin_count($_SESSION['Bid']);
	        $config["per_page"] = 5;
	        $config["uri_segment"] = 3;
	        $this->pagination->initialize($config);	 
	        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;               
                $data['count']=$this->user_groups->get_user_groups_admin_count($_SESSION['Bid']);         
	        $data["depa"] = $this->user_groups->get_user_groups_admin_details($config["per_page"],$page,$_SESSION['Bid']);
                $data['branch']=$this->branch->get_branch();
	        $data["links"] = $this->pagination->create_links();                 
                $this->load->view('template/header');
                $this->load->view('user_groups',$data);
                $this->load->view('template/footer');
        }else{
         if($_SESSION['Depa_per']['read']==1){ 
                $this->load->model('user_groups');            
                $this->load->library("pagination"); 
                $this->load->model('branch');
	        $config["base_url"] = base_url()."index.php/user_groupsCI/get_user_groups";
	        $config["total_rows"] = $this->user_groups->get_user_groups_count($_SESSION['Bid']);
	        $config["per_page"] = 5;
	        $config["uri_segment"] = 3;
	        $this->pagination->initialize($config);	 
	        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;               
                $data['count']=$this->user_groups->get_user_groups_count($_SESSION['Bid']);         
	        $data["depa"] = $this->user_groups->get_user_groups_details($config["per_page"], $page,$_SESSION['Bid']);
                $data['all_depa']=$this->user_groups->get_user_groups();
                $data['branch']=$this->branch->get_branch();
	        $data["links"] = $this->pagination->create_links();                 
                $this->load->view('template/header');
                $this->load->view('user_groups',$data);
                $this->load->view('template/footer');
    }
    else{
                echo "Ypu Have No permission to Read user_groups Details";
                redirect('home');
    }}
    }
    function user_groups(){  
        if($this->input->post('back')){
                redirect('home');
        }
        if($this->input->post('add')){
             if($_SESSION['Depa_per']['add']==1){ 
                $this->load->model('branch');               
                $this->load->view('template/header');               
                $this->load->view('add_user_groups');
                $this->load->view('template/footer');
        }
        else{
            echo "you have no permission to add user_groups";
                $this->get_user_groups();
        }}
        if($this->input->post('delete')){
            if($_SESSION['Depa_per']['delete']==1){ 
                $this->delete_selected_user_groups();
             redirect('posmain/user_groups');
        }else{
                echo "You have no permission to delete";
                $this->get_user_groups();
        }    
        }
        if($this->input->post('activate')){
             if($_SESSION['Depa_per']['delete']==1){ 
                   $data1 = $this->input->post('mycheck'); 
                    if(!$data1==''){              
                    $this->load->model('user_groups');             
                    foreach( $data1 as $key => $value){                              
                        $this->user_groups->activate_user_groups($value);          
                 }                     
               }        
             }
             $this->get_user_groups();
        }        
         if($this->input->post('deactivate')){
             if($_SESSION['Depa_per']['delete']==1){ 
                   $data1 = $this->input->post('mycheck'); 
                    if(!$data1==''){              
                    $this->load->model('user_groups');             
                    foreach( $data1 as $key => $value){                              
                        $this->user_groups->deactivate_user_groups($value);          
                 }                     
               }        
             }
             $this->get_user_groups();
        }
       if($this->input->post('delete_admin')){
            if($_SESSION['Depa_per']['delete']==1){ 
                   $data1 = $this->input->post('mycheck'); 
                    if(!$data1==''){              
                    $this->load->model('user_groups');             
                    foreach( $data1 as $key => $value){                     
                     $this->user_groups->delete_user_groups_for_admin($value);          
                 }                     
               }        
             }
             $this->get_user_groups();
        }
       
    }
    function delete_selected_user_groups(){
         if($_SESSION['Depa_per']['delete']==1){ 
               $data1 = $this->input->post('mycheck'); 
              if(!$data1==''){              
              $this->load->model('user_groups');             
              foreach( $data1 as $key => $value){           
              $this->user_groups_delete($value);            
              }              
              }
         }else{
             echo "You have no permission to delete";
             $this->get_user_groups();
         }
    }    
    function add_user_groups(){
        if($_SESSION['Depa_per']['add']==1){ 
                $this->load->model('user_groups');            
                $this->form_validation->set_rules("user_groups_name",$this->lang->line('user_groups_name'),"required"); 
               // $this->form_validation->set_rules('branchs',$this->lang->line('branch'),"required");
                
           if ($this->form_validation->run()) {
                $this->load->model('branch');
                $depart=$this->input->post('user_groups_name');
             if($this->branch->check_deaprtment_is_already($depart,$_SESSION['Bid'])!=TRUE){
                 
                $id=$this->user_groups->add_user_groups($depart,$_SESSION['Bid']);
                $this->add_user_groups_branch($id,$_SESSION['Bid']);               
                $item_add=  $this->input->post('item_read');
                $item_read=$this->input->post('item_add');
                $item_edit=$this->input->post('item_edit');
                $item_delete=$this->input->post('item_delete');
                $item=$item_add+$item_delete+$item_edit+$item_read;               
                $user_read=$this->input->post('user_read');
                $user_add=$this->input->post('user_add');
                $user_edit=$this->input->post('user_edit');
                $user_delete=$this->input->post('user_delete');
                $user=$user_add+$user_delete+$user_edit+$user_read;               
                $depa_read=$this->input->post('depa_read');
                $depa_add=$this->input->post('depa_add');
                $depa_edit=$this->input->post('depa_edit');
                $depa_delete=$this->input->post('depa_delete');
                $depa=$depa_add+$depa_delete+$depa_edit+$depa_read;                 
                $branch_read=$this->input->post('branch_read');
                $branch_add=$this->input->post('branch_add');
                $branch_edit=$this->input->post('branch_edit');
                $branch_delete=$this->input->post('branch_delete');
                $branch=$branch_add+$branch_delete+$branch_edit+$branch_read;               
                $this->add_permission($item,$depa,$user,$branch,$id,$_SESSION['Bid']);
               redirect('posmain/user_groups');
               
               }else{
                   echo "This is user_groups is already added in this branch";
                $this->load->model('branch');
                $data['branch']=  $this->branch->get_branch();
                $this->load->view('template/header');                
                $this->load->view('add_user_groups',$data);
                $this->load->view('template/footer');
               }
           }else{
                $this->load->model('branch');
                $data['branch']=  $this->branch->get_branch();
                $this->load->view('template/header');                
                $this->load->view('add_user_groups',$data);
                $this->load->view('template/footer');
           }
           
        }
           else{
                echo "You Have No permission to add user_groups";
                $this->get_user_groups();
           }       
           if($this->input->post('cancel')){
                redirect('posmain/user_groups');
           }    
    }
   
    function add_permission($item,$depa,$user,$branch,$depart_id,$branchid){
         if($_SESSION['Depa_per']['add']==1){ 
                $this->load->model('permissions');
                $this->permissions->set_item_permission($item,$depart_id,$branchid);
                $this->permissions->set_user_permission($user,$depart_id,$branchid);
                $this->permissions->set_depart_permission($depa,$depart_id,$branchid);
                $this->permissions->set_branch_permission($branch,$depart_id,$branchid);
            
         }else{
             $this->get_user_groups();
         }
    }
     function add_user_groups_branch($id,$branch){
         if($_SESSION['Depa_per']['add']==1){                 
                $this->load->model('user_groups');                
                $this->user_groups->set_branch_user_groups($id,$branch);                
                }else{
                    $this->get_user_groups();
                }
        }
        function user_groups_delete($id){
            if($_SESSION['Depa_per']['delete']==1){ 
                $this->load->model('user_groups');
                $this->user_groups->delete_user_groups($id);
                //$this->user_groups->delete_item_permission($id);
                //$this->user_groups->delete_user_permission($id);
                //$this->user_groups->delete_branch_permission($id);
                //$this->user_groups->delete_depart_permission($id);
                //$this->user_groups->delete_depart_branch($id);                 
                redirect('user_groupsCI/get_user_groups');
            }else{
                redirect('user_groupsCI/get_user_groups');
            }            
        }
        function delete_user_groups_for_admin($id){
                $this->load->model('user_groups');
                $this->user_groups->delete_user_groups_for_admin($id);
                redirect('user_groupsCI');
        }
        function edit_user_groups($id){
            if($_SESSION['Depa_per']['edit']==1){ 
                 $this->load->model('user_groups');
                 $data['row']=$this->user_groups->get_seleted_user_groups_details($id);
                 $this->load->view('template/header');
                 $this->load->view('edit_user_groups',$data);
                 $this->load->view('template/footer');
            }else{
                echo "you have No permission To Edit user_groups";                
                redirect('user_groupsCI');
            }
        }
        function update_user_groups(){
          if($_SESSION['Depa_per']['edit']==1){ 
                 $this->load->model('user_groups');            
                 $this->form_validation->set_rules("user_groups",$this->lang->line('user_groups_name'),"required");                              
           if ($this->form_validation->run()) {
                 $this->load->model('branch');
                 $depart=$this->input->post('user_groups');
                 $id=$this->input->post('id') ;
             if($this->branch->check_deaprtment_is_already_for_update($depart,$_SESSION['Bid'],$id)!=TRUE){
                 $this->user_groups->update_user_groups($id,$depart);
                 $this->get_user_groups();
             }else{
                 echo "$depart  user_groups is allready added";;
                 $this->edit_user_groups($id);
             }
           }
          }else{
              echo "You ahve no permission to edit user_groups";
          }
          if($this->input->post('cancel')){
              redirect('user_groupsCI');
          }
        }
        function edit_user_groups_permission($id){
            
            if($_SESSION['full_per']==4444){
                 $this->load->model('user_groups');
                 $data['row']=$this->user_groups->get_seleted_user_groups_details($id);
                 $this->load->model('permissions');
                 $data['user']=$this->permissions->get_user_permission($id,$_SESSION['Bid'],$id);
                 $data['item']=$this->permissions->get_item_permission($id,$_SESSION['Bid'],$id);
                 $data['depart']=$this->permissions->get_depart_permission($id,$_SESSION['Bid'],$id);
                 $data['branch']=$this->permissions->get_branch_permission($id,$_SESSION['Bid'],$id);
               
                 $this->load->view('template/header');
                 $this->load->view('edit_user_groups_permission',$data);
                 $this->load->view('template/footer');
            }else{
                echo "You have no permission to edit User permissions";
               
                redirect('user_groupsCI');
            }
        }
        function update_user_groups_permission(){
            if($this->input->post('cancel')){
                $this->get_user_groups();
            }
            if($this->input->post('update')){
                $item_add=  $this->input->post('item_read');
                $item_read=$this->input->post('item_add');
                $item_edit=$this->input->post('item_edit');
                $item_delete=$this->input->post('item_delete');
                $item=$item_add+$item_delete+$item_edit+$item_read;               
                $user_read=$this->input->post('user_read');
                $user_add=$this->input->post('user_add');
                $user_edit=$this->input->post('user_edit');
                $user_delete=$this->input->post('user_delete');
                $user=$user_add+$user_delete+$user_edit+$user_read;               
                $depa_read=$this->input->post('depa_read');
                $depa_add=$this->input->post('depa_add');
                $depa_edit=$this->input->post('depa_edit');
                $depa_delete=$this->input->post('depa_delete');
                $depa=$depa_add+$depa_delete+$depa_edit+$depa_read;                 
                $branch_read=$this->input->post('branch_read');
                $branch_add=$this->input->post('branch_add');
                $branch_edit=$this->input->post('branch_edit');
                $branch_delete=$this->input->post('branch_delete');
                $branch=$branch_add+$branch_delete+$branch_edit+$branch_read;  
                $id=$this->input->post('id');
                $this->update_permission($item,$user,$depa,$branch,$id,$_SESSION['Bid']);
                $this->get_user_groups();
            }
        }
        function update_permission($item,$user,$depa,$branch,$depart_id,$branchid){
                $this->load->model('permissions');
                $this->permissions->update_item_permission($item,$depart_id,$branchid);
                $this->permissions->update_user_permission($user,$depart_id,$branchid);
                $this->permissions->update_depart_permission($depa,$depart_id,$branchid);
                $this->permissions->update_branch_permission($branch,$depart_id,$branchid);
        }
        function to_activate_user_groups($id){
                $this->load->model('user_groups');
                $this->user_groups->activate_user_groups($id);   
                redirect('user_groupsCI');
        }
        function  to_deactivate_user_groups($id){
                $this->load->model('user_groups');
                $this->user_groups->deactivate_user_groups($id);
                redirect('user_groupsCI');
        }
}
?>