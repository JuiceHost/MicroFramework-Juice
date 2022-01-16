<?php

namespace Juice\Controllers;

use Twig\Environment;

class BaseController
{
    /** @var Environment */
    protected $template;

    public function __construct(Environment $template)
    {
        $this->template = $template;   
    }

    public function render(string $templateName, array $parameters = [])
    {
        return $this->template->render($templateName, $parameters);
    }

    public function display(string $templateName, array $parameters = [])
    {
        $this->template->display($templateName, $parameters);
    }
}