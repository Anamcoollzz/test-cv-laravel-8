<?php

namespace App\Repositories;

use Illuminate\Http\JsonResponse;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class ActivityRepository
{

    /**
     * create activity data
     *
     * @param array $data
     * @return Activity
     */
    public function create(array $data)
    {
        return Activity::create($data);
    }

    /**
     * get data as datatable object
     *
     * @return JsonResponse
     */
    public function getDataTable()
    {
        // $image = '{{Storage::url($image)}}';
        return DataTables::of(Activity::with('causer'))
            ->addIndexColumn()
            // ->editColumn('image', $image)
            ->make(true);
    }

    /**
     * find activity data by id
     *
     * @param mixed $id
     * @return Activity
     */
    public function find($id)
    {
        return Activity::find($id);
    }

    /**
     * update activity data by id
     *
     * @param mixed $id
     * @param array $data
     * @return Activity
     */
    public function update($id, array $data)
    {
        $activity = $this->find($id);
        $activity->update($data);
        return $activity;
    }

    /**
     * delete activity data by id
     *
     * @param mixed $id
     * @return boolean
     */
    public function delete($id)
    {
        $activity = $this->find($id);
        if ($activity) {
            return $activity->delete();
        }
        return false;
    }
}
