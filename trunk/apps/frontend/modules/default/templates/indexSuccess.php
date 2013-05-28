<?
function baseurl_for($application, $absolute = false)
{
    $url = $absolute ? 'http://' . $_SERVER["HTTP_HOST"] : '';
    //$rel_root = $sf_requestthis->getContext()->getRequest()->getRelativeUrlRoot();
    $rel_root = sfContext::getInstance()->getRequest()->getRelativeUrlRoot();
    $url .= $rel_root .'/'. $application . (sfConfig::get("sf_environment") != 'prod' ? '_' . sfConfig::get("sf_environment") : '') . '.php/';
    return $url;
}
?>
<div class="wrapper" style="width: 90%;">
<div class="left">
<h1><?php echo __('Virtual Organizations')?></h1>
<?php echo  link_to(image_tag("unite.jpg"),baseurl_for("organization")) ?><br>
</div>
<div class="right">
<h1><?php echo __('Service registry')?></h1>
<?php echo  link_to(image_tag("service.jpg"),baseurl_for("service")) ?><br>
</div>
</div>
