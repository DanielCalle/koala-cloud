<?php namespace Tools;

class View extends Response {

    protected $template;
    protected $vars;
    protected $twig;

    public function __construct($template, $vars = array())
    {
        $loader = new \Twig_Loader_Filesystem('../views');
        $this->twig = new \Twig_Environment($loader, array('debug' => DEBUG));
        $this->template = $template;
        $this->vars = $vars;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function getVars()
    {
        return $this->vars;
    }

    public function getTemplateFileName()
    {
        return $this->getTemplate() . '.twig';
    }

    public function execute()
    {
        echo $this->twig->render($this->getTemplateFileName(), $this->getVars());
    }

}