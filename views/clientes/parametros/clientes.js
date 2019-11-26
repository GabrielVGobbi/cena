
var maskCpfOuCnpj = IMask(document.getElementById('cpfcnpj'), {
    mask: [{
        mask: '000.000.000-00',
        maxLength: 11
    },
    {
        mask: '00.000.000/0000-00'
    }
    ]
});

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

$(function () {
   
    $("#submit").click(function () {
        var cnpj = $('#cpfcnpj').val();
        var nome = $('#cliente_nome').val();
        var id = $('#id_cliente').val();

        if(cnpj.length > 0)
            (cnpj.length == 18)
                ? $("#formcpnj").removeClass("has-error")
                : $("#formcpnj").addClass("has-error") + toastr.error('cpnj invalido')

        nome.length != ''
            ? $("#formnome").removeClass("has-error") + (validateClienteDouble(nome, id))
            : $("#formnome").addClass("has-error") + toastr.error('nome invalido')

    });

    //verifica se ja existe um cliente com esse nome
    function validateClienteDouble(nome, id) {
        var verificar = $('#cliente_nome').attr('data-name');

        $.ajax({
            url: BASE_URL + 'ajax/ValidateClienteDouble',
            type: 'POST',
            data: {
                nome: nome,
                id: id
            },
            dataType: 'json',
            success: function (json) {
                $(document).ready(reload(json));
            },
        });
    }

    function reload(data) {
        if (data == true) {
            $("#formnome").addClass("has-warning");
            $("#validate").val("false");
            toastr.warning('Ja existe um cliente com esse nome');
        } else {
            $("#formnome").removeClass("has-error");
            $("#formnome").removeClass("has-warning");
            $(document).ready(submit);
        }

    }

    function submit() {
        if (!$(".form-group").hasClass("has-warning") && !$(".form-group").hasClass("has-error"))
            $("#cliete_edit").submit();
    }

    $("#copyEmail").on('click', function (e) {
      
        var text = document.querySelector("#dep_email");
        text.select();

        try {
            var text = document.execCommand('copy');
            if (text) { toastr.success('email copiado'); }
        } catch (e) {
            toastr.success(e);
        }

    });


});
