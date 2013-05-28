<h2><?php echo __("Shared services")?></h2>

<div class="hentry">
<p>
<?php echo __("In this portal you can register your service. The target is that the VOs can use your service and its entitlements.")?>
</p>

            <? $onclickurl='parent.location="'.url_for("service/new").'"'; ?>
            <?php echo  image_tag("add",array(
                "id"=>"service_add_button",
                "class"=>"button",
                "title"=>__("Register your service"),
                "onClick"=>$onclickurl,
                )) ?>
</div>

<? include_partial("global/noticeDialog")?>


