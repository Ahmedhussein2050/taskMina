<?php

namespace App\Modules\Admin\Controllers\Reviews;

use App\Bll\Lang;
use App\Bll\Utility;
use App\Http\Controllers\Controller;

use App\Modules\Admin\Models\Reviews\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ReviewsController extends Controller
{
    public function index()
    {
        $reviews = Review::query()
            ->Join('users', 'reviews.user_id', 'users.id')
            ->join('product_details', 'reviews.product_id', 'product_details.product_id')
            ->select('reviews.*', 'product_details.title', 'users.name', 'users.last_name', 'users.phone')
            ->where('product_details.lang_id', Lang::getSelectedLangId())
            ->get();
        if (request()->ajax()) {
            return \Yajra\DataTables\Facades\DataTables::of($reviews)
                ->addColumn('change_status', function ($query) {
                    if ($query->status == 0) {
                        return "<a href data-id='" . $query->id . "' class='btn btn-warning change-status'>" . _i('Approve') . "</a>";
                    } else {
                        return "<a class='btn btn-success'>" . _i('Approved') . "</a>";
                    }
                })
                ->addColumn('delete', function ($query) {
                    return "<a href data-id='" . $query->id . "' class='btn btn-danger delete'>" . _i('Delete') . "</a>";
                })
                ->addColumn('user_name', function ($query) {
                    return $query->name . ' ' . $query->last_name;
                })
                ->addColumn('created_at', function ($query) {
                    return Utility::dates($query->created_at);
                })
                ->addColumn('updated_at', function ($query) {
                    return Utility::dates($query->updated_at);
                })
                ->rawColumns(['created_at', 'updated_at', 'change_status', 'delete'])
                ->make(true);
        }
        return view('admin.reviews.index');
    }

    public function update()
    {
        $review = Review::query()->find(request()->id);
        $review->status = 1;
        $review->save();
        if ($review->save()) {
            return response()->json();
        }
    }
    public function destroy()
    {
        $review = Review::query()->find(request()->id);
        if ($review){
            $review->delete();
            return response()->json();
        }
    }
}
