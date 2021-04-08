<!DOCTYPE html>
@extends('welcome')

<html lang="en">

<head>
</head>

<body>

    <!--Uploader-->
    <div class="uploader center">

        <div class="panel panel-primary uplodaer">
            <div class="panel-heading">
                <h2> Upload File </h2>
            </div>
            <div class="panel-body">

                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('file.upload.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="uploaderControls">

                        <div class="col-md-6">
                            <input type="file" name="file" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success uploaderBtn">Upload</button>
                        </div>

                    </div>
                    <!--End Uploader-->




</body>

</html>
