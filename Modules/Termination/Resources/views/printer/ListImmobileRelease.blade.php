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
                <p style="font-size: 13px; font-weight: bold; margin-bottom: 0px; padding-bottom: 0px">LISTA DE IMÓVEIS LIBERADOS PELA RESCISÃO</p>
                <p style="margin-top: 0px; padding-top: 0px">Periodo: ({{$data['period']}})</p>
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
            <th class="text-left" style="width: 100px">Código</th>
            <th class="text-center" style="width: 100px">Inativação</th>
            <th class="text-left" style="width: 300px">Para</th>
            <th class="text-center" style="width: 100px">Repasse</th>
            <th class="text-center" style="width: 100px">Tempo</th>
            <th class="text-center" style="width: 100px">Site</th>
            <th class="text-center" style="width: 100px">Fotos Site</th>
            <th class="text-center" style="width: 100px">Fotos Int.</th>
            <th class="text-center" style="width: 100px">Anúncio</th>
            <th class="text-left" style="width: 100px">Status</th>
            <th class="text-center" style="width: 100px">Tempo 2</th>
            <th class="text-center" style="width: 100px">Tempo 3</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data['data'] as $key => $item)

            <tr>
                <td class="text-left">{{uppercase($item['immobile_code'])}}</td>
                <td class="text-center">{{date('d/m/Y', strtotime($item['inactivate_date']))}}</td>
                <td class="text-left">{{uppercase($item['rp_receive_name'])}}</td>
                <td class="text-center">{{date('d/m/Y', strtotime($item['date_send']))}}</td>
                <td class="text-center">{{$item['duration_inactivate_to_release']}}(D)</td>
                <td class="text-center">{{$item['site'] === 1 ? 'Sim' : 'Não'}}</td>
                <td class="text-center">{{$item['picture_site'] === 1 ? 'Sim' : 'Não'}}</td>
                <td class="text-center">{{$item['internal_picture'] === 1 ? 'Sim' : 'Não'}}</td>
                <td class="text-center">{{$item['advertisement'] === 1 ? 'Sim' : 'Não'}}</td>
                <td class="text-left">
                    @if($item['status'] === 'p')
                        <span style="font-weight: bold; color: #E98531">Pendente</span>
                    @else
                        <span style="font-weight: bold; color: darkgreen">Finalizado</span>
                    @endif
                </td>
                <td class="text-center">
                    @if($item['duration_immobile_release_process'] === null)
                        -
                    @else
                        {{$item['duration_immobile_release_process']}}(D)
                    @endif
                </td>
                <td class="text-center">
                    @if($item['duration_immobile_release_process'] === null)
                        -
                    @else
                        {{$item['duration_total_process']}}(D)
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="font-size: 11px; margin-top: 10px;">
        Total encontrado:
        <span style="font-weight: bold"> {{count($data['data'])}} </span>
        resultado(s)
    </div>
</div>

</body>
