<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Term;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    public function index()
    {
        $type = request()->get('type');
        $search = request()->get('q');
        $limit = request()->get('limit') ?? 10;
        $tags = Term::where('type', $type . '_tag')
                ->where('value', 'LIKE', "%$search%")
                ->latest()
                ->paginate($limit)
                ->appends(request()->all());

        return view('admin.tags.index', compact('tags', 'type'));
    }

    public function create()
    {
        $type = request()->get('type');
        return view('admin.tags.create', compact('type'));
    }

    public function store(Request $request)
    {
        $type = request()->get('type');
        $validated = $request->validate([
            'value' => [
                'required',
                'string',
                'max:255',
                Rule::unique('terms')->where(fn ($query) => $query->where('type', $type)),
            ],
        ]);

        Term::create([
            'type' => $type . "_tag",
            'value' => $validated['value'],
        ]);

        return redirect()->route("admin.tags.index", ['type' => $type])
            ->with('success', ucfirst($type) . ' tag created.');
    }

    public function edit(Term $tag)
    {
        $type = request()->get('type');
        return view('admin.tags.edit', compact('tag', 'type'));
    }

    public function update(Request $request, Term $tag)
    {
        $type = request()->get('type');
        $validated = $request->validate([
            'value' => [
                'required',
                'string',
                'max:255',
                Rule::unique('terms')
                    ->where(fn ($query) => $query->where('type', $type))
                    ->ignore($tag->id),
            ],
        ]);

        $tag->update($validated);

        return redirect()->route("admin.tags.index", ['type' => $type])
            ->with('success', ucfirst($type) . ' tag updated.');
    }

    public function destroy(Term $tag)
    {
        $type = request()->get('type');
        $tag->delete();

        return redirect()->route("admin.tags.index", ['type' => $type])
            ->with('success', ucfirst($type) . ' tag deleted.');
    }
}