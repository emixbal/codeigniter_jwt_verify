<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('vendor/autoload.php');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Example extends REST_Controller{
    function __construct(){
        parent::__construct();
    }

    function index_get(){
        //implement helper
        $loggedin_user = verify_token($this->input->get_request_header('Authorization'));

        // get data from token extraction
        $user_id = decode_id($loggedin_user->id);
        $organization_id = decode_id($loggedin_user->organization_id);

        $total_data = $this->contract_api->listing_example($user_id, $user_id, $organization_id, $config)->total_data;
        $total_page = ceil($total_data/$per_page);
        $start_page = ($page>1) ? ($page * $per_page) - $per_page : 0;
        $result = $this->contract_api->listing_example($user_id, $user_id, $organization_id, $config, array("limit"=>$per_page,"offset"=>$start_page));

        $response = [
            "message"=>"ok",
            "page"=>$page,
            "per_page"=>$per_page,
            "total_data"=>$total_data,
            "total_page"=>$total_page,
            "data"=>$result,
        ];
        $status = 200;

        return $this->output
        ->set_status_header($status)
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
    }
}
