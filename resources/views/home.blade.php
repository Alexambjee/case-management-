<?php
session_start();
if(isset($_SESSION['session'])){
    $session = $_SESSION['session'];
}
else{
    $session = '';
}
?>
<!-- extending layout -->
@extends('layout.app')
<!-- app title -->
@section('title','STAFF EXIT')

<!-- main section -->
@section('main-content')
    @if ($session)
        <app :user="{{$session}}" ></app>
    @else
        <app :user="false"></app>
    @endif
@endsection