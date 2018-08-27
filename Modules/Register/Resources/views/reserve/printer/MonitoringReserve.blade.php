<style>
    .border-report {
        border: 1px solid black;
    }

    .main-header {
        font-size: 11px;
        font-weight: bold;
        text-transform: uppercase;
        height: 20px;
        width: 40%;
        float: left;
    }

    .header {
        font-size: 11px;
        font-weight: bold;
        text-transform: uppercase;
        height: 20px;
        width: 20%;
        float: left;
    }


    .sub-main-header {
        font-size: 11px;
        text-transform: capitalize;
        height: 20px;
        width: 40%;
        float: left;
    }

    .sub-header {
        font-size: 11px;
        text-transform: capitalize;
        height: 20px;
        width: 20%;
        float: left;
    }

    .clearfix:after {
        font-size: 11px;
        content : "";
        display : block;
        clear : both;
    }
</style>

<body>

<div style="border: 1px solid black; height: 90px; margin-bottom: 3px;">

    @include('printer.head')

    <div style="width: 100%;">

        <div style="width: 50%; margin-left: 35%; margin-top: 3%">
            <span style="font-size: 15px; font-weight: bold">
                RELATÓRIO RESERVA DE IMÓVEIS (<span style="text-transform: uppercase">{{$data['current_month']['month_name']}} / {{$data['year']}}</span>)
            </span>
        </div>

    </div>

    <div style="font-size: 8px; position: absolute; top: 3px; right: 20px; text-align: right; width: 300px;">Impresso em: {{date('d/m/Y')}} as {{date('H:i:s')}}</div>

</div>

