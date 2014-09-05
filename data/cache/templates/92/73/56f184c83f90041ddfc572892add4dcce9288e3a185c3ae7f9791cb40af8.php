<?php

/* application/index/index */
class __TwigTemplate_927356f184c83f90041ddfc572892add4dcce9288e3a185c3ae7f9791cb40af8 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("layout/layout");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout/layout";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        $this->displayParentBlock("title", $context, $blocks);
        echo " - Home";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "     <!-- Three columns of text below the carousel -->
      <div class=\"row\">
        <div class=\"col-lg-4\">
          <img class=\"img-circle\" src=\"data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==\" alt=\"Generic placeholder image\" style=\"width: 140px; height: 140px;\">
          <h2>Heading</h2>
          <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.</p>
          <p><a class=\"btn btn-default\" href=\"#\" role=\"button\">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class=\"col-lg-4\">
          <img class=\"img-circle\" src=\"data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==\" alt=\"Generic placeholder image\" style=\"width: 140px; height: 140px;\">
          <h2>Heading</h2>
          <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.</p>
          <p><a class=\"btn btn-default\" href=\"#\" role=\"button\">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class=\"col-lg-4\">
          <img class=\"img-circle\" src=\"data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==\" alt=\"Generic placeholder image\" style=\"width: 140px; height: 140px;\">
          <h2>Heading</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class=\"btn btn-default\" href=\"#\" role=\"button\">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->


      <!-- START THE FEATURETTES -->

      <hr class=\"featurette-divider\">

      <div class=\"row featurette\">
        <div class=\"col-md-7\">
          <h2 class=\"featurette-heading\">First featurette heading. <span class=\"text-muted\">It'll blow your mind.</span></h2>
          <p class=\"lead\">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
        </div>
        <div class=\"col-md-5\">
          <img class=\"featurette-image img-responsive\" data-src=\"holder.js/500x500/auto\" alt=\"Generic placeholder image\">
        </div>
      </div>

      <hr class=\"featurette-divider\">

      <div class=\"row featurette\">
        <div class=\"col-md-5\">
          <img class=\"featurette-image img-responsive\" data-src=\"holder.js/500x500/auto\" alt=\"Generic placeholder image\">
        </div>
        <div class=\"col-md-7\">
          <h2 class=\"featurette-heading\">Oh yeah, it's that good. <span class=\"text-muted\">See for yourself.</span></h2>
          <p class=\"lead\">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
        </div>
      </div>

      <hr class=\"featurette-divider\">

      <div class=\"row featurette\">
        <div class=\"col-md-7\">
          <h2 class=\"featurette-heading\">And lastly, this one. <span class=\"text-muted\">Checkmate.</span></h2>
          <p class=\"lead\">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
        </div>
        <div class=\"col-md-5\">
          <img class=\"featurette-image img-responsive\" data-src=\"holder.js/500x500/auto\" alt=\"Generic placeholder image\">
        </div>
      </div>

      <hr class=\"featurette-divider\">

      <!-- /END THE FEATURETTES -->
";
    }

    public function getTemplateName()
    {
        return "application/index/index";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 6,  36 => 5,  29 => 3,);
    }
}
