<?php if ($tipo == 'PARCIAL') : ?>

    <input id="checkEtapa<?php echo $etp['id_etapa_obra']; ?>" class="flat-red" name="check[]" <?php echo ($etp['parcial_check'] == '0' ? '' : 'checked'); ?> type="checkbox">

<?php else : ?>


    <input id="checkEtapa<?php echo $etp['id_etapa_obra']; ?>" <?php echo $this->userInfo['user']->hasPermission('obra_edit') ? '' : 'disabled' ?> class="flat-blue" name="check[]" <?php echo ($etp['check'] == '0' ? '' : 'checked'); ?> type="checkbox" value="<?php echo $etp['id']; ?>">


<?php endif; ?>