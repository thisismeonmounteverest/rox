<?php

namespace AppBundle\Pagerfanta;

use Pagerfanta\View\Template\Template;

/**
 * TwitterBootstrap4Template

 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class TwitterBootstrap4Template extends Template
{
    protected static $defaultOptions = [
        'prev_message'        => '&larr; Previous',
        'next_message'        => 'Next &rarr;',
        'dots_message'        => '&hellip;',
        'active_suffix'       => '',
        'css_container_class' => 'pagination',
        'css_prev_class'      => 'prev',
        'css_next_class'      => 'next',
        'css_disabled_class'  => 'disabled',
        'css_dots_class'      => 'disabled',
        'css_active_class'    => 'active',
    ];
    public function container()
    {
        return sprintf(
            '<nav><ul class="%s">%%pages%%</ul></nav>',
            $this->option('css_container_class')
        );
    }
    public function page($page)
    {
        $text = $page;
        return $this->pageWithText($page, $text);
    }
    public function pageWithText($page, $text)
    {
        $class = null;
        return $this->pageWithTextAndClass($page, $text, $class);
    }
    private function pageWithTextAndClass($page, $text, $class)
    {
        $href = $this->generateRoute($page);
        return $this->linkLi($class, $href, $text);
    }
    public function previousDisabled()
    {
        $class = $this->previousDisabledClass();
        $text = $this->option('prev_message');
        return $this->spanLi($class, $text);
    }
    private function previousDisabledClass()
    {
        return $this->option('css_prev_class') . ' ' . $this->option('css_disabled_class');
    }
    public function previousEnabled($page)
    {
        $text = $this->option('prev_message');
        $class = $this->option('css_prev_class');
        return $this->pageWithTextAndClass($page, $text, $class);
    }
    public function nextDisabled()
    {
        $class = $this->nextDisabledClass();
        $text = $this->option('next_message');
        return $this->spanLi($class, $text);
    }
    private function nextDisabledClass()
    {
        return $this->option('css_next_class') . ' ' . $this->option('css_disabled_class');
    }
    public function nextEnabled($page)
    {
        $text = $this->option('next_message');
        $class = $this->option('css_next_class');
        return $this->pageWithTextAndClass($page, $text, $class);
    }
    public function first()
    {
        return $this->page(1);
    }
    public function last($page)
    {
        return $this->page($page);
    }
    public function current($page)
    {
        $text = trim($page . ' ' . $this->option('active_suffix'));
        $class = $this->option('css_active_class');
        return $this->spanLi($class, $text);
    }
    public function separator()
    {
        $class = $this->option('css_dots_class');
        $text = $this->option('dots_message');
        return $this->spanLi($class, $text);
    }
    public function __construct()
    {
        parent::__construct();
        $this->setOptions(['active_suffix' => '<span class="sr-only">(current)</span>']);
    }
    public function linkLi($class, $href, $text)
    {
        $liClass = implode(' ', array_filter(['page-item', $class]));
        return sprintf('<li class="%s"><a class="page-link" href="%s">%s</a></li>', $liClass, $href, $text);
    }
    public function spanLi($class, $text)
    {
        $liClass = implode(' ', array_filter(['page-item', $class]));

        return sprintf('<li class="%s"><span class="page-link">%s</span></li>', $liClass, $text);
    }
}
