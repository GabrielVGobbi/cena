<?php

// nome do arquivo
$fileName = 'Financeiro' . '.xls';
// Abrindo tag tabela e criando título da tabela
$html = '';
$html .= '<table border="1">';
$html .= '<tr>';
$html .= '<th colspan="6">' . 'Financeiro' . '</th>';
$html .= '</tr>';
// criando cabeçalho
$html .= '<tr>';
$html .= '<th>Nome da Obra</th>';
$html .= '<th>Valor Total Negociado</th>';
$html .= '<th>Valor a Receber</th>';
$html .= '<th>Valor Recebido</th>';
$html .= '<th>Liberado Faturar</th>';
$html .= '<th>Saldo</th>';

$html .= '</tr>';
// criando o conteúdo da tabela 


foreach ($tableDados as $k) {
	$saldo = intval($k['valor_negociado']) - intval($k['faturado']);
	$html .= '<tr>';
	$html .= '	<td>' . $k['obr_razao_social'] . '</td>';
	$html .= '	<td>' . 'R$ '.' '.controller::number_format($k['valor_negociado']) . '</td>';
	$html .= '	<td>' . 'R$ '.controller::number_format($k['receber'])  . '</td>';
	$html .= '	<td>' . 'R$ '.controller::number_format($k['recebido'])  . '</td>';
	$html .= '	<td>' . 'R$ '.controller::number_format($k['faturar'])  . '</td>';
	$html .= '	<td>' . 'R$ '.controller::number_format($saldo)  . '</td>';



	$html .= '</tr>';
}


$html .= '</table>';

// configurando header para download
header("Content-Description: PHP Generated data");
header("Content-Type: application/x-msexcel");
header("Content-Disposition: attachment; filename=\"{$fileName}\"");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Pragma: no-cache");
// envio conteúdo
echo $html;
exit;
