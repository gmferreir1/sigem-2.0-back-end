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

    .page-break {
        page-break-after: always;
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

    .header {
        font-weight: bold;
        text-transform: uppercase;
        height: 20px;
        font-size: 11px;
    }


</style>

<body>

<div style="border: 1px solid black; height: 90px; margin-bottom: 3px;">

    @include('printer.head')

    <div style="width: 100%;">

        <div style="width: 50%; margin-left: 41%; margin-top: 3%">
            <p style="font-size: 13px; font-weight: bold; margin-bottom: 0px; padding-bottom: 0px">
                LISTA DE CONTRATOS - TRANSFERÊNCIA ({{$data['period']}})
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
        <tr style="font-size: 10px; background-color: #E98531">
            <th class="text-center" style="width: 50px">Transf</th>
            <th class="text-center" style="width: 55px;">Contrato</th>
            <th class="text-center" style="width: 60px">Cod. Imóvel</th>
            <th class="text-left" style="width: 350px;">Endereço</th>
            <th class="text-left" style="width: 220px">Motivo</th>
            <th class="text-left" style="width: 200px">Solicitante</th>
            <th class="text-left" style="width: 80px">Telefone</th>
            <th class="text-center" style="width: 60px;">Status</th>
            <th class="text-center" style="width: 100px;">Responsável</th>
            <th class="text-center" style="width: 80px">Conclusão</th>
            <th class="text-center" style="width: 60px">Duração</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data['data'] as $item)
            <tr style="font-size: 8px">
                <td class="text-center">{{ date('d/m/Y', strtotime($item['transfer_date'])) }}</td>
                <td class="text-center">{{ uppercase($item['contract']) }}</td>
                <td class="text-center">{{uppercase($item['immobile_code'])}}</td>
                <td class="text-left">{{uppercase($item['address'])}}, {{uppercase($item['neighborhood'])}}</td>
                <td class="text-left">{{ uppercase($item['reason_name']) }}</td>
                <td class="text-left">{{ uppercase($item['requester_name']) }}</td>
                <td class="text-left">{{ $item['requester_phone_01'] }}</td>
                @if ($item['status'] == 'p')
                    <td class="text-center">Pendente</td>
                @elseif ($item['status'] == 'r')
                    <td class="text-center">Resolvido</td>
                @else
                    <td class="text-center">Cancelado</td>
                @endif
                <td class="text-left">{{ limitStr(uppercase($item['responsible_transfer_name']), 15) }}</td>
                <td class="text-center">{{ !$item['end_process'] ? '-' :  date('d/m/Y', strtotime($item['end_process']))}}</td>
                <td class="text-center">{{ $item['days_duration_process'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="page-break"></div>

<div style="border: 1px solid black; height: 90px; margin-bottom: 3px;">

    @include('printer.head')

    <div style="font-size: 8px; width: 300px; float: right; text-align: right; margin-top: 4px; margin-right: 20px;">
        Impresso em: {{date('d/m/Y')}} as {{date('H:i:s')}}
    </div>

    <div style="width: 100%;">

        <div style="width: 50%; margin-left: 41%; margin-top: 3%">
            <p style="font-size: 13px; font-weight: bold; margin-bottom: 0px; padding-bottom: 0px">
                QUANTITATIVO DE CONTRATOS - TRANSFERÊNCIA ({{$data['period']}})
            </p>
        </div>

    </div>

</div>


<div style="width: 800px; margin-top: 30px;" class="header">
    <div style="width: 300px; float: left">Nome</div>
    <div style="width: 200px; float: left">Quantidade</div>
    <div style="width: 200px; float: left">
        <span style="margin-left: 15px;">Valor</span>
    </div>
    <div style="width: 100px; float: left">
        <div style="text-align: left">
            <span style="margin-left: 1px">%</span>
        </div>
    </div>
</div>

@foreach($data['report_qt']['per_user'] as $perUser)
    <div style="width: 800px; font-size: 11px;">
        <div style="width: 300px; float: left">{{uppercase($perUser['name'])}}</div>
        <div style="width: 200px; float: left">
            <span style="margin-left: 25px">{{zeroToLeft($perUser['qt'])}}</span>
        </div>
        <div style="width: 200px; float: left">
            <span style="margin-left: 15px;">R$ {{number_format($perUser['value'], 2, '.', ',')}}</span>
        </div>
        <div style="width: 100px; float: left">
            <div style="text-align: left">
                <span style="margin-left: 1px">{{zeroToLeft($perUser['percent'])}}%</span>
            </div>
        </div>
    </div>
@endforeach

<div style="width: 800px; font-size: 11px; margin-top: 40px;">
    <div style="width: 300px; float: left; font-weight: bold">{{uppercase($data['report_qt']['total']['name'])}}</div>
    <div style="width: 200px; float: left; font-weight: bold">
        <span style="margin-left: 25px">{{zeroToLeft($data['report_qt']['total']['qt'])}}</span>
    </div>
    <div style="width: 200px; float: left; font-weight: bold">
        <span style="margin-left: 15px;">R$ {{number_format($data['report_qt']['total']['value'], 2, '.', ',')}}</span>
    </div>
    <div style="width: 100px; float: left; font-weight: bold">
        <div style="text-align: left">
            <span style="margin-left: 1px"> 100%</span>
        </div>
    </div>
</div>


<div style="font-size: 11px; margin-top: 90px;width: 700px;">

    <div style="font-size: 12px; font-weight: bold;">
        MOTIVOS ( 5 Principais )
    </div>

    <div style="margin-top: 10px;">
        @foreach($data['report_qt']['reasons'] as $key => $reason)
            @if($key < 5)
                <div style="width: 800px; height: 20px;">
                    <div style="float: left; width: 50px;">{{ zeroToLeft($reason['qt']) }}</div>
                    <div style="float: left; width: 300px;">{{ uppercase($reason['name']) }}</div>
                    <div style="float: left; width: 20px;">R$</div>
                    <div style="float: left; width: 200px;">{{ number_format($reason['value'], 2, ',', '.') }}
                        @if($reason['percent'] == 0)
                            (000%)
                        @else
                            ({{ $reason['percent'] }}%)
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>

</div>

</body>
