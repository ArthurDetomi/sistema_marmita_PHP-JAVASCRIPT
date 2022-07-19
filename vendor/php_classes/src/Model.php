<?php
namespace Sistema;

class Model{

    private $values = array();

    public function __call($name, $args)
    {
        $method = substr($name, 0, 3);
        $restName = substr($name, 3, strlen($name));
        switch($method)
        {
            case "get":
                return (isset($this->values[$restName]))?$this->values[$restName]:NULL;
            break;

            case "set":
                $this->values[$restName] = $args[0];
            break;
            
        }
    }

    public function setData($data = array())
    {
        foreach($data as $key=>$value){
            $this->{"set".$key}($value);
        }

    }

    public function getValues()
    {
        return $this->values;
    }

}
?>