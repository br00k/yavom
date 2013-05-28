<h2><?php echo(__('Service: <strong>%s%</strong>',array('%s%'=>$s)))?> 
<? if ($s->getType() != 'valid'):?>
<p class="ui-state-error">
<?php echo(__('This service is invalid yet. Please validate the owner!'))?>
<span class="right">
<?php echo link_to(__('Click here to validate!'),'service/validateForm?id='.$s->getId()) ?>
</span> 
</p>
<?endif?>

<? if ($s->isMy()):?>
          <span class="right">
          <?php echo  link_to(image_tag("icons/wrench",array("title"=>__('Edit service'))),"service/edit?id=".$s->getId()); ?>
          <?php echo  image_tag("icons/delete",array("title"=>__('Delete service'),"class"=>"service_delete_button button")); ?>
          </span>
          <? include_partial("deleteServiceForm",array("s"=>$s)) ?>
        <? endif?>
</h2>
<div class="service"> 
<div class="hentry">
   <h3 class="entry-title">&#183; <?php echo __('About the service')?> &#183;</h3>
   <div class="managers">
   <div class="bluehead">
	<strong><?php echo __('Managers')?></strong>
   </div>
   <div class="entitlements">
   <?php
           foreach($s->getServicePrincipal() as $sp)
           { 
             //echo($sp->getPrincipal()->getFedid().'<br>');
             if ($s->isMy()){
                 include_partial("showName", array("p"=>$sp->getPrincipal(),"i"=>FALSE, "s"=>$s)); 
                 
               }
           }        
   ?>
   </div>
   <div class="organizations">
	<strong><?php echo __('Invitations')?></strong>
        <span class="right">
        <? if ($s->isMy()):?>
            <? $onclickurl='parent.location="'.url_for("invitePrincipal/inviteForm?s_id=".$s->getId()).'"'; ?>
            <?php echo  image_tag("icons/add",array(
		"id"=>"invite_add_button",
		"class"=>"button",
		"title"=>__('Invite new manager'),
		"onClick"=>$onclickurl,
		)) ?>
        <? endif?>
		<?php echo  image_tag("icons/bullet_arrow_up",array("id"=>"member_hide_button","class"=>"button member_hide_button","title"=>_('Hide'), "style"=>"display: none;")) ?>
		    <?php echo  image_tag("icons/bullet_arrow_down",array("id"=>"member_show_button","class"=>"button member_show_button","title"=>__('Show'))) ?>
        </span>
        <div class="m" style="display: none;">
	<?php
           /*foreach($s->getServiceInvitation() as $i)
           { 
             if ($i->getStatus() == "accepted")
             {
               if ($s->isMy()){
                 include_partial("showName", array("p"=>$i->getPrincipal(),"i"=>$i, "s"=>FALSE)); 
               }
               else {
                 include_partial("showName", array("p"=>$i->getPrincipal(),"i"=>FALSE, "s"=>FALSE)); 
               }
             }
           }*/
           foreach($s->getServiceInvitation() as $i )
           {
             if ($i->getStatus() == "pending")
             {
               include_partial("showInvitation", array("i"=>$i));
             }
           }
        ?>
        </div>
   </div>
   </div>
  <br>
  <div class="clear"> </div>
      <div class="bluehead">
	<strong><?php echo __('Settings')?></strong>
        
      </div>
      
        <p><?php echo __('URL of the service:')?> <span class="right"> <a href="<?php echo  $s->getUrl()?>" target="_blank"><?php echo  $s->getUrl() ?></a></span></p>
        <p><?php echo __('SAML SP entityId:')?> <span class="right"><?php echo  $s->getEntityId() ?></span> </p>
        <p><?php echo __('Description:')?> <span class="right"><?php echo  $s->getDescription(ESC_RAW) ?></span> </p>
      
      
      <div class="allentitlements">
      <div class="bluehead">
	<strong><?php echo __('Entitlements')?></strong>
        <? if ($s->isMy()):?>
          <span class="right">
          <?php echo  link_to(image_tag("icons/add",array("title"=>__('New entitlement'))),"entitlement/new?id=".$s->getId()); ?>
          </span>
        <? endif?>
      </div>
      
        <?foreach($s->getEntitlement() as $e):?>
          <p>
          <?php echo  $e ?>
          <span class="right">
          <?php echo  image_tag("icons/information",array("title"=>__('Entitlement details'), "class" =>"entitlementcard_button", "id"=>"entitlementcard_button_".$e->getId())); ?>
          <?php echo  link_to(image_tag("icons/wrench",array("title"=>__('Update entitlement'))),"entitlement/edit?id=".$e->getId()); ?>
          <?php echo  image_tag("icons/delete",array("title"=>__('Delete entitlement'),"class"=>"entitlement_delete_button button", "id" => $e->getId())); ?>
          </span>
          </p>
          <? include_partial("showEntitlement",array("e"=>$e)) ?>
          <? include_partial("deleteEntitlementForm",array("e"=>$e)) ?>
        <?endforeach?>
      </div>

