<?php

class View
{

    private $layout;

    public function __construct($layout="layout")
    {
        $this->layout = basename($layout);
    }

    public function render($imePHTMLdatoteke,$podaci=[])
    {
        ob_start();
        extract($podaci);
        include BP . "app/view/$imePHTMLdatoteke.phtml";
        $content = ob_get_clean();
        if($this->layout){
            include BP . "app/view/{$this->layout}.phtml";
        }else{
            echo $content;
        }
        return $this;
    }

}