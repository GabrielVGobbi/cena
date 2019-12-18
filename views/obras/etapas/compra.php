<?php if ($array[0]['tipo'] == COMPRA && $array[0]['quantidade_obra'] == 0 ) :  ?>

<?php else : ?>
    <form id="compras" action="<?php echo BASE_URL; ?>obras/editEtapaObra/<?php echo $array[0]['id_etapa_obra']; ?>" method="post">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 15%">Ações</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody>
                <tr style="display:;">
                    <td>
                        <a type="button" data-toggle="modal" data-target="#editarEtapa<?php echo $array[0]['id_etapa_obra']; ?>" class="btn btn-info"><i class="fa fa-fw fa-check-square-o"></i></a>
                        <button class="btn btn-danger" data-toggle="popover" title="Remover?" data-content="<a href='<?php echo BASE_URL ?>obras/obra_etapa_delete/<?php echo $array[0]['id_etapa_obra']; ?>/<?php echo $array[0]['id_obra']; ?>' class='btn btn-danger'>Sim</a> <button type='button' class='btn btn-default pop-hide'>Não</button>">
                            <i class="fa fa-fw fa-trash"></i>
                        </button>
                    </td>
                    <td><?php echo $array[0]['quantidade_obra']; ?></td>
                    <td><?php echo $array[0]['preco_obra']; ?></td>
                    <td><?php echo $array[0]['tipo_compra_obra']; ?></td>
                </tr>
                <tr style="display:none;">
                    <td></td>
                    <td>
                        <button type="submit" data-toggle="tooltip" title="" data-original-title="Salvar" class="btn btn-success"><i class="fa fa-fw fa-check-square-o"></i></button>
                        <button type="button" data-toggle="tooltip" title="" data-original-title="Cancelar" class="btn btn-danger"><i class="fa fa-fw fa-close"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
<?php endif; ?>