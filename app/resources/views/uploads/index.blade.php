@extends('layouts.templates.default')

@section('content')
  <div class="container">

    <form method="POST" action="{{ route('uploads.store') }}" enctype="multipart/form-data" class="mb-3">
      @csrf
      <div class="form-group">
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="upload_file" name="upload_file">
          <label class="custom-file-label browse-hide" for="upload_file">{{ __("Choose File") }}</label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">{{ __('Store') }}</button>
    </form>

    {{ $uploads->links() }}

    <div class="list-group mb-3">
      @foreach ($uploads as $upload)
        <div class="list-group-item d-flex" style="overflow-x: auto;">
          @if (empty($upload->deleted_at))
            <a href="{{ route('uploads.download', $upload) }}" class="text-decoration-none mr-3">
              <span>{{ $upload->name . "." . $upload->extension }}</span>
              <div class="small text-muted">
                <span>[{{ $upload->id }}]</span>
                <span>{{ DateHelper::isoFormat($upload->created_at) }}</span>
                <span>&mdash;</span>
                <span>{{ FileHelper::formatSizeUnits($upload->size) }}</span>
              </div>
            </a>
            <a href="{{ route('uploads.destroy', $upload) }}" class="text-decoration-none text-danger ml-auto"
            onclick="event.preventDefault(); let confirmed = confirm('Delete?'); if (confirmed) { document.getElementById('delete-upload-{{ $upload->id }}').submit(); }">
              {{ __('Delete') }}
            </a>
            <form id="delete-upload-{{ $upload->id }}" action="{{ route('uploads.destroy', $upload) }}" method="POST" class="d-none">
              @method('DELETE')
              @csrf
            </form>
          @else
            <div class="mr-3">
              <span>{{ $upload->name . "." . $upload->extension }}</span>
              <div class="small text-muted">
                <span>[{{ $upload->id }}]</span>
                <span>{{ DateHelper::isoFormat($upload->created_at) }}</span>
              </div>
            </div>
            <span class="text-danger text-nowrap ml-auto">{{ DateHelper::isoFormat($upload->deleted_at) }}</span>
          @endif
        </div>
      @endforeach
    </div>

    {{ $uploads->links() }}

  </div>
@endsection

@push('script')
<script type="text/javascript">
window.addEventListener('load', function() { $( document ).ready(function() {

  $('#upload_file').on('change', function () {
    let files = Object.values(this.files)
    let names = files.map(f => f.name)
    let total = files.map(f => f.size).reduce((a, b) => a + b, 0)
    let count = files.length
    if (count > 0) {
      total = Number(total / 1048576).toFixed(2)
      label = names.join(', ') + ' [' + total + 'MB]'
      $(this).siblings('.custom-file-label')
            .addClass('selected')
            .html(label)
    }
  })

});});
</script>
@endpush

@push('head')
<style>
.custom-file-label {
	overflow: hidden;
}
.custom-file-label.browse-hide::after {
	display: none;
}
</style>
@endpush