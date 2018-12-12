<?php

/* base.html.twig */
class __TwigTemplate_5d0c3a69a8a3962c8d98c249d32e88f5a91a2d00a01e2c553229607aff72c653 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_6d9062cb42addd5f7fd27bcd70163e93863fa0de008f5b09c7d6435c57f5565b = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_6d9062cb42addd5f7fd27bcd70163e93863fa0de008f5b09c7d6435c57f5565b->enter($__internal_6d9062cb42addd5f7fd27bcd70163e93863fa0de008f5b09c7d6435c57f5565b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "base.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        ";
        // line 6
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 7
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
    </head>
    <body>
        ";
        // line 10
        $this->displayBlock('body', $context, $blocks);
        // line 11
        echo "        ";
        $this->displayBlock('javascripts', $context, $blocks);
        // line 12
        echo "    </body>
</html>
";
        
        $__internal_6d9062cb42addd5f7fd27bcd70163e93863fa0de008f5b09c7d6435c57f5565b->leave($__internal_6d9062cb42addd5f7fd27bcd70163e93863fa0de008f5b09c7d6435c57f5565b_prof);

    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        $__internal_9750427613ee99d766863f43f5e9d8715017b61e9e1d15656a1f150c1cbdc731 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_9750427613ee99d766863f43f5e9d8715017b61e9e1d15656a1f150c1cbdc731->enter($__internal_9750427613ee99d766863f43f5e9d8715017b61e9e1d15656a1f150c1cbdc731_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Welcome!";
        
        $__internal_9750427613ee99d766863f43f5e9d8715017b61e9e1d15656a1f150c1cbdc731->leave($__internal_9750427613ee99d766863f43f5e9d8715017b61e9e1d15656a1f150c1cbdc731_prof);

    }

    // line 6
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_ac420296cb43692c1dcc2f0811f4abc1ee415f9fd24f1f94b710b8f506d69ecf = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_ac420296cb43692c1dcc2f0811f4abc1ee415f9fd24f1f94b710b8f506d69ecf->enter($__internal_ac420296cb43692c1dcc2f0811f4abc1ee415f9fd24f1f94b710b8f506d69ecf_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_ac420296cb43692c1dcc2f0811f4abc1ee415f9fd24f1f94b710b8f506d69ecf->leave($__internal_ac420296cb43692c1dcc2f0811f4abc1ee415f9fd24f1f94b710b8f506d69ecf_prof);

    }

    // line 10
    public function block_body($context, array $blocks = array())
    {
        $__internal_4da0bd4ff296615b6b8a694fe51c522b55fcc99413740657e7de1c72ba19651b = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_4da0bd4ff296615b6b8a694fe51c522b55fcc99413740657e7de1c72ba19651b->enter($__internal_4da0bd4ff296615b6b8a694fe51c522b55fcc99413740657e7de1c72ba19651b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_4da0bd4ff296615b6b8a694fe51c522b55fcc99413740657e7de1c72ba19651b->leave($__internal_4da0bd4ff296615b6b8a694fe51c522b55fcc99413740657e7de1c72ba19651b_prof);

    }

    // line 11
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_ca6eca38ae1b2e8648da565c200c5309940843fbb363dc4da366f7ab83dde2e4 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_ca6eca38ae1b2e8648da565c200c5309940843fbb363dc4da366f7ab83dde2e4->enter($__internal_ca6eca38ae1b2e8648da565c200c5309940843fbb363dc4da366f7ab83dde2e4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_ca6eca38ae1b2e8648da565c200c5309940843fbb363dc4da366f7ab83dde2e4->leave($__internal_ca6eca38ae1b2e8648da565c200c5309940843fbb363dc4da366f7ab83dde2e4_prof);

    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  93 => 11,  82 => 10,  71 => 6,  59 => 5,  50 => 12,  47 => 11,  45 => 10,  38 => 7,  36 => 6,  32 => 5,  26 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <title>{% block title %}Welcome!{% endblock %}</title>
        {% block stylesheets %}{% endblock %}
        <link rel=\"icon\" type=\"image/x-icon\" href=\"{{ asset('favicon.ico') }}\" />
    </head>
    <body>
        {% block body %}{% endblock %}
        {% block javascripts %}{% endblock %}
    </body>
</html>
", "base.html.twig", "C:\\xampp\\htdocs\\diagnosticosxxi\\api\\app\\Resources\\views\\base.html.twig");
    }
}
