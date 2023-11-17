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

/* modules/custom/custom_book_appointments/templates/book-appointment.html.twig */
class __TwigTemplate_a9ccdb20e2e8dc7ab5f040f9e4423281 extends Template
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
        echo "
<nav>
  <div class=\"nav nav-tabs\" id=\"nav-tab\" role=\"tablist\">
    <a class=\"nav-item nav-link active\" id=\"nav-book-appointment-tab\" data-toggle=\"tab\" href=\"#nav-book-appointment\" role=\"tab\" aria-controls=\"nav-book-appointment\" aria-selected=\"true\">Book An Appointment</a>
    <a class=\"nav-item nav-link\" id=\"nav-review-report-tab\" data-toggle=\"tab\" href=\"#nav-review-report\" role=\"tab\" aria-controls=\"nav-review-report\" aria-selected=\"false\">Review Medical Report</a>
    <a class=\"nav-item nav-link\" id=\"nav-general-enquiry-tab\" data-toggle=\"tab\" href=\"#nav-general-enquiry\" role=\"tab\" aria-controls=\"nav-general-enquiry\" aria-selected=\"false\">Make General Enquiry</a>
  </div>
</nav>

<div class=\"tab-content\" id=\"nav-tabContent\">
  <div class=\"tab-pane fade show active\" id=\"nav-book-appointment\" role=\"tabpanel\" aria-labelledby=\"nav-book-appointment-tab\">
  ";
        // line 12
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["forms"] ?? null), "appointment_form", [], "any", false, false, true, 12), 12, $this->source), "html", null, true);
        echo "
  </div>
  <div class=\"tab-pane fade\" id=\"nav-review-report\" role=\"tabpanel\" aria-labelledby=\"nav-review-report-tab\">
  ";
        // line 15
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["forms"] ?? null), "medical_review_form", [], "any", false, false, true, 15), 15, $this->source), "html", null, true);
        echo "
  </div>
  <div class=\"tab-pane fade\" id=\"nav-general-enquiry\" role=\"tabpanel\" aria-labelledby=\"nav-general-enquiry-tab\">
  ";
        // line 18
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["forms"] ?? null), "general_enquiry_form", [], "any", false, false, true, 18), 18, $this->source), "html", null, true);
        echo "
  </div>
</div>";
    }

    public function getTemplateName()
    {
        return "modules/custom/custom_book_appointments/templates/book-appointment.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  64 => 18,  58 => 15,  52 => 12,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/custom/custom_book_appointments/templates/book-appointment.html.twig", "C:\\Users\\91894\\Desktop\\xampp\\htdocs\\DrupalStudy\\web\\modules\\custom\\custom_book_appointments\\templates\\book-appointment.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array("escape" => 12);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                [],
                ['escape'],
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
