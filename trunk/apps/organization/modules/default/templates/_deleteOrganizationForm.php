A(z) <strong><?php echo  $o->getName() ?></strong> nevű szervezet törlésére készül!!! Ha törli, ezzel együtt törtlődnek a tagok és jogosultások, szerepkörök kapcsolásai is. Nagyon fontolja meg, hogy mire kattint, ez az utolsó figyelmeztetés!

<form action="<?php echo url_for('default/processDeleteOrgForm') ?>" method="POST" >
  <input type="hidden" name="id" value="<?php echo  $o->getId() ?>">
  <table>
    <tr>
      <th>Ha valóban törli, gépelje be, hogy "Igen" (idézőjelek nélkül, nagy kezdőbetűvel)</th>
      <td>
        <input name="confirm">
      </td>
    <tr>
      <td colspan="2">
        <input type="submit" />
      </td>
    </tr>
  </table>
</form>
