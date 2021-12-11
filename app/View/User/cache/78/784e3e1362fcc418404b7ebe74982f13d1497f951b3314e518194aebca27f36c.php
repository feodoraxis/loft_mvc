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

/* auth.twig */
class __TwigTemplate_49fd97596df2dc7cfe9414ce44fff57c4d33a0f368ad54c09e12360cd1f147cb extends \Twig\Template
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
        your email
        <input type=\"text\" name=\"user[email]\">
    </label><br />
    <label for=\"\">
        your password
        <input type=\"password\" name=\"user[password]\">
    </label><br />

    <button>Auth</button>
</form>";
    }

    public function getTemplateName()
    {
        return "auth.twig";
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
        return new Source("", "auth.twig", "/Applications/MAMP/htdocs/app/View/User/auth.twig");
    }
}
