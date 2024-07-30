<?php

namespace Velarde\SymfonyThemeBundle\Twig;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SymfonyThemeTwigExtension extends AbstractExtension
{
    private $baseLayout;

    private $widgetDirectory;

    /**
     * @var Environment
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

    public function setEngine(Environment $v)
    {
        $this->templatingEngine = $v;
    }

    public function getName(): string
    {
        return 'symfony_theme_twig_extension';
    }

    public function getFunctions(): array
    {
        return array(
            new TwigFunction('get_theme_layout', array($this, 'getThemeLayout')),
            new TwigFunction('get_theme_widget', array($this, 'getThemeWidget')),
            new TwigFunction('render_theme_widget', array($this, 'renderWidget')),
        );
    }

    public function getThemeLayout()
    {
        return $this->baseLayout;
    }

    public function getThemeWidget($widgetName)
    {
        $widget = $this->widgetDirectory . ':' . $widgetName . '.html.twig';

        return $widget;
    }

    public function renderWidget($widgetName)
    {
        // use first the overwrite

        $widget = $widgetName . '.html.twig';
        try {
            return $this->templatingEngine->render($widget);
        } catch (LoaderError $e) {
            return $this->templatingEngine->render($this->getThemeWidget($widgetName));
        }
    }

}