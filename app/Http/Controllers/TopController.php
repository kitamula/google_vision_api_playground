<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function analyze(Request $request)
    {
        $client = new \Google\Cloud\Vision\V1\ImageAnnotatorClient();

        // 一時フォルダに保存
        $analyzeImageFilePath = $request->analyze_image->store('temp', 'public');

        // $imageFilePath = $request->analyze_image->getPathname();
        $image = $client->createImageObject(file_get_contents(storage_path('app/public/'.$analyzeImageFilePath)));

        // 画像の特徴を取得する
        $result = $client->labelDetection($image);
        // 顔を検出する
        // $detectFace = $client->faceDetection($image);
        // dd($detectFace->getFaceAnnotations());

        // エラーがあった場合はfalseを返す
        if (!is_null($result->getError())) {
            return ['result' => false];
        }

        // dd($result->getLabelAnnotations());

        // ラベルを取得する
        // $labels = $result->getLabelAnnotations();

        return view('index', compact('result', 'analyzeImageFilePath'));
    }
}
