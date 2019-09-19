<?php
$etapa = $array[0]['id_etapa_obra'] - 1;
$etapaCheck = $this->etapa->check($etapa, $array[0]['id_obra'], $array[0]['tipo']);
?>

<form id="obra" action="<?php echo BASE_URL; ?>obras/editEtapaObra/<?php echo $array[0]['id_etapa_obra']; ?>" method="post">
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 15%">Ações</th>
                <th>Responsavel</th>
                <th>Data Programada</th>
                <th>Data Inicada</th>
                <th>Tempo de Atividade</th>
                <th>Liberação Parcial</th>

            </tr>
        </thead>
        <tbody>

            <tr>
                <td>
                    <?php if ($etapaCheck == 1 || $etapaCheck == '') : ?>

                        <a type="button" data-toggle="modal" data-target="#editarEtapa<?php echo $array[0]['id_etapa_obra']; ?>" class="btn btn-info"><i class="fa fa-fw fa-check-square-o"></i></a>
           

                        <button class="btn btn-danger" data-toggle="popover" title="Remover?" data-content="<a href='<?php echo BASE_URL ?>obras/obra_etapa_delete/<?php echo $array[0]['id_etapa_obra']; ?>/<?php echo $array[0]['id_obra']; ?>' class='btn btn-danger'>Sim</a> <button type='button' class='btn btn-default pop-hide'>Não</button>">
																<i class="fa fa-fw fa-trash"></i>
															</button>
                    <?php endif; ?>

                </td>
                <td><?php echo $array[0]['responsavel']; ?></td>
                <td><?php echo $array[0]['data_programada']; ?></td>
                <td><?php echo $array[0]['data_iniciada']; ?></td>
                <td><?php echo $array[0]['tempo_atividade']; ?></td>

                <td>
                    <?php if ($array[0]['parcial_check'] == 0) : ?>
                        <button type="button" id="parcial_check<?php echo $array[0]['id_etapa_obra']; ?>" data-toggle="tooltip" title="" data-original-title="liberação parcial" class="btn btn-warning"><i class="fa fa-fw fa-close"></i></button>

                    <?php elseif ($array[0]['parcial_check'] == 1) : ?>
                        <a href="<?php echo BASE_URL; ?>obras/updateEtapa/<?php echo $array[0]['id_etapa']; ?>/<?php echo $array[0]['id_obra']; ?>" data-toggle="tooltip" title="" data-original-title="Concluir" class="btn btn-success"><i class="fa fa-fw fa-check"></i></a>
                    <?php elseif ($array[0]['parcial_check'] == 2) : ?>

                    <?php endif; ?>
                </td>
            </tr>

        </tbody>
    </table>
</form>

<script>
    $(function() {
        $('#parcial_check' + <?php echo $array[0]['id_etapa_obra']; ?>).on('click', function(event) {

            var q = <?php echo $array[0]['id_etapa_obra']; ?>;
            checked = '0';
            idobra = <?php echo $array[0]['id_obra']; ?>;
            tipo = '0';
            <?php if (isset($_GET['tipo'])) : ?>
                <?php if ($_GET['tipo'] == '') : ?>
                    tipo = '0';
                <?php else : ?>
                    tipo = <?php echo $_GET['tipo']; ?>;
                <?php endif; ?>

            <?php endif; ?>
            $.ajax({

                url: BASE_URL + 'ajax/parcialCheck',
                type: 'POST',
                data: {
                    id_etapa: q,
                    checked: checked,
                    id_obra: idobra
                },
                dataType: 'json',
                success: function(json) {

                    window.location.href = BASE_URL + "obras/edit/" + idobra + '?tipo=' + tipo;

                },
            });
        });

    });
</script>