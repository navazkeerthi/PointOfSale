<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pos_users extends CI_Controller{
     
    function __construct() {
       
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('unit_test');
        session_start();        
        $this->load->helper(array('form', 'url'));
        $this->load->library('poslanguage');                 
        $this->poslanguage->set_language();
    }
    function index(){
        $this->load->library('poslanguage');                 
        $this->poslanguage->set_language();
        $this->get_pos_users_details();
        
       // $this->pos_users_testing();
    } 
    function pos_users_testing(){
         $this->load->model('pos_users_model');
        $test= $this->pos_users_model->get();
  
          $expected_result ='is_true';

        $test_name = 'Adds one plus one';
       
        $this->unit->run($test, $expected_result, $test_name);
      return $this->unit->report();
        
        
        
    }
    function get_pos_users_details(){
         if($_SESSION['admin']==2){
             $this->load->helper("url");
                $this->load->model('pos_users_model');
                $this->load->model('branch');                  
                $this->load->library("pagination"); 
	        $config["base_url"] = base_url()."index.php/pos_users/get_pos_users_details";
	        $config["total_rows"] = $this->pos_users_model->pos_users_count_for_admin($_SESSION['Bid']);
	        $config["per_page"] = 8;
	        $config["uri_segment"] = 3;
	        $this->pagination->initialize($config);	 
	        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                $data['branch']=$this->branch->get_selected_branch_for_view();
                $data['count']=$this->pos_users_model->pos_users_count_for_admin($_SESSION['Bid']);         
	        $data["row"] = $this->pos_users_model->get_pos_users_details_for_admin($config["per_page"], $page,$_SESSION['Bid']);
                $data['urow']= $this->pos_users_model->get_branch_pos_users_for_admin();
	        $data["links"] = $this->pagination->create_links(); 
                
                $this->load->view('template/header');
                $this->load->view('pos_users_list',$data);
                $this->load->view('template/footer');
         }else{
        if($_SESSION['user_per']['read']==1){ 
                $this->load->helper("url");
                $this->load->model('pos_users_model');
                $this->load->model('branch');                   
                $this->load->library("pagination"); 
	        $config["base_url"] = base_url()."index.php/pos_users/get_pos_users_details";
	        $config["total_rows"] = $this->pos_users_model->pos_users_count($_SESSION['Uid'],$_SESSION['Bid']);
	        $config["per_page"] = 8;
	        $config["uri_segment"] = 3;
	        $this->pagination->initialize($config);	 
	        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                $data['branch']=$this->branch->get_selected_branch_for_user_view();
                $data['count']=$this->pos_users_model->pos_users_count($_SESSION['Uid'],$_SESSION['Bid']);             
	        $data["row"] = $this->pos_users_model->get_pos_users_details($config["per_page"], $page,$_SESSION['Uid'],$_SESSION['Bid']);
                $data['urow']=$this->pos_users_model->get_user_details_for_user($_SESSION['Uid']);
	        $data["links"] = $this->pagination->create_links(); 
                
                $this->load->view('template/header');
                $this->load->view('pos_users_list',$data);
                $this->load->view('template/footer');
        }else{
            redirect('home');
        }}
    }
    function edit_pos_users_details($id){
        if($_SESSION['user_per']['edit']==1){ 
                $this->load->model('pos_users_model');
                $this->load->model('branch');
                $this->load->model('user_groups');
                $data['row']=  $this->pos_users_model->edit_pos_users($id); 
                $data['error']="";
                $data['file_name']="null";
                $data['selected_branch']=$this->branch->get_selected_branch($id);
                $data['selected_depart']=$this->user_groups->get_user_depart($id);
                
                $data['branch']= $this->branch->get_user_for_branch($_SESSION['Uid']);
                $data['depa']= $this->user_groups->get_user_groups(); 
                $this->load->view('template/header');
                $this->load->view('edit_pos_users_details',$data);
                $this->load->view('template/footer');
               
        }else{
            echo "You have No permission to Edit users";
            redirect('pos_users/get_pos_users_details');
        }
    }
     function get_selected_branchs($depart,$id){
        $this->load->model('branch');
        $new_depa=array();
        $o=0;
        $w = 0;
        $departed=$this->branch->get_user_branch($id);
        $arr=array_merge($depart,$departed);

                $len = count($arr);
        for ($i = 0; $i < $len; $i++) {
        $temp = $arr[$i];
        $j = $i;
        for ($k = 0; $k < $len; $k++) {
            if ($k != $j) {
            if ($temp == $arr[$k]) {
               
                $arr[$k]=" ";
                $arr[$i]=" ";
            }
            }
        }
        }
      $r=0;
        for ($i = 0; $i < $len; $i++) {
       if($arr[$i]==" "){
           
       }
       else{
           $new_depa[$r]=$arr[$i];
           $r++;
       }
        }
        return $new_depa;
           
    }
    function get_selected_user_groups($depart,$id){
        $this->load->model('user_groups');
        $new_depa=array();
        $o=0;
        $w = 0;
        $departed=$this->user_groups->get_all_user_depart($id);
        $arr=array_merge($depart,$departed);

                $len = count($arr);
        for ($i = 0; $i < $len; $i++) {
        $temp = $arr[$i];
        $j = $i;
        for ($k = 0; $k < $len; $k++) {
            if ($k != $j) {
            if ($temp == $arr[$k]) {
               
                $arr[$k]=" ";
                $arr[$i]=" ";
            }
            }
        }
        }
$r=0;
        for ($i = 0; $i < $len; $i++) {
       if($arr[$i]==" "){
           
       }
       else{
           $new_depa[$r]=$arr[$i];
           $r++;
       }
        }
        return $new_depa;
           
    }
    
    function cancel(){
        $this->get_pos_users_details();
    }
    function upadate_pos_users_details(){
       if($_SESSION['user_per']['edit']==1){ 
       $this->load->library('form_validation');
                $this->form_validation->set_rules("first_name",$this->lang->line('first_name'),"required"); 
                $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'required|max_length[10]|regex_match[/^[0-9]+$/]|xss_clean');
                $this->form_validation->set_rules('age', $this->lang->line('age'), 'required|max_length[2]|regex_match[/^[0-9]+$/]|xss_clean');
                $this->form_validation->set_rules("last_name",$this->lang->line('last_name'),"required"); 
                $this->form_validation->set_rules('email', $this->lang->line('email'), 'valid_email|required');                
                $this->form_validation->set_rules('address',$this->lang->line('address'),"required");
                $this->form_validation->set_rules('city',$this->lang->line('city'),"required");
                $this->form_validation->set_rules('state',$this->lang->line('state'),"required");
                $this->form_validation->set_rules('zip',$this->lang->line('zip'),"required");
                $this->form_validation->set_rules('dob',$this->lang->line('date_of'),"required");                 
                $this->form_validation->set_rules('depa',$this->lang->line('user_groups'),"required");              
                $this->form_validation->set_rules('pos_users_id','pos_users_id',"required");
                $this->form_validation->set_rules('country','Country',"required");
                $id=  $this->input->post('id');	  
	    if ( $this->form_validation->run() !== false ) {
			  $this->load->model('pos_users_model');
                          $first_name=$this->input->post('first_name');
                          $last_name=  $this->input->post('last_name');
                          $email=$this->input->post('email');
			  $emp_id=$this->input->post('pos_users_id');
                          $password=$this->input->post('password');
                          $address=$this->input->post('address');
                          $phone=$this->input->post('phone');
                          $city=$this->input->post('city');
                          $state=$this->input->post('state');
                          $zip=$this->input->post('zip');
                          $country=$this->input->post('country');
                          $user_groups=urldecode($this->input->post('depa'));
                          $yourdatetime =$this->input->post('dob');
                          $image_name=$this->input->post('image_name');
                          $age=  $this->input->post('age');
                          $sex= $this->input->post('sex');                          
                          $dob= strtotime($yourdatetime);                          
                          $this->load->model('pos_users_model');                        
                          $this->pos_users_model->update_pos_users($age,$sex,$id,$first_name,$last_name,$emp_id,$address,$city,$state,$zip,$country,$email,$phone,$dob,$image_name);
                          $this->update_user_user_groups($id,$user_groups);                         
                          $this->update_user_branch($id,$user_groups);                         
                          $this->get_pos_users_details();                                                             
    }else{
        $this->load->model('branch');
        $data['branch']=  $this->branch->get_branch();
        $this->edit_pos_users_details($id);        
        }
       }else{
           echo "You Have No Permission To Edit Users";
           $this->get_pos_users_details();
       }
}
function update_user_branch($id,$depapartment){
   
     $this->load->model('branch');
      $this->branch->delete_user_branchs($id);
              
           $new_depa=array();
           $branch=array();        
           $bid=array();
           $bid = explode(' ',$depapartment);
           $l=0;
           for($i=1;$i<count($bid);$i++){
               $depart=array();
               $depart=explode('.',$bid[$i]);
                        $branch[$l]=$depart[0];
                       $l++;               
               }               
               $arr=$branch;
        $len = count($arr);
        for ($i = 0; $i < $len; $i++) {
        $temp = $arr[$i];
        $j = $i;
        for ($k = 0; $k < $len; $k++) {
            if ($k != $j) {
            if ($temp == $arr[$k]) {               
                $arr[$k]=" ";                
            }
            }
        }
        }
$r=0;
        for ($i = 0; $i < $len; $i++) {
       if($arr[$i]==" "){           
       }
       else{
            $new_depa[$r]=$arr[$i];
           $r++;
       }
        }           
            for($k=0;$k<count($new_depa);$k++)
            {
               $this->branch->set_branch($id,$new_depa[$k]);
            }
}
function update_user_user_groups($id,$depapartment){
     
     $this->load->model('user_groups');
     $this->user_groups->delete_user_depart($id);
     
           $bid=array();
           $bid = explode(' ',$depapartment);
           for($i=1;$i<count($bid);$i++){
               $depart=array();
               $depart=explode('.',$bid[$i]);
                            
               $this->user_groups->set_user_groups($id,$depart[1],$depart[0]);
           }
             

    
}

