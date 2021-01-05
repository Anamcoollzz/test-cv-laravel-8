<?php

namespace App\Repositories;

use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class BlogRepository
{

    /**
     * create blog data
     *
     * @param array $data
     * @return Blog
     */
    public function create(array $data)
    {
        return Blog::create($data);
    }

    /**
     * get data as datatable object
     *
     * @return JsonResponse
     */
    public function getDataTable()
    {
        $image = '{{Storage::url($image)}}';
        return DataTables::of(Blog::query())
            ->addIndexColumn()
            ->editColumn('image', $image)
            ->make(true);
    }

    /**
     * find blog data by id
     *
     * @param mixed $id
     * @return Blog
     */
    public function find($id)
    {
        return Blog::find($id);
    }

    /**
     * update blog data by id
     *
     * @param mixed $id
     * @param array $data
     * @return Blog
     */
    public function update($id, array $data)
    {
        $blog = $this->find($id);
        $blog->update($data);
        return $blog;
    }

    /**
     * delete blog data by id
     *
     * @param mixed $id
     * @return boolean
     */
    public function delete($id)
    {
        $blog = $this->find($id);
        if ($blog) {
            return $blog->delete();
        }
        return false;
    }
}
