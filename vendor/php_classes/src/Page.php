<?php
namespace Sistema;
use \Rain\Tpl;

class Page{

    private $tpl;
    private $options = array();
    private $defaults = array(
        "header"=>true,
        "footer"=>true,
        "data"=>array(
        )
    );

    public function __construct( $opts = array(), $tpl_dir = "/sistemamarmita/views/")
    {
        $this->options = array_merge($this->defaults, $opts);
        $config = array(
            "base_url" => null,
            "tpl_dir" => $_SERVER["DOCUMENT_ROOT"].$tpl_dir,
            "cache_dir" => $_SERVER["DOCUMENT_ROOT"]."/sistemamarmita/views-cache/",
            "debug" => false
        );
        Tpl::configure($config);
        $this->tpl = new Tpl();
        if($this->options["data"] === true) $this->setData($this->$options["data"]);//faz o assign das variaveis
        if($this->options["header"] === true) $this->tpl->draw("header", false);//desenha o header de inicio
    }

    private function setData($data = array())
    {
        foreach($data as $key=>$value){ //percorre e faz o assing das variaveis de template
            $this->tpl->assign($key, $value);
        }
    }

    public function setTpl($name, $data = array(), $returnHTML = false)
    {
        $this->setData($data);//faz o assign das variaveis
        return $this->tpl->draw($name, $returnHTML);//desenha o template
    }

    public function __destruct()
    {
        if($this->options["footer"] === true)$this->tpl->draw("footer");
    }
}


?>