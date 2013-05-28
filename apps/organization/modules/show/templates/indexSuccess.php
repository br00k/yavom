<h2><?php echo __('Organization: <strong>%o%</strong>',array('%o%'=>$o))?>
   <? if ($o->isMy()):?>
    <span class="right">
     <?php echo image_tag("icons/email",array("id"=>"send_mail_button", "class"=>"button","title"=>__('Send message to VO members'))) ?>
    <?php echo image_tag("icons/wrench",array("id"=>"org_update_button", "class"=>"button","title"=>__('Edit organization'))) ?>
    <?php echo  image_tag("icons/delete",array("title"=>__('Delete organization'),"class"=>"organization_delete_button button")); ?>
    <?php echo image_tag("icons/lightbulb",array("id"=>"hint_button", "class"=>"button","title"=>__("Hint"))) ?>     
    </span>
    <div id="org_update">
            <? include_partial("updateOrganizationForm",array("o"=>$o,"form"=>$update_org_form)) ?>
    </div>
    <? include_partial("deleteOrganizationForm",array("o"=>$o)) ?>
    <? include_partial("sendMail", array("o"=>$o, "form"=>$send_mail_form)) ?>
    <div class="clear"></div>
   <? endif ?>
</h2>
<div class="hentry">
   <h3 class="entry-title">&#183; <?php echo __('About the organization')?> &#183;</h3>
     <?php echo $o->getDescription(ESC_RAW) ?>
     <div class="role">
      <p>&nbsp;</p>
      <div class="principals">
	<strong><?php echo __('The leaders');?></strong>
        <? if ($o->isMy()):?>
          <span class="right">
          <?php echo  link_to(image_tag("icons/group"),"updateOrganizationPrincipal/index?id=".$o->getId(),array("title"=>__("Update members"))); ?>
          </span>
        <? endif?>
        <br>
	<?php foreach($o->getPrincipal() as $p) :?>  
           <? include_partial("showName", array("p"=>$p,"i"=>FALSE)) ?>
	<?php endforeach?>
      </div>
      <div class="entitlements">
	<strong><?php echo __('The participants')?></strong>
        <span class="right">
        <? if ($o->isMy()):?>
            <? $onclickurl='parent.location="'.url_for("invitePrincipal/inviteForm?o_id=".$o->getId()).'"'; ?>
            <?php echo  image_tag("icons/add",array(
		"id"=>"invite_add_button",
		"class"=>"button",
		"title"=>__('Invite new member'),
		"onClick"=>$onclickurl,
		)) ?>
        <? endif?>
		<?php echo  image_tag("icons/bullet_arrow_up",array("id"=>"member_hide_button","class"=>"button member_hide_button","title"=>__('Hide'), "style"=>"display: none;")) ?>
		    <?php echo  image_tag("icons/bullet_arrow_down",array("id"=>"member_show_button","class"=>"button member_show_button","title"=>__('Show'))) ?>
        </span>
        <br>
        <div class="m" style="display: none;">
	<?php
           foreach($o->getInvitation() as $i)
           { 
             if ($i->getStatus() == "accepted")
             {
               if (! $i->getPrincipal()->hasRoleAt($o))
               {
                  echo image_tag("icons/error",array("title"=>__("User is not in any role")));
               }
               if ($o->isMy()){
                 include_partial("showName", array("p"=>$i->getPrincipal(),"i"=>$i)); 
               }
               else {
                 include_partial("showName", array("p"=>$i->getPrincipal(),"i"=>FALSE)); 
               }
             }
           }
           foreach($o->getInvitation() as $i )
           {
             if ($i->getStatus() == "pending")
             {
               include_partial("showInvitation", array("i"=>$i));
             }
           }
        ?>
        </div>
      </div>
<div class="clear"></div>
     <div class="role">
      <p>&nbsp;</p>
      <div class="principals">
	<strong><?php echo __('Subscribed service entitlements')?></strong>
        <span class="right">
        <? if ($o->isMy()):?>
            <? $onclickurl='parent.location="'.url_for("subscribeService/index?id=".$o->getId()).'"'; ?>
            <?php echo  image_tag("icons/add",array(
		"class"=>"button",
		"title"=>__('Connect new service'),
		"onClick"=>$onclickurl,
		)) ?>
        <? endif?>
        </span>
        <br>
	<?php foreach($o->getOrganizationEntitlementPack() as $oe) :?>  
           <? include_partial("showEntitlementPack", array("e"=>$oe->getEntitlementPack(),"oe"=>$oe)) ?>
	<?php endforeach?>
      </div>
     </div>
  </div>
	<div class="clear"></div>
</div>
<div class="hentry">
	<h3 class="entry-title">&#183; <?php echo __('Roles')?> &#183;</h3>
