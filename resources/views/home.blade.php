@php
if(empty($query)){
    $query = [];
    $sum = [];
    $date = [];
    $fundos = [];
}else{
    $sum = [];
    $date = [];
    $fundos = [];
    foreach ($query as $key => $value) {
        $sum[$key] = $value->{'sum(value)'};
        $date[$key] = $value->date; 

        switch ($value->fundo_id) {
            case 1:
                $fundo = "fundo1";
                break;
            case 2:
                $fundo = "fundo2";
                break;
            case 3:
                $fundo = "fundo3";
                break;
            case 4:
                $fundo = "fundo4";
                break;
        }
        $fundos[$key] = $fundo;
    }

}



@endphp
@extends('adminlte::page')

@section('title', 'Dashboard')



@section('content')


<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Gráfico de Linha</h3>
    </div>             
    <div class="card-body">
        <form action="{{ route('form') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-sm-6">                    
                    <div class="form-group">                    
                        <label>Data Início:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                            </div>
                            @if(!empty($dateFrom))                            
                                <input type="text" class="form-control float-right" name="datetimepickerFrom" value="{{$dateFrom}}" id="datetimepickerFrom">
                            @else
                                <input type="text" class="form-control float-right" name="datetimepickerFrom" id="datetimepickerFrom">
                            @endif    
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Data Fim:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                            </div>
                            @if(!empty($dateTo))
                                <input type="text" class="form-control" name="datetimepickerTo" value="{{$dateTo}}" id="datetimepickerTo">
                            @else
                                <input type="text" class="form-control" name="datetimepickerTo" id="datetimepickerTo">
                            @endif    
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">                    
                        <div class="form-check form-check-inline">                       
                            <input class="form-check-input" type="checkbox" name="checkbox[]" id="inlineCheckbox1" value="1" @if(!empty($numberFundos[0])) ? checked="checked" : checked="" @endif>
                            <label class="form-check-label" for="inlineCheckbox2">Fundo 1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="checkbox[]" id="inlineCheckbox2" value="2"@if(!empty($numberFundos[1])) ? checked="checked" : checked="" @endif>
                            <label class="form-check-label" for="inlineCheckbox2">Fundo 2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="checkbox[]" id="inlineCheckbox3" value="3" @if(!empty($numberFundos[2])) ? checked="checked" : checked="" @endif>
                            <label class="form-check-label" for="inlineCheckbox2">Fundo 3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="checkbox[]" id="inlineCheckbox4" value="4" @if(!empty($numberFundos[3])) ? checked="checked" : checked="" @endif>
                            <label class="form-check-label" for="inlineCheckbox2">Fundo 4</label>
                        </div>    
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
                <div class="col-sm-12">
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



@stop


@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
@stop

@section('js')

<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>

<script>

$(function() {
    $("#datetimepickerTo").datepicker({dateFormat: 'yy-mm-dd'});
    $("#datetimepickerFrom").datepicker({dateFormat: 'yy-mm-dd'});
});

var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [@php foreach ($date as $dates) {
            echo "'$dates',";
        }   @endphp],
        datasets: [{
            label: 'Fundos',
            data: [@php echo implode(',', $sum); @endphp],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
        data: {
        labels: [@php foreach ($date as $dates) {
            echo "'$dates',";
        }   @endphp],
        datasets: [{
            label: 'Fundos',
            data: [@php echo implode(',', $sum); @endphp],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@stop