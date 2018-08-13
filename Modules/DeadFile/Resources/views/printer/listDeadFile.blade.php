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
        font-size: 11px;
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

    .page-break {
        page-break-after: always;
    }

</style>

<body>

<div style="border: 1px solid black; height: 90px; margin-bottom: 3px;">

    @include('printer.head')

    <div style="width: 100%;">

        <div style="width: 50%; margin-left: 38%; margin-top: 3%">
            <p style="font-size: 13px; font-weight: bold; margin-bottom: 0px; padding-bottom: 0px">
                LISTA DE PROCESSOS ARQUIVADOS ({{count($data['data'])}})
            </p>
            <p style="margin-top: 0px !important; padding-top: 0px !important;">
                <span style="font-size: 11px">Arquivo: </span>
                <span style="font-weight: bold; font-size: 11px">{{$data['filter_data']['type_release']}}</span>

                <span style="font-size: 11px">Ano: </span>
                <span style="font-weight: bold; font-size: 11px">{{$data['filter_data']['year_release']}}</span>
            </p>
        </div>

    </div>

    <div style="font-size: 8px; position: absolute; top: 5px; right: 20px; text-align: right; width: 300px;">
        Impresso em: {{date('d/m/Y')}} as {{date('H:i:s')}}
    </div>

</div>

<div>
    <table class="table">
        <thead>
            <tr style="font-size: 10px">
                <th class="text-center" style="width: 100px">Contrato</th>
                <th class="text-center" style="width: 150px">Rescisão</th>
                <th class="text-center" style="width: 90px">Caixa</th>
                <th class="text-center" style="width: 90px">Arquivo</th>
                <th class="text-center" style="width: 130px">Status</th>
                <th class="text-center" style="width: 100px">Ano</th>
                <th class="text-center" style="width: 100px">Tipo</th>
                <th class="text-left" style="width: 400px">Responsável</th>
                <th class="text-center" style="width: 150px">Arquivamento</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data['data'] as $item)
            <tr>
                <td class="text-center">{{$item['contract']}}</td>
                <td class="text-center">{{date('d/m/Y', strtotime($item['termination_date']))}}</td>
                <td class="text-center">{{$item['cashier']}}</td>
                <td class="text-center">{{$item['file']}}</td>
                <td class="text-center">{{$item['status'] == 1 ? 'Arquivado' : 'Cancelado'}}</td>
                <td class="text-center">{{$item['year_release']}}</td>
                <td class="text-center">{{$item['type_release'] == 'rent' ? 'Aluguel' : 'Justiça'}}</td>
                <td class="text-left">{{uppercase($item['rp_last_action_name'])}}</td>
                <td class="text-center">{{$item['created_at'] ? date('d/m/Y', strtotime($item['created_at'])) : ' - '}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>


</div>




</body>
