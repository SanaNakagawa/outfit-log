<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactsSendmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PgSql\Lob;

class ContactsController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function confirm(Request $request)
    {
        $request->validate([
        'email' => 'required|email',
        'title' => 'required',
        'body' => 'required',
        ]);

        // フォームからの入力値を全て取得
        $inputs = $request->all();

        return view('contact.confirm', compact('inputs'));
    }

    public function send(Request $request)
    {
        // バリデーション
        $request->validate([
            'email' => 'required|email',
            'title' => 'required',
            'body' => 'required'
        ]);

        // actionの値を取得
        $action = $request->input('action');

        // action以外のinputの値を取得
        $inputs = $request->except('action');

        //actionの値で分岐 前ページにリダイレクトまたはメールの送信処理
        if($action !== 'submit'){
            return redirect()->route('contact.index')->withInput($inputs);
            
        } else {
            try {
                // ユーザと自分にメールを送信
                Mail::to($inputs['email'])->send(new ContactsSendmail($inputs));
                $fromAddress = config('mail.from.address');
                Mail::to($fromAddress)->send(new ContactsSendmail($inputs));

            } catch (\Exception $e) {
                Log::error($e->getMessage());

                return back()->withErrors(['mail_error' => 'メールの送信中に問題が発生しました。']);
            }

            // 二重送信対策のためトークンを再発行
            $request->session()->regenerateToken();

            // 送信完了ページへ
            return view('contact.thanks');
        }
    }
}
