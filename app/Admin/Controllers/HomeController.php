<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        $user = \Encore\Admin\Facades\Admin::user();
        return $content
            ->title('HOME')
            ->description('管理画面トップページ')
            ->row(function (Row $row) use ($user) {
            // Menuで設定した項目(フォルダ以外)
            foreach (\Encore\Admin\Facades\Admin::menu() as $item) {
                self::addButton($row, $item, $user);
            }
        });
    }

    public static function addButton($row, $item, $user)
    {
        if($user->visible(\Illuminate\Support\Arr::get($item, 'roles', [])) && $user->can(\Illuminate\Support\Arr::get($item, 'permission'))){
            if(isset($item['children'])){
                // 親要素の場合 仕切りとして追加
                $row->column(12, function (Column $column) use ($item){
                    $column->append('
                        <h3><i class="fa '.$item['icon'].' " aria-hidden="true"></i> '.$item['title'].'</h3>
                    ');
                });
            }

            if (!isset($item['children']) && $item['uri'] != '/') {
                // 葉要素の場合 ボタンとして追加
                $row->column(4, function (Column $column) use ($item) {
                    $itemUri = url()->isValidUrl($item['uri']) ? $item['uri'] : admin_url($item['uri']);
                    $column->append('
                        <a type="button" class="btn btn-primary btn-lg btn-block" href="'.$itemUri.'" style="margin-bottom: 5px"><i class="fa '.$item['icon'].' " aria-hidden="true"></i> '. admin_trans($item['title']) .'</a>
                    ');
                });
            }else if(isset($item['children'])){
                // 子要素がある時はネストしてループ
                foreach ($item['children'] as $nestedItem) {
                    self::addButton($row, $nestedItem, $user);
                }
            }
        }
    }
}
