<h2><?php echo __('Virtual organizations')?></h2>

<div class="hentry">
<?php echo __('
<p>
What is Virtual Organization?
</p>
<p>
Virtual Organization is a dynamic set of individuals or institutions defined around a set of resource-sharing rules and conditions.
</p>

<p>
If you dont have any Virtual Organization, you can create here: 
</p>
') ?>
    <?php echo  image_tag("add",array("id"=>"org_new_button", "class"=>"button","title"=>__("Create new organization"))) ?>
    <div id="org_new">
            <? include_partial("newOrganizationForm",array("form"=>new OrganizationForm())) ?>
    </div>
</div>

<? include_partial("global/noticeDialog")?>

<script>
$(document).ready(function() {
        var $on = $('#org_new')
	    .dialog({
		autoOpen: false,
		title: '<?php echo __('Create organization')?>',
                    modal: true,
                    width: 500
		});
	$('#org_new_button').click(function() {
		$on.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
<?php foreach ($oos as $o) :?>
	var $od<?php echo  $o->getId()?> = $('#org_delete_<?php echo  $o->getId()?>')
		.dialog({
			autoOpen: false,
			title: '<?php echo  __('Delete organization named: %name%', array('%name%'=> $o->getName()))?>',
                        modal: true,
                        width: 500,
                        buttons: {
				"<?php echo __("Cancel")?>": function() {
					$( this ).dialog( "close" );
				}
			}
		});
	$('#org_delete_button_<?php echo  $o->getId()?>').click(function() {
		$od<?php echo  $o->getId()?>.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
<?php endforeach ?>
});
</script>
