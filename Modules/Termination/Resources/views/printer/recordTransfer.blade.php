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

    .sub-header {
        font-size: 11px;
        margin-top: 10px;
    }

</style>

<body>

<div style="border: 1px solid black; height: 90px; margin-bottom: 3px;">
    <div style="float: right; font-size: 10px; margin-right: 5px;">
        <span>Impresso em: </span>
        <span>{{ date('d/m/Y H:i') }}</span>
    </div>
    @include('printer.head')

    <div style="width: 100%;">

        <div style="width: 90%; margin-left: 35%; margin-top: 4%">
            <span style="font-size: 15px; font-weight: bold">
                FICHA TRANSFERÊNCIA DE CONTRATO DE LOCAÇÃO
            </span>
        </div>

    </div>

</div>

<div class="sub-header" style="height: 20px; margin-top: 20px; font-size: 17px; width: 100%">

    <div style="width: 220px; float: left;">
        CONTRATO: <span style="font-size: 17px; font-weight: bold">{{$data['termination']['contract']}}</span>
    </div>

    <div style="width: 210px; float: left">
        BAIXA: ____/____/______
    </div>

    <div style="width: 210px; float: left">
        CAIXA: ______________
    </div>

    <div style="width: 210px; float: left">
        ARQUIVO: _____________
    </div>

    <div style="width: 240px; float: left;">
        RESP: <span style="font-size: 15px; font-weight: bold">{{uppercase(explode(' ',$data['termination']['rp_per_inactive_name'])[0])}}</span>
    </div>

</div>

<hr style="height:1px; width: 100%; border:none; color:#000; background-color:#000;"/>

<!-- Endereço do imovel -->
<div style="font-size: 17px; padding-top: 2px; height: 20px; width: 100%">
    <div style="float: left; width: 100px;">ENDEREÇO: </div>
    <div style="float: left; width: 800px;">
        &nbsp;
        ( {{ $data['termination']['immobile_code'] }} )
        {{ uppercase($data['termination']['address']) }},
        {{ uppercase($data['termination']['neighborhood']) }},
        <span style="margin-left: 10px;">MONTES CLAROS - MG</span>
    </div>
</div>
<!-- // Endereço do imovel -->

<hr style="height:1px; width: 100%; border:none; color:#000; background-color:#000;"/>

<!-- inquilino -->
<div style="font-size: 17px; padding-top: 2px; height: 20px">
    <div style="float: left; width: 100px;">LOCATÁRIO: </div>
    <div style="float: left; width: 400px;">&nbsp;{{ uppercase($data['termination']['tenant']) }}</div>
    <div style="float: left">Fones: </div>
    <div style="width: 150px; float: left; margin-left: 5px;"> {{ format_phone($data['termination']['tenant_phone_residential']) }}</div>
    <div style="width: 150px; float: left; margin-left: 5px;"> {{ format_phone($data['termination']['tenant_phone_commercial']) }}</div>
    <div style="width: 150px; float: left; margin-left: 5px;"> {{ format_phone($data['termination']['tenant_cell_phone']) }}</div>
</div>
<!-- // inqulino -->

<hr style="height:1px; width: 100%; border:none; color:#000; background-color:#000;"/>

<!-- locador -->
<div style="font-size: 17px; padding-top: 2px; height: 20px;">
    <div style="float: left; width: 100px;">LOCADOR:</div>
    <div style="float: left; width: 400px;">{{ uppercase($data['termination']['owner']) }}</div>
    <div style="float: left">Fones: </div>
    <div style="width: 150px; float: left; margin-left: 5px;"> {{ format_phone($data['termination']['owner_phone_residential']) }}</div>
    <div style="width: 150px; float: left; margin-left: 5px;"> {{ format_phone($data['termination']['owner_phone_commercial']) }}</div>
    <div style="width: 150px; float: left; margin-left: 5px;"> {{ format_phone($data['termination']['owner_cell_phone']) }}</div>
</div>
<!-- // locador -->

<hr style="height:1px; width: 100%; border:none; color:#000; background-color:#000;"/>


<div style="font-size: 17px; padding-top: 5px; height: 20px; margin-top: 10px;">
    <div style="font-weight: bold">ALUGUÉIS DE ENCARGOS DA LOCAÇÃO</div>
</div>