</div>
<div class="clear"> </div>
</div>
<div class="hentry">
	<h3 class="entry-title">&#183; <?php echo __('Entitlement packages')?> &#183;</h3>

<div class="service">
<div class="entitlementpack">
<p class="bluehead" ><strong><?php echo __('Defined entitlement packages')?></strong>
    <span class="right">
        <? if ($s->isMy()):?>
            
            <?php echo  link_to(image_tag("icons/add",array("title"=>__('Define new package'))),"entitlement_pack/new?id=".$s->getId()); ?>
        <? endif ?>
    <?php echo  image_tag("icons/bullet_arrow_up",array("id"=>"entitlementpack_hide_button","class"=>"button","title"=>__('Hide'))) ?>
    <?php echo  image_tag("icons/bullet_arrow_down",array("id"=>"entitlementpack_show_button","class"=>"button","title"=>__('Show'))) ?>
    </span>
</p>
</div>
        
<div class="entitlementpacks">

<?php foreach($rs as $r) :?>  
<div class="entitlementpack " id="id_<?php echo  $r->getId()?>"> 
  <p class="entitlementpackhead">
  <strong>
  <?php echo  $r->getName() ?>
  </strong>
  <? if ($s->isMy()):?>
    <span class="right">
    <?php echo  link_to(image_tag("icons/wrench",array("title"=>__('Edit package'))),"entitlement_pack/edit?id=".$r->getId()); ?>
    <?php echo  image_tag("icons/delete",array("title"=>__('Delete package'),"class"=>"entitlement_pack_delete_button button", "id" => $r->getId())); ?>
    <?php echo  image_tag("icons/bullet_arrow_up",array("id"=>"entitlementpack_hide_button_".$r->getId(),"class"=>"button entitlementpack_hide_button","title"=>__('Hide'))) ?>
    <?php echo  image_tag("icons/bullet_arrow_down",array("id"=>"entitlementpack_show_button_".$r->getId(),"class"=>"button entitlementpack_show_button","title"=>__('Show'), "style"=>"display: none;")) ?>
    </span>
    <? include_partial("deleteEntitlementPackForm",array("r"=>$r)) ?>
    <div id="entitlementpack_update_<?php echo  $r->getId()?>">
        <? include_partial("updateEntitlementPackForm",array("r"=>$r,"form"=>new ServEntitlementPackForm())) ?>
    </div>
  <? endif?>
  </p>
  <p>
  <?php echo  $r->getDescription(ESC_RAW);?>
  </p>
  <p><?php echo __('Share type:')?> <span class="right"><?php echo __($r->getType()) ?></span> </p>
  <p><?php echo __('Subscribe token:')?> <span class="right">
		<?php echo  $r->getToken() ?>
                <?php echo  image_tag("icons/email_go",array(
		   "title"=>__('Send secret token'),
		   "class" =>"send_token_button button",
		   "id"=>$r->getId())); ?>
		<?php $form->setDefault('ep_id', $r->getId());?>
                <? include_partial("sendTokenForm",array("s"=>$s, "ep"=>$r,"form"=>$form)) ?>
		</span> </p>
  
  <div class="entitlements">
  <div class="entitlement r r_<?php echo  $r->getId()?>">
  
  <strong><?php echo __('Entitlements')?></strong>
  <?  if ($s->isMy()):?>
    <span class="right">
    <?php echo  link_to(image_tag("icons/key_go"),"updateEntitlementPackEntitlement/index?id=".$r->getId(),array("title"=>__('Rearrange entitlements'))); ?>
    </span>
  <? endif  ?>
  <br>
  <?php foreach($r->getEntitlement() as $e) :?>  
    <?php echo  $e.'<span class="idekelleneright">'.image_tag("icons/information",array("title"=>__('Entitlement details'), "class" =>"entitlementcard_button", "id"=>"entitlementcard_button_2_".$e->getId())).'</span>'; ?>
    <br>
  <? endforeach ?>
  </div>
  </div>
  <div class="organizations r r_<?php echo  $r->getId()?>">
      <div>
	<strong><?php echo __('Subscribed organizations')?></strong>
     </div>
        <?foreach($r->getOrganizationEntitlementPack() as $oe):?>
          <?php echo  $oe->getOrganization() ?>
          <span class="right" style="height: 1em">
          <?php echo  image_tag("icons/information",array(
		"title"=>__('Organization details'),
		"class" =>"organizationcard_button",
		"id"=>"organizationcard_button_".$oe->getOrganizationId())); ?>
          <?if ($oe->getStatus()=="accepted"): ?>
	    <?php echo  image_tag("icons/tick",array("title"=>__('Connected')))?>
	    <?php echo  image_tag("icons/delete",array("title"=>__('Delete connection'),
		"class" =>"organization_unlink_button button",
		"id"=>$oe->getId())) ?>
	    <? include_partial("unlinkOrganizationForm",array("epid"=>$oe->getId(),"o"=>$oe->getOrganization(),"e"=>$oe->getEntitlementPack())) ?>
          <?else: ?>
            <?php echo  image_tag("icons/hourglass",array(
		"title"=>__('Pending'),
		"class" =>"organization_accept_button button",
		"id"=>$oe->getId())); ?>
            <? include_partial("acceptOrganizationForm",array("epid"=>$oe->getId(),"o"=>$oe->getOrganization(),"e"=>$oe->getEntitlementPack())) ?>
          <?endif?>
          </span>
          <br>
          <? include_partial("showOrganization",array("o"=>$oe->getOrganization())) ?>
        <?endforeach?>
      </div>
  
  
 <div class="clear"></div>
