<div class="col-md-12">
    <div class="box box-default box-solid">
        <div class="row">
            <div class="col-md-12">
                <div class="box-header with-border">
                    <h3 class="box-title">Cliente "<?php echo $obr['cliente_apelido']; ?>"</h3>
                </div>
                <?php if (($obr['id_departamento'] != 0)) : ?>

                    <div class="box-body" style="">
                        
                        <div class="col-md-3" style="margin-bottom:6px;margin-top:2px">
                            <div class="form-group">
                                <label>Departamento</label>

                                <select class="form-control select2 deptSelecionado" style="width: 100%;" name="cliente_departamento" id="cliente_departamento" aria-hidden="true">
                                    <option value="">selecione</option>
                                    <?php foreach ($departamento_cliente as $cliDep) : ?>

                                        <option <?php echo ((isset($obr['id_departamento']) && $obr['id_departamento'] == $cliDep['id_departamento'])) ?  'selected' : '' ?> value="<?php echo $cliDep['id_departamento']; ?>"><?php echo $cliDep['dep_responsavel'] ?></option>

                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3" style="margin-bottom:6px;">
                            <label>Telefone Fixo</label>
                            <input type="text" class="form-control" disabled name="departamento_telefone_fixo" id="departamento_telefone_fixo" autocomplete="off">
                        </div>

                        <div class="col-md-3" style="margin-bottom:6px;">
                            <label>Telefone Celular</label>
                            <input type="text" class="form-control" disabled name="departamento_telefone_celular" id="departamento_telefone_celular" autocomplete="off">
                        </div>

                        <div class="col-md-3" style="margin-bottom:6px;">
                            <label>Email</label>
                            <input type="text" class="form-control" disabled name="departamento_email" id="departamento_email" autocomplete="off">
                        </div>



                    </div>
                <?php else : ?>

                   
                    <div class="col-md-3" style="margin-bottom:6px;margin-top:2px">
                        <div class="form-group">
                            <label>Departamento</label>



                            <?php if (!empty($departamento_cliente)) : ?>
                                <select class="form-control select2 deptSelecionado" style="width: 100%;" name="cliente_departamento" id="cliente_departamento" aria-hidden="true">


                                    <option value="">selecione</option>

                                    <?php foreach ($departamento_cliente as $cliDep) : ?>

                                        <option <?php echo ((isset($obr['id_departamento']) && $obr['id_departamento'] == $cliDep['id_departamento'])) ?  'selected' : '' ?> value="<?php echo $cliDep['id_departamento']; ?>"><?php echo $cliDep['dep_responsavel'] ?></option>

                                    <?php endforeach; ?>

                                </select>


                            <?php else : ?>

                                <input type="text" class="form-control" disabled name="" id="" value="Cliente sem departamento" autocomplete="off">

                            <?php endif; ?>


                        </div>
                    </div>


                    <div class="col-md-3" style="margin-bottom:6px;">
                        <label>Telefone Fixo</label>
                        <input type="text" class="form-control" disabled name="departamento_telefone_fixo" id="departamento_telefone_fixo" autocomplete="off">
                    </div>

                    <div class="col-md-3" style="margin-bottom:6px;">
                        <label>Telefone Celular</label>
                        <input type="text" class="form-control" disabled name="departamento_telefone_celular" id="departamento_telefone_celular" autocomplete="off">
                    </div>


                    <div class="col-md-3" style="margin-bottom:6px; ">
                        <label>Email</label>
                        <input type="text" class="form-control" disabled name="departamento_email" id="departamento_email" autocomplete="off">
                    </div>


                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<script>
    $(function() {

        $(document).ready(getDep);

        $('#cliente_departamento').change(function() {
            $('#departamento_email').val('');
            $('#departamento_telefone_celular').val('');
            $('#departamento_telefone_fixo').val('');


            $("#departamento_telefone_celular").css("display", "none");
            $("#departamento_telefone_fixo").css("display", "none");
            $("#departamento_email").css("display", "none");

            getDep();
        });

        function getDep() {

            var departamento_selecionado = $('.deptSelecionado').select2('data');

            if (departamento_selecionado)
                var id_departamento = departamento_selecionado[0].id;

            if (id_departamento != '') {

                $.ajax({

                    url: BASE_URL + 'ajax/getDepartamentoById',
                    type: 'POST',
                    data: {
                        id_departamento: id_departamento,
                    },
                    dataType: 'json',
                    success: function(json) {

                        $("#departamento_telefone_celular").css("display", "flex");
                        $("#departamento_telefone_fixo").css("display", "flex");

                        $("#departamento_email").css("display", "flex");

                        $('#departamento_email').val(json.dep_email);
                        $('#departamento_telefone_celular').val(json.dep_telefone_celular);
                        $('#departamento_telefone_fixo').val(json.dep_telefone_fixo);

                    },
                });
            }

        }



    });
</script>