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

    .page-break {
        page-break-after: always;
    }

</style>

<body>

<div style="border: 1px solid black; height: 90px; margin-bottom: 3px;">

    @include('printer.head')

    <div style="width: 100%;">

        <div style="width: 50%; margin-left: 39%; margin-top: 2%">
            <span style="font-size: 15px; font-weight: bold">
                <p style="font-size: 13px; font-weight: bold; margin-bottom: 0px; padding-bottom: 0px">RELATÓRIO DE RESERVAS CANCELADAS</p>
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
            <th class="text-center" style="width: 50px">Código</th>
            <th class="text-center" style="width: 60px">Reserva</th>
            <th class="text-center" style="width: 80px">Anunc.</th>
            <th class="text-center" style="width: 80px">Neg.</th>
            <th class="text-left" style="width: 300px">Cliente</th>
            <th class="text-left" style="width: 220px">Motivo Cancelamento</th>
            <th class="text-center" style="width: 60px">Conc.</th>
            <th class="text-center" style="width: 50px">TMP</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data['data'] as $key => $item)
            <tr>
                <td class="text-center">{{uppercase($item['immobile_code'])}}</td>
                <td class="text-center">{{date('d/m/Y', strtotime($item['date_reserve']))}}</td>
                <td class="text-center">{{number_format($item['value'],2, ',', '.')}}</td>
                <td class="text-center">{{number_format($item['value_negotiated'],2, ',', '.')}}</td>
                <td class="text-left">{{uppercase($item['client_name'])}}</td>
                <td class="text-left">{{$item['reason_cancel_name'] ? uppercase($item['reason_cancel_name']) : ' - '}}</td>
                <td class="text-center">{{!$item['conclusion'] ? '-' : date('d/m/Y', strtotime($item['conclusion']))}}</td>
                <td class="text-center">{{$item['duration_process']}}(D)</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div style="margin-top: 10px;">
        <span style="font-size: 11px;">Tempo médio para cancelamento das reservas: <span style="font-weight: bold">{{$data['median']}}</span></span>
    </div>
</div>

<div class="page-break"></div>

<div style="border: 1px solid black; height: 90px; margin-bottom: 3px;">

    @include('printer.head')

    <div style="font-size: 8px; width: 300px; float: right; text-align: right; margin-top: 4px; margin-right: 20px;">
        Impresso em: {{date('d/m/Y')}} as {{date('H:i:s')}}
    </div>

    <div style="width: 100%;">

        <div style="width: 50%; margin-left: 38%; margin-top: 2%">
            <span style="font-size: 15px; font-weight: bold">
                <p style="font-size: 13px; font-weight: bold; margin-bottom: 0px; padding-bottom: 0px">RELATÓRIO QUANTITATIVO RESERVAS CANCELADAS</p>
                <p style="margin-top: 0px; padding-top: 0px">Periodo: {{$data['period']}}</p>
            </span>
        </div>

    </div>

</div>

<div style="font-size: 11px; margin-top: 30px; width: 700px; margin-left: 20px;">

    <!-- total -->
    <div style="width: 800px; height: 20px;">
        <div style="width: 50px; float: left; font-weight: bold">TOTAL</div>
        <div style="width: 50px; float: left; font-weight: bold">{{ zeroToLeft($data['report_qt']['total']['qt']) }}</div>
        <div style="width: 150px; float: left; font-weight: bold;">
            RESERVAS
        </div>
        <div style="width: 400px; float: left; font-weight: bold">
            <div style="float: left; width: 50px">R$</div>
            <div style="float: left; width: 350px">
                {{ number_format($data['report_qt']['total']['value'], 2, ',', '.') }}
            </div>
        </div>
    </div>

    <!-- residencial -->
    <div style="width: 700px; height: 20px;">
        <div style="width: 50px; float: left; margin-left: 50px;">
            {{ zeroToLeft($data['report_qt']['total']['residential']['qt']) }}
        </div>
        <div style="width: 150px; float: left">RESIDENCIAIS</div>
        <div style="width: 400px; float: left">
            <div style="float: left; width: 50px">R$</div>
            <div style="float: right; width: 350px;">{{  number_format($data['report_qt']['total']['residential']['value'], 2, ',', '.') }}

                @if($data['report_qt']['total']['residential']['percent'] == 0)
                    (000 %)
                @else
                ({{ $data['report_qt']['total']['residential']['percent'] }} %)
                @endif

            </div>
        </div>
    </div>

    <!-- comercial -->
    <div style="width: 700px">
        <div style="width: 50px; float: left; margin-left: 50px;">{{ zeroToLeft($data['report_qt']['total']['commercial']['qt']) }}</div>
        <div style="width: 150px; float: left">NÃO RESIDENCIAIS</div>
        <div style="width: 400px; float: left">
            <div style="float: left; width: 50px;">R$</div>
            <div style="float: right; width: 350px;">{{ number_format($data['report_qt']['total']['commercial']['value'], 2, ',', '.') }}

                @if($data['report_qt']['total']['commercial']['percent'] == 0)
                    (000 %)
                @else
                ({{ $data['report_qt']['total']['commercial']['percent'] }} %)
                @endif

            </div>
        </div>
    </div>


    <!-- Total por integrante -->
    <div style="width: 800px; margin-top: 60px; height: 20px;">
        <div style="width: 300px; float: left; font-weight: bold">TOTAL POR INTEGRANTE</div>
        <div style="width: 200px; float: left; font-weight: bold">
            QUANTIDADE
        </div>
        <div style="width: 200px; float: left; font-weight: bold">
            VALOR
        </div>
        <div style="width: 100px; float: left; font-weight: bold">
            %
        </div>
    </div>

    <div style="width: 800px;">
        @foreach($data['report_qt']['per_user'] as $item)
            <div style="width: 800px; height: 20px;">
                <div style="width: 300px; float: left">{{uppercase($item['name'])}}</div>
                <div style="width: 200px; float: left">
                    <span style="padding-left: 30px;">{{zeroToLeft($item['qt'])}}</span>
                </div>
                <div style="width: 70px; float: left">
                    <div style="text-align: left; float: left">R$</div>
                    <div style="text-align: right; float: right;">{{number_format($item['value'], 2, ',', '.')}}</div>
                </div>
                <div style="width: 145px; float: left">
                    <div style="text-align: right">
                        {{$item['percent']}} %
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- / total por integrante -->


    <div style="font-size: 11px; margin-top: 20px;width: 700px;">

        <div style="font-size: 12px; font-weight: bold;">
            MOTIVOS ( 5 Principais )
        </div>

        <div style="margin-top: 10px;">
            @foreach($data['report_qt']['per_reason'] as $key => $reason)
                @if($key < 5)
                    <div style="width: 600px; height: 20px;">
                        <div style="float: left; width: 50px;">{{ zeroToLeft($reason['qt']) }}</div>
                        <div style="float: left; width: 200px;">{{ limitStr(uppercase($reason['reason']), 22) }}</div>
                        <div style="float: left; width: 50px;">R$</div>
                        <div style="float: left; width: 250px;">{{ number_format($reason['value'], 2, ',', '.') }}
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

</div>



</body>
