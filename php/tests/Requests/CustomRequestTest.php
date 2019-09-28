<?php

namespace Tests\Requests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CustomRequest;


class CustomRequestTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @dataProvider dataproviderExample
     */

    public function testExample($dataLists)
    {

        $request = new CustomRequest();
        $rules = $request->rules();
        $validator = Validator::make($dataLists, $rules);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    public function dataproviderExample()
    {
        return [
            '正常' => [['title' => 'タイトル', 'body' => '本文', true]],
            '最大文字数エラー' => [['title', str_repeat('a', 51), 'body', '本文', false], ['title', 'タイトル', 'body', str_repeat('a', 2001), false]],
            '必須エラー' => [['title', '', 'body', '本文', false], ['title', 'タイトル', 'body', '', false]]
        ];
    }


    // public function testExample($title, $val1, $body, $val2, $expect)
    // {
    //     $dataLists = [$title => $val1, $body => $val2];
    //     $request = new CustomRequest();
    //     $rules = $request->rules();
    //     $validator = Validator::make($dataLists, $rules);
    //     $result = $validator->passes();
    //     $this->assertEquals($expect, $result);
    // }

    // public function dataproviderExample()
    // {
    //     return [
    //         '正常1' => ['title', 'タイトル', 'body', '本文', true],
    //         '必須エラー1' => ['title', '', 'body', '本文', false],
    //         '最大文字数エラー1' => ['title', str_repeat('a', 51), 'body', '本文', false],
    //         '必須エラー' => ['title', 'タイトル', 'body', '', false],
    //         '最大文字数エラー' => ['title', 'タイトル', 'body', str_repeat('a', 2001), false]
    //     ];
    // }
}


