<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* registration.twig */
class __TwigTemplate_b0a52de59b13f2ca1579455c9f8e4e9999dc84686f0a58fd2c3b13c459c275f6 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "message", [], "any", false, false, false, 1), "html", null, true);
        echo "

<form action=\"";
        // line 3
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["data"] ?? null), "action", [], "any", false, false, false, 3), "html", null, true);
        echo "\" method=\"post\">
    <label for=\"\">
        user name
        <input type=\"text\" name=\"user[name]\">
    </label><br />
    <label for=\"\">
        user email
        <input type=\"text\" name=\"user[email]\">
    </label><br />
    <label for=\"\">
        user password
        <input type=\"password\" name=\"user[password][1]\">
    </label><br />

    <label for=\"\">
        repeat password
        <input type=\"password\" name=\"user[password][2]\">
    </label><br />

    <button>Registration</button>
</form>";
    }

    public function getTemplateName()
    {
        return "registration.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  42 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "registration.twig", "/Applications/MAMP/htdocs/app/View/User/registration.twig");
    }
}
