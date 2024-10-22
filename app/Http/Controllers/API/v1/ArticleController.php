<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class ArticleController extends Controller
{

    public function index(Request $request)
    {
        // $article = Article::latest('publish_date')->get();
        $query = Article::query()->latest('publish_date');
        $keyword = $request->input('title');
        if ($keyword) {
            $query->where('title', 'like', "%{$keyword}%");
        }
        $article = $query->paginate(2);

        if ($article->isEmpty()) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Article emppty',
            ], Response::HTTP_NOT_FOUND);
        } else {
            return response()->json([
                'data' => $article->map(function ($article) {
                    return [
                        'title' => $article->title,
                        'content' => $article->content,
                        'publish_date' => $article->publish_date,
                    ];
                }),
                'message' => 'List articles',
                'status' => Response::HTTP_OK

            ], Response::HTTP_OK);
        }


        return response()->json([
            'data' => Article::latest()->get(),
            'message' => 'All articles retrieved successfully',

        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'publish_date' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            Article::create([
                'title' => $request->title,
                'content' => $request->content,
                'publish_date' => Carbon::create($request->publish_date)->toDateString(),
            ]);

            return response()->json([
                'status' => Response::HTTP_OK,
                'menssage' => 'Data stored to db'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Error storng data : ' . $e->getMessage());

            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed stored data to db'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function show($id)
    {
        $article = Article::where('id', $id)->first();

        if ($article) {
            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => $article
            ], Response::HTTP_OK);
        } else {
            # code...
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Article not found'
            ], Response::HTTP_NOT_FOUND);
        }
    }
    public function update(Request $request, $id)
    {
        $article = Article::find($id);

        if (!$article) {
            # code...
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Article not found'
            ], Response::HTTP_NOT_FOUND);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'publish_date' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {

            $article->update([
                'title' => $request->title,
                'content' => $request->content,
                'publish_date' => Carbon::create($request->publish_date)->toDateString(),
            ]);
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Data updated successfully'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Error updating data : ' . $th->getMessage());

            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to update data'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function destroy($id)
    {
        $article = Article::find($id);

        try {
            $article->delete();
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Article deleted successfully'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            //throw $th;
            Log::error('Error deleting data : ' . $e->getMessage());

            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to delete data'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function teste()
    {
        // $articles = Article::all();

        $article = Article::findOrFail(3);
        return response()->json([
            'data' => $article,
            'message' => 'List articles',
            'status' => Response::HTTP_OK

        ], Response::HTTP_OK);

    }
}