<div class="role">
<p class="rolehead" ><?php echo __('Defined roles in the organization.')?>
    <span class="right">
        <? if ($o->isMy()):?>
            <?php echo  image_tag("icons/add",array("id"=>"role_add_button","class"=>"button","title"=>__('Define new role'))) ?>
        <? endif ?>
    <?php echo  image_tag("icons/bullet_arrow_up",array("id"=>"role_hide_button","class"=>"button","title"=>__('Hide'))) ?>
    <?php echo  image_tag("icons/bullet_arrow_down",array("id"=>"role_show_button","class"=>"button","title"=>__('Show'))) ?>
    </span>
</p>
</div>
        <? if ($o->isMy()):?>
          <div id="role_add">
            <? include_partial("newRoleForm",array("o"=>$o,"form"=>new OrgRoleForm())) ?>
          </div>
        <? endif ?>
<div class="roles">

<?php foreach($rs as $r) :?>  
<?php //var_dump($r);exit;?>  
<div class="role" id="id_<?php echo  $r->getId()?>"> 
  <p class="rolehead">
  <strong>
  <?php echo  $r->getName() ?>
  </strong>
  <? if ($o->getDefaultRoleId() == $r->getId()):?>
    <?php echo  image_tag("icons/star",array("title"=>__("Default role"))) ?>
  <? endif ?>
  <? if ($o->isMy()):?>
    <span class="right">
    <?php echo  image_tag("icons/wrench",array("id"=>"role_update_button_".$r->getId(),"class"=>"button","title"=>__("Edit role"))) ?>
    <?php echo  image_tag("icons/delete",array("id"=>"role_delete_button_".$r->getId(),"class"=>"button","title"=>__("Delete role"))) ?>
    <?php echo  image_tag("icons/bullet_arrow_up",array("id"=>"role_hide_button_".$r->getId(),"class"=>"button role_hide_button","title"=>__('Hide'))) ?>
    <?php echo  image_tag("icons/bullet_arrow_down",array("id"=>"role_show_button_".$r->getId(),"class"=>"button role_show_button","title"=>__("Show"), "style"=>"display: none;")) ?>
    </span>
    <div id="role_delete_<?php echo  $r->getId()?>">
      <?php echo __('You are about to remove <strong>%rname%</strong> role. If you do so, the connections between the members and their entitlements will be lost.',array("%rname%"=>$r->getName())) ?>
    </div>
    <div id="role_update_<?php echo  $r->getId()?>">
        <? include_partial("updateRoleForm",array("r"=>$r,"form"=>new OrgRoleForm())) ?>
    </div>
  <? endif?>
  </p>
  <p>
  <?php echo  $r->getDescription(ESC_RAW);?>
  </p>
  <div class="principals r r_<?php echo  $r->getId()?>">
  <strong><?php echo __('Role members')?></strong>
  <? if ($o->isMy()):?>
    <span class="right">
    <?php echo  link_to(image_tag("icons/group"),"updateRolePrincipal/index?id=".$r->getId(),array("title"=>_('Redefine members'))); ?>
    </span>
  <? endif?>
  <br>
  <?php foreach($r->getPrincipal() as $rp) :?>  
           <? include_partial("showRoledPrincipal", array("rp"=>$rp)) ?>
  <? endforeach ?>
  </div>
  <div class="entitlements r r_<?php echo  $r->getId()?>">
  <strong><?php echo __('Entitlements')?></strong>
  <? if ($o->isMy()):?>
    <span class="right">
    <?php echo  link_to(image_tag("icons/key_go"),"updateRoleEntitlement/index?id=".$r->getId(),array("title"=>__('Redefine entitlements'))); ?>
    </span>
  <? endif?>
  <br>
  <?php foreach($r->getEntitlement() as $e) :?>  
    <?php echo  include_partial("showEntitlement",array("e"=>$e)) ?>
  <? endforeach ?>
  </div>
 <div class="clear"></div>
</div>
<? endforeach ?>
</div>
</div>
<? if ($o->isMy()):?>
<div id="reordersuccess">
<?php echo __('New order of roles is stored.'); ?>
</div>
<? endif ?>
<div id="not_linked_principal">
<?php echo __('Warning! The <strong>federal ID</strong> of the participant has been entered manually and without checking, this may cause some problems!');?>
</div>

<? include_partial("hint",array("o"=>$o))?>
<? include_partial("global/noticeDialog")?>

