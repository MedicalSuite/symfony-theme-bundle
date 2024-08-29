<?php

namespace Velarde\SymfonyThemeBundle\Twig;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SymfonyThemeTwigExtension extends AbstractExtension
{
    private string $baseLayout;
    private string $widgetDirectory;
    private Environment $templatingEngine;

    public function setBaseLayout($v): void
    {
        $this->baseLayout = $v;
    }

    public function setWidgetDirectory($v): void
    {
        $this->widgetDirectory = $v;
    }

    public function setEngine(Environment $v): void
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

    public function getThemeLayout(): string
    {
        return $this->baseLayout;
    }

    public function getThemeWidget($widgetName): string
    {
        $widget = $this->widgetDirectory . ':' . $widgetName . '.html.twig';

        return $widget;
    }

    public function renderWidget($widgetName): string
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