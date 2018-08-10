<style>
    table {
        border-collapse: collapse;
        border: 0.1px solid #000;
    }

    table td {
        border-collapse: collapse;
        border-left: 0.1px solid #000;
        border-right: 0.1px solid #000;
    }

    tr {
        border-collapse: collapse;
        border: 0.1px solid black;
    }

    th {
        border-collapse: collapse;
        border-left: 0.1px solid #000;
        border-right: 0.1px solid #000;
    }

    table thead tr {
        background-color: #CCCCCC;
        font-size: 13px;
    }

    thead { display: table-header-group }

    tfoot { display: table-row-group }

    tr { page-break-inside: avoid }

    tr {
        font-size: 9px;
    }

    .rec { text-indent:10em }

</style>

<body>

<div style="border: 1px solid black; height: 90px; margin-bottom: 3px;">

    @include('printer.head')

    <div style="width: 100%;">

        <div style="width: 70%; margin-left: 28%; margin-top: 5%">
            <span style="font-size: 15px; font-weight: bold">
                TERMO DE ENTREGA DE CHAVES - APÓS VISTORIA
            </span>
        </div>

    </div>

</div>

<div>


    <div style="font-size: 12px; margin-top: 20px; text-align: justify">
        <p class="text-info rec">
            Estou entregando, nesta data, as chaves do imóvel situado na ( {{ $data['termination']['immobile_code'] }} )
            {{ uppercase($data['termination']['address']) }}  {{ uppercase($data['termination']['neighborhood']) }} MONTES CLAROS - MG, após
            realizada vistoria final, ciente que o recebimento das mesmas, por parte da Administradora Master RSM Imóveis
            não libera Locatário(s) e Fiadore(s) do pagamento de alugueis e encargos locatícios devidos e ainda não quitados.
        </p>
    </div>

    <div style="font-size: 12px; margin-top: 80px;">
        <span>Montes Claros, {{dateExtensive()}}</span>
    </div>

    <div>
        <div style="font-size: 11px; margin-top: 30px;  width: 300px; text-align: left">

            {{ uppercase($data['client_data']['name']) }}

            @if($data['client_data']['cpf'])
                <span> - {{ $data['client_data']['cpf'] }} </span>
            @endif

        </div>
    </div>

</div>


<!-- 2 via -->
<div style="border: 1px solid black; height: 90px; margin-bottom: 3px; margin-top: 250px;">

    @include('printer.head')

    <div style="width: 100%;">

        <div style="width: 70%; margin-left: 25%; margin-top: 5%">
            <span style="font-size: 15px; font-weight: bold">
                TERMO DE RECEBIMENTO DE CHAVES - APÓS VISTORIA
            </span>
        </div>

    </div>

</div>

<div>

    <div style="font-size: 12px; margin-top: 20px; text-align: justify">
       <p class="text-info rec">
           Estamos recebendo, nesta data, as chaves do imóvel situado na ( {{ $data['termination']['immobile_code'] }} )
           {{ uppercase($data['termination']['address']) }}  {{ uppercase($data['termination']['neighborhood']) }} MONTES CLAROS - MG, após
           realizada vistoria final. O Locatário esta ciente que o recebimento das mesmas, por parte da Administradora Master RSM Imóveis
           não libera Locatário(s) e Fiadore(s) do pagamento de alugueis e encargos locatícios devidos e ainda não quitados.
       </p>
    </div>

    <div style="font-size: 12px; margin-top: 80px;">
        <span>Montes Claros, {{dateExtensive()}}</span>
    </div>

    <div>
        <div style="font-size: 11px; margin-top: 30px;  width: 300px; text-align: left">
            MASTER RSM IMÓVEIS
        </div>
    </div>

</div>



</body>
