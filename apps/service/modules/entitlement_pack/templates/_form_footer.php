
<?= image_tag("icons/arrow_refresh",array("id"=>"regenerate","class"=>"button")) ?>
<script>
$(document).ready(function() {
  /*$("#service_token").click(8);*/
  if ($("#entitlement_pack_token").val() ==  "" )
  {
    $("#entitlement_pack_token").val($.password(24));
  }
  $("#entitlement_pack_token").after($("#regenerate"));
  $("#regenerate").click(function() {
    $("#entitlement_pack_token").val($.password(24));
  });
});
</script>
