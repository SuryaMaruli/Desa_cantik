@extends('layouts.admin')

@section('page-title', 'Edit Berita')

@section('content')
<script>
    // Redirect to index page and auto-open edit modal
    window.location.href = '/admin/berita?open_edit={{ $berita->id }}';
</script>
@endsection
