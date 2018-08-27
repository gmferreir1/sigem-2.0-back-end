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

    .page-break {
        page-break-after: always;
    }

    .header {
        font-weight: bold;
        text-transform: uppercase;
        height: 30px;
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
                <p style="font-size: 13px; font-weight: bold; margin-bottom: 0px; padding-bottom: 0px">RELATÓRIO DE CONTRATOS CELEBRADOS</p>
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
            <th class="text-center" style="width: 80px">Contrato</th>
            <th class="text-left" style="width: 260px;">Endereço</th>
            <th class="text-left" style="width: 170px;">Bairro</th>
            <th class="text-center" style="width: 30px;">F</th>
            <th class="text-center" style="width: 40px;">Tipo</th>
            <th class="text-center" style="width: 40px;">Prazo</th>
            <th class="text-center" style="width: 40px;">Taxa</th>
            <th class="text-center" style="width: 80px;">VR Bruto</th>
            <th class="text-center" style="width: 80px;">TX. Adm</th>
            <th class="text-left" style="width: 180px;">Observações</th>
            <th class="text-left" style="width: 170px;">Cidade Origem</th>
            <th class="text-center" style="width: 50px;">UF</th>
            <th class="text-center" style="width: 50px;">FIN</th>
        </tr>
        </thead>
        <tbody>
            @foreach($data['data'] as $key => $item)
                <tr>
                    <td class="text-center">{{$item['contract']}}</td>
                    <td class="text-left">{{uppercase($item['address'])}}</td>
                    <td class="text-left">{{uppercase($item['neighborhood'])}}</td>
                    <td class="text-center">{{uppercase($item['type_location'])}}</td>
                    <td class="text-center">{{uppercase($item['immobile_type_name'])}}</td>
                    <td class="text-center">{{uppercase($item['deadline'])}}</td>
                    <td class="text-center">{{$item['taxa']}}%</td>
                    <td class="text-center">
                        <div style="float: left; margin-left: 5px;">R$</div>
                        <div style="float: right; margin-right: 5px;">{{number_format($item['value_negotiated'], 2, ',', '.')}}</div>
                    </td>
                    <td class="text-center">
                        <div style="float: left; margin-left: 5px;">R$</div>
                        <div style="float: right; margin-right: 5px;">{{number_format(calcTxAdm($item['value_negotiated'], $item['taxa']), 2, ',', '.')}}</div>
                    </td>
                    <td class="text-left">{{uppercase($item['observation'])}}</td>
                    <td class="text-left">{{uppercase($item['origin_city'])}}</td>
                    <td class="text-center">{{uppercase($item['origin_state'])}}</td>
                    <td class="text-center">{{uppercase($item['finality'])}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 10px;">
        <span style="font-size: 11px;">Tempo médio para celebração dos contratos: <span style="font-weight: bold">{{$data['median']}}</span></span>
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
                <p style="font-size: 13px; font-weight: bold; margin-bottom: 0px; padding-bottom: 0px">RELATÓRIO QUANTITATIVO CONTRATOS CELEBRADOS</p>
                <p style="margin-top: 0px; padding-top: 0px">Periodo: {{$data['period']}}</p>
            </span>
        </div>

    </div>

</div>

<div style="font-size: 11px; margin-top: 30px; width: 700px; margin-left: 20px;">


    <div style="width: 800px; height: 30px; margin-top: 50px;" class="sub-header">
        <div style="width: 200px; float: left; font-weight: bold">Total Realizado</div>
        <div style="width: 30px; float: left">
            <span style="padding-left: 30px;; font-weight: bold">QTD: </span>
        </div>
        <div style="width: 100px; float: left">
            <span style="padding-left: 30px">{{zeroToLeft($data['report_qt']['total']['qt'])}}</span>
        </div>
        <div style="width: 80px; float: left">
            <span style="padding-left: 30px;; font-weight: bold">VALOR: </span>
        </div>
        <div style="width: 70px; float: left">
            <div style="text-align: left; float: left; font-weight: bold">R$</div>
            <div style="text-align: right; float: right; font-weight: bold">
                {{number_format($data['report_qt']['total']['value'], 2, ',', '.')}}
            </div>
        </div>
        <div style="width: 145px; float: left">
            <div style="text-align: right"></div>
        </div>
    </div>


    <!--
    <div style="width: 800px;" class="header">
        <div style="width: 200px; float: left">Tipo</div>
        <div style="width: 200px; float: left">Quantidade</div>
        <div style="width: 200px; float: left">
            <span style="margin-left: 15px;">Valor</span>
        </div>
        <div style="width: 200px; float: left">
            <div style="text-align: left">
                <span style="margin-left: 1px">%</span>
            </div>
        </div>
    </div>
    -->

    <div style="width: 800px;" class="sub-header">
        <div style="width: 200px; float: left; text-decoration: underline">Comercial</div>
        <div style="width: 30px; float: left">
            <span style="padding-left: 30px;; font-weight: bold">QTD: </span>
        </div>
        <div style="width: 100px; float: left">
            <span style="padding-left: 30px;">{{zeroToLeft($data['report_qt']['commercial']['qt'])}}</span>
        </div>
        <div style="width: 80px; float: left">
            <span style="padding-left: 30px;; font-weight: bold">VALOR: </span>
        </div>
        <div style="width: 120px; float: left">
            <div style="text-align: left; float: left">R$</div>
            <div style="text-align: right; float: right;">{{number_format($data['report_qt']['commercial']['value'], 2, ',', '.')}} ({{$data['report_qt']['commercial']['percent']}} %)</div>
        </div>
        <div style="width: 95px; float: left">
            <div style="text-align: right">

            </div>
        </div>
    </div>

    <div style="width: 800px; height: 80px" class="sub-header">
        <div style="width: 200px; float: left; text-decoration: underline">Residencial</div>
        <div style="width: 30px; float: left">
            <span style="padding-left: 30px;; font-weight: bold">QTD: </span>
        </div>
        <div style="width: 100px; float: left">
            <span style="padding-left: 30px;">{{zeroToLeft($data['report_qt']['residential']['qt'])}}</span>
        </div>
        <div style="width: 80px; float: left">
            <span style="padding-left: 30px;; font-weight: bold">VALOR: </span>
        </div>
        <div style="width: 120px; float: left">
            <div style="text-align: left; float: left">R$</div>
            <div style="text-align: right; float: right;">{{number_format($data['report_qt']['residential']['value'], 2, ',', '.')}} ({{$data['report_qt']['residential']['percent']}} %)</div>
        </div>
        <div style="width: 95px; float: left">
            <div style="text-align: right">

            </div>
        </div>
    </div>

    <!-- Total por integrante -->
    <div style="width: 800px; height: 20px;" class="sub-header">
        <div style="width: 200px; float: left; font-weight: bold">Total Por Integrante</div>
        <div style="width: 200px; float: left">
            &nbsp;
        </div>
        <div style="width: 70px; float: left">
            <div style="text-align: left; float: left"> &nbsp;</div>
            <div style="text-align: right; float: right;"> &nbsp;</div>
        </div>
        <div style="width: 145px; float: left">
            <div style="text-align: right">
                &nbsp;
            </div>
        </div>
    </div>
    <div>
        @foreach($data['report_qt']['per_user'] as $item)
            <div style="width: 800px;" class="sub-header">
                <div style="width: 200px; float: left">{{uppercase($item['name'])}}</div>
                <div style="width: 30px; float: left">
                    <span style="padding-left: 30px;; font-weight: bold">QTD: </span>
                </div>
                <div style="width: 100px; float: left">
                    <span style="padding-left: 30px;">{{zeroToLeft($item['qt'])}}</span>
                </div>
                <div style="width: 80px; float: left">
                    <span style="padding-left: 30px;; font-weight: bold">VALOR: </span>
                </div>
                <div style="width: 120px; float: left">
                    <div style="text-align: left; float: left">R$</div>
                    <div style="text-align: right; float: right;">{{number_format($item['value'], 2, ',', '.')}} ({{$item['percent']}} %)</div>
                </div>
                <div style="width: 95px; float: left">
                    <div style="text-align: right">

                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- / total por integrante -->


    <!--
    <div style="width: 800px; height: 30px;" class="sub-header">
        <div style="width: 200px; float: left; font-weight: bold">Total Taxa Adm</div>
        <div style="width: 30px; float: left">
            <span style="padding-left: 30px;; font-weight: bold">  </span>
        </div>
        <div style="width: 100px; float: left">
            <span style="padding-left: 30px;; font-weight: bold"> </span>
        </div>
        <div style="width: 80px; float: left">
            <span style="padding-left: 30px;; font-weight: bold">VALOR: </span>
        </div>
        <div style="width: 120px; float: left">
            <div style="text-align: left; float: left; font-weight: bold">R$</div>
            <div style="text-align: right; float: right; font-weight: bold">
                {{number_format($data['report_qt']['total_taxa'], 2, ',', '.')}}
            </div>
        </div>
        <div style="width: 95px; float: left">
            <div style="text-align: right"></div>
        </div>
    </div>
    -->


</div>


</body>
