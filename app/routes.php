<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('form');
});

Route::post('/', function(){
	//フォームのバリデーションルールを定義する
	$rules = array(
		'link' => 'required|url'
	);
	//バリデーション
	$validation = Validator::make(Input::all(), $rules);
	//バリデーションに引っかかった場合、メインページでエラーを出す
	if($validation->fails()) {
		return Redirect::to('/')
		->withInput()
		->withErrors($validation);
	} else {
		//既にリンクがDBにあるか確認。ある場合はその結果を返す
		$link = Link::where('url', '=', Input::get('link'))
		->first();
		//URLが既にDBに登録されている場合、その情報をviewに返す
		if($link) {
			return Redirect::to('/')
			->withInput()
			->with('link', $link->hash);
		} else {
			//登録されていなければ新しいユニークなURLを作る
			do {
				$newHash = Str::random(6);
			} while (Link::where('hash', '=', $newHash)->count() > 0);

			//DBにレコード追加
			Link::create(array(
				'url' => Input::get('link'),
				'hash' => $newHash
			));

			//新しい短縮URLを返す
			return Redirect::to('/')
			->withInput()
			->with('link', $newHash);
		}
	}
})