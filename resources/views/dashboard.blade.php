<!-- extending layouts/default -->
@extends('layouts.default')

@section('content')
<div class="flex-center position-ref full-height">
    <div class="content">
        <h3>Hi {{ @$name }}, This is yours Files List</h3>
        <br>
        @if(count($files))
        <table>
            <thead>
                <tr>
                    <th>File Icon</th>
                    <th>File Name</th>
                    <th>File Size (in KB)</th>
                    <th>File View Link</th>
                    <th>File Download Link</th>
                </tr>
            </thead>
            <tbody>
                @foreach($files as $file)
                <tr>
                    <td><img src="{{ @$file->file_icon_link }}" alt=""></td>
                    <td>{{ @$file->file_name }}</td>
                    <td>{{ @$file->file_size }} KB</td>
                    <td><a href="{{ @$file->file_view_link }}">View</a></td>
                    <td>
                        @if($file->file_download_link != "N/A") <a href="{{ @$file->file_download_link }}">Download</a> @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <table>
            <tr>
                <td> No Records Found!</td>
            </tr>
        </table>
        @endif
        {{ $files->links() }}<!-- pagination -->
    </div>
</div>
@stop