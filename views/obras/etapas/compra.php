

<?php if ($variavel) : ?>
    <?php foreach ($variavel as $var) : ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 15%">Ações</th>
                    <th>Nome Variavel</th>
                    <th>Quantidade Variavel</th>
                    <th>Preço Variavel</th>
                    <th>Tipo</th>
                    <th>Total</th>

                </tr>
            </thead>
            <tbody>
                <tr style="display:;">
                    <td>
                        <a type="button" data-toggle="modal" data-target="#editarVariavel<?php echo $var['etcc_id']; ?>" class="btn btn-info"><i class="fa fa-fw fa-check-square-o"></i></a>
                        
                    </td>
                    <td><?php echo $var['nome_variavel']; ?></td>
                    <td><?php echo $var['etcc_quantidade']; ?></td>
                    <td><?php echo $var['preco_variavel']; ?></td>
                    <td><?php echo $array[0]['tipo_compra_obra']; ?></td>
                    <td>R$ <?php echo controller::number_format(intval($var['preco_variavel']) * intval($var['etcc_quantidade'])) ?></td>

                </tr>
                <?php include("variavel.php"); ?>
            </tbody>
        </table>

    <?php endforeach; ?>
<?php else : ?>
    <form id="compras" action="<?php echo BASE_URL; ?>obras/editEtapaObra/<?php echo $array[0]['id_etapa_obra']; ?>" method="post">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 15%">Ações</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Tipo</th>
                    <th>Total</th>

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
                    <td><?php echo $verify['etcc_quantidade']; ?></td>
                    <td><?php echo $array[0]['preco_obra']; ?></td>
                    <td><?php echo $array[0]['tipo_compra_obra']; ?></td>
                    <td>R$ <?php echo controller::number_format(intval($array[0]['preco_obra']) * intval($verify['etcc_quantidade'])); ?></td>

                </tr>

            </tbody>
        </table>
    </form>
<?php endif; ?>