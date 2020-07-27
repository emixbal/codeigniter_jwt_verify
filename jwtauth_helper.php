<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('vendor/autoload.php');
use \Firebase\JWT\JWT;

if(!function_exists('verify_token')){
    function verify_token($raw_token) {
        $secretkey = 'kode_rahasia_kamu';

        if($raw_token!=''){ //jika header Authorization provided
            $raw_token = trim($raw_token);
            $exploded = explode(" ", $raw_token);
            if(count($exploded)>1){ //jika bearer key provided
                $bearer = $exploded[0];
                $token = $exploded[1];
                if($bearer!='Bearer'){ //jika bearer key bukan Bearer
                    $status=401;
                    $data = array(
                        "message"=>"Wrong format bearer token.",
                        "data"=>null
                    );
                    $ctx = (return_formatter($status, $data));
                    echo $ctx->final_output;
                    header("content-type: application/json");
                    exit();
                }else{  //jika bearer key adalah Bearer
                    try { //melakukan decode. Tidak melakukan apapun jika benar
                        $jwt = JWT::decode($token, $secretkey, array('HS256'));
                        return $jwt;
                    } catch (\Throwable $th) { // jika token salah
                        $status=401;
                        $data = array(
                            "message"=>"Invalid token.",
                            "data"=>null
                        );
                        $ctx = (return_formatter($status, $data));
                        echo $ctx->final_output;
                        header("content-type: application/json");
                        exit();
                    }
                }                
            } else{ //jika bearer key not provided
                $status=403;
                $data = array(
                    "message"=>"Wrong format bearer token.",
                    "data"=>null
                );
                $ctx = (return_formatter($status, $data));
                echo $ctx->final_output;
                header("content-type: application/json");
                exit();
            }
        } else{ //jika header Authorization not provided
            $status=403;
            $data = array(
                "message"=>"Token is not provided.",
                "data"=>null
            );
            $ctx = (return_formatter($status, $data));
            echo $ctx->final_output;
            header("content-type: application/json");
            exit();
        }
    }
}

function return_formatter($status, $data){
    // bikin responses formatter
    $ci = &get_instance();
    return $ci->output
    ->set_status_header($status)
    ->set_content_type('application/json')
    ->set_output(json_encode($data));
}
?>