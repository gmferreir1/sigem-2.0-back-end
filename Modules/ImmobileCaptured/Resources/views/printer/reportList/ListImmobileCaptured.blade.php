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

</style>

<body>

<div style="border: 1px solid black; height: 90px; margin-bottom: 3px;">

    @include('printer.head')

    <div style="width: 100%;">

        <div style="width: 50%; margin-left: 41%; margin-top: 3%">
            <p style="font-size: 13px; font-weight: bold; margin-bottom: 0px; padding-bottom: 0px">
                LISTA DE IMÓVEIS CAPTADOS ({{$data['period']}})
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
            <th class="text-left" style="width: 250px">Proprietário</th>
            <th class="text-center" style="width: 100px;">Código</th>
            <th class="text-center" style="width: 80px">Fin</th>
            <th class="text-left" style="width: 400px;">Endereço</th>
            <th class="text-left" style="width: 100px">Tipo</th>
            <th class="text-center" style="width: 100px">Valor</th>
            <th class="text-center" style="width: 80px">Captação</th>
            <th class="text-left" style="width: 200px;">Captador</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data['data'] as $item)
            <tr style="font-size: 8px">
                <td class="text-left">{{uppercase($item['owner'])}}</td>
                <td class="text-center">{{uppercase($item['immobile_code'])}}</td>
                <td class="text-center">{{uppercase($item['type_location'])}}</td>
                <td class="text-left">{{uppercase($item['address'])}}, {{uppercase($item['neighborhood'])}}</td>
                <td class="text-left">{{ucwords($item['type_immobile_name'])}}</td>
                <td class="text-center" style="padding-left: 5px; padding-right: 5px">
                    <div style="float: left">R$ </div>
                    <div style="float: right">{{number_format($item['value'], 2, ',', '.')}}</div>
                </td>
                <td class="text-center">{{formatDate($item['captured_date'])}}</td>
                <td class="text-left">{{ucwords($item['responsible_name'])}}</td>
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
                QUANTITATIVO IMÓVEIS CAPTADOS ({{$data['period']}})
            </p>
        </div>

    </div>

</div>



<!-- total realizado -->
<div style="width: 95%; height: 30px; float: left; margin-top: 20px">

    <div style="float: left; width: 200px; height: 20px; font-size: 11px">
        <span style="font-weight: bold;">TOTAL REALIZADO</span>
    </div>

    <div style="float: left; width: 150px; height: 20px; font-size: 11px">
        <div style="font-weight: bold;; width: 20px; float: left">QTD: </div>
        <div style="margin-left: 20px; float: left">{{$data['report_qt']['resume_total']['total']['total_qt']}}</div>
    </div>

    <div style="float: left; width: 200px; height: 20px; font-size: 11px">
        <div style="font-weight: bold;; width: 30px; float: left">VALOR: </div>
        <div style="margin-left: 20px; float: left">R$ </div>
        <div style="margin-left: 10px; float: right">{{number_format($data['report_qt']['resume_total']['total']['total_values'], 2, ',', '.')}}</div>
    </div>

</div>

<!-- residencial -->
<div style="width: 95%; height: 25px; float: left">

    <div style="float: left; width: 200px; height: 20px; font-size: 11px">
        <span style="font-weight: bold; text-decoration: underline">RESIDENCIAL</span>
    </div>

    <div style="float: left; width: 150px; height: 20px; font-size: 11px">
        <div style="font-weight: bold;; width: 20px; float: left">QTD: </div>
        <div style="margin-left: 20px; float: left">{{$data['report_qt']['resume_total']['residential']['total_qt']}}</div>
    </div>

    <div style="float: left; width: 200px; height: 20px; font-size: 11px">
        <div style="font-weight: bold;; width: 30px; float: left">VALOR: </div>
        <div style="margin-left: 20px; float: left">R$ </div>
        <div style="margin-left: 10px; float: right">{{number_format($data['report_qt']['resume_total']['residential']['total_values'], 2, ',', '.')}} ({{$data['report_qt']['resume_total']['residential']['percent']}}%)</div>
    </div>

</div>
<!-- / residencial -->

