<?php

namespace Velarde\SymfonyThemeBundle\Twig;

use Symfony\Bundle\TwigBundle\TwigEngine;

class SymfonyThemeTwigExtension extends \Twig_Extension
{
    private $baseLayout;

    private $widgetDirectory;

    /**
     * @var \Twig_Environment
     */
    private $templatingEngine;

    public function setBaseLayout($v)
    {
        $this->baseLayout = $v;
    }

    public function setWidgetDirectory($v)
    {
        $this->widgetDirectory = $v;
    }

    public function setEngine(\Twig_Environment $v)
    {
        $this->templatingEngine = $v;
    }



    public function getName()
    {
        return 'symfony_theme_twig_extension';
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('get_theme_layout', array($this, 'getThemeLayout')),
            new \Twig_SimpleFunction('get_theme_widget', array($this, 'getThemeWidget')),
            new \Twig_SimpleFunction('render_theme_widget', array($this, 'renderWidget')),
        );
    }

    public function getThemeLayout()
    {
        return $this->baseLayout;
    }

    public function getThemeWidget($widgetName)
    {
        $widget =  $this->widgetDirectory.':'.$widgetName.'.html.twig';


        return $widget;
    }

    public function renderWidget($widgetName)
    {
        // use first the overwrite

        $widget = $widgetName.'.html.twig';
        try{
            return $this->templatingEngine->render($widget);
        }
        catch (\Twig_Error_Loader $e){
            return $this->templatingEngine->render($this->getThemeWidget($widgetName));
        }
    }

}