<script>
$(document).ready(function() {
        var $ou = $('#org_update')
	    .dialog({
		autoOpen: false,
		title: '<?php echo __('Edit organization preferences'); ?>',
                    modal: true,
                    width: 500
		});
	$('#org_update_button').click(function() {
		$ou.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
        var $rc = $('#role_add')
	    .dialog({
		autoOpen: false,
		title: '<?php echo __('Create new role')?>',
                    modal: true,
                    width: 500
		});
	$('#role_add_button').click(function() {
		$rc.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
	$('.organization_delete').dialog({
		autoOpen: false,
		title: '<?php echo(__('Delete organization'))?>',
                    modal: true,
                    width: 500
		});
	$('.organization_delete_button').click(function() {
		$('.organization_delete').dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
	$('.send_mail').dialog({
		autoOpen: false,
		title: '<?php echo(__('Send message'))?>',
                    modal: true,
                    width: 500
		});
	$('#send_mail_button').click(function() {
		$('.send_mail').dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
	$('#role_hide_button').click(function() {
                $('.role_show_button').show();
                $('.role_hide_button').hide();
		$('.r').slideUp();
	});
	$('#role_show_button').click(function() {
                $('.role_show_button').hide();
                $('.role_hide_button').show();
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


        /*   A szerepkörök sorrendezhetőek */
        <? if ($o->isMy()):?>
        $('#reordersuccess').dialog({
		autoOpen: false,
        	width: 500,
		title: '<?php echo __('Role rearrangement')?>',
		buttons: {
		"OK": function() {
			$( this ).dialog( "close" );
			}
		}
	});
        $('.roles').sortable({
		opacity: 0.6,
		cursor: 'move',
                scroll: true,
                revert: true,
                placeholder: 'ui-state-highlight',
                axis: 'y',
                handle: '.rolehead',
                update: function(){
                     $('#reordersuccess').dialog("open");
                     var order = $('.roles').sortable("serialize");
                     $.post("<?php echo  url_for('show/roleReorder') ?>", order, function(data){});
                }
        });
        <? endif ?>

        /* info felugrók */
        $('#hint_button').click(function(){
          $('#hint').dialog('open');
        });
        $('#hint').dialog({
		autoOpen: false,
        	width: 500,
		title: '<?php echo __('Hints'); ?>'
	});
        /* Nem linkelt principal */
        $('#not_linked_principal').dialog({
		autoOpen: false,
        	width: 500,
		title: '<?php echo __('Unlinked principal')?>'
	});
	$('.not_linked_principal').click(function() {
		$('#not_linked_principal').dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
        /* Szereplő névjegye */
        $('.namecard').dialog({
		autoOpen: false,
        	width: 500,
		title: '<?php echo __('Principal details')?>'
	});
        /* Jogosultság névjegye */
        $('.entitlementcard').dialog({
		autoOpen: false,
        	width: 500,
		title: '<?php echo __('Entitlement details')?>'
	});
	
	$('.entitlementpackcard').dialog({
		autoOpen: false,
        	width: 500,
		title: '<?php echo __('Entitlement pack details')?>'
	});
	
        /* Szolgáltatás névjegye */
        $('.servicecard').dialog({
		autoOpen: false,
        	width: 600,
		title: '<?php echo __('Service details')?>'
	});
        /* Meghívó névjegye */
        $('.invitationcard').dialog({
		autoOpen: false,
        	width: 500,
		title: '<?php echo __('Invitation details')?>'
	});

<?php foreach($rs as $r) :?>  
	var $rd<?php echo  $r->getId()?> = $('#role_delete_<?php echo  $r->getId()?>')
		.dialog({
			autoOpen: false,
			title: '<?php echo __('Delete %rname% role', array("%rname%"=>$r->getName()))?>',
                        modal: true,
                        width: 500,
                        buttons: {
				"<?php echo __('Cancel')?>": function() {
					$( this ).dialog( "close" );
				},
				"<?php echo __('Delete')?>": function() {
                                        $(location).attr('href','<?php echo  url_for("show/deleteRole?id=".$r->getId())?>');
				}
			}
		});
	$('#role_delete_button_<?php echo  $r->getId()?>').click(function() {
		$rd<?php echo  $r->getId()?>.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});

	var $ru<?php echo  $r->getId()?> = $('#role_update_<?php echo  $r->getId()?>')
		.dialog({
			autoOpen: false,
			title: '<?php echo __('Update %rname% role', array("%rname%"=>$r->getName()))?>',
                        modal: true,
                        width: 500
		});
	$('#role_update_button_<?php echo  $r->getId()?>').click(function() {
		$ru<?php echo  $r->getId()?>.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
        
	$('#role_hide_button_<?php echo  $r->getId()?>').click(function() {
		$('.r_<?php echo  $r->getId()?>').slideUp();
                $('#role_show_button_<?php echo  $r->getId()?>').show();
                $('#role_hide_button_<?php echo  $r->getId()?>').hide();
	});
	$('#role_show_button_<?php echo  $r->getId()?>').click(function() {
		$('.r_<?php echo  $r->getId()?>').slideDown();
                $('#role_show_button_<?php echo  $r->getId()?>').hide();
                $('#role_hide_button_<?php echo  $r->getId()?>').show();
	});

<? endforeach ?>
});
</script>
