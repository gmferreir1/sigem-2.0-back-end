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

    .text-center {
        text-align: center;
        padding-left: 2px; !important;
        padding-right: 2px; !important;
    }

    .text-left {
        padding-left: 5px; !important;
        text-align: left;
    }

    .sub-header > div {
        height: 30px;
        text-transform: uppercase;
    }

</style>

<body>

<div style="border: 1px solid black; height: 90px; margin-bottom: 3px;">

    @include('printer.head')

    <div style="width: 100%;">

        <div style="width: 50%; margin-left: 38%; margin-top: 2%">
            <span style="font-size: 15px; font-weight: bold">
                 <p style="font-size: 13px; font-weight: bold; margin-bottom: 0px; padding-bottom: 0px">RELATÓRIO DE RESERVAS NO SISTEMA ({{count($data['data'])}})</p>
                 <p style="margin-top: 0px; padding-top: 0px">Periodo: {{$data['period']}}</p>
            </span>
        </div>

    </div>

    <div style="font-size: 8px; position: absolute; top: 5px; right: 20px; text-align: right; width: 300px;">
        Impresso em: {{date('d/m/Y')}} as {{date('H:i:s')}}
    </div>

</div>

<div>
    <table class="table">
        <thead>
        <tr style="font-size: 10px; background-color: #E98531">
            <th class="text-center" style="width: 50px">#</th>
            <th class="text-center" style="width: 50px">Imóvel</th>
            <th class="text-center" style="width: 50px">Contrato</th>
            <th class="text-center" style="width: 60px">Reserva</th>
            <th class="text-center" style="width: 70px">Anunc.</th>
            <th class="text-center" style="width: 70px">Neg.</th>
            <th class="text-left" style="width: 400px">Cliente</th>
            <th class="text-center" style="width: 80px">Previsão</th>
            <th class="text-left" style="width: 120px">Situação</th>
            <th class="text-left" style="width: 100px">Cadastro</th>
            <th class="text-left" style="width: 100px">Recepção</th>
            <th class="text-center" style="width: 80px">Conc.</th>
            <th class="text-center" style="width: 80px">TMP</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data['data'] as $key => $item)
            <tr>
                <td class="text-center">{{$item['code_reserve']}}</td>
                <td class="text-center">{{uppercase($item['immobile_code'])}}</td>
                <td class="text-center">{{!$item['contract'] ? '-' : uppercase($item['contract'])}}</td>
                <td class="text-center">{{date('d/m/Y', strtotime($item['date_reserve']))}}</td>
                <td class="text-center">
                    <div style="float: left">&nbsp;R$</div>
                    <div style="float: right">{{number_format($item['value'],2, ',', '.')}}&nbsp;</div>
                </td>
                <td class="text-center">
                    <div style="float: left">&nbsp;R$</div>
                    <div style="float: right">{{number_format($item['value_negotiated'],2, ',', '.')}}&nbsp;</div>
                </td>
                <td class="text-left">{{uppercase($item['client_name'])}}</td>
                <td class="text-center">{{date('d/m/Y', strtotime($item['prevision']))}}</td>
                <td class="text-left">{{uppercase(getSituationNameReserve($item['situation']))}}</td>
                <td class="text-left">{{str_limit(uppercase($item['attendant_register_name']), 10)}}</td>
                <td class="text-left">{{str_limit(uppercase($item['attendant_reception_name']), 10)}}</td>
                <td class="text-center">{{!$item['conclusion'] ? '-' : date('d/m/Y', strtotime($item['conclusion']))}}</td>
                <td class="text-center">{{$item['duration_process']}}(D)</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
