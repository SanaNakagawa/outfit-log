<?php

namespace App\Http\Controllers;

use App\Models\Bottom;
use App\Models\Photo;
use App\Models\Shoe;
use App\Models\Top;
use App\Models\Color;
use App\Models\Jacket;
use App\Models\Prefecture;
use App\Models\PrefectureUser;
use App\Models\User;
use App\Models\Rating;
use App\Models\Weather;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //直前に表示した詳細ページのデータがセッションに残っている場合は削除
        $sessionData = session('photoDetails');        
        if (isset($sessionData)){
            session()->forget('photoDetails');
        }

        $photos= Auth::user()->photos()->orderBy('selected_date', 'desc')->paginate(30);
             
        //気温を表示する地域
        $userPrefecture= Auth::user()->prefectureUser;
        //ユーザーの地域の初期設定を東京に
        if (!$userPrefecture){
            $userPrefecture = new PrefectureUser();
            $userPrefecture-> user_id = Auth::user()->id;
            $userPrefecture-> prefecture_id = '13';
            $userPrefecture-> save();
        }
        $today = now()->format('n月j日');
        
        //Open Meteoから当日の気温予報を取得
        $weatherData = Weather::fetchAndShowWeatherData($userPrefecture);
            $todayMaxTemp = $weatherData['today']['max_temperature'];
            $todayMinTemp = $weatherData['today']['min_temperature'];
            $yesterdayMaxTemp = $weatherData['yesterday']['max_temperature'];
            $yesterdayMinTemp = $weatherData['yesterday']['min_temperature'];
            $maxTempDifference = $todayMaxTemp - $yesterdayMaxTemp;
            $minTempDifference = $todayMinTemp - $yesterdayMinTemp;
         
        return view('photos.index', compact('photos','userPrefecture','today','todayMaxTemp', 'todayMinTemp', 'maxTempDifference', 'minTempDifference'));
    }

    public function getPhotosForCalendar()
    {
        $photos = Auth::user()->photos;

        return view('photos.calendar', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {      
        $sessionData = null;

        //再登録の時用
        if (session('is_reposting')){
            $sessionData = session('photoDetails');
            //セッションのデータをクリア
            session()->forget(['is_reposting','photoDetails']);
        }
        
        //服の選択肢
        $jackets = Jacket::all();
        $tops = Top::all();
        $bottoms = Bottom::all();
        $shoes = Shoe::all();
        $colors = Color::all();

        //地域
        $userPrefecture = optional(Auth::user()->PrefectureUser);
        $prefectures = Prefecture::all();

        return view('photos.create', compact('sessionData', 'jackets','tops','bottoms','shoes','colors', 'userPrefecture', 'prefectures'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sessionFileName' => 'required_without:file', // 'file'がない場合は'sessionFileName'が必須
            'file' => 'required_without:sessionFileName|file|image|mimetypes:image/jpeg, image/png', 
            'selected_date' => 'required|date|before_or_equal:today',
            ]);

        DB::beginTransaction();
        
        try{        
            //新規登録の場合
            if ($request->has('file')){
                $file = $request->file('file');
                $ext = $file-> getClientOriginalExtension();
                $filename = time().".". $ext;
                $file -> storeAs('images', $filename, 'public');
                
                //DBに投稿内容を保存
                $photo = new Photo;
                $photo -> user_id = Auth::id();
                $photo -> filename = $filename;
                $photo -> selected_date = $request->input('selected_date');
                $photo -> save();
            } 
            
            //再登録の場合
            elseif($request->has('sessionFileName')) {
                $photo = new Photo;
                $photo -> user_id = Auth::id();
                $photo -> filename = $request->input('sessionFileName');
                $photo -> selected_date = $request->input('selected_date');
                $photo -> save();
            }  
    
            //服の種類の選択があれば保存
            if ($request->has('jacket_id') && $request->has('jacket_color_id')) {
                $photo->jackets()->attach($request->jacket_id, ['color_id' => $request->jacket_color_id]);
            }
            if ($request->has('top_id') && $request->has('top_color_id')) {
                $photo->tops()->attach($request->top_id, ['color_id' => $request->top_color_id]);
            } 
            if ($request->has('bottom_id') && $request->has('bottom_color_id')) {
                $photo->bottoms()->attach($request->bottom_id, ['color_id' => $request->bottom_color_id]);
            }        
            if ($request->has('shoe_id') && $request->has('shoe_color_id')) {
                $photo->shoes()->attach($request->shoe_id, ['color_id' => $request->shoe_color_id]);
            }        

            //地域       
            $userPrefecture= Auth::user()->prefectureUser;               
            $selectedPrefecture = $request->input('prefecture');

            //ユーザーの地域情報が選択と異なる場合上書き
            if ($userPrefecture->prefecture_id != $selectedPrefecture){
                $userPrefecture-> update([
                    'prefecture_id' => $selectedPrefecture                
                ]);
            } 
            
            //選択された地域、日付、写真IDを渡して気温情報を取得・保存
            $selectedDate = $request-> input('selected_date');
            $photoId = $photo->id;
            Weather::fetchAndSaveWeatherData($photoId, $selectedDate, $userPrefecture);

            DB::commit();

            return redirect('/photos');

        } catch (\Exception $e){
            DB::rollBack();
            Log::error("写真の保存に失敗: " . $e->getMessage());
            return back()->withErrors('写真の保存に失敗しました。');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        $this->authorize('view', $photo);

        //中間テーブルを経由して写真に関連するデータを取得
        $jacket = $photo->jackets()->first();
        $jacketColor = $jacket ? color::find($jacket->pivot->color_id) : null;

        $top = $photo->tops()->first();
        $topColor = $top ? Color::find($top->pivot->color_id) : null;

        $bottom = $photo->bottoms()->first();
        $bottomColor = $bottom ? Color::find($bottom->pivot->color_id) : null;

        $shoe = $photo->shoes()->first();
        $shoeColor = $shoe ? Color::find($shoe->pivot->color_id) : null;

        //評価        
        $photoRating = $photo->photoRating()->first();

        //これまでに同じ写真を登録した回数
        $count = Photo::where('filename', $photo->filename)->count();

        //同じ種類・色のトップスの写真を検索
        $topQuery = Photo::where('user_id', Auth::id());
        if($top) {
            $topQuery -> whereHas('tops', function ($q) use ($top, $topColor) {
                $q->where('tops.id', $top->id)
                    ->where('photo_top_color.color_id', $topColor->id);
            });
        }
        $topRelatedPhotos = $topQuery ->take(12)->get()->unique('filename');

        //同じ種類・色のボトムスの写真を検索
        $bottomQuery = Photo::where('user_id', Auth::id());
        if($bottom) {
            $bottomQuery -> whereHas('bottoms', function ($q) use ($bottom, $bottomColor) {
                $q->where('bottoms.id', $bottom->id)
                    ->where('photo_bottom_color.color_id', $bottomColor->id);
            });
        }
        $bottomRelatedPhotos = $bottomQuery ->take(12)->get()->unique('filename');

        //再登録用に写真とアイテムの情報をセッションに保存
        session(['photoDetails' => compact('photo', 'jacket', 'jacketColor', 'top', 'topColor', 'bottom', 'bottomColor', 'shoe', 'shoeColor')]);

        return view('photos.show', compact('photo','jacket','jacketColor','top','topColor','bottom','bottomColor','shoe','shoeColor', 'photoRating', 'count', 'topRelatedPhotos','bottomRelatedPhotos'));
    }

    public function repost(Photo $photo)
    {
       //再登録用のセッションフラグ
       session(['is_reposting' => true]);
       
       //投稿ページに移動
       return redirect()->route('photos.create');
    }

    public function search(Request $request)
    {
        //服、色の選択肢
        $jackets = Jacket::all();
        $tops = Top::all();
        $bottoms = Bottom::all();
        $shoes = Shoe::all();

        $colors = Color::all();
        
        //ユーザーの選択
        $jacketId = $request->input('jacket_id');
        $topId = $request->input('top_id');
        $bottomId = $request->input('bottom_id');
        $shoeId = $request->input('shoe_id');

        $jacketColorId = $request->input('jacket_color');
        $topColorId = $request->input('top_color');
        $bottomColorId = $request->input('bottom_color');
        $shoeColorId = $request->input('shoe_color');

        //ユーザーの選択から絞り込み
        $query = Photo::where('user_id', Auth::id());

        if ($jacketId) {
            $query -> whereHas('jackets', function ($q) use ($jacketId) {
                $q -> where('jackets.id', $jacketId);
            }); 
        }
        if ($jacketColorId) {
            $query->whereHas('jackets', function ($q) use ($jacketColorId) {
                $q->where('photo_jacket_color.color_id', $jacketColorId); 
            });
        }  
        if ($topId) {
            $query -> whereHas('tops', function ($q) use ($topId) {
                $q -> where('tops.id', $topId);
            }); 
        }
        if ($topColorId) {
            $query->whereHas('tops', function ($q) use ($topColorId) {
                $q->where('photo_top_color.color_id', $topColorId); 
            });
        }
        if ($bottomId) {
            $query -> whereHas('bottoms', function ($q) use ($bottomId) {
                $q -> where('bottoms.id', $bottomId);
            }); 
        }
        if ($bottomColorId) {
            $query->whereHas('bottoms', function ($q) use ($bottomColorId) {
                $q->where('photo_bottom_color.color_id', $bottomColorId); 
            });
        }
        if ($shoeId) {
            $query -> whereHas('shoes', function ($q) use ($shoeId) {
                $q -> where('shoes.id', $shoeId);
            }); 
        }
        if ($shoeColorId) {
            $query->whereHas('shoes', function ($q) use ($shoeColorId) {
                $q->where('photo_shoe_color.color_id', $shoeColorId); 
            });
        }

        //同じファイル名の登録は2回以上表示しない
        $photos = $query->get()->unique('filename');

        return view('photos.search', compact('jackets', 'jacketId', 'jacketColorId', 'tops','topId', 'topColorId', 'bottoms','bottomId', 'bottomColorId', 'shoes','shoeId', 'shoeColorId', 'colors', 'photos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        session(['is_reposting' => true]);
        $sessionData = session('photoDetails');
        //セッションのデータをクリア
        session()->forget(['is_reposting','photoDetails']);

        $jackets = Jacket::all();
        $tops = Top::all();
        $bottoms = Bottom::all();
        $shoes = Shoe::all();
        $colors = Color::all();

        //これまでに同じ写真を登録した回数
        $count = Photo::where('filename', $photo->filename)->count();

        return view('photos.edit', compact('photo','jackets', 'tops', 'bottoms', 'shoes', 'colors','count', 'sessionData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        $this->authorize('update', $photo);

        DB::beginTransaction();

        try {
            // 同じファイル名の写真を取得
            $photosToUpdate = Photo::where('filename', $photo->filename)->get();

            // アイテムの種類と色を更新
            foreach ($photosToUpdate as $photoToUpdate) {
                if ($request->filled('jacket_id') && $request->filled('jacket_color_id')) {
                    $photoToUpdate->jackets()->sync([$request->jacket_id => ['color_id' => $request->jacket_color_id]]);
                }
                if ($request->filled('top_id') && $request->filled('top_color_id')) {
                    $photoToUpdate->tops()->sync([$request->top_id => ['color_id' => $request->top_color_id]]);
                }
                if ($request->filled('bottom_id') && $request->filled('bottom_color_id')) {
                    $photoToUpdate->bottoms()->sync([$request->bottom_id => ['color_id' => $request->bottom_color_id]]);
                }
                if ($request->filled('shoe_id') && $request->filled('shoe_color_id')) {
                    $photoToUpdate->shoes()->sync([$request->shoe_id => ['color_id' => $request->shoe_color_id]]);
                }
            }

            DB::commit();
            return redirect()->route('photos.show', $photo->id)->with('success', 'アイテムが更新されました。');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("アイテム更新エラー: " . $e->getMessage());
            return back()->withErrors('アイテムの更新中にエラーが発生しました。');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        $this->authorize('view', $photo);
        
        try {
            //同じファイル名を持つレコードをカウント
            $count = Photo::where('filename', $photo->filename)->count();

            //同じファイル名を持つレコードが無い場合にはストレージからファイルを削除
            if ($count == 1){
                $filePath = storage_path('app/public/images').'/'. $photo->filename;
                if (File::exists($filePath)){
                    File::delete($filePath);
                } else {
                    dd($filePath);
                }
            } 

            //DBからレコードを削除
            $photo->delete();

            return redirect()->route('photos.index')->with('success', '写真が削除されました。');      
           
        } catch(\Exception $e) {
            Log::error("写真削除エラー: " . $e->getMessage());
            return back()->withErrors('写真の削除に失敗しました。');
        }
    }
}
