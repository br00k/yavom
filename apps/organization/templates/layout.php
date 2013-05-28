<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <div id="wrapper">
		<div id="header">
			<h1><?php echo  link_to(__("Virtual organizations"),"default/index") ?></h1>
			<p><?php echo __('Unite!')?></p>			
		</div>
		<div id="content">
    <?php echo $sf_content ?>
			<div class="clear"></div>
			
		</div>
		
		<div id="sidebar">
			<? if ($sf_user->getGuardUser()): ?>
			<div class="widget">
				<h2><?php echo __('Profile')?></h2>
				<p><?php echo  $sf_user->getGuardUser()->getLastName(); ?></p>
                                <p><?php echo  link_to(__("My entitlements"),"getMyEntitlements/index") ?></p>
				<p><?php echo  link_to(__("Logout"),"saml/logout"); ?></p>
			</div>
			<div class="widget">
				<h2><?php echo __('My Organizations')?></h2>
                                <? if ($sf_user->getPrincipal()->getOrganization()) : ?>
                                <? $os = $sf_user->getPrincipal()->getOrganization(); ?>
                                <? $ros = $sf_user->getPrincipal()->getRelatedOrganizations(FALSE); ?>
                                <? foreach($os as $o ): ?>
                                  <?php $oe = Doctrine_query::create()->select('oe.id')->from('OrganizationEntitlementPack oe')->where('oe.organization_id=?',$o->getId())->execute(); ?>
				  <p><?php echo  $o ?>
                                  <span class="right">
				  <?php echo  image_tag("icons/user",array("title"=>__("Participants")))?><?php echo  count($o->getInvitation()) ?>
				  <?php echo  image_tag("icons/application_cascade",array("title"=>__("Subscribed services")))?><?php echo  count($oe) ?>
				&nbsp;&nbsp;
                                  <?php echo  link_to(image_tag("icons/wrench",array("class"=>"button","title"=>__("Manage organization"))),"show/index?id=".$o->getId()) ?>
                                  <?php echo  $o->hasPendingService()?image_tag("icons/error",array("title"=>__("Pending service subscribtions"))):"" ?>
                                  </p>
                                <? endforeach ?>
                                <?php foreach($ros as $o) :?>  
                                  <p><?php echo  $o ?>
                                  <span class="right">
                                  <?php echo  link_to(image_tag("icons/group",array("title"=>__('Show organization'))),"show/index?id=".$o->getId()) ?>
                                  </span>
                                  </p>
                                <? endforeach ?>
                                <? endif ?>
			</div>
			<? endif ?>
		</div>
		
		<div class="clear"></div>
			
		<div id="footer">
		<div>
<a href="<?php echo url_for("language_switch", array("lang"=>"hu"))?>"><?php echo image_tag("hu_flag.png", array("title"=>"Magyar")); ?></a>
<a href="<?php echo url_for("language_switch", array("lang"=>"en"))?>"><?php echo image_tag("en_flag.png", array("title"=>"English")); ?></a>
</div>
<div class="clear"></div>
			<p><a href="https://aai.sztaki.hu"><?php echo  image_tag("aai.sztaki.hu_banner_mirrored_30px.png")?></a></p>
		</div>
		
	</div>
	
</body>
</html>
