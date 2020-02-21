<div class="box box-default box-solid collapsed" id="filtro_<?php echo $viewData['pageController']; ?>" style="display:none;">
    <div class="box-body" style="">
        <form method="GET">
            <div class="box-body">
                <div class="row">


                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="fl_art_nome">Nome da Obra</label>
                            <input class="form-control" id="filtro_descricao" name="filtros[nome_obra]" placeholder="" autocomplete="off" value="<?php echo isset($_GET['filtros']['nome_obra']) ? $_GET['filtros']['nome_obra'] : ''; ?>">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fl_art_nome">Numero de Nota (Faturamento)</label>
                            <input class="form-control" id="filtro_descricao" name="filtros[nf_n]" placeholder="" autocomplete="off" value="<?php echo isset($_GET['filtros']['nf_n']) ? $_GET['filtros']['nf_n'] : ''; ?>">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="popver_urgencia" style="margin-right: 1px;position: relative;top: 37px;" data-target="webuiPopover1">
                            <input type="checkbox" id="checkUrgencia" class="checkbox_desgn "  name="timeline-photo" value="">
                            <span>
                                <span class="icon unchecked">
                                    <span class="mdi mdi-check"></span>
                                </span>
                                Só obras a Faturar
                            </span>
                        </label>
                    </div>

                    <div class="col-md-3">
                        <label class="popver_urgencia" style="margin-right: 1px;position: relative;top: 37px;" data-target="webuiPopover1">
                            <input type="checkbox" id="checkUrgencia" class="checkbox_desgn "  name="timeline-photo" value="">
                            <span>
                                <span class="icon unchecked">
                                    <span class="mdi mdi-check"></span>
                                </span>
                                Só obras a Receber
                            </span>
                        </label>
                    </div>

            

                </div>

                <div class="pull-right">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>
    </div>
</div>