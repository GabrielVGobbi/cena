function modalEditar(id, tipo) {

    $('#modalEditar' + tipo + id).modal('show');


}


function lerMensagem(id_not_user, link) {

    $(function () {

        $.ajax({

            url: BASE_URL + 'ajax/lerNotificacao',
            type: 'POST',
            data: {
                id_not_user: id_not_user
            },
            dataType: 'json',
            success: function (json) {

                window.location.href = link;

            },
        });

    });

}


$(function () {
    $('[data-toggle="popover"]').popover({ html: true });

    $(document).on('click', '.pop-hide', function () {
        $('.popover').popover('hide');
    });




});

function formata(v) {

    return parseFloat(v).toLocaleString("pt-BR", { minimumFractionDigits: 2 });
}

$(function () {

    //Initialize Select2 Elements
    $('.select2').select2()

    $('.select2-add-service').select2()


    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker({
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
    },
        function (start, end) {
            $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
    )

    //Date picker
    $('#datepicker').datepicker({
        autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('#checkRecebido').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    })





    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
        showInputs: false
    })
})
$(function () {



    $('input[type="checkbox"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });



    //marcar todos os CheckBox
    $('#marcarTodos').on('ifChecked', function (event) {
        $('.check').each(function () {
            $(this).iCheck('check');
        });
    });

    //Desmarcar todos os checkbox 
    $('#marcarTodos').on('ifUnchecked', function (event) {
        $('.check').each(function () {
            $(this).iCheck('uncheck');
        });
    });


    $('#mercado_live').on('ifChecked', function (event) {
        $('.dados-ml').show();
    });

    $('#mercado_live').on('ifUnchecked', function (event) {
        $('.dados-ml').hide();
    });

    $(".mailbox-star").click(function (e) {
        e.preventDefault();
        //detect type
        var $this = $(this).find("a > i");
        var glyph = $this.hasClass("glyphicon");
        var fa = $this.hasClass("fa");

        if (glyph) {
            $this.toggleClass("glyphicon-star");
            $this.toggleClass("glyphicon-star-empty");
        }

        if (fa) {
            $this.toggleClass("fa-star");
            $this.toggleClass("fa-star-o");
        }
    });
});

function openFiltro($name) {
    $('#filtro_' + $name).toggle();
}

$(function () {


    $("#newMensageChat").on("submit", function (event) {
        event.preventDefault();
        var data = $(this).serialize();

        $.ajax({
            url: BASE_URL + 'ajax/newMensageChat/',
            type: 'POST',
            data: data,
            dataType: 'json',
            
            success: function (json) {
               getMensage();
               $('input[name="message"]').val('')

            },
            error: function (xhr, ajaxOptions, thrownError) {
                toastr.error('Erro contate o administrador, Codigo MSGE123');
            }
        });
    });


    $('.new_servico').on('click', function (e) {

        e.preventDefault();

        html = '<label>Nome</label>        <input type="text" class="form-control" name="razao_social" id="razao_social" autocomplete="off" value="">';

        $('.servico').append(html);


    });

    $('#addDepartamento').on('click', function (e) {

        e.preventDefault();

        html = '<input type="hidden" class="form-control" name="dep[id_departamento][]" id="dep[id_departamento][]">';

        html += '<div class="col-md-3">';
        html += '    <div class="form-group">';
        html += '        <label>Responsavel</label>';
        html += '        <div class="input-group">';
        html += '            <div class="input-group-addon">';
        html += '                <i class="fa fa-fw fa-user-plus"></i>';
        html += '            </div>';
        html += '            <input type="text" class="form-control" name="dep[dep_responsavel][]" id="dep[dep_responsavel][]">';
        html += '        </div>';
        html += '    </div>';
        html += '</div>';
        html += '<div class="col-md-3">';
        html += '    <div class="form-group">';
        html += '        <label>Email</label>';
        html += '        <div class="input-group">';
        html += '            <div class="input-group-addon">';
        html += '                <i class="fa fa-envelope"></i>';
        html += '            </div>';
        html += '            <input type="text" class="form-control" name="dep[dep_email][]" id="dep[dep_email][]">';
        html += '        </div>';
        html += '    </div>';
        html += '</div>';
        html += '<div class="col-md-2">';
        html += '    <div class="form-group">';
        html += '        <label>Telefone Fixo</label>';
        html += '        <div class="input-group">';
        html += '            <div class="input-group-addon">';
        html += '                <i class="fa fa-phone"></i>';
        html += '            </div>';
        html += '            <input type="text" class="form-control" name="dep[dep_telefone_fixo][]" id="dep[dep_telefone_fixo][]">';
        html += '        </div>';
        html += '    </div>';
        html += '</div>';
        html += '<div class="col-md-2">';
        html += '    <div class="form-group">';
        html += '        <label>Telefone Celular</label>';
        html += '        <div class="input-group">';
        html += '            <div class="input-group-addon">';
        html += '                <i class="fa fa-phone"></i>';
        html += '            </div>';
        html += '            <input type="text" class="form-control" name="dep[dep_telefone_celular][]" id="dep[dep_telefone_celular][]"> ';
        html += '        </div>';
        html += '    </div>';
        html += '</div>';
        html += '<div class="col-md-2">';
        html += '    <div class="form-group">';
        html += '        <label>Função</label>';
        html += '        <div class="input-group">';
        html += '            <div class="input-group-addon">';
        html += '                <i class="fa fa-fw fa-suitcase"></i>';
        html += '            </div>';
        html += '            <input type="text" class="form-control" name="dep[dep_funcao][]" id="dep[dep_funcao][]"> ';
        html += '        </div>';
        html += '    </div>';
        html += '</div>';


        $('.addDepartamento').append(html);

    });

    $('.new_documento').on('click', function (e) {

        e.preventDefault();

        html = '<label>Nome</label>        <input type="text" class="form-control" name="nome_documento[]" id="nome_documento" autocomplete="off" value="">';

        $('.documento').append(html);


    });

    $('.new_etapa').on('click', function (e) {

        e.preventDefault();

        html = '<div class="col-md-10"><div class="form-group"><label>Sub-Serviço</label> <input type="text" class="form-control" name="etapas[nome_etapa][]" id="etapas[]" autocomplete="off"></div></div>';

        html += '<div class="col-md-2"> <label>Prazo</label><div class="input-group"><input type="text" class="form-control" name="etapas[prazo_etapa][]" id="etapas[]" autocomplete="off"><div class="input-group-btn"><div class="btn btn-default"><i></i> Dias </div> </div></div></div>';

        $('.etapa_add').append(html);


    });

    $('.new_variavel').on('click', function (e) {

        e.preventDefault();


        html = '<div class="row"> ';
        html += '<div class="col-md-4"><div class="form-group"> <label>Nome da Variavel</label><input type="text" class="form-control" name="variavel[nome_variavel][]" id="nome_variavel" autocomplete="off">';



        html += '</div> </div><div class="col-md-2"><div class="form-group"> <label>Preço</label><input value="R$ " type="text" class="form-control" name="variavel[preco_variavel][]" id="preco_variavel" autocomplete="off"></div></div>';
        html += '</div>';


        $('#new_variavel').append(html);


    });

    $('.new_variavel_edit').on('click', function (e) {

        e.preventDefault();

        html = '    <div class="row" style="    left: 10px;position: relative;">'
        html += '    <div class="col-md-4">'
        html += '        <div class="form-group" style="margin-right: 26px;margin-left: -10px;">'
        html += '            <label>Nome da Variavel</label>'
        html += '            <input type="text" class="form-control" value="" name="variavel[nome_variavel][]" id="nome_variavel" autocomplete="off">'
        html += '        </div>'
        html += '    </div>'

        html += '    <div class="col-md-2">'
        html += '        <div class="form-group"  style="margin-right: 26px;margin-left: -10px;">'
        html += '            <label>Preço</label>'
        html += '            <input type="text" class="form-control" name="variavel[preco_variavel][]" value="" id="preco_variavel" autocomplete="off">'
        html += '        </div>'
        html += '    </div>'
        html += '    </div>'

        $('#new_variavel_edit').append(html);


    });

    $('.new_service').on('click', function (e) {

        $('#new_service').toggle();
        $('#service_ok').toggle();

    });

    $('.new_obra').on('click', function (e) {

        $('#new_obra').toggle();
        //$('#obra_ok').toggle();

        $('.file_doc').attr('name', 'documento_arquivo');

    });




    $('.service_add').on('change', function (e) {

        if ($(".service_add>option:selected").text() != 'selecione') {

            var servico = '"' + $(".service_add>option:selected").text() + '"';
            $(".title-etapas").html("Adicionar Etapas para o Serviço " + servico);
            $('#etapas_col').toggle();
        }

    });




});

function add_service(obj) {
    var name = $('.select2-search__field').val()

    if (name != '' && name != undefined) {

        swal({
            title: "Tem certeza",
            text: "Você esta adicionando um Serviço: " + name,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {

            });
    } else {
        swal({
            title: "Por favor",
            text: "O Campo de adição não pode ser vazio!!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {

            });
    }
}



function darAcessoCliente(id) {

    $('#acessoUsuario' + id).modal('toggle');
}


function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('rua').value = ("");
    document.getElementById('bairro').value = ("");
    document.getElementById('cidade').value = ("");
    document.getElementById('uf').value = ("");
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('rua').value = (conteudo.logradouro);
        document.getElementById('bairro').value = (conteudo.bairro);
        document.getElementById('cidade').value = (conteudo.localidade);
        document.getElementById('uf').value = (conteudo.uf);

    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        toastr.error('cep não encontrado');
    }
}

