<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;
use Illuminate\Support\Facades\DB;

class MealsController extends Controller
{
    public function show(Request $request) {
        $request->validate([
            'per_page' => 'integer',
            'page' => 'integer',
            'category' => 'nullable',
            'tags' => 'regex:/^([0-9]+,*)+$/',
            'with' => 'string',
            'lang' => 'required|string',
            'diff_time' => 'integer|min:0',
        ]);
        
        //parametri
        $per_page = $request->query('per_page', 5);
        $page = $request->query('page', 1);
        $category = $request->query('category');
        $tags = $request->query('tags');
        $with = $request->query('with');
        $lang = $request->query('lang');
        $diff_time = $request->query('diff_time', -1);
        
        if(!is_null($tags)) 
            $tags = array_map('intval', explode(',', $tags));
        $available_langs = DB::table('languages')->select('locale')->get();
        if (str_contains($available_langs, $lang)) 
            app()->setLocale($lang);
        else 
            return redirect('/meals?lang=en');

        $data = Meal::query();
        //with category, tags, ingredients
        if(str_contains($with, 'category')) 
            $data = $data->with('categories');
        if(str_contains($with, 'tags')) 
            $data = $data->with('tags:id,slug');
        if(str_contains($with, 'ingredients')) 
            $data = $data->with('ingredients:id,slug');

        //category(optional, NULL, !NULL, id) & tags (optional, lista id-eva)
        if($category == 'NULL') { //nemaju kategoriju
            $data = $data->whereNull('category');
            if(!is_null($tags)) {
                foreach($tags as $tag) {
                    $data = $data->whereHas('tags', function($q) use ($tag) {
                        return $q->where('tag_id', $tag);
                    });
                }
            }
        } elseif($category == '!NULL') { //imaju kategoriju
            if(is_null($tags)) {
                $data = $data->whereNotNull('category');
            } else {
                foreach($tags as $tag) {
                    $data = $data->whereHas('tags', function($q) use ($tag) {
                        return $q->where('tag_id', $tag);
                    });
                }
                $data = $data->whereNotNull('category');
            }
        } elseif (is_null($category)) { //svi
            if(!is_null($tags)) {
                foreach($tags as $tag) {
                    $data = $data->whereHas('tags', function($q) use ($tag) {
                        return $q->where('tag_id', $tag);
                    });
                }
            }
        } elseif (intval($category)) { //id
            if(is_null($tags)) {
                $data = $data->where('category', '=', $category);
            } else {
                foreach($tags as $tag) {
                    $data = $data->whereHas('tags', function($q) use ($tag) {
                        return $q->where('tag_id', $tag);
                    });
                }
                $data = $data->where('category', '=', $category);
            }
        } else {
            return redirect('/meals?lang=en');
        }

        //diff_time
        if ($diff_time != -1)
            $data = $data->withTrashed()->where(function ($query) use ($diff_time) {
                $query->where('meals.created_at', '>', date("Y-m-d H:i:s",$diff_time))
                ->orWhere('meals.updated_at', '>', date("Y-m-d H:i:s",$diff_time))
                ->orWhere('meals.deleted_at', '>', date("Y-m-d H:i:s",$diff_time));
            });

        $data = $data->paginate($per_page)->appends(request()->query());

        //status
        foreach($data as $meal) {
            if(strtotime($meal->deleted_at) > intval(($diff_time))) 
                $meal->status = 'deleted';
            elseif((strtotime($meal->updated_at) > intval($diff_time)) and (strtotime($meal->updated_at)>strtotime($meal->created_at)))
                $meal->status = 'modified';
            else 
                $meal->status = 'created';
        }

        $prev = $data->previousPageUrl();
        $next = $data->nextPageUrl();
        $self = $data->url($page);
        return response()
            ->json([
            'meta' => [
                'current_page' => $data->currentPage(),
                'total_items' => $data->total(),
                'itemsPerPage' => $data->perPage(),
                'total_pages' => ceil($data->total()/$data->perPage()),
            ],
            'data' => $data->except((['current_page', 'first_page_url', 'from', 'last_page', 'last_page_url'])),
            'links' => [
                'prev' => $prev,
                'next' => $next,
                'self' => $self
            ], 
        ]);
    }
}
