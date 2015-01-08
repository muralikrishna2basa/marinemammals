<?php

/* AppBundle:Page:index.html.twig */
class __TwigTemplate_45302c1a6b04c0623cbce06140387ea2300d23510200faccff95a520ec246fc2 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("AppBundle::col-layout.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'sidebar' => array($this, 'block_sidebar'),
            'mainbar' => array($this, 'block_mainbar'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "AppBundle::col-layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        echo "Welcome -";
    }

    // line 3
    public function block_sidebar($context, array $blocks = array())
    {
        // line 4
        echo "<h2>Recent observations</h2>
";
    }

    // line 5
    public function block_mainbar($context, array $blocks = array())
    {
        // line 6
        echo "<h2>About Belgian Marine Mammals</h2>

<div class=\"col-lg-6\">
\t<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ut
\t\tenim eu sem malesuada gravida ac id dui. Donec luctus placerat tortor,
\t\teget rhoncus tellus consequat ut. Morbi magna est, ultrices non
\t\tegestas sit amet, maximus ullamcorper ligula. Nulla vulputate et mi
\t\tnec faucibus. Proin ullamcorper nisi sed euismod malesuada. Etiam
\t\tiaculis sollicitudin lacus, nec bibendum diam fermentum non. Curabitur
\t\tnec ornare erat. Ut maximus ultrices odio. Donec facilisis lacus vitae
\t\tlibero aliquet porttitor. Nunc et ante vitae erat suscipit accumsan.
\t\tCras lacinia odio a fringilla ultricies. Proin sapien sapien, congue
\t\tac ultricies at, egestas eu massa.</p>
\t<p>Sed at nibh dolor. Phasellus sagittis vulputate interdum. Morbi non
\t\tvelit libero. Integer vel sagittis arcu. Ut congue commodo dui, vel
\t\tcondimentum metus porta ultricies. Maecenas ut sem tempus, hendrerit
\t\tlorem a, molestie orci. Integer et sapien eu mi consequat pretium
\t\tvenenatis et urna. Aliquam posuere dolor justo, vel lacinia lectus
\t\teuismod et. Curabitur nec quam volutpat, congue massa vitae, venenatis
\t\tdiam. Phasellus et aliquam odio. Integer fringilla massa nec est
\t\tvulputate mattis. Vestibulum vel arcu magna. Sed sagittis, tellus sed
\t\tfeugiat volutpat, magna elit suscipit arcu, at accumsan lacus odio
\t\teget lorem. Aliquam in mi hendrerit, rutrum lorem quis, tincidunt
\t\tnunc. Curabitur nisi urna, iaculis et metus quis, vehicula sagittis
\t\ttortor. Cras in purus mi.</p>
\t<p>Praesent vulputate facilisis diam, vitae ornare felis blandit in.
\t\tSed a pellentesque mi. Etiam euismod diam massa, ut rutrum ligula
\t\tgravida et. Ut in luctus metus, lacinia accumsan diam. Lorem ipsum
\t\tdolor sit amet, consectetur adipiscing elit. Vestibulum finibus turpis
\t\teu risus laoreet lacinia. Suspendisse potenti. Donec porttitor
\t\telementum tellus in luctus. Suspendisse consectetur elementum orci,
\t\tnon ultrices nisi ultrices sit amet. Sed porttitor, ante sit amet
\t\thendrerit accumsan, est metus cursus ipsum, et lacinia dui magna sed
\t\ttortor. Proin blandit sapien et fermentum venenatis.</p>
\t<p>Vestibulum fermentum neque et consectetur pulvinar. Duis auctor diam
\t\tnec purus commodo rhoncus. Aenean non cursus dui. Mauris euismod nulla
\t\tnisi, in interdum odio laoreet quis. Morbi facilisis turpis non augue
\t\tdapibus, vitae aliquam libero auctor. Quisque consectetur libero est,
\t\tid convallis ipsum vulputate dictum. Mauris et placerat magna, sit
\t\tamet vehicula arcu. Mauris dapibus pretium nunc. Nullam congue
\t\tconvallis lobortis. Phasellus quis ante vel leo euismod pharetra.
\t\tDonec maximus vel urna in scelerisque. Praesent pulvinar imperdiet
\t\torci. Quisque non porttitor nisl. Curabitur iaculis enim sapien, sit
\t\tamet vehicula mauris cursus et.</p>
</div>
<div class=\"col-lg-6\">
\t<p>Ut non odio et mauris pharetra euismod. Vivamus porttitor ultricies
\t\tvarius. Aliquam semper lectus est, quis malesuada ante ornare sed.
\t\tInteger porta fringilla ipsum volutpat molestie. In in commodo quam.
\t\tInteger porta nisi nec orci commodo tempus. Cras vel leo ac lorem
\t\tlaoreet laoreet ac in erat. Donec semper euismod leo efficitur tempus.
\t\tQuisque placerat luctus felis, et porta eros auctor sit amet. Class
\t\taptent taciti sociosqu ad litora torquent per conubia nostra, per
\t\tinceptos himenaeos. Praesent suscipit, justo sed vestibulum euismod,
\t\tligula erat placerat nisi, ut aliquet orci massa quis velit.
\t\tVestibulum vel massa nibh. Nam in felis ut sapien volutpat sodales
\t\teget ut turpis.</p>
\t<p>Cras dignissim odio nisl, sit amet cursus libero volutpat ac. Nunc
\t\tneque augue, venenatis vel sodales ac, sagittis posuere nisl. Nullam
\t\tbibendum risus quis tortor blandit, vehicula cursus sem vestibulum.
\t\tSed ut pulvinar libero. Praesent luctus porttitor ex, in mattis nunc
\t\ttempus nec. Nulla ullamcorper nisi facilisis aliquam bibendum.
\t\tCurabitur id fermentum enim, vitae consequat libero.</p>
</div>
";
    }

    public function getTemplateName()
    {
        return "AppBundle:Page:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  47 => 6,  44 => 5,  39 => 4,  36 => 3,  30 => 2,);
    }
}
