<h2><?php echo __('Pending invitations')?></h2>

<table>
<tr>
 <th>
  <?__('E-mail')?>
 </th>
 <th>
  <?__('Invited to')?>
 </th>
 <th>
  <?__('Date of invitation')?>
 </th>
 <th>
  <?__('Number of e-mails sent')?>
 </th>
 <th>
  <?__('Date of last message')?>
 </th>
 <th>
  <?php echo  image_tag("icons/arrow_refresh",array("title"=>__("Resend selected invitations"))) ?>
  <?php echo  image_tag("icons/delete",array("title"=>_("Delete selected invitations"))) ?>
  <input type="checkbox" name="all">
 </th>
</tr>

<? foreach($pis as $i): ?>
<tr>
 <td>
  <?php echo  $i->getEmail() ?>
 </td>
 <td>
  <? include_partial("show/showRole",array("r"=>$i->getRole())) ?>
 </td>
 <td>
  <?php echo  $i->getCreatedAt() ?>
 </td>
 <td>
  <?php echo  $i->getCounter() ?>
 </td>
 <td>
  <?php echo  $i->getLastReinviteAt() ?>
 </td>
 <td>
  <?php echo  image_tag("icons/arrow_refresh",array("title"=>__("Resend invitation"), "class"=>"reinvite","id"=>$i->getId())) ?>
  <?php echo  image_tag("icons/delete",array("title"=>__("Delete invitation"),"class"=>"delete","id"=>$i->getId())) ?>
  <input type="checkbox" name="id_<?php echo  $i->getId() ?>">
 </td>
</tr>
<?endforeach?>
</table>

<h2><?php echo __('Accepted invitations')?></h2>

<table>
<tr>
 <th>
  <?__('E-mail')?>
 </th>
 <th>
  <?__('Invited to')?>
 </th>
 <th>
  <?__('Date of invitation')?>
 </th>
 <th>
  <?php echo __('Date accepted')?>
 </th>
</tr>

<? foreach($ais as $i): ?>
<tr>
 <td>
  <?php echo  $i->getEmail() ?>
 </td>
 <td>
  <? include_partial("show/showRole",array("r"=>$i->getRole())) ?>
 </td>
 <td>
  <?php echo  $i->getCreatedAt() ?>
 </td>
 <td>
  <?php echo  $i->getAcceptAt() ?>
 </td>
</tr>
<?endforeach?>
</table>

<? include_partial("global/noticeDialog")?>

<script>
$(document).ready(function() {
   /* Szerepkör névjegye */
   $('.rolecard').dialog({
      autoOpen: false,
      width: 600,
      title: 'Szerepkör adatai'
   });

  $('.delete').click(function() {
    window.location.replace("<?php echo  url_for("invitePrincipal/delete?id=") ?>" + $(this).attr("id"));
  });
  $('.reinvite').click(function() {
    window.location.replace("<?php echo  url_for("invitePrincipal/reinvite?id=") ?>" + $(this).attr("id"));
  });
});
</script>
