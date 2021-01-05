<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Repositories\BlogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

    public function __construct()
    {
        $this->blogRepository = new BlogRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->blogRepository->getDataTable();
        }
        return view('blog.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required',
            'body'     => 'required',
            'image'    => 'required|file|image',
            'category' => 'required',
        ]);
        $data    = $request->only(['title', 'body', 'category']);
        $data['image'] = $request->image->store('public/blog');
        $blog    = $this->blogRepository->create($data);
        activity()
            ->causedBy(Auth::user())
            ->log('Create blog');
        return response()->json([
            'message' => 'Blog success created',
            'data'    => $blog,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        return $this->blogRepository->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'    => 'required',
            'body'     => 'required',
            'image'    => 'nullable|file|image',
            'category' => 'required',
        ]);
        $data    = $request->only(['title', 'body', 'category']);
        if ($request->hasFile('image'))
            $data['image'] = $request->image->store('public/blog');
        $blog    = $this->blogRepository->update($id, $data);
        activity()
            ->causedBy(Auth::user())
            ->log('Update blog');
        return response()->json([
            'message' => 'Blog success updated',
            'data'    => $blog,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = $this->blogRepository->find($id);
        if ($blog) {
            if (Storage::exists($blog->image)) {
                Storage::delete($blog->image);
            }
            activity()
                ->causedBy(Auth::user())
                ->log('Delete blog');
            return $this->blogRepository->delete($id);
        }
        return false;
    }
}
