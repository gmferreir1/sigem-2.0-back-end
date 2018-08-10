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

    p {
        padding: 0px !important;
        margin: 0px !important;
    }

</style>

<body>

<div style="border: 1px solid black; height: 90px; margin-bottom: 3px;">

    @include('printer.head')

    <div style="width: 100%;">

        <div style="width: 70%; margin-left: 32%; margin-top: 5%">
            <span style="font-size: 15px; font-weight: bold">
               TERMO DE ENTREGA DE CHAVES COM RESSALVAS
            </span>
        </div>

    </div>

</div>

<div>

    <div style="height: 20px; margin-top: 20px;">
        <div style="width:80px; font-size: 12px; float: left">CONTRATO: </div>
        <div style="font-weight: bold; font-size: 13px; float: left; width: 500px;">{{ $data['termination']['contract'] }}</div>
    </div>

    <div style="height: 20px;">
        <div style="width:80px; font-size: 12px; float: left">Imóvel: </div>
        <div style="font-weight: bold; font-size: 12px;float: left; width: 500px;">
            {{ uppercase($data['termination']['address']) }}, {{ uppercase($data['termination']['neighborhood']) }} - MONTES CLAROS - MG
        </div>
    </div>

    <div style="height: 20px;">
        <div style="width:80px; font-size: 12px; float: left">Locatário: </div>
        <div style="font-weight: bold; font-size: 12px; float: left; width: 500px;">{{ uppercase($data['termination']['tenant']) }}</div>
    </div>

    <div style="height: 20px;">
        <div style="width:80px; font-size: 12px; float: left">Locador: </div>
        <div style="font-weight: bold; font-size: 12px; float: left; width: 500px;">{{ uppercase($data['termination']['owner']) }}</div>
    </div>


    <div style="font-size: 12px; margin-top: 20px; text-align: justify">
        Declaro que estou entregando nesta data,
        @if($data['rental_accessory']['control_gate'])
            {{ $data['rental_accessory']['control_gate'] }} controle(s),
        @endif
        @if($data['rental_accessory']['keys_delivery'])
            {{ $data['rental_accessory']['keys_delivery'] }} chaves(s),
        @endif
        @if($data['rental_accessory']['control_alarm'])
            {{ $data['rental_accessory']['control_alarm'] }} controles(s) alarme,
        @endif
        @if($data['rental_accessory']['key_manual_gate'])
            {{ $data['rental_accessory']['key_manual_gate'] }} chave(s) manual portão
        @endif
        @if($data['rental_accessory']['fair_card'])
            {{ $data['rental_accessory']['fair_card'] }} cartão feira
        @endif
        do imóvel supra, após vistoria realizada no dia
        {{ $data['survey_date'] }}, onde foram constatadas as pendencias abaixo relacionadas, pelo vistoriador da Master RSM Imóveis e das quais
        não concordo em resolvê - las.
    </div>


    <div style="font-weight: bold; font-size: 12px; margin-top: 20px; margin-bottom: 10px; text-decoration: underline">
        RELAÇÃO DE PENDÊNCIAS
    </div>

    <div style="font-size: 11px;">
        {!! nl2br($data['termination']['observation']) !!}
    </div>


    <div style="font-size: 12px; margin-top: 30px;">
        <span>Montes Claros, {{dateExtensive()}}</span>
    </div>


    <div style="font-size: 11px; margin-top: 40px;  width: 300px; text-align: left">
        {{ uppercase($data['termination']['tenant']) }}
    </div>

</div>



</body>
