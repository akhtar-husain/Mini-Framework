<?php
namespace App;

class Validation
{
    public $error = array();
    public $arr = array();
    public function __construct($arr){
        $this->arr = $arr;
    }

    public function validate(){
        foreach($this->arr as $key => $value){
            if($value == "" || empty(trim($this->arr[$key]))){
                $this->error[$key] = "This field can't be empty";
            }
        }
        if(count($this->error)){
            return $this->error;
        }
        else{
            return TRUE;
        }
    }
}
