<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    // Display a index of the pages.
    public function index()
    {
        $pages = Page::all();
        return view('admin.page.list', compact('pages'));
    }

    // Show the form for creating a new page.
    public function create()
    {
        return view('admin.page.create');
    }

    // Store a newly created page in the database.
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $page = new Page([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
        ]);

        $page->save();

        return redirect()->route('page.list')->with('success', 'Page created successfully.');
    }

    // Show the form for editing the specified page.
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.page.edit', compact('page'));
    }

    // Update the specified page in the database.
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $page = Page::findOrFail($id);
        $page->title = $request->get('title');
        $page->content = $request->get('content');

        $page->save();

        return redirect()->route('page.list')->with('success', 'Page updated successfully.');
    }

    // Remove the specified page from the database.
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return redirect()->route('page.list')->with('success', 'Page deleted successfully.');
    }
}
