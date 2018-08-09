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
                RELATÓRIO DE CONTRATOS INATIVADOS ({{$data['extra_data']['period']}})
            </p>
            <p style="font-size: 10px; margin-top: 0px; padding-top: 0px; margin-left: 13%">
                ({{ uppercase($data['extra_data']['responsible_select']) }})
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
            <th class="text-center" style="width: 50px">Contrato</th>
            <th class="text-center" style="width: 40px;">Tp</th>
            <th class="text-left" style="width: 300px;">Endereço</th>
            <th class="text-left" style="width: 250px;">
                @if($data['extra_data']['type_record'] === 'owner')
                <span>Locador</span>
                @else
                <span>Locatário</span>
                @endif
            </th>
            <th class="text-center" style="width: 65px;">1ºCont.</th>
            <th class="text-center" style="width: 65px;">Rescisão</th>
            <th class="text-left" style="width: 50px;">Tempo</th>
            <th class="text-center" style="width: 220px;">Motivo</th>
            <th class="text-center" style="width: 150px;">Destino</th>
            <th class="text-center" style="width: 80px;">Aluguel</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data['data'] as $item)
            <tr style="font-size: 10px">
                <td class="text-center">{{ $item['contract'] }}</td>
                <td class="text-center" style="width: 40px;">
                    @if($item['type_location'] == 'co')
                        <span>C</span>
                    @else
                        <span>R</span>
                    @endif
                </td>
                <td class="text-left">{{ uppercase($item['address']) }} {{ uppercase($item['neighborhood']) }}</td>
                <td class="text-left">
                    @if($data['extra_data']['type_record'] === 'owner')
                    {{ uppercase($item['owner']) }}
                    @else
                    {{ uppercase($item['tenant']) }}
                    @endif
                </td>
                <td class="text-center">
                    @if($item['date_primary_contract'])
                        <span>{{ date('d/m/Y', strtotime($item['date_primary_contract'])) }}</span>
                    @else
                        <span> - </span>
                    @endif
                </td>
                <td class="text-center">
                    @if($item['termination_date'])
                        <span>{{ date('d/m/Y', strtotime($item['termination_date'])) }}</span>
                    @else
                        <span> - </span>
                    @endif
                </td>
                <td class="text-left">
                    @if($item['termination_date'])
                        <span>
                            {{ $item['time_duration_contract']['y'] }}a,
                            {{ $item['time_duration_contract']['m'] }}m
                        </span>
                    @else
                        <span> - </span>
                    @endif
                </td>
                <td class="text-left">{{ uppercase($item['reason']) }}</td>
                <td class="text-left">
                    @if($item['destination'])
                        <span>{{ uppercase($item['destination']) }}</span>
                    @else
                        <span> - </span>
                    @endif
                </td>
                <td style="padding-left: 2px; padding-right: 2px">
                    <span style="float: left">R$</span>
                    <span style="float: right">{{ number_format($item['value'], 2, ',', '.') }}</span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


    @if($data['extra_data']['report_data']['median_contracts'])
        <div style="margin-top: 10px;; font-size: 11px;">
            Média tempo dos contratos: <span style="font-weight: bold">{{ $data['extra_data']['report_data']['median_contracts'] }}</span>
        </div>
    @endif


</div>


<div class="page-break"></div>


<div style="border: 1px solid black; height: 90px; margin-bottom: 3px;">

    @include('printer.head')

    <div style="font-size: 8px; margin-right: 15px; text-align: right; width: 300px;; float: right; margin-top: 4px;">
        Impresso em: {{date('d/m/Y')}} as {{date('H:i:s')}}
    </div>

    <div style="width: 100%;">

        <div style="width: 50%; margin-left: 38%; margin-top: 3%">
            <p style="font-size: 13px; font-weight: bold; margin-bottom: 0px; padding-bottom: 0px">
                RELATÓRIO DE CONTRATOS INATIVADOS ({{$data['extra_data']['period']}})
            </p>
            <p style="font-size: 10px; margin-top: 0px; padding-top: 0px; margin-left: 13%">
                ({{ uppercase($data['extra_data']['responsible_select']) }})
            </p>
        </div>

    </div>

</div>


