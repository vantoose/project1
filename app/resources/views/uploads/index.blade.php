@extends('layouts.templates.default')

@section('content')
  <div class="container">

    <div class="alert alert-info" role="alert">
      <span>Uploads total size:</span>
      <span>{{ FileHelper::formatSizeUnits(Auth::user()->uploadsTotalSize) }}</span>
    </div>

    <form method="POST" action="{{ route('uploads.store') }}" enctype="multipart/form-data" class="mb-3">
      @csrf
      <div class="form-group">
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="upload_file" name="upload_file">
          <label class="custom-file-label browse-hide" for="upload_file">{{ __("Choose File") }}</label>
          <small class="form-text text-muted">
            Upload max filesize is
            {{ PhpConfigHelper::getUploadMaxFilesizeWithSizeUnits() }}
            ({{ FileHelper::convertToKilobytes(PhpConfigHelper::getUploadMaxFilesize()) }} bytes)
          </small>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">{{ __('Store') }}</button>
    </form>

    <div class="overflow-auto">
      {{ $uploads->links() }}
    </div>

    <div class="list-group mb-3">
      @foreach ($uploads as $upload)
        <div class="list-group-item" style="overflow-x: auto;">
          @if (empty($upload->deleted_at))
            <div class="d-flex">
              <div class="mr-3">
                <span>{{ $upload->name . "." . $upload->extension }}</span>
                <div class="small text-muted">
                  <span>[{{ $upload->id }}]</span>
                  <span>{{ DateHelper::isoFormat($upload->created_at) }}</span>
                  <span>&mdash;</span>
                  <span>{{ FileHelper::formatSizeUnits($upload->size) }}</span>
                </div>
                <div class="mt-1">
                  <a role="button" class="btn btn-link text-decoration-none" href="{{ route('uploads.download', $upload) }}">{{ __('routes.web.uploads.download') }}</a>
                  <button type="button" class="btn btn-link text-decoration-none" onclick="event.preventDefault(); copyToClipboard('{{ $upload->public_url }}');">{{ __('Copy public link') }}</button>
                </div>
              </div>

              <div class="ml-auto">
                <a href="{{ route('uploads.destroy', $upload) }}" class="text-decoration-none text-danger" 
                onclick="event.preventDefault(); let confirmed = confirm('Delete?'); if (confirmed) { document.getElementById('delete-upload-{{ $upload->id }}').submit(); }">
                  {{ __('Delete') }}
                </a>
                <form id="delete-upload-{{ $upload->id }}" action="{{ route('uploads.destroy', $upload) }}" method="POST" class="d-none">
                  @method('DELETE')
                  @csrf
                </form>
              </div>
            </div>
          @else
            <div class="d-flex">
              <div class="mr-3">
                <span>{{ $upload->name . "." . $upload->extension }}</span>
                <div class="small text-muted">
                  <span>[{{ $upload->id }}]</span>
                  <span>{{ DateHelper::isoFormat($upload->created_at) }}</span>
                </div>
              </div>

              <div class="ml-auto">
                <span class="text-danger text-nowrap">{{ DateHelper::isoFormat($upload->deleted_at) }}</span>
              </div>
            </div>
          @endif
        </div>
      @endforeach
    </div>

    <div class="overflow-auto">
      {{ $uploads->links() }}
    </div>

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

@push('script')
<script type="text/javascript">
function copyToClipboard(text) {
  let textarea = document.createElement('textarea')
  textarea.value = text
  document.body.appendChild(textarea)
  textarea.select()
  let result = document.execCommand('copy')
  document.body.removeChild(textarea)
  return result
}
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