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

/* modules/custom/my_custom_router/templates/arguments-display.html.twig */
class __TwigTemplate_2e2571adb7ecdcb2e4afe77015aa0874 extends Template
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
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<p>Page Rendered Using Twig Template</p>
<div>
  <p>";
        // line 3
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Argument1: @arg1", ["@arg1" => ($context["num1"] ?? null)]));
        echo "</p>
  <p>";
        // line 4
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Argument2: @arg2", ["@arg2" => ($context["num2"] ?? null)]));
        echo "</p>
</div>

";
    }

    public function getTemplateName()
    {
        return "modules/custom/my_custom_router/templates/arguments-display.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  47 => 4,  43 => 3,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/custom/my_custom_router/templates/arguments-display.html.twig", "C:\\Users\\91894\\Desktop\\xampp\\htdocs\\DrupalStudy\\web\\modules\\custom\\my_custom_router\\templates\\arguments-display.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array("t" => 3);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                [],
                ['t'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
