<?php

namespace App\Http\Controllers\Admin;
use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PostController extends Controller
{


	public function pending(){
		$page_title = 'Pending Posts';

		$posts = Post::where('status', 2)
                    ->latest()
                    ->with('user')
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->paginate(getPaginate());

		return view('admin.post.index', compact('page_title', 'posts'));
	}

	public function approved(){
		$page_title = 'Approved Topics';

		$posts = Post::where('status', 1)
                    ->latest()
                    ->with('user')
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->paginate(getPaginate());

		return view('admin.post.index', compact('page_title', 'posts'));
	}

	public function posts(){
		$page_title = 'All Topics';

		$posts = Post::where('status', '!=', 3)
                    ->latest()
                    ->with('user')
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->paginate(getPaginate());

		return view('admin.post.index', compact('page_title', 'posts'));
	}

	public function approve(Request $request){

		$request->validate([
			'id' => 'required|exists:posts,id',
		]);

		$post = Post::where('id', $request->id)
                    ->where('status', 2)
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->firstOrFail();
		$post->status = 1;
		$post->save();

		$notify[] = ['success', 'Post approved successfully.'];
        return back()->withNotify($notify);
	}

	public function details($id){

		$post = Post::where('id', $id)->where('status', '!=', 3)->firstOrFail();
		$page_title = 'Posts Details of '.$post->post_title;
		return view('admin.post.details', compact('page_title', 'post'));
	}



      public function reject(Request $request)
    {


        $post = Post::where('id', $request->id)
                    ->where('status', 2)
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->firstOrFail();
		$post->delete();
         $notify[] = ['success', 'Forum Post Deleted successfully.'];
        return back()->withNotify($notify);

    }
    public function indexComment()
    {

       $user = auth()->user();
        $post = Comment::all();

        // return $post;
		$page_title = 'All Comments';
		return view('admin.post.comment', compact('page_title', 'post', 'user'));

    }

    public function delete(Request $request)
    {


        $post = Comment::where('id', $request->id);
		$post->delete();
         $notify[] = ['success', 'Forum Post Deleted successfully.'];
        return back()->withNotify($notify);

    }

}
