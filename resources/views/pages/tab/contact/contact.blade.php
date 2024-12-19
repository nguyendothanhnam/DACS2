@extends('layout')
@section('tabcontent')

<div class="container my-5">
    <div class="content-card">
        <div class="description">
            <p>{!! $ct_desc !!}</p>  <!-- In ra dữ liệu page_desc với HTML (nếu có) -->
        </div>
    </div>
</div>
@endsection