<div>
    <div class="row">
        <div class="col-md-12 col-lg-12">

            <!-- reservas mês anterior -->
            <div class="border-report clearfix" style="padding: 5px;">
                <!-- Header -->
                <div class="main-header" style="width: 40%;">Reservas Mês <span style="text-transform: lowercase">(es)</span> Anterior<span style="text-transform: lowercase">(es)</span></div>
                <div class="header">QT</div>
                <div class="header">VR.</div>
                <div class="header">%(VR).</div>
                <!-- / header -->

                <div class="sub-main-header" style="font-weight: bold">Total</div>
                <div class="sub-header">{{zeroToLeft($data['previous_month']['total']['qt'])}}</div>
                <div class="sub-header">R$ {{number_format($data['previous_month']['total']['value'], 2, ',', '.')}}</div>
                <div class="sub-header"> - </div>

                <div class="sub-main-header">Comercial</div>
                <div class="sub-header">{{zeroToLeft($data['previous_month']['commercial']['qt'])}}</div>
                <div class="sub-header">R$ {{number_format($data['previous_month']['commercial']['value'], 2, ',', '.')}}</div>
                <div class="sub-header">{{$data['previous_month']['commercial']['percent']}}</div>

                <div class="sub-main-header">Residencial</div>
                <div class="sub-header">{{zeroToLeft($data['previous_month']['residential']['qt'])}}</div>
                <div class="sub-header">R$ {{number_format($data['previous_month']['residential']['value'], 2, ',', '.')}}</div>
                <div class="sub-header">{{$data['previous_month']['residential']['percent']}}</div>
            </div>
            <!-- / reservas mês anterior -->

            <!-- reservas do mês -->
            <div class="border-report clearfix" style="padding: 5px; margin-top: 10px;">
                <!-- header -->
                <div class="main-header" style="width: 40%;">Reservas do Mês</div>
                <div class="header">QT</div>
                <div class="header">VR.</div>
                <div class="header">%(VR).</div>
                <!-- / header -->

                <div class="sub-main-header" style="font-weight: bold">{{$data['current_month']['month_name']}}</div>
                <div class="sub-header">{{zeroToLeft($data['current_month']['total']['qt'])}}</div>
                <div class="sub-header">R$ {{number_format($data['current_month']['total']['value'], 2, ',', '.')}}</div>
                <div class="sub-header"> - </div>

                <div class="sub-main-header">Comercial</div>
                <div class="sub-header">{{zeroToLeft($data['current_month']['commercial']['qt'])}}</div>
                <div class="sub-header">R$ {{number_format($data['current_month']['commercial']['value'], 2, ',', '.')}}</div>
                <div class="sub-header"> {{$data['current_month']['commercial']['percent']}} </div>

                <div class="sub-main-header">Residencial</div>
                <div class="sub-header">{{zeroToLeft($data['current_month']['residential']['qt'])}}</div>
                <div class="sub-header">R$ {{number_format($data['current_month']['residential']['value'], 2, ',', '.')}}</div>
                <div class="sub-header"> {{$data['current_month']['residential']['percent']}} </div>

                <div style="width: 100%;">
                    <hr style="width: 100%; margin: 5px 0px 5px 0px"/>
                </div>

                <!-- Setor cadastro -->
                <!-- reservas por integrante header -->
                <div class="main-header" style="width: 40%;"> Cadastro</div>
                <div class="header">QT</div>
                <div class="header">VR.</div>
                <div class="header">%(VR).</div>
                <!-- / reservas por integrante header -->
                <!-- reservas por integrante header -->
                @foreach($data['current_month']['per_user']['users_register_sector'] as $per_user)
                <div v-for="per_user in r">
                    <div class="sub-main-header">{{$per_user['name']}}</div>
                    <div class="sub-header">{{zeroToLeft($per_user['qt'])}}</div>
                    <div class="sub-header">R$ {{number_format($per_user['value'], 2, ',', '.')}}</div>
                    <div class="sub-header">{{$per_user['percent']}}</div>
                </div>
                @endforeach

                @if($data['current_month']['total']['qt'] == 0)
                <div>
                    <div class="sub-main-header"> - </div>
                    <div class="sub-header"> - </div>
                    <div class="sub-header"> - </div>
                    <div class="sub-header"> - </div>
                </div>
                @endif
                <!-- / reservas por integrante header -->
                <!-- / Setor cadastro -->

                <!-- Setor recepção -->
                <!-- reservas por integrante header -->
                <div class="main-header" style="width: 40%;"> Recepção</div>
                <div class="header">QT</div>
                <div class="header">VR.</div>
                <div class="header">%(VR).</div>
                <!-- / reservas por integrante header -->
                <!-- reservas por integrante header -->
                @foreach($data['current_month']['per_user']['users_reception_sector'] as $per_user)
                    <div v-for="per_user in r">
                        <div class="sub-main-header">{{$per_user['name']}}</div>
                        <div class="sub-header">{{zeroToLeft($per_user['qt'])}}</div>
                        <div class="sub-header">R$ {{number_format($per_user['value'], 2, ',', '.')}}</div>
                        <div class="sub-header">{{$per_user['percent']}}</div>
                    </div>
                @endforeach

                @if($data['current_month']['total']['qt'] == 0)
                    <div>
                        <div class="sub-main-header"> - </div>
                        <div class="sub-header"> - </div>
                        <div class="sub-header"> - </div>
                        <div class="sub-header"> - </div>
                    </div>
                @endif
                <!-- / reservas por integrante header -->
                <!-- / setor recepção -->
            </div>
            <!-- / reservas do mês -->

            <!-- reservas canceladas no mês -->
            <div class="border-report clearfix" style="padding: 5px; margin-top: 10px;">

                <!-- header -->
                <div class="main-header" style="width: 40%;">Reservas Canceladas no Mês</div>
                <div class="header">QT</div>
                <div class="header">VR.</div>
                <div class="header">%(VR).</div>
                <!-- / header -->

                <div class="sub-main-header" style="font-weight: bold">{{$data['current_month_canceled']['month_name']}}</div>
                <div class="sub-header">{{zeroToLeft($data['current_month_canceled']['total']['qt'])}}</div>
                <div class="sub-header">R$ {{number_format($data['current_month_canceled']['total']['value'], 2, ',', '.')}}</div>
                <div class="sub-header"> - </div>

                <div class="sub-main-header">Comercial</div>
                <div class="sub-header">{{zeroToLeft($data['current_month_canceled']['commercial']['qt'])}}</div>
                <div class="sub-header">R$ {{number_format($data['current_month_canceled']['commercial']['value'], 2, ',', '.')}}</div>
                <div class="sub-header"> {{$data['current_month_canceled']['commercial']['percent']}} </div>

                <div class="sub-main-header">Residencial</div>
                <div class="sub-header">{{zeroToLeft($data['current_month_canceled']['residential']['qt'])}}</div>
                <div class="sub-header">R$ {{number_format($data['current_month_canceled']['residential']['value'], 2, ',', '.')}}</div>
                <div class="sub-header"> {{$data['current_month_canceled']['residential']['percent']}} </div>

                <div style="width: 100%;">
                    <hr style="width: 100%; margin: 5px 0px 5px 0px"/>
                </div>

                <!-- Setor cadastro -->
                <!-- reservas por integrante header -->
                <div class="main-header" style="width: 40%;"> Cadastro</div>
                <div class="header">QT</div>
                <div class="header">VR.</div>
                <div class="header">%(VR).</div>
                <!-- / reservas por integrante header -->
                <!-- reservas por integrante header -->
                @foreach($data['current_month_canceled']['per_user']['users_register_sector'] as $per_user)
                    <div v-for="per_user in r">
                        <div class="sub-main-header">{{$per_user['name']}}</div>
                        <div class="sub-header">{{zeroToLeft($per_user['qt'])}}</div>
                        <div class="sub-header">R$ {{number_format($per_user['value'], 2, ',', '.')}}</div>
                        <div class="sub-header">{{$per_user['percent']}}</div>
                    </div>
                @endforeach
                @if($data['current_month_canceled']['total']['qt'] == 0)
                    <div>
                        <div class="sub-main-header"> - </div>
                        <div class="sub-header"> - </div>
                        <div class="sub-header"> - </div>
                        <div class="sub-header"> - </div>
                    </div>
                @endif
                <!-- / reservas por integrante header -->
                <!-- / setor cadastro -->

                <!-- Setor recepção -->
                <!-- reservas por integrante header -->
                <div class="main-header" style="width: 40%;"> Recepção</div>
                <div class="header">QT</div>
                <div class="header">VR.</div>
                <div class="header">%(VR).</div>
                <!-- / reservas por integrante header -->
                <!-- reservas por integrante header -->
                @foreach($data['current_month_canceled']['per_user']['users_reception_sector'] as $per_user)
                    <div v-for="per_user in r">
                        <div class="sub-main-header">{{$per_user['name']}}</div>
                        <div class="sub-header">{{zeroToLeft($per_user['qt'])}}</div>
                        <div class="sub-header">R$ {{number_format($per_user['value'], 2, ',', '.')}}</div>
                        <div class="sub-header">{{$per_user['percent']}}</div>
                    </div>
                @endforeach

                @if($data['current_month_canceled']['total']['qt'] == 0)
                    <div>
                        <div class="sub-main-header"> - </div>
                        <div class="sub-header"> - </div>
                        <div class="sub-header"> - </div>
                        <div class="sub-header"> - </div>
                    </div>
                @endif
                <!-- / reservas por integrante header -->
                <!-- / setor recepção -->

            </div>
            <!-- / reservas canceladas no mes -->


            <!-- reservas assinadas no mês -->
            <div class="border-report clearfix" style="padding: 5px; margin-top: 10px;">
                <!-- header -->
                <div class="main-header" style="width: 40%;">Reservas Assinadas no Mês</div>
                <div class="header">QT</div>
                <div class="header">VR.</div>
                <div class="header">%(VR).</div>
                <!-- / header -->

                <div class="sub-main-header" style="font-weight: bold">{{$data['current_month_signed']['month_name']}}</div>
                <div class="sub-header">{{zeroToLeft($data['current_month_signed']['total']['qt'])}}</div>
                <div class="sub-header">R$ {{number_format($data['current_month_signed']['total']['value'], 2, ',', '.')}}</div>
                <div class="sub-header"> - </div>

                <div class="sub-main-header">Comercial</div>
                <div class="sub-header">{{zeroToLeft($data['current_month_signed']['commercial']['qt'])}}</div>
                <div class="sub-header">R$  {{number_format($data['current_month_signed']['commercial']['value'], 2, ',', '.')}}</div>
                <div class="sub-header"> {{$data['current_month_signed']['commercial']['percent']}} </div>

                <div class="sub-main-header">Residencial</div>
                <div class="sub-header">{{zeroToLeft($data['current_month_signed']['residential']['qt'])}}</div>
                <div class="sub-header">R$  {{number_format($data['current_month_signed']['residential']['value'], 2, ',', '.')}}</div>
                <div class="sub-header"> {{$data['current_month_signed']['residential']['percent']}} </div>

                <div style="width: 100%;">
                    <hr style="width: 100%; margin: 5px 0px 5px 0px"/>
                </div>

                <!-- Setor cadastro -->
                <!-- reservas por integrante header -->
                <div class="main-header" style="width: 40%;">Cadastro</div>
                <div class="header">QT</div>
                <div class="header">VR.</div>
                <div class="header">%(VR).</div>
                <!-- / reservas por integrante header -->
                <!-- reservas por integrante header -->
                @foreach($data['current_month_signed']['per_user']['users_register_sector'] as $per_user)
                    <div v-for="per_user in r">
                        <div class="sub-main-header">{{$per_user['name']}}</div>
                        <div class="sub-header">{{zeroToLeft($per_user['qt'])}}</div>
                        <div class="sub-header">R$ {{number_format($per_user['value'], 2, ',', '.')}}</div>
                        <div class="sub-header">{{$per_user['percent']}}</div>
                    </div>
                @endforeach

                @if($data['current_month_signed']['total']['qt'] == 0)
                    <div>
                        <div class="sub-main-header"> - </div>
                        <div class="sub-header"> - </div>
                        <div class="sub-header"> - </div>
                        <div class="sub-header"> - </div>
                    </div>
                @endif
                <!-- / reservas por integrante header -->
                <!-- / setor cadastro -->

                <!-- Setor recepção -->
                <!-- reservas por integrante header -->
                <div class="main-header" style="width: 40%;">Recepção</div>
                <div class="header">QT</div>
                <div class="header">VR.</div>
                <div class="header">%(VR).</div>
                <!-- / reservas por integrante header -->
                <!-- reservas por integrante header -->
                @foreach($data['current_month_signed']['per_user']['users_reception_sector'] as $per_user)
                    <div v-for="per_user in r">
                        <div class="sub-main-header">{{$per_user['name']}}</div>
                        <div class="sub-header">{{zeroToLeft($per_user['qt'])}}</div>
                        <div class="sub-header">R$ {{number_format($per_user['value'], 2, ',', '.')}}</div>
                        <div class="sub-header">{{$per_user['percent']}}</div>
                    </div>
                @endforeach

                @if($data['current_month_signed']['total']['qt'] == 0)
                    <div>
                        <div class="sub-main-header"> - </div>
                        <div class="sub-header"> - </div>
                        <div class="sub-header"> - </div>
                        <div class="sub-header"> - </div>
                    </div>
                @endif
                <!-- / reservas por integrante header -->
                <!-- / setor recepção -->
            </div>
            <!-- / reservas assinadas no mes -->

            <!-- reservas proximo mês -->
            <div class="border-report clearfix" style="padding: 5px; margin-top: 10px;">
                <div class="main-header" style="width: 40%;">Reservas Proximo Mês</div>
                <div class="header">QT</div>
                <div class="header">VR.</div>
                <div class="header">%(VR).</div>
                <!-- / header -->

                <div class="sub-main-header" style="font-weight: bold">{{$data['next_month']['month_name']}}</div>
                <div class="sub-header">{{zeroToLeft($data['next_month']['total']['qt'])}}</div>
                <div class="sub-header">R$ {{number_format($data['next_month']['total']['value'], 2, ',', '.')}}</div>
                <div class="sub-header"> - </div>

                <div class="sub-main-header">Comercial</div>
                <div class="sub-header">{{zeroToLeft($data['next_month']['commercial']['qt'])}}</div>
                <div class="sub-header">R$ {{number_format($data['next_month']['commercial']['value'], 2, ',', '.')}}</div>
                <div class="sub-header"> {{$data['next_month']['commercial']['percent']}} </div>

                <div class="sub-main-header">Residencial</div>
                <div class="sub-header">{{zeroToLeft($data['next_month']['residential']['qt'])}}</div>
                <div class="sub-header">R$ {{number_format($data['next_month']['residential']['value'], 2 ,',', '.')}}</div>
                <div class="sub-header"> {{$data['next_month']['residential']['percent']}} </div>
            </div>
            <!-- / reservas mês anterior -->

        </div>
    </div>
</div>



</body>
