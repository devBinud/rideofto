@extends('admin.layout', [
    'pageTitle' => 'Dashboard',
    'currentPage' => 'dashboard'
])

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('custom-css')
    
    <style>
        .count{
            font-weight: bold !important ;
        }
        .counter-card:hover{
            scale: 1.1 !important ;
            cursor: pointer;
        }
    </style>
@endsection

@section('body')





@endsection

@section('custom-js')

<script src="{{ asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>


    
@endsection