<!-- comercial -->
<div style="width: 95%; height: 50px; float: left">

    <div style="float: left; width: 200px; height: 20px; font-size: 11px">
        <span style="font-weight: bold; text-decoration: underline">COMERCIAL</span>
    </div>

    <div style="float: left; width: 150px; height: 20px; font-size: 11px">
        <div style="font-weight: bold;; width: 20px; float: left">QTD: </div>
        <div style="margin-left: 20px; float: left">{{$data['report_qt']['resume_total']['commercial']['total_qt']}}</div>
    </div>

    <div style="float: left; width: 200px; height: 20px; font-size: 11px">
        <div style="font-weight: bold;; width: 30px; float: left">VALOR: </div>
        <div style="margin-left: 20px; float: left">R$ </div>
        <div style="margin-left: 10px; float: right">{{number_format($data['report_qt']['resume_total']['commercial']['total_values'], 2, ',', '.')}} ({{$data['report_qt']['resume_total']['commercial']['percent']}}%)</div>
    </div>

</div>
<!-- / comercial -->

<!-- / total realizado -->





<!-- relatorio por captador -->

<div style="margin-top: 20px">
    <span style="font-size: 12px">RELATÓRIO POR CAPTADOR</span>
</div>

@foreach($data['report_qt']['resume_per_user'] as $item)
<div>

    <div style="width: 95%; height: 30px; float: left; margin-top: 20px">

        <div style="float: left; width: 200px; height: 20px; font-size: 11px">
            <span style="font-weight: bold">{{limitStr(uppercase($item['name']), 20)}}</span>
        </div>

        <div style="float: left; width: 150px; height: 20px; font-size: 11px">
            <div style="font-weight: bold;; width: 20px; float: left">QTD: </div>
            <div style="margin-left: 20px; float: left">{{$item['resume_total']['total']['total_qt']}}</div>
        </div>

        <div style="float: left; width: 200px; height: 20px; font-size: 11px">
            <div style="font-weight: bold;; width: 30px; float: left">VALOR: </div>
            <div style="margin-left: 20px; float: left">R$ </div>
            <div style="margin-left: 10px; float: right">{{number_format($item['resume_total']['total']['total_values'], 2, ',', '.')}}</div>
        </div>

    </div>

    <!-- residencial -->
    <div style="width: 95%; height: 25px; float: left">

        <div style="float: left; width: 200px; height: 20px; font-size: 11px">
            <span style="font-weight: bold; text-decoration: underline">RESIDENCIAL</span>
        </div>

        <div style="float: left; width: 150px; height: 20px; font-size: 11px">
            <div style="font-weight: bold;; width: 20px; float: left">QTD: </div>
            <div style="margin-left: 20px; float: left">{{$item['resume_total']['residential']['total_qt']}}</div>
        </div>

        <div style="float: left; width: 200px; height: 20px; font-size: 11px">
            <div style="font-weight: bold;; width: 30px; float: left">VALOR: </div>
            <div style="margin-left: 20px; float: left">R$ </div>
            <div style="margin-left: 10px; float: right">{{number_format($item['resume_total']['residential']['total_values'], 2, ',', '.')}} ({{$item['resume_total']['residential']['percent']}}%)</div>
        </div>

    </div>
    <!-- / residencial -->

    <!-- comercial -->
    <div style="width: 95%; height: 50px; float: left">

        <div style="float: left; width: 200px; height: 20px; font-size: 11px">
            <span style="font-weight: bold; text-decoration: underline">COMERCIAL</span>
        </div>

        <div style="float: left; width: 150px; height: 20px; font-size: 11px">
            <div style="font-weight: bold;; width: 20px; float: left">QTD: </div>
            <div style="margin-left: 20px; float: left">{{$item['resume_total']['commercial']['total_qt']}}</div>
        </div>

        <div style="float: left; width: 200px; height: 20px; font-size: 11px">
            <div style="font-weight: bold;; width: 30px; float: left">VALOR: </div>
            <div style="margin-left: 20px; float: left">R$ </div>
            <div style="margin-left: 10px; float: right">{{number_format($item['resume_total']['commercial']['total_values'], 2, ',', '.')}} ({{$item['resume_total']['commercial']['percent']}}%)</div>
        </div>

    </div>
    <!-- / comercial -->


</div>
@endforeach
<!-- / relatorio por captador -->


</body>
