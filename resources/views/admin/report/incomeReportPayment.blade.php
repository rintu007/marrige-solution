@extends('admin.layouts.adminMaster')

@push('css')
@endpush

@section('content')

  @include('admin.report.parts.incomeReportPayment')

@endsection


@push('js')
<script src="{{asset('js/report.js')}}"></script>
@endpush