</div>
<? endforeach ?>

</div>
</div>
</div>
<? if ($s->isMy()):?>
<div id="reordersuccess">
A csomagok új sorrendje eltárolva.
</div>
<? endif ?>

<? include_partial("global/noticeDialog")?>

<script>
$(document).ready(function() {
        $('.entitlement_delete').dialog({
		autoOpen: false,
		title: '<?php echo __('Delete entitlement') ?>',
                    modal: true,
                    width: 500
		});
	$('.entitlement_delete_button').click(function() {
		$('.entitlement_delete[id=' + this.id + ']').dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
	 $('.entitlement_pack_delete').dialog({
		autoOpen: false,
		title: '<?php echo __('Delete package') ?>',
                    modal: true,
                    width: 500
		});
	$('.entitlement_pack_delete_button').click(function() {
		$('.entitlement_pack_delete[id=' + this.id + ']').dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
        $('.service_delete').dialog({
		autoOpen: false,
		title: '<?php echo(__('Delete service'))?>',
                    modal: true,
                    width: 500
		});
	$('.service_delete_button').click(function() {
		$('.service_delete').dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
        $('.organization_accept').dialog({
		autoOpen: false,
		title: '<?php echo __('Accept organization') ?>',
                    modal: true,
                    width: 500
		});
	$('.organization_accept_button').click(function() {
		$('.organization_accept[id=' + this.id + ']').dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
        $('.organization_unlink').dialog({
		autoOpen: false,
		title: '<?php echo __('Withdraw entitlement pack') ?>',
                    modal: true,
                    width: 500
		});
	$('.organization_unlink_button').click(function() {
		$('.organization_unlink[id=' + this.id + ']').dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
        $('.send_token').dialog({
		autoOpen: false,
		title: '<?php echo __('Send secret token') ?>',
                    modal: true,
                    width: 500
		});
	$('.send_token_button').click(function() {
		$('.send_token').dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
	
	/* Jogosultságok gombjai */
        var $rc = $('#entitlementpack_add')
	    .dialog({
		autoOpen: false,
		title: '<?php echo __('Create new entitlement package') ?>',
                    modal: true,
                    width: 500
		});
	$('#entitlementpack_add_button').click(function() {
		$rc.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
	$('#entitlementpack_hide_button').click(function() {
                $('.entitlementpack_show_button').show();
                $('.entitlementpack_hide_button').hide();
		$('.r').slideUp();
	});
	$('#entitlementpack_show_button').click(function() {
                $('.entitlementpack_show_button').hide();
                $('.entitlementpack_hide_button').show();
		$('.r').slideDown();
	});
	
	$('#member_hide_button').click(function() {
                $('#member_show_button').show();
                $('#member_hide_button').hide();
		$('.m').slideUp();
	});
	$('#member_show_button').click(function() {
                $('#member_show_button').hide();
                $('#member_hide_button').show();
		$('.m').slideDown();
	});

	<? if ($s->isMy()):?>
        $('#reordersuccess').dialog({
		autoOpen: false,
        	width: 500,
		title: '<?php echo __('Rearrange packages') ?>',
		buttons: {
		"OK": function() {
			$( this ).dialog( "close" );
			}
		}
	});
        $('.entitlementpacks').sortable({
		opacity: 0.6,
		cursor: 'move',
                scroll: true,
                revert: true,
                placeholder: 'ui-state-highlight',
                axis: 'y',
                handle: '.entitlementpackhead',
                update: function(){
                     $('#reordersuccess').dialog("open");
                     var order = $('.entitlementpacks').sortable("serialize");
                     $.post("<?php echo  url_for('show/entitlementPackReorder') ?>", order, function(data){});
                }
        });
        <? endif ?>

        /* info felugrók */
        /* Jogosultság névjegye */
        $('.entitlementcard').dialog({
		autoOpen: false,
        	width: 500,
		title: '<?php echo __('Entitlement details') ?>'
	});
	
	/* Jogosultságcsomag névjegye */
        $('.entitlementpackcard').dialog({
		autoOpen: false,
        	width: 500,
		title: '<?php echo __('Package details') ?>'
	});
        /* Szervezet névjegye */
        $('.organizationcard').dialog({
		autoOpen: false,
        	width: 500,
		title: '<?php echo __('Organization details') ?>'
	});
	/* Meghívó névjegye */
        $('.invitationcard').dialog({
		autoOpen: false,
        	width: 500,
		title: '<?php echo __('Invitation details') ?>'
	});
        /* Szereplő névjegye */
        $('.namecard').dialog({
		autoOpen: false,
        	width: 500,
		title: '<?php echo __('Manager details') ?>'
	});
	
<?php foreach($rs as $r) :?>  
	var $rd<?php echo  $r->getId()?> = $('#entitlementpack_delete_<?php echo  $r->getId()?>')
		.dialog({
			autoOpen: false,
			title: '<?php echo(__('Delete package').$r->getName()); ?>',
                        modal: true,
                        width: 500,
                        buttons: {
				"Mégsem": function() {
					$( this ).dialog( "close" );
				},
				"Törlés": function() {
                                        $(location).attr('href','<?php echo  url_for("show/deleteEntitlementPack?id=".$r->getId())?>');
				}
			}
		});
	$('#entitlementpack_delete_button_<?php echo  $r->getId()?>').click(function() {
		$rd<?php echo  $r->getId()?>.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});

	var $ru<?php echo  $r->getId()?> = $('#entitlementpack_update_<?php echo  $r->getId()?>')
		.dialog({
			autoOpen: false,
			title: '<?php echo  $r->getName()?> csomag frissítése',
                        modal: true,
                        width: 500
		});
	$('#entitlementpack_update_button_<?php echo  $r->getId()?>').click(function() {
		$ru<?php echo  $r->getId()?>.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
        
	$('#entitlementpack_hide_button_<?php echo  $r->getId()?>').click(function() {
		$('.r_<?php echo  $r->getId()?>').slideUp();
                $('#entitlementpack_show_button_<?php echo  $r->getId()?>').show();
                $('#entitlementpack_hide_button_<?php echo  $r->getId()?>').hide();
	});
	$('#entitlementpack_show_button_<?php echo  $r->getId()?>').click(function() {
		$('.r_<?php echo  $r->getId()?>').slideDown();
                $('#entitlementpack_show_button_<?php echo  $r->getId()?>').hide();
                $('#entitlementpack_hide_button_<?php echo  $r->getId()?>').show();
	});

<? endforeach ?>
});
</script>
