<form action="<?php echo url_for('getentitlements/index') ?>" method="POST">
  <table>
    <?php echo $form ?>
    <tr>
      <td colspan="2">
        <input type="submit" />
      </td>
    </tr>
  </table>
</form>
<? if(isset($es)) :?>
<ul>
  <li>Kérdés</li>
  <ul>
    <li>Principal:   <?php echo $p ?></li>
    <li>Service:   <?php echo $s ?></li>
  </ul>
  <li>Jogok</li>
  <? if ($es != NULL):?>
    <ul>
    <? foreach($es as $e) :?>
      <li><?= $e->getName() ?></li>
    <? endforeach ?>
    </ul>
  <? else:?>
  Nincs jogosultság ezen az alkalmazáson.
  <? endif?>
  <li>Urik</li>
  <? if ($uris != NULL):?>
    <ul>
    <? foreach($uris as $uri) :?>
      <li><?= $uri ?></li>
    <? endforeach ?>
    </ul>
  <? else:?>
  Nincs URI ezen az alkalmazáson.
  <? endif?>
</ul>
<? endif ?>
