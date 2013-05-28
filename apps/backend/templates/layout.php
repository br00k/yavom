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
     <div class="header" style="padding-top: 25px;">
     <div id="firstheader" style="float: left; padding-right: 10px;">
     <a href="<?php echo url_for('sfGuardUser/index')?>" >
       <?= image_tag("icons/user") ?>
       Userek
     </a>
     <br>
     <a href="<?php echo url_for('principal/index')?>" >
       <?= image_tag("icons/user") ?>
       Tagok
     </a>
     <a href="<?php echo url_for('sfGuardUser/index')?>" >
       <?= image_tag("icons/user") ?>
       Userek
     </a>
     </div>
     <div id="secondheader" style="float: left; padding-right: 10px;">
     <a href="<?php echo url_for('organization_principal/index')?>" >
         Szervezet menedzserek
     </a>
     <br>
     <a href="<?php echo url_for('role_principal/index')?>" >
         Szervezeti szereposztás
     </a>
     <br>
     <a href="<?php echo url_for('invitation/index')?>" >
         Meghívások
     </a>
     </div>
     <div id="thirdheader" style="float: left; padding-right: 10px;">
     <a href="<?php echo url_for('organization/index')?>" >
       <?= image_tag("icons/group") ?>
       Szervezetek
     </a>
     <br>
     <a href="<?php echo url_for('role/index')?>" >
       <?= image_tag("icons/group_key") ?>
       Szerepek
     </a>
     </div>
     <div id="fourthheader" style="float: left; padding-right: 10px;">
     <a href="<?php echo url_for('organization_service/index')?>" >
         Szervezetek és szolgáltatások
     </a>
     <br>
     <a href="<?php echo url_for('role_entitlement/index')?>" >
         Szerepek és jogosultságok
     </a>
     </div>
     <div id="fifthheader" style="float: left; padding-right: 10px;">
     <a href="<?php echo url_for('service/index')?>" >
       <?= image_tag("icons/application") ?>
         Regisztrált szolgáltatások
     </a>
     <br>
     <a href="<?php echo url_for('entitlement/index')?>" >
       <?= image_tag("icons/lock") ?>
       Szolgáltatások jogosultságai
     </a>
     </div>
     <div id="sixthheader" style="float: left; padding-right: 10px;">
     <a href="<?php echo url_for('getentitlements/index')?>" >
       <?= image_tag("icons/arrow_switch") ?>
        Jog lekérdező
     </a>
     </div>
     </div>
     <? if ($sf_user->hasFlash("errors")): ?>
        <div class="errors" style="clear: both;">
        Hibák:<br>
        <?= $sf_user->getFlash("errors"); ?>
	</div>
     <? endif ?>
     <div class="content" style="clear: both;">
     <?php echo $sf_content ?>
     </div>
     <div class="footer">
       Virtual Organizations (aai.sztaki.hu)
     </div>
  </body>
</html>
