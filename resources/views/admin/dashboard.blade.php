@extends('admin.layouts.adminMaster')
{{-- @section('title', 'TMM') --}}
<?php $me = Auth::user(); ?>
@push('css')

@endpush

@section('content')

  @include('admin.parts.dashboard')

@endsection


@push('js')
{{-- <script type="text/javascript">
  alert('ok');
</script> --}}
@endpush