<div style="font-size: 17px; padding-top: 5px; padding-bottom: 10px;">

    <div style="width: 100%">
        <span style="font-weight: bold">Multa Rescisoria:</span>
        <span style="text-align: justify; font-size: 15px;">
            {!! nl2br($data['rental_accessory']['fine_termination']) !!}
        </span>
        <span style="margin-left: 5px; font-weight: bold">
            R$ {{number_format($data['rental_accessory']['fine_termination_value_debit'], 2, ',', '.')}}
        </span>

        @if($data['rental_accessory']['fine_termination_value_debit'] != 0)
            <span>
            @if($data['rental_accessory']['fine_termination_type_debit'] == 'd')
                    <span>(débito)</span>
                @else
                    <span>(crédito)</span>
                @endif
        </span>
        @endif

    </div>

</div>


<hr style="height:1px; width: 100%; border:none; color:#000; background-color:#48484c;"/>


<div style="font-size: 17px;">

    <div style="width: 100%; padding-bottom: 25px;">
        <span style="font-weight: bold">Condominio:</span>
        <span style="text-align: justify; font-size: 17px;">

            {!! nl2br($data['rental_accessory']['condominium']) !!}

        </span>
        <span style="margin-left: 5px; font-weight: bold">
            R$ {{number_format($data['rental_accessory']['condominium_value_debit'], 2, ',', '.')}}
        </span>
        @if($data['rental_accessory']['condominium_type_debit'] != 0)
            <span>
            @if($data['rental_accessory']['condominium_type_debit'] == 'd')
                    <span>(débito)</span>
                @else
                    <span>(crédito)</span>
                @endif
        </span>
        @endif

    </div>

    <hr style="height:1px; width: 100%; border:none; color:#000; background-color:#48484c;"/>

    <div style="width: 100%; padding-bottom: 25px; font-size: 17px;">
        <span style="font-weight: bold">Copasa:</span>
        <span style="text-align: justify; font-size: 17px;">

            {!! nl2br($data['rental_accessory']['copasa']) !!}

        </span>

        <span style="margin-left: 5px; font-weight: bold">
            R$ {{number_format($data['rental_accessory']['copasa_value_debit'], 2, ',', '.')}}
        </span>
        @if($data['rental_accessory']['copasa_value_debit'] != 0)
            <span>(débito)</span>
        @endif

    </div>

    <hr style="height:1px; width: 100%; border:none; color:#000; background-color:#48484c;"/>

    <div style="width: 100%; padding-bottom: 25px; font-size: 17px;">
        <span style="font-weight: bold">Cemig:</span>
        <span style="text-align: justify; font-size: 17px">

            {!! nl2br($data['rental_accessory']['cemig']) !!}

        </span>

        <span style="margin-left: 5px; font-weight: bold">
            R$ {{number_format($data['rental_accessory']['cemig_value_debit'], 2, ',', '.')}}
        </span>

        @if($data['rental_accessory']['cemig_value_debit'] != 0)
            <span>(débito)</span>
        @endif
    </div>

    <hr style="height:1px; width: 100%; border:none; color:#000; background-color:#48484c;"/>

    <div style="width: 100%; padding-bottom: 30px; font-size: 17px">
        <span style="font-weight: bold">IPTU:</span>
        <span style="text-align: justify; font-size: 17px;">

            {!! nl2br($data['rental_accessory']['iptu']) !!}

        </span>
        <span style="margin-left: 5px; font-weight: bold">
            R$ {{number_format($data['rental_accessory']['iptu_value_debit'], 2, ',', '.')}}
        </span>

        @if($data['rental_accessory']['iptu_value_debit'] != 0)
            <span>
             @if($data['rental_accessory']['iptu_type_debit'] == 'd')
                    <span>(débito)</span>
                @else
                    <span>(crédito)</span>
                @endif
        </span>
        @endif
    </div>

    <hr style="height:1px; width: 100%; border:none; color:#000; background-color:#48484c;"/>

    <div style="width: 100%; padding-bottom: 30px; font-size: 17px;">
        <span style="font-weight: bold">Taxa de Lixo:</span>
        <span style="text-align: justify; font-size: 17px;">

            {!! nl2br($data['rental_accessory']['garbage_rate']) !!}

        </span>
        <span style="margin-left: 5px; font-weight: bold">
            R$ {{number_format($data['rental_accessory']['garbage_rate_value_debit'], 2, ',', '.')}}
        </span>
        @if($data['rental_accessory']['garbage_rate_value_debit'] != 0)
            <span>
                @if($data['rental_accessory']['garbage_rate_type_debit'] == 'd')
                    <span>(débito)</span>
                @else
                    <span>(crédito)</span>
                @endif
           </span>
        @endif
    </div>

    <hr style="height:1px; width: 100%; border:none; color:#000; background-color:#48484c;"/>

    <div style="width: 100%; padding-bottom: 30px; font-size: 17px;">
        <span style="font-weight: bold">Pendências:</span>
        <span style="text-align: justify; font-size: 17px;">

            {!! nl2br($data['rental_accessory']['pendencies']) !!}

        </span>
        <span style="margin-left: 5px; font-weight: bold">
            R$ {{number_format($data['rental_accessory']['pendencies_value_debit'], 2, ',', '.')}}
        </span>
        @if($data['rental_accessory']['pendencies_value_debit'] != 0)
            <span>
                @if($data['rental_accessory']['pendencies_type_debit'] == 'd')
                    <span>(débito)</span>
                @else
                    <span>(crédito)</span>
                @endif
           </span>
        @endif
    </div>

    <hr style="height:1px; width: 100%; border:none; color:#000; background-color:#48484c;"/>

    <div style="width: 100%; padding-bottom: 15px; font-size: 17px;">
        <span style="font-weight: bold">Pintura:</span>
        <span style="text-align: justify; font-size: 17px;">

            {!! nl2br($data['rental_accessory']['paint']) !!}

        </span>
        <span style="margin-left: 5px; font-weight: bold">
            R$ {{number_format($data['rental_accessory']['paint_value_debit'], 2, ',', '.')}}
        </span>
        @if($data['rental_accessory']['paint_value_debit'] != 0)
            <span>
                @if($data['rental_accessory']['paint_type_debit'] == 'd')
                    <span>(débito)</span>
                @else
                    <span>(crédito)</span>
                @endif
           </span>
        @endif
    </div>

    <hr style="height:1px; width: 100%; border:none; color:#000; background-color:#48484c;"/>

    <div style="width: 100%; padding-bottom: 50px; font-size: 17px;">
        <span style="font-weight: bold">Alugueis:</span>
        <span style="text-align: justify">

            {!! nl2br($data['rental_accessory']['value_rent']) !!}

        </span>

        <span style="margin-left: 5px; font-weight: bold">
            R$ {{number_format($data['rental_accessory']['value_rent_value_debit'], 2, ',', '.')}}
        </span>

        @if($data['rental_accessory']['value_rent_value_debit'] != 0)
            <span>
            @if($data['rental_accessory']['value_rent_type_debit'] == 'd')
                    <span>(débito)</span>
                @else
                    <span>(crédito)</span>
                @endif
        </span>
        @endif

    </div>

