<?php
class Purchase_main extends CI_Controller{
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
                redirect('home');
        }else{
            $this->get_suppliers();
        }
    }
    function get_suppliers(){
         if (!$_SERVER['HTTP_REFERER']){ redirect('home');} //check the function is call directly or not if yes then redirect to home
        else{
            if($_SESSION['admin']==2){// check user is admin or not
                $this->load->library("pagination"); 
                $this->load->model('branch');
                $this->load->model('purchase');
	        $config["base_url"] = base_url()."index.php/purchase_main/get_suppliers";
	        $config["total_rows"] = $this->purchase->supplier_count_for_admin($_SESSION['Bid']);// get supplier count
	        $config["per_page"] = 8;
	        $config["uri_segment"] = 3;
	        $this->pagination->initialize($config);	 
	        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                $data['branch']=$this->purchase->get_selected_branch_for_view();
                $data['count']=$this->purchase->supplier_count_for_admin($_SESSION['Bid']);         
	        $data["row"] = $this->purchase->get_supplier_details_for_admin($config["per_page"], $page,$_SESSION['Bid']);
                $data['urow']= $this->purchase->get_suppliers();
	        $data["links"] = $this->pagination->create_links();                 
                $this->load->view('template/header');
                $this->load->view('supplier_list',$data);
                $this->load->view('template/footer');
            }else{
                $this->load->library("pagination"); 
                $this->load->model('branch');
                $this->load->model('purchase');
	        $config["base_url"] = base_url()."index.php/purchase_main/get_suppliers";
                $config["total_rows"] = $this->purchase->get_purchase_order_user($_SESSION['Bid']);
	        $config["per_page"] = 8;
	        $config["uri_segment"] = 3;
	        $this->pagination->initialize($config);	 
	        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                $data['branch']=$this->purchase->get_selected_branch_for_view();
                $data['count']=$this->purchase->get_purchase_order_user($_SESSION['Bid']);             
	        $data["row"] = $this->purchase->get_purchase_order_details_for_user($config["per_page"], $page,$_SESSION['Bid']);
                $data['urow']=$this->purchase->get_suppliers();
	        $data["links"] = $this->pagination->create_links(); 
                
                $this->load->view('template/header');
                $this->load->view('purchase/order_list',$data);
                $this->load->view('template/footer');
            }
        }
    }
    function purchase_order_details(){
        if (!$_SERVER['HTTP_REFERER']){ redirect('home');} //check the function is call directly or not if yes then redirect to home
        else{
        if($this->input->post('BacktoHome')){
            redirect('home');
        }
        if($this->input->post('add_new')){
                $this->load->view('template/header');
                $this->load->view('purchase/add_new_order');
                $this->load->view('template/footer');
        }
        }
    }
     function get_selected_item()
    {
          if (!$_SERVER['HTTP_REFERER']){ redirect('home');}else{
       $this->load->model('purchase');
           $qo = mysql_real_escape_string( $_REQUEST['query'] );

        $value=  $this->purchase->get_selected_supplier($qo,$_SESSION['Bid']);

$data=$value[0];
$dis=$value[1];
$id=$value[2];

   
	    echo '<ul>'."\n";
	    for($i=0;$i<count($data);$i++)
	    {
		$p = $data[$i];
		$p = preg_replace('/(' . $qo . ')/i', '<span style="font-weight:bold;">'.'</span>', $p);
		echo "\t".'<li id="autocomplete_'.$data[$i].'" rel="'.$dis[$i].'_' . $dis[$i].'_' .$id[$i] .'_' . $id[$i]. '">'. utf8_encode( "$data[$i]" ) .'</li>'."\n";
	    }
	    echo '</ul>';
          }
	
    }
}
?>
