  <?php
                                                            $prazo_etapa =  $etp['prazo_etapa'];
                                                            $prazo_restante =  date('d/m/y', strtotime('+' . $etp['prazo_etapa'] . 'days', strtotime($obr['data_obra'])));

                                                            $data_hoje = date('d-m-Y');




                                                            $data_inicial = $obr['data_obra'];
                                                            $nova_data = controller::SomarData($data_inicial, $etp['prazo_etapa']);


                                                            $data1 = new DateTime($data_hoje);
                                                            $data2 = new DateTime($nova_data);

                                                            $intervalo = $data1->diff($data2);


                                                            $mes = ($intervalo->m != '0' ? $intervalo->m . ' meses e ' : "");
                                                            $msg = 'Restam: ' . $mes . '' . $intervalo->d . ' Dia(s)';


                                                            if (strtotime(date('d-m-Y')) > strtotime($nova_data)) {
                                                                $check = 'danger';
                                                                $atraso = 'danger';
                                                                $msg = 'Atrasado em ' . $intervalo->d . ' Dia(s)';
                                                            } elseif (strtotime(date('d-m-Y')) == strtotime($nova_data)) {
                                                                $check = 'warning';
                                                                $msg = 'Entrega Hoje';
                                                            } elseif (strtotime(date('d-m-Y')) < strtotime($nova_data)) {
                                                                $check = 'success';
                                                                $msg = $mes . $intervalo->d . ' Dia(s) Restante(s)';
                                                            }
                                                            if ($etp['check'] == '1') {
                                                                $msg = 'Concluido';
                                                                $check = 'success';
                                                                $atraso = 'success';
                                                            }

                                                            ?>
                                                        <li>
                                                            <input class="checkEtapa<?php echo $obr[0];?>" name="check[]" <?php echo ($etp['check'] == '0' ? '' : 'checked'); ?> type="checkbox" value="<?php echo $etp['id']; ?>">
                                                            <span class="text"><?php echo $etp['etp_nome']; ?></span>
                                                            <small style="    font-size: 12px;" class="label label-<?php echo $check; ?>"><i class="fa fa-clock-o"></i> <?php echo $msg; ?></small>
                                                            
                                                        </li>