function pesquisacep(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if (validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('rua').value = "consultando";
            document.getElementById('bairro').value = "consultando";
            document.getElementById('cidade').value = "consultando";
            document.getElementById('uf').value = "consultando";


            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = '//viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            toastr.error('tem um numero a mais no cep');
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};

function moeda(a, e, r, t) {
    let n = ""
        , h = j = 0
        , u = tamanho2 = 0
        , l = ajd2 = ""
        , o = window.Event ? t.which : t.keyCode;
    if (13 == o || 8 == o)
        return !0;
    if (n = String.fromCharCode(o),
        -1 == "0123456789".indexOf(n))
        return !1;
    for (u = a.value.length,
        h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
        ;
    for (l = ""; h < u; h++)
        -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
    if (l += n,
        0 == (u = l.length) && (a.value = ""),
        1 == u && (a.value = "0" + r + "0" + l),
        2 == u && (a.value = "0" + r + l),
        u > 2) {
        for (ajd2 = "",
            j = 0,
            h = u - 3; h >= 0; h--)
            3 == j && (ajd2 += e,
                j = 0),
                ajd2 += l.charAt(h),
                j++;
        for (a.value = "",
            tamanho2 = ajd2.length,
            h = tamanho2 - 1; h >= 0; h--)
            a.value += ajd2.charAt(h);
        a.value += r + l.substr(u - 2, u)
    }
    return !1
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function openChat(v) {

    if ($("#colapse").hasClass("collapsed-box")) {
        $('#chat').width('300');
        $('.chat-title').html('Chat');


        $.ajax({
            url: BASE_URL + "ajax/lerMensagesALL",
            success: function (data) {
                $('.titlemensagem').html('0');
                $('.titlemensagem').attr('data-original-title', '0 Nova(s) Mensagen(s)');

            }
        });

    } else {
        setTimeout(function () { $('#chat').width('70'); $('.chat-title').html(''); }, 300);
    }

}
function getMensage() {

    $.ajax({
        url: BASE_URL + "ajax/getMensage",
        success: function (data) {
            $('#chatFor').html(data);
        }
    });
}

function getMensageNaoLidas() {

    $.ajax({
        url: BASE_URL + "ajax/getMensageNaoLidas",
        success: function (data) {
            
            $('.titlemensagem').html(data);
            $('.titlemensagem').attr('data-original-title', data+' Nova(s) Mensagen(s)');

        }
    });
}







