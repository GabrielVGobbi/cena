<?php if ($tipo == 'PARCIAL') : ?>

    <input id="checkEtapa<?php echo $etp['id_etapa_obra']; ?>" class="flat-red" name="check[]" <?php echo ($etp['parcial_check'] == '0' ? '' : 'checked'); ?> type="checkbox">

<?php else : ?>

    <?php if ($check == 1) : ?>

        <input id="checkEtapa<?php echo $etp['id_etapa_obra']; ?>" class="flat-blue" name="check[]" <?php echo ($etp['check'] == '0' ? '' : 'checked'); ?> type="checkbox" value="<?php echo $etp['id']; ?>">

    <?php else : ?>

        <input disabled id="checkEtapa<?php echo $etp['id_etapa_obra']; ?>" class="flat-blue" name="check[]" <?php echo ($etp['check'] == '0' ? '' : 'checked'); ?> type="checkbox" value="<?php echo $etp['id']; ?>">

    <?php endif; ?>


<?php endif; ?>