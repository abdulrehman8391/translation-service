<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $q = Translation::query()->select(['id', 'key', 'locale', 'context']);
        if ($request->filled('locale')) $q->where('locale', $request->input('locale'));
        if ($request->filled('key')) $q->where('key', 'like', '%' . $request->input('key') . '%');
        if ($request->filled('tag')) {
            $tag = $request->input('tag');
            $q->where(function ($b) use ($tag) {
                $b->where('tag0', $tag)->orWhereJsonContains('tags', $tag);
            });
        }
        $items = $q->orderBy('id', 'desc')->limit((int)$request->input('per_page', 50))->get();
        return response()->json(['data' => $items]);
    }

    public function store(Request $r)
    {
        $d = $r->validate(['key' => 'required|string|max:191', 'locale' => 'required|string|max:10', 'value' => 'required|string', 'tags' => 'nullable|array', 'context' => 'nullable|string|max:100']);
        $t = Translation::create($d);
        Cache::forget('translations_export_small_' . $t->locale);
        return response()->json($t, 201);
    }

    public function show($id)
    {
        return response()->json(Translation::findOrFail($id));
    }

    public function update(Request $r, $id)
    {
        $d = $r->validate(['value' => 'sometimes|required|string', 'tags' => 'nullable|array', 'context' => 'nullable|string|max:100']);
        $t = Translation::findOrFail($id);
        $t->update($d);
        Cache::forget('translations_export_small_' . $t->locale);
        return response()->json($t);
    }

    public function export($locale)
    {
        $small = 'translations_export_small_' . $locale;
        $count = DB::table('translations')->where('locale', $locale)->count();
        if ($count <= 5000 && Cache::has($small)) return response()->json(Cache::get($small));
        if ($count <= 5000) {
            $rows = DB::table('translations')->where('locale', $locale)->select('key', 'value')->get();
            $assoc = [];
            foreach ($rows as $r) $assoc[$r->key] = $r->value;
            Cache::put($small, $assoc, 60);
            return response()->json($assoc);
        }
        $stream = function () use ($locale) {
            echo '{';
            $first = true;
            DB::table('translations')->where('locale', $locale)->orderBy('id')->select('key', 'value')->chunk(5000, function ($rows) use (&$first) {
                foreach ($rows as $row) {
                    if (!$first) echo ',';
                    $k = json_encode($row->key, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    $v = json_encode($row->value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    echo substr($k, 1, -1) . ':' . $v;
                    $first = false;
                }
                if (function_exists('ob_flush')) {
                    ob_flush();
                }
                flush();
            });
            echo '}';
        };
        return response()->stream($stream, 200, ['Content-Type' => 'application/json']);
    }
}