</div>


<hr style="height:1px; width: 100%; border:none; color:#000; background-color:#000;"/>

<div style="margin-top: 10px; font-size: 17px;">

    <div style="height: 30px;">
        <div style="width: 180px; float: left">
            <span style="font-weight: bold">Inativação:</span>
        </div>
        <div style="width: 900px; float: left">
            <span> {{ date('d/m/Y', strtotime($data['termination']['termination_date'])) }} </span>
        </div>
    </div>

    <div style="height: 30px;">
        <div style="width: 180px; float: left">
            <span style="font-weight: bold">Motivo Rescisão:</span>
        </div>
        <div style="width: 900px; float: left">
            <span> {{ uppercase($data['termination']['reason_name']) }} </span>
        </div>
    </div>
    <!-- dados da transferencia -->
    <div style="height: 30px;">
        <div style="width: 180px; float: left">
            <span style="font-weight: bold">Resp Transf:</span>
        </div>

        <div style="width: 900px; float: left">
            <span>{{ $data['termination']['rp_register_sector_name'] }}</span>
        </div>
    </div>

    <div style="height: 30px;">
        <div style="width: 180px; float: left">
            <span style="font-weight: bold">Novo Contrato:</span>
        </div>

        <div style="width: 900px; float: left">
            <span>{{ $data['termination']['new_contract_code'] }}</span>
        </div>
    </div>
    <!-- dados da transferencia -->
</div>



<div style="margin-top: 30px">
    <?php
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
    ?>
   <span style="font-weight: bold; font-size: 15px;">DATA: </span>
    <span style="font-size: 15px;">{{strftime('%d de %B de %Y', strtotime('today'))}}</span>
</div>

</body>
