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



                <form action="{{ route('file.upload.post') }}" method="POST" enctype="multipart/form-data">
                  @csrf

                            <button type="submit" class="btn btn-success uploaderBtn"><input type="file" name="file" class="form-control">Upload</button>


                      </form>
                    <!--End Uploader-->
</div>
</div>



</body>

</html>
