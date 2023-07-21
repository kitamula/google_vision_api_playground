<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{route('index')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="analyze_image" id="">
        <input type="submit" value="送信">
    </form>

    @if(!empty($result))
    <div id="result_box">
        <div class="img">
            {{-- フォームに添付された画像を表示する --}}
            <img width="200px" src="{{asset('storage/'.$analyzeImageFilePath)}}" alt="">
        </div>
        <ul>
            @foreach ($result->getLabelAnnotations() as $annotation)
            <li>{{$annotation->getDescription()}}</li>
            @endforeach
        </ul>
    </div>
    @endif
</body>
</html>
