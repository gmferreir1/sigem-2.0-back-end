<body>

<style>
    .label {
        font-weight: bold;
    }

    .border {
        border: 1px solid black;
    }

    .sub-border {
        border-top: none;
        border-left: none;
        border-bottom: none;
    }

    .text {
        margin-left: 5px;
        padding-top: 0px;
        margin-top: 0px;
        padding-bottom: 0px;
        margin-bottom: 0px;
    }

    .font-bold {
        font-weight: bold;
    }

</style>

<div style="border: 1px solid black; height: 90px; margin-bottom: 3px;">

    @include('printer.head')

    <div style="width: 100%;">

        <div style="width: 60%; margin-left: 30%; margin-top: 4%">
            <span style="font-size: 15px; font-weight: bold">
                PROPOSTA LOCAÇÃO DE IMÓVEL NÃO RESIDENCIAL Nº {{$data['code_reserve']}}
            </span>
        </div>

    </div>

    <div style="font-size: 8px; position: absolute; top: 3px; right: 20px; text-align: right; width: 300px;">Impresso em: {{date('d/m/Y')}} as {{date('H:i:s')}}</div>

</div>

<div>
    <div style="margin-top: 20px">
        <span>
            <span class="label">IMOVEL:</span>
            <span>({{$data['immobile_code']}}) {{uppercase($data['address'])}} {{uppercase($data['neighborhood'])}}</span>
        </span>
    </div>

    <div style="margin-top: 20px; font-weight: bold">
        PROPONENTE / INFORMAÇÕES COMPLEMENTARES
    </div>

    <div class="border" style="height: 43px; margin-top: 5px">
        <div style="width: 70%; float: left" class="border sub-border">
            <p class="text">Nome</p>
            <p class="text">{{uppercase($data['client_name'])}}</p>
        </div>

        <div style="width: 20%; float: left;">
            <p class="text">CPF</p>
            <p class="text">{{$data['client_cpf']}}</p>
        </div>
    </div>

    <div class="border" style="height: 45px; border-top: none">

        <div style="width: 20%; float: left; height: 45px" class="border sub-border">
            <p class="text">RG</p>
            <p class="text">{{uppercase($data['client_rg'])}}</p>
        </div>

        <div style="width: 35%; float: left; height: 45px" class="border sub-border">
            <p class="text">Profissão</p>
            <p class="text">{{$data['client_profession']}}</p>
        </div>

        <div style="width: 40%; float: left; border-right: none" class="border sub-border">
            <p class="text">Empresa</p>
            <p class="text">{{$data['client_company']}}</p>
        </div>

    </div>

    <div class="border" style="height: 45px; border-top: none">

        <div style="width: 20%; float: left; height: 45px" class="border sub-border">
            <p class="text">Fone 01</p>
            <p class="text">{{$data['client_phone_01']}}</p>
        </div>

        <div style="width: 20%; float: left; height: 45px" class="border sub-border">
            <p class="text">Fone 02</p>
            <p class="text">{{$data['client_phone_02']}}</p>
        </div>

        <div style="width: 20%; float: left; height: 45px" class="border sub-border">
            <p class="text">Fone 03</p>
            <p class="text">{{$data['client_phone_03']}}</p>
        </div>

        <div style="width: 30%; float: left; border-right: none" class="border sub-border">
            <p class="text">Email</p>
            <p class="text">{{$data['client_email']}}</p>
        </div>

    </div>

    <div class="border" style="height: 45px; border-top: none">

        <div style="width: 65%; float: left; height: 45px" class="border sub-border">
            <p class="text">Endereço</p>
            <p class="text">
                {{!$data['client_address'] ? '' : uppercase($data['client_address'])}}
                {{!$data['client_neighborhood'] ? '' : ' ,' . uppercase($data['client_neighborhood'])}}
            </p>
        </div>

        <div style="width: 30%; float: left; border-right: none" class="border sub-border">
            <p class="text">Cidade</p>
            <p class="text">{{!$data['client_city'] ? '' : uppercase($data['client_city'])}}</p>
        </div>

    </div>

    <div class="border" style="height: 45px; border-top: none">

        <div style="width: 17%; float: left; height: 45px" class="border sub-border">
            <p class="text">Paga aluguel ?</p>
            <p class="text">
                <span>( &nbsp; &nbsp; ) SIM</span>
                <span>( &nbsp; &nbsp; ) NÂO</span>
            </p>
        </div>

        <div style="width: 60%; float: left; height: 45px" class="border sub-border">
            <p class="text">Endereço</p>
            <p class="text">&nbsp;</p>
        </div>

        <div style="width: 8%; float: left; border-right: none" class="border sub-border">
            <p class="text">Valor R$</p>
            <p class="text">&nbsp;</p>
        </div>

    </div>

    <div class="border" style="height: 45px; border-top: none">

        <div style="width: 50%; float: left; height: 45px" class="border sub-border">
            <p class="text">Para quem ? / Fone</p>
        </div>

        <div style="width: 40%; float: left; border-right: none" class="border sub-border">
            <p class="text">Motivo Desta Locação</p>
            <p class="text">&nbsp;</p>
        </div>

    </div>

    <div style="margin-top: 20px; font-weight: bold">
        DADOS PARA CELEBRAÇÃO DO CONTRATO
    </div>
    <div style="margin-top: 10px; font-weight: bold">
        FINALIDADE
    </div>
    <div class="border" style="height: 45px; margin-top: 10px">

        <div style="width: 20%; float: left;" class="border sub-border">
            <p class="text">Ramo de Atividade</p>
            <p class="text">&nbsp;</p>
        </div>

        <div style="width: 30%; float: left;" class="border sub-border">
            <p class="text">Prazo Contrato</p>
            <p class="text">&nbsp;</p>
        </div>

        <div style="width: 20%; float: left;" class="border sub-border">
            <p class="text">Dia Pagamento</p>
            <p class="text">&nbsp;</p>
        </div>

        <div style="width: 20%; float: left; border-right: none" class="border sub-border">
            <p class="text">Valor R$</p>
            <p class="text">&nbsp;</p>
        </div>

    </div>

    <div class="border" style="height: 160px; margin-top: 10px; padding-left: 5px; padding-top: 10px">

        <div style="width: 95%; float: left;">
            <span>Forma Pagamento Aluguel: </span>
            <span style="margin-left: 10px">(&nbsp; &nbsp;) Na Administradora</span>
            <span style="margin-left: 10px; margin-right: 10px"> - </span>
            <span>(&nbsp; &nbsp;) Boleto Bancário - Tarifa por Conta do Locatário</span>
        </div>

        <div style="width: 95%; float: left; margin-top: 20px">
            <span>Garantia: </span>
            <span style="margin-left: 10px">(&nbsp; &nbsp;) Fiadores</span>
            <span style="margin-left: 10px; margin-right: 10px"> - </span>
            <span>(&nbsp; &nbsp;) Boleto Bancário - Seguro Fiança</span>
            <span style="margin-left: 10px; margin-right: 10px"> - </span>
            <span>(&nbsp; &nbsp;) Título de Capitalização ________ meses</span>
        </div>

        <div style="width: 95%; float: left; margin-top: 20px">
            <span>Cláusula pintura pintor indicado pelo Proprietário: </span>
            <span style="margin-left: 10px; margin-right: 10px"> - </span>
            <span>(&nbsp; &nbsp;) SIM</span>
            <span>(&nbsp; &nbsp;) NÃO</span>
        </div>

        <div style="width: 95%; float: left; margin-top: 20px">
            <span>Projeto Incêndio / AVCB: </span>
            <span style="margin-left: 10px; margin-right: 10px"> - </span>
            <span>(&nbsp; &nbsp;) Por conta do Locatário</span>
            <span style="margin-left: 10px; margin-right: 10px"> - </span>
            <span>(&nbsp; &nbsp;) Por conta do Locador</span>
        </div>

    </div>


    <div style="margin-top: 5px; font-weight: bold">
        OBSERVAÇÕES IMPORTANTES
    </div>

    <div class="border" style="height: 280px; margin-top: 5px; padding-left: 5px; text-align: justify">

        <div style="width: 95%; float: left; margin-top: 5px">
            a)- <span style="font-weight: bold">Caberá exclusivamente ao pretendente à Locação, antes da celebração do Contrato de Locação,
                    consultar os órgãos e/ou entidades públicas competentes sobre a compatibilidade do uso que pretende dar ao imóvel
                    em face do zoneamento urbano aplicável, bem como tomar todas as providencias necessárias para obtenção da respectiva licença
                    de uso e outorga do alvará de localização e funcionamento, ficando o proprietário do imóvel bem como a Master RSM Imóveis isentos
                    de qualquer responsabilidade.
                </span>
        </div>
        <div style="width: 95%; float: left; margin-top: 10px">
            b) - As fichas cadastrais e documentos exigidos deverão ser apresentados até <span style="font-weight: bold">05 dias úteis</span>, contados desta
            data, ficando reservado à Master RSM Imóveis o direito de exigir documentos complementares, de acordo com a
            análise do cadastro.
        </div>

        <div style="width: 95%; float: left; margin-top: 5px">
            c) - A não apresentação dos documentos, dentro deste período, libera o imóvel, automaticamente, para os outros interessados.
        </div>

        <div style="width: 95%; float: left; margin-top: 5px">
            d) - O simples preenchimento desta proposta não implica no reconhecimento de qualquer direito à locação.
            Somente após a aprovação do cadastro é que haverá uma promessa de locação por parte do proprietário do imóvel.
        </div>
    </div>

    <div style="margin-top: 10px">
        <span>Montes Claros, {{dateExtensive()}}, </span>
        <span style="font-weight: bold">Ass. _________________________________________________________________</span>
    </div>

    <div class="border" style="height: 50px; margin-top: 20px; padding-left: 5px">

        <div style="width: 16%; float: left; margin-top: 10px">
            <span class="font-bold" style="font-size: 12px;">Consultora Aluguel:</span>
        </div>

        <div style="width: 30%; float: left; margin-top: 10px">
            <span style="font-size: 11px;">{{uppercase($data['attendant_reception_name'])}}</span>
        </div>

        <div style="width: 16%; float: left; margin-top: 10px">
            <span class="font-bold" style="font-size: 12px;">Consultora Cadastro:</span>
        </div>

        <div style="width: 30%; float: left; margin-top: 10px">
            <span style="font-size: 11px">{{uppercase($data['attendant_register_name'])}}</span>
        </div>

    </div>

    <div class="border" style="height: 80px; margin-top: 10px">

        <div style="width: 80%; float: left; height: 80px;" class="border sub-border">
            <p class="text font-bold">OBSERVAÇÃO</p>
            <p class="text">&nbsp;</p>
        </div>

        <div style="width: 10%; float: left; border-right: none; height: 150px" class="border sub-border">
            <p class="text font-bold">CONTRATO</p>
            <p class="text">&nbsp;</p>
        </div>

    </div>

</div>



</body>
