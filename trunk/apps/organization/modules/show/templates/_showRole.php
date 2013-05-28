<? $divid = uniqid(); ?>
<?php echo  $r.'<span class="idekelleneright">'.image_tag("icons/information",array("class"=>"rolecard_button","id"=>"rolecard_button_".$divid)) ?></span>
<br>
<div class="rolecard" id="rolecard_<?php echo  $divid ?>">
 <div>
 <?php echo __('Organization name:')?><span class="right"><?php echo  $r->getOrganization()->getName()?></span>
 </div>
 <div>
 <?php echo __('Role neve:')?><span class="right"><?php echo  $r->getName() ?></span>
 <div>
</div>
<script>
$(document).ready(function() {
        /* Szerepkör névjegye */
        $('#rolecard_button_<?php echo  $divid ?>').click(function() {
                $('#rolecard_<?php echo  $divid ?>').dialog('open');
                return false;
        });
});
</script>
