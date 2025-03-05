@extends('layouts.csslink')

@section('content')
@section('navbar')
<style>
    /* Navbar Styling */
    .navbar {
        height: 55px;
        display: flex;
        align-items: center;
    }

    .navbar-brand img {
        height: 50px;
        margin-right: 10px;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
    }

    /* Gradient Bar */
    .gradient-bar {
        background: linear-gradient(to right, #dd9f03, #eabe03, #dd9f03);
        height: 10px;
        width: 100%;
    }

    /* Page Styling */
    .info-container {
        background: url('{{ asset("backgroundimage.jpg") }}') no-repeat center center;
        background-size: cover;
        background-color: rgba(255, 255, 255, 0.8);
        background-blend-mode: lighten;
        padding: 40px;
        min-height: 100vh;
    }

    .info-title {
        font-weight: 900;
        color: #03592c;
        font-size: 2.5rem;
    }

    .info-text {
        font-weight: bold;
        color: #03592c;
        font-size: 1.2rem;
        display: block;
        margin-bottom: 5px;
    }

    .info-value {
        font-weight: normal;
        color:  #03592c;
        font-size: 1.2rem;
        margin-left: 10px;
    }

    .spacer {
        margin-bottom: 20px;
    }

    .edit-btn {
        background-color: #0d5cba;
        color: white;
        border: none;
        font-size: 1rem;
        padding: 10px 20px;
        margin-top: 15px;
        border-radius: 5px;
    }
</style>

<nav class="navbar navbar-expand-sm navbar-light bg-white border-bottom">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a class="navbar-brand fw-bold text-success d-flex align-items-center" href="#">
            <img src="{{ asset('NVLogo.png') }}" alt="NV Logo">
            <span style="font-weight: 1000; font-size: 2.2rem; color: #03592c;">IPCR</span>
        </a>

        <div class="d-flex gap-2">
            <button class="btn text-white" style="background-color: #03592c;">Assign Targets</button>
            <button class="btn text-white" style="background-color: #0d5cba;">Settings</button>
            <a href="{{ url('/') }}" class="btn text-white" style="background-color: #bc0c0c;">Logout</a>
        </div>
    </div>
</nav>

<div class="gradient-bar"></div>
@endsection

<div class="info-container d-flex  ml-5 align-items-start">
    <h1 class="info-title">PERSONAL INFORMATION</h1>

    <div class="d-flex flex-row">
        <div class="d-flex flex-column mr-4">
            <label class="info-text">Admin Name: <span class="info-value">Juan S. Dela Cruz</span></label>
            <label class="info-text">Position: <span class="info-value">Administrative Aide III (Clerk I)</span></label>
            <label class="info-text">Status: <span class="info-value">Casual</span></label>
        </div>
        <div class="d-flex flex-column">
            <label class="info-text">Division: <span class="info-value">Organizational Development Division</span></label>
            <label class="info-text">Username: <span class="info-value">JSDelaCruz</span></label>
            <label class="info-text">Password: <span class="info-value">qwertyuiop</span></label>
        </div>
    </div>

    <button class="edit-btn mt-3">Edit Account</button>
</div>


@endsection
