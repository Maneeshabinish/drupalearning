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

/* modules/custom/custom_address_book/templates/birthday-list.html.twig */
class __TwigTemplate_ac51b308637ab63abc425e75097ec3e5 extends Template
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
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("custom_address_book/custom_block_css"), "html", null, true);
        echo "
<div class='custom-block' >
    ";
        // line 3
        if (($context["names"] ?? null)) {
            // line 4
            echo "    <h5 class='block-heading'><strong>Happy Birthday!!!</strong></h5>
        <ul class='block-list'>
        ";
            // line 6
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["names"]);
            foreach ($context['_seq'] as $context["_key"] => $context["names"]) {
                // line 7
                echo "            <li class='block-items'>";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["names"], 7, $this->source), "html", null, true);
                echo "</li>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['names'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 9
            echo "        </ul>
    ";
        } else {
            // line 11
            echo "    <p class= 'block-noitem'>No Birthdays Today!</p>
  ";
        }
        // line 13
        echo "</div>";
    }

    public function getTemplateName()
    {
        return "modules/custom/custom_address_book/templates/birthday-list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  71 => 13,  67 => 11,  63 => 9,  54 => 7,  50 => 6,  46 => 4,  44 => 3,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/custom/custom_address_book/templates/birthday-list.html.twig", "C:\\Users\\91894\\Desktop\\xampp\\htdocs\\DrupalStudy\\web\\modules\\custom\\custom_address_book\\templates\\birthday-list.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 3, "for" => 6);
        static $filters = array("escape" => 1);
        static $functions = array("attach_library" => 1);

        try {
            $this->sandbox->checkSecurity(
                ['if', 'for'],
                ['escape'],
                ['attach_library']
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
