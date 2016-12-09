<?php
class Settings extends CI_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->helper(['url', 'status', 'store', 'asset']);
    }

    public function index() {
        $data['title'] = 'Settings';
        $this->load->view('settings_index', $data);
    }

    public function save() {
        if($this->input->method(true) == 'POST') {
            if($this->input->post('addstatus') == 'Add Status') {
                $status = $this->input->post('status');
                status_add($status);
            }
            else if($this->input->post('addstore') == 'Add Store') {
                $store = $this->input->post('store');
                store_add($store);
            }
            else if($this->input->post('submit') == 'Save') {
                $status_id = $this->input->post('status_name');
                $color = $this->input->post('status_color');
                set_status_color($status_id, $color);
            }
        }
        redirect('settings');
    }
    
    public function deletestore($id = null) {
        $data['title'] = 'Delete Store';
        
        if($id != null && is_numeric($id))
            delete_store($id);
        
        redirect('/settings');
    }
    
    public function deletestatus($id = null) {
        $data['title'] = 'Delete Status';
        
        if($id != null && is_numeric($id))
            delete_status($id);
        
        redirect('/settings');
    }
    
    public function getstatuscolor($id) {
        if($id != null && is_numeric($id)) {
            $color = get_status_color($id);
            echo $color;
        }
        else
            echo "#FFFFFF";
    }
    
    public function setstatuscolor($id, $color) {
        if($id != null && $color != null && is_numeric($id) && is_string($color)) {
            if(preg_match("(#([0-9A-Fa-f]{3,6}))", $color)) {
                set_status_color($id, $color);
             }
        }
   }
   
   public function raisepriority($id) {
        if($id == null || !is_numeric($id))
            redirect('/settings');

        $status = get_status_by_id($id);
        $priority = $status->priority;

        if($priority > 0) {
            $newPriority = $priority - 1;
            $altStatus = get_status_with_priority($newPriority);
            set_status_priority($altStatus->id, $priority);
            set_status_priority($id, $newPriority);
        }
        redirect('/settings');
    }

    public function lowerpriority($id) {
        if($id == null || !is_numeric($id))
            redirect('/settings');

        $status = get_status_by_id($id);
        $priority = $status->priority;

        if($priority < get_status_count()) {
            $newPriority = $priority + 1;
            $altStatus = get_status_with_priority($newPriority);
            set_status_priority($altStatus->id, $priority);
            set_status_priority($id, $newPriority);
        }
        redirect('/settings');
    }
	
	public function getstatuslist() {
		$items = get_status_list();
		$status = [];
		
		foreach($items as $item) {
			$status[] = $item->name;
		}
		echo json_encode($status);
	}
}
?>