function do_upload($id)
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
                        $file_name='null';
			$this->after_uploading($id, $error);
		}
		else
		{
                   
                      $upload_data = $this->upload->data();
                       $file_name =$upload_data['file_name'];
                      $error="";
                      $this->after_uploading($id, $error,$file_name);
			
		}
                
	}
        function after_uploading($id,$error,$file_name){
            
                $data['error']=$error;
                $data['file_name']=$file_name;
                $this->load->model('pos_users_model');
                $this->load->model('branch');
                $this->load->model('user_groups');
                $data['row']=  $this->pos_users_model->edit_pos_users($id); 
               
               $data['selected_branch']=$this->branch->get_selected_branch($id);
                $data['selected_depart']=$this->user_groups->get_user_depart($id);
                
                $data['branch']= $this->branch->get_user_for_branch($_SESSION['Uid']);
                $data['depa']= $this->user_groups->get_user_groups(); 
                $this->load->view('template/header');
                $this->load->view('edit_pos_users_details',$data);
                $this->load->view('template/footer');
                
        }
       
        
        function delete_selected_pos_users(){
            if($this->input->post('BacktoHome')){
                redirect('home');
            }
           if($this->input->post('delete_all')){
               if($_SESSION['user_per']['delete']==1){ 
              $data1 = $this->input->post('mycheck'); 
              if(!$data1==''){
              $deleted_by=$_SESSION['Uid'];
              $this->load->model('pos_users_model');
              foreach( $data1 as $key => $value){           
             $this->pos_users_model->delete_pos_users($value,$deleted_by,$_SESSION['Bid']);             
              }              
              }
            $this->get_pos_users_details();
              }else{
                echo "U have No Permission to Delete New User";
                $this->get_pos_users_details();
              }
           }
           if($this->input->post('delete_user_for_admin')){
                 if($_SESSION['admin']==2){ 
              $data1 = $this->input->post('mycheck'); 
              if(!$data1==''){              
              $this->load->model('pos_users_model');
              foreach( $data1 as $key => $value){           
             $this->pos_users_model->delete_pos_users_for_admin($value,$_SESSION['Bid']);             
              }              
              }
            $this->get_pos_users_details();
              }else{
              
               redirect('pos_users');
              }
           }
            if($this->input->post('Add_pos_users')){
                 if($_SESSION['user_per']['add']==1){  
                    $this->load->model('user_groups');
                    $this->load->model('branch');
                     if($_SESSION['admin']==2){ 
                     $data['branch']=$this->branch->get_user_for_branch_admin();
                     }
                     else{
                    $data['branch']= $this->branch->get_user_for_branch($_SESSION['Uid']);
                     }
                    $data['depa']= $this->user_groups->get_user_groups();  
                   
                   // $this->load->view('template/header');
                    $this->load->view('add_new_pos_users',$data);
                    $this->load->view('template/footer');
             
             
             }else{
                 echo "U have No Permission to Add New User";
                $this->get_pos_users_details();
             }
        }
        if($this->input->post('activate')){
             $data1 = $this->input->post('mycheck'); 
              if(!$data1==''){                      
              $this->load->model('pos_users_model');
              foreach( $data1 as $key => $value){                   
                $this->pos_users_model->activate_user($value,$_SESSION['Bid']); 
              }
        }redirect('pos_users');
        }
        if($this->input->post('deactivate')){
             $data1 = $this->input->post('mycheck'); 
              if(!$data1==''){              
              $this->load->model('pos_users_model');
              foreach( $data1 as $key => $value){  
                  $this->pos_users_model->deactivate_user($value,$_SESSION['Bid']); 
              }
        } redirect('pos_users');
        
        }}
        function add_pos_users_details(){
            
           if($_SESSION['user_per']['add']==1){             
      if ($this->input->post('Cancel')) {
             $this->get_pos_users_details(); 
            }
            if ($this->input->post('Save')) {                            
                $this->load->library('form_validation');
                $this->form_validation->set_rules("first_name",$this->lang->line('first_name'),"required"); 
                $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'required|max_length[10]|regex_match[/^[0-9]+$/]|xss_clean');
                $this->form_validation->set_rules('age', $this->lang->line('age'), 'required|max_length[2]|regex_match[/^[0-9]+$/]|xss_clean');
                $this->form_validation->set_rules("last_name",$this->lang->line('last_name'),"required"); 
                $this->form_validation->set_rules('email', $this->lang->line('email'), 'valid_email|required');
                $this->form_validation->set_rules('password',$this->lang->line('password'),"required");
                $this->form_validation->set_rules('address',$this->lang->line('address'),"required");
                $this->form_validation->set_rules('city',$this->lang->line('city'),"required");
                $this->form_validation->set_rules('state',$this->lang->line('state'),"required");
                $this->form_validation->set_rules('zip',$this->lang->line('zip'),"required");
                $this->form_validation->set_rules('dob',$this->lang->line('date_of'),"required");                           
                $this->form_validation->set_rules('depa',  $this->lang->line('user_groups'),"required");
                $this->form_validation->set_rules('pos_users_id',$this->lang->line('user_name'),"required");
                $this->form_validation->set_rules('country',$this->lang->line('country'),"required");
                $id=  $this->input->post('id');	  
	    if ( $this->form_validation->run() !== false ) {        
			  $this->load->model('pos_users_model');
                          $first_name=$this->input->post('first_name');
                          $last_name=  $this->input->post('last_name');
                          $email=$this->input->post('email');
			  $emp_id=$this->input->post('pos_users_id');
                          $password=$this->input->post('password');
                          $address=$this->input->post('address');
                          $phone=$this->input->post('phone');
                          $city=$this->input->post('city');
                          $state=$this->input->post('state');
                          $zip=$this->input->post('zip');
                          $country=$this->input->post('country');
                          $user_groups=urldecode($this->input->post('depa'));
                          $yourdatetime =$this->input->post('dob');                          
                          $age=  $this->input->post('age');
                          $sex= $this->input->post('sex');
                          $dob= strtotime($yourdatetime);
                          $created_by=$_SESSION['Uid'];
                          $this->load->model('pos_users_model');
                          if($this->pos_users_model->user_checking($email,$emp_id,$dob)==FALSE){                              
                          $id= $this->pos_users_model->adda_new_pos_users($dob,$created_by,$sex,$age,$first_name,$last_name,$emp_id,$password,$address,$city,$state,$zip,$country,$email,$phone,'10');
                          $this->add_user_branchs($id,$user_groups);
                          $this->add_user_user_groups($id,$user_groups);
                                                  
                          $this->get_pos_users_details();                           
                         
                          }
                          else{
                   echo 'this user is alreay added';
                   
                  $this->load->model('user_groups');
                    $this->load->model('branch');
                    $data['branch']= $this->branch->get_user_for_branch($_SESSION['Uid']);
                    $data['depa']= $this->user_groups->get_user_groups(); 
                   $this->load->view('template/header');
                    $this->load->view('add_new_pos_users',$data);
                    $this->load->view('template/footer');
                        
                          }
            }else{
                    $this->load->model('user_groups');
                    $this->load->model('branch');
                    $data['branch']= $this->branch->get_user_for_branch($_SESSION['Uid']);
                    $data['depa']= $this->user_groups->get_user_groups(); 
                    $this->load->view('template/header');
                    $this->load->view('add_new_pos_users',$data);
                    $this->load->view('template/footer');
              }    
             }                
        }else{
               echo "U have No Permission to Add New User";
                $this->get_pos_users_details();
           }
        }
       function add_user_user_groups($id,$depapartment){
           
           $this->load->model('user_groups');
           $bid=array();
           $bid = explode(' ',$depapartment);
           for($i=1;$i<count($bid);$i++){
               $depart=array();
               $depart=explode('.',$bid[$i]);
                            
               $this->user_groups->set_user_groups($id,$depart[1],$depart[0]);
           }
        }
         function add_user_branchs($id,$depapartment){
            $this->load->model('branch');
            $new_depa=array();
           $branch=array();
         $this->load->model('user_groups');
           $bid=array();
           $bid = explode(' ',$depapartment);
           $l=0;
           for($i=1;$i<count($bid);$i++){
               $depart=array();
               $depart=explode('.',$bid[$i]);
                        $branch[$l]=$depart[0];
                       $l++;
               
               }
               
               $arr=$branch;

         $len = count($arr);
        for ($i = 0; $i < $len; $i++) {
        $temp = $arr[$i];
        $j = $i;
        for ($k = 0; $k < $len; $k++) {
            if ($k != $j) {
            if ($temp == $arr[$k]) {
               
                $arr[$k]=" ";
                
            }
            }
        }
        }
$r=0;
        for ($i = 0; $i < $len; $i++) {
       if($arr[$i]==" "){
           
       }
       else{
            $new_depa[$r]=$arr[$i];
           $r++;
       }
        }            
            for($k=0;$k<count($new_depa);$k++)
            {
               $this->branch->set_branch($id,$new_depa[$k]);                
            }
        }       
         function add_pos_users_image(){
              $uploaddir = './uploads/'; 
               $file = $uploaddir . basename($_FILES['uploadfile']['name']); 
               $_SESSION['image_name']=basename($_FILES['uploadfile']['name']); 
               
                if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
                echo "success"; 
                } else {
                        echo "error";
                }
        }
      
        function to_deactivate_user($id){  
                $this->load->model('pos_users_model');
                $this->pos_users_model->deactivate_user($id,$_SESSION['Bid']);   
                redirect('pos_users');
        }
        function to_activate_user($id){
                $this->load->model('pos_users_model');
                $this->pos_users_model->activate_user($id,$_SESSION['Bid']);   
                redirect('pos_users');
        }
        function delete_pos_users_details_in_admin($id){
                $this->load->model('pos_users_model');
                $this->pos_users_model->delete_user_for_admin($id,$_SESSION['Bid']);   
                redirect('pos_users');
        }
        
       


}
?>
