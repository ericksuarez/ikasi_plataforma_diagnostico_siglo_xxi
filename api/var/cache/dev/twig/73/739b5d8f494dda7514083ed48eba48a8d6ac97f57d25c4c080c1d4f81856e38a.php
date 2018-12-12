<?php

/* @WebProfiler/Collector/router.html.twig */
class __TwigTemplate_26b6a4e54e29965c93b5f5a0ca1cfa66b5487c303bcece1cbe2f8955eae5be32 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/router.html.twig", 1);
        $this->blocks = array(
            'toolbar' => array($this, 'block_toolbar'),
            'menu' => array($this, 'block_menu'),
            'panel' => array($this, 'block_panel'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@WebProfiler/Profiler/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_f02cf78f01dc7f4cbf163a4cfdacbfd948055b7751537ecb0eeba51256fae6e6 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_f02cf78f01dc7f4cbf163a4cfdacbfd948055b7751537ecb0eeba51256fae6e6->enter($__internal_f02cf78f01dc7f4cbf163a4cfdacbfd948055b7751537ecb0eeba51256fae6e6_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/router.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_f02cf78f01dc7f4cbf163a4cfdacbfd948055b7751537ecb0eeba51256fae6e6->leave($__internal_f02cf78f01dc7f4cbf163a4cfdacbfd948055b7751537ecb0eeba51256fae6e6_prof);

    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        $__internal_9b8d1641437bb7489e50af82bcec7d9253774c0ac82384377d864b0199968878 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_9b8d1641437bb7489e50af82bcec7d9253774c0ac82384377d864b0199968878->enter($__internal_9b8d1641437bb7489e50af82bcec7d9253774c0ac82384377d864b0199968878_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        
        $__internal_9b8d1641437bb7489e50af82bcec7d9253774c0ac82384377d864b0199968878->leave($__internal_9b8d1641437bb7489e50af82bcec7d9253774c0ac82384377d864b0199968878_prof);

    }

    // line 5
    public function block_menu($context, array $blocks = array())
    {
        $__internal_df42142ae20938b54d2accf4287a8f5e030f474f66a343e1d7e7c548920a3917 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_df42142ae20938b54d2accf4287a8f5e030f474f66a343e1d7e7c548920a3917->enter($__internal_df42142ae20938b54d2accf4287a8f5e030f474f66a343e1d7e7c548920a3917_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 6
        echo "<span class=\"label\">
    <span class=\"icon\">";
        // line 7
        echo twig_include($this->env, $context, "@WebProfiler/Icon/router.svg");
        echo "</span>
    <strong>Routing</strong>
</span>
";
        
        $__internal_df42142ae20938b54d2accf4287a8f5e030f474f66a343e1d7e7c548920a3917->leave($__internal_df42142ae20938b54d2accf4287a8f5e030f474f66a343e1d7e7c548920a3917_prof);

    }

    // line 12
    public function block_panel($context, array $blocks = array())
    {
        $__internal_663bf9e1681a7eb95eb53061c8915f1172f3007a5dfc2524e84b56d56d0f4a17 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_663bf9e1681a7eb95eb53061c8915f1172f3007a5dfc2524e84b56d56d0f4a17->enter($__internal_663bf9e1681a7eb95eb53061c8915f1172f3007a5dfc2524e84b56d56d0f4a17_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 13
        echo "    ";
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\HttpKernelExtension')->renderFragment($this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("_profiler_router", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
        echo "
";
        
        $__internal_663bf9e1681a7eb95eb53061c8915f1172f3007a5dfc2524e84b56d56d0f4a17->leave($__internal_663bf9e1681a7eb95eb53061c8915f1172f3007a5dfc2524e84b56d56d0f4a17_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/router.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 13,  67 => 12,  56 => 7,  53 => 6,  47 => 5,  36 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '@WebProfiler/Profiler/layout.html.twig' %}

{% block toolbar %}{% endblock %}

{% block menu %}
<span class=\"label\">
    <span class=\"icon\">{{ include('@WebProfiler/Icon/router.svg') }}</span>
    <strong>Routing</strong>
</span>
{% endblock %}

{% block panel %}
    {{ render(path('_profiler_router', { token: token })) }}
{% endblock %}
", "@WebProfiler/Collector/router.html.twig", "C:\\xampp\\htdocs\\diagnosticosxxi\\api\\vendor\\symfony\\symfony\\src\\Symfony\\Bundle\\WebProfilerBundle\\Resources\\views\\Collector\\router.html.twig");
    }
}
