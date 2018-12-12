<?php

/* @Twig/Exception/exception_full.html.twig */
class __TwigTemplate_c67ac15191fa696e169f648e09bc7d61261ea2f3ea34ab71384f201a3953c1ef extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@Twig/layout.html.twig", "@Twig/Exception/exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@Twig/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_d29c2d6c1302858cc6d7525c67a5070dd676952e680bbc08ac693a16eae3d2e9 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_d29c2d6c1302858cc6d7525c67a5070dd676952e680bbc08ac693a16eae3d2e9->enter($__internal_d29c2d6c1302858cc6d7525c67a5070dd676952e680bbc08ac693a16eae3d2e9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_d29c2d6c1302858cc6d7525c67a5070dd676952e680bbc08ac693a16eae3d2e9->leave($__internal_d29c2d6c1302858cc6d7525c67a5070dd676952e680bbc08ac693a16eae3d2e9_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_30785a63c1041b48f3312048c864c70d0199d015a4dfc9c19cecdf41a3637714 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_30785a63c1041b48f3312048c864c70d0199d015a4dfc9c19cecdf41a3637714->enter($__internal_30785a63c1041b48f3312048c864c70d0199d015a4dfc9c19cecdf41a3637714_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpFoundationExtension')->generateAbsoluteUrl($this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_30785a63c1041b48f3312048c864c70d0199d015a4dfc9c19cecdf41a3637714->leave($__internal_30785a63c1041b48f3312048c864c70d0199d015a4dfc9c19cecdf41a3637714_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_b1800d6954fe650a6c1702808f4448bba3e476e0738666e7488171ba5d7da71a = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_b1800d6954fe650a6c1702808f4448bba3e476e0738666e7488171ba5d7da71a->enter($__internal_b1800d6954fe650a6c1702808f4448bba3e476e0738666e7488171ba5d7da71a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_b1800d6954fe650a6c1702808f4448bba3e476e0738666e7488171ba5d7da71a->leave($__internal_b1800d6954fe650a6c1702808f4448bba3e476e0738666e7488171ba5d7da71a_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_7377549c07438baa8aff8a2494e3db4e2c218cfe22c925be0b0b0f5a579eff8f = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_7377549c07438baa8aff8a2494e3db4e2c218cfe22c925be0b0b0f5a579eff8f->enter($__internal_7377549c07438baa8aff8a2494e3db4e2c218cfe22c925be0b0b0f5a579eff8f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("@Twig/Exception/exception.html.twig", "@Twig/Exception/exception_full.html.twig", 12)->display($context);
        
        $__internal_7377549c07438baa8aff8a2494e3db4e2c218cfe22c925be0b0b0f5a579eff8f->leave($__internal_7377549c07438baa8aff8a2494e3db4e2c218cfe22c925be0b0b0f5a579eff8f_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '@Twig/layout.html.twig' %}

{% block head %}
    <link href=\"{{ absolute_url(asset('bundles/framework/css/exception.css')) }}\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
{% endblock %}

{% block title %}
    {{ exception.message }} ({{ status_code }} {{ status_text }})
{% endblock %}

{% block body %}
    {% include '@Twig/Exception/exception.html.twig' %}
{% endblock %}
", "@Twig/Exception/exception_full.html.twig", "C:\\xampp\\htdocs\\diagnosticosxxi\\api\\vendor\\symfony\\symfony\\src\\Symfony\\Bundle\\TwigBundle\\Resources\\views\\Exception\\exception_full.html.twig");
    }
}
