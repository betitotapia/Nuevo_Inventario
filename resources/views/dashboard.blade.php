@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h4>Privado</h4>
                    <p>Remisiones privadas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h4>Integral</h4>
                    <p>Servicios integrales</p>
                </div>
                <div class="icon">
                    <i class="fas fa-stethoscope"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h4>Inventario</h4>
                    <p>Almacenes y existencias</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
        </div>
    </div>
@stop