<div style="font-size: 11px; margin-top: 30px; width: 700px; margin-left: 20px;">

    <!-- total -->
    <div style="width: 700px; height: 20px;">
        <div style="width: 50px; float: left; font-weight: bold">TOTAL</div>
        <div style="width: 50px; float: left; font-weight: bold">{{ zeroToLeft($data['extra_data']['report_data']['total']['qt']) }}</div>
        <div style="width: 150px; float: left; font-weight: bold;">
            CONTRATOS
        </div>
        <div style="width: 400px; float: left; font-weight: bold">
            <div style="float: left; width: 50px">R$</div>
            <div style="float: left; width: 350px">
                {{ number_format($data['extra_data']['report_data']['total']['value'], 2, ',', '.') }}
            </div>
        </div>
    </div>

    <!-- residencial -->
    <div style="width: 700px; height: 20px;">
        <div style="width: 50px; float: left; margin-left: 50px;">
            {{ zeroToLeft($data['extra_data']['report_data']['residential']['qt']) }}
        </div>
        <div style="width: 150px; float: left">RESIDENCIAIS</div>
        <div style="width: 400px; float: left">
            <div style="float: left; width: 50px">R$</div>
            <div style="float: right; width: 350px;">{{  number_format($data['extra_data']['report_data']['residential']['value'], 2, ',', '.') }}

                @if($data['extra_data']['report_data']['residential']['percent'] == 0)
                    (000 %)
                @else
                ({{ $data['extra_data']['report_data']['residential']['percent'] }} %)
                @endif

            </div>
        </div>
    </div>

    <!-- comercial -->
    <div style="width: 700px">
        <div style="width: 50px; float: left; margin-left: 50px;">{{ zeroToLeft($data['extra_data']['report_data']['commercial']['qt']) }}</div>
        <div style="width: 150px; float: left">NÃO RESIDENCIAIS</div>
        <div style="width: 400px; float: left">
            <div style="float: left; width: 50px;">R$</div>
            <div style="float: right; width: 350px;">{{ number_format($data['extra_data']['report_data']['commercial']['value'], 2, ',', '.') }}

                @if($data['extra_data']['report_data']['commercial']['percent'] == 0)
                    (000 %)
                @else
                ({{ $data['extra_data']['report_data']['commercial']['percent'] }} %)
                @endif

            </div>
        </div>
    </div>
</div>

<div style="font-size: 11px;; margin-top: 100px; margin-left: 20px;">

    <div style="font-size: 12px; font-weight: bold;">
        DESTINOS ( 5 Principais )
    </div>

    <div style="width: 700px; font-size: 12px; font-weight: bold; height: 20px;">
        <div style="float: left; width: 50px;">{{ zeroToLeft($data['extra_data']['destinations']['total_rent_again']) }}</div>
        <div style="float: left; width: 400px;">ALUGARAM NOVAMENTE</div>
        <div style="float: left; width: 250px;">%</div>
    </div>

    @foreach($data['extra_data']['destinations']['report_rent_again'] as $key => $destination)
        @if($key < 5)
            <div style="width: 700px; height: 20px;">
                <div style="float: left; width: 50px;">{{ zeroToLeft($destination['qt']) }}</div>
                <div style="float: left; width: 400px;">{{ uppercase($destination['destination']) }}</div>
                <div style="float: left; width: 250px;">
                    @if($destination['percent'] == 0)
                        000%
                    @else
                        {{ $destination['percent'] }}%
                    @endif
                </div>
            </div>
        @endif
    @endforeach

</div>

<div style="font-size: 11px;; margin-top: 50px; margin-left: 20px;">

    <div style="width: 700px; font-size: 12px; font-weight: bold; height: 20px;">
        <div style="float: left; width: 50px;">{{ zeroToLeft($data['extra_data']['reasons']['total_reason']) }}</div>
        <div style="float: left; width: 400px;">MOTIVOS ( 5 Principais )</div>
        <div style="float: left; width: 250px;">%</div>
    </div>

    @foreach($data['extra_data']['reasons']['report_reason'] as $key => $reason)
        @if($key < 5)
            <div style="width: 700px; height: 20px;">
                <div style="float: left; width: 50px;">{{ zeroToLeft($reason['qt']) }}</div>
                <div style="float: left; width: 400px;">{{ uppercase($reason['reason']) }}</div>
                <div style="float: left; width: 250px;">
                    @if($reason['percent'] == 0)
                        000%
                    @else
                        {{ $reason['percent'] }}%
                    @endif
                </div>
            </div>
        @endif
    @endforeach

</div>

<div style="font-size: 11px;; margin-top: 50px; margin-left: 20px;">

    <div style="width: 700px; font-size: 12px; font-weight: bold; height: 20px;">
        <div style="float: left; width: 50px;">{{ zeroToLeft($data['extra_data']['survey']['total_survey']) }}</div>
        <div style="float: left; width: 400px;">VISTORIAS</div>
        <div style="float: left; width: 250px;">%</div>
    </div>

    @foreach($data['extra_data']['survey']['report_survey'] as $surveyor_data)
        <div style="width: 700px; height: 20px;">
            <div style="float: left; width: 50px;">{{ zeroToLeft($surveyor_data['qt']) }}</div>
            <div style="float: left; width: 400px; font-weight: bold">{{ limitStr(uppercase($surveyor_data['surveyor_name']), 30) }}</div>
            <div style="float: left; width: 250px;">
                @if($surveyor_data['percent'] == 0)
                    000%
                @else
                    {{ $surveyor_data['percent'] }}%
                @endif
            </div>
        </div>
        <!-- Ressalvas -->
        <div style="width: 700px; height: 25px;">
            <div style="float: left; width: 50px;">{{ zeroToLeft($surveyor_data['qt_caveat']) }}</div>
            <div style="float: left; width: 200px;">COM RESSALVAS</div>
        </div>
    @endforeach

</div>


</body>
