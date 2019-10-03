<?php
    $etapa = $array[0]['id_etapa_obra'] - 1;
    //$etapaCheck = $this->etapa->check($etapa, $array[0]['id_obra'], $array[0]['tipo']);
?>
<form id="concessionaria" action="<?php echo BASE_URL; ?>obras/editEtapaObra/<?php echo $array[0]['id_etapa_obra']; ?>" method="post">
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 15%">Ações</th>
                <th>Nº Nota</th>
                <th>Data de Abertura</th>
                <th>Prazo de Atendimento</th>
            </tr>
        </thead>
        <tbody>

            <tr style="display:;">
                <td>
                   
                        <a type="button" data-toggle="modal" data-target="#editarEtapa<?php echo $array[0]['id_etapa_obra']; ?>" class="btn btn-info"><i class="fa fa-fw fa-check-square-o"></i></a>
                  
                    <a type="button" data-toggle="tooltip" title="" data-original-title="Deletar" class="btn btn-danger" href="<?php echo BASE_URL ?>obras/obra_etapa_delete/<?php echo $array[0]['id_etapa_obra']; ?>/<?php echo $array[0]['id_obra'];?>"><i class="ion ion-trash-a"></i></a>

                </td>
                <td><?php echo $array[0]['nota_numero']; ?></td>
                <td><?php echo $array[0]['data_abertura']; ?></td>
                <td><?php echo $array[0]['prazo_atendimento']; ?></td>
            </tr>

            <tr style="display:none;">
                <td></td>
                <td><input name="COMnota_numero" value="<?php echo $array[0]['nota_numero']; ?>"></td>
                <td><input name="COMdata_abertura" value="<?php echo $array[0]['data_abertura']; ?>"></td>
                <td><input name="COMprazo_atendimento" value="<?php echo $array[0]['prazo_atendimento']; ?>"></td>
                <td>
                    <button type="submit" data-toggle="tooltip" title="" data-original-title="Salvar" class="btn btn-success"><i class="fa fa-fw fa-check-square-o"></i></button>
                    <button type="button" data-toggle="tooltip" title="" data-original-title="Cancelar" class="btn btn-danger"><i class="fa fa-fw fa-close"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</form>