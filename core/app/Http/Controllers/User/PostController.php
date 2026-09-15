<?php

namespace App\Http\Controllers\User;

use App\CommissionLog;
use App\GeneralSetting;
use App\Lib\GoogleAuthenticator;
use App\Models\Survey\Questionimage;
use App\Plan;
use App\Deposit;
use App\PtcView;
use App\Referral;
use App\Rules\FileTypeValidate;
use App\Transaction;
use App\User;
use App\WithdrawMethod;
use App\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Carbon;
use App\Post;
use App\Category;
use App\SubCategory;
use App\Comment;
use App\Reaction;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Image;
use Validator;
use App\Models\Survey\UserMicroJob;
use App\ComplatedSurvey;
use App\Models\Survey\SurveyQuestion;
use App\Models\Survey\Survey;
use Illuminate\Support\Facades\Crypt;
use App\Gateway;
use App\Ptc;
use App\Models\Survey\MicroJob;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }


    public function postForm(){
        $page_title = 'Create New Post';
        $subCategories = SubCategory::where('status', 1)
                                ->latest()
                                ->whereHas('category', function($cat){
                                    $cat->where('status', 1)->whereHas('forum', function($forum){
                                        $forum->where('status', 1);
                                    });
                                })
                                ->get();
        return view($this->activeTemplate.'user.post.form', compact('page_title', 'subCategories'));
    }

    public function postCreate(Request $request){

        $request->validate([
            'sub_category' => 'required|exists:sub_categories,id',
            'title' => 'required|string|max:191',
            'des' => 'required|string|max:64000',
            'tags' => 'required|array|max:60000'
        ]);

        SubCategory::where('status', 1)
                   ->where('id', $request->sub_category)
                   ->whereHas('category', function($cat){
                       $cat->where('status', 1)->whereHas('forum', function($forum){
                           $forum->where('status', 1);
                       });
                   })
                ->firstOrFail();

        $general = GeneralSetting::first();
        $approve = $general->auto_approve ? 1 : 2;

        $user = Auth::user();

        $new = new Post();
        $new->user_id = $user->id;
        $new->tags = json_encode($request->tags);
        $new->sub_category_id = $request->sub_category;
        $new->post_title = $request->title;
        $new->description = $request->des;
        $new->status = $approve;
        $new->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'Created post from '.$user->username;
        $adminNotification->click_url = urlPath('admin.users.post.all',$user->id);
        $adminNotification->save();

        $notify[] = ['success', 'Post created successfully.'];
        return redirect()->route('user.post.all')->withNotify($notify);
    }

    public function updatePostForm($id){

        $page_title = 'Update Post';
        $user = Auth::user();

        $post = Post::where('user_id', $user->id)
                    ->where('id', $id)
                    ->where('status', '!=', 3)
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                  })->firstOrFail();

        $subCategories = SubCategory::where('status', 1)
                                    ->whereHas('category', function($cat){
                                        $cat->where('status', 1)->whereHas('forum', function($forum){
                                            $forum->where('status', 1);
                                        });
                                    })
                                ->get();

        return view($this->activeTemplate.'user.post.update', compact('page_title', 'subCategories', 'post'));
    }

    public function updatePost(Request $request){

        $request->validate([
            'id' => 'required|exists:posts,id',
            'sub_category' => 'required|exists:sub_categories,id',
            'title' => 'required|string|max:191',
            'des' => 'required|string|max:64000',
            'tags' => 'required|array|max:60000'
        ]);

        $post = Post::where('user_id', Auth::user()->id)
                    ->where('id', $request->id)
                    ->where('status', '!=', 3)
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })->firstOrFail();
      $general = GeneralSetting::first();
       $approve = $general->auto_approve ? 1 : 2;
        $post->user_id = Auth::user()->id;
        $post->tags = json_encode($request->tags);
        $post->sub_category_id = $request->sub_category;
        $post->post_title = $request->title;
        $post->description = $request->des;
        $post->status = $approve;
        $post->save();

        $notify[] = ['success', 'Post updated successfully.'];
        return back()->withNotify($notify);
    }

    public function deletePost(Request $request){

        $request->validate([
            'id' => 'required|exists:posts,id',
        ]);

        $post = Post::where('id', $request->id)
                    ->where('user_id', Auth::user()->id)
                    ->where('status', '!=', 3)
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->firstOrFail();

        $post->status = 3;
        $post->save();

        $notify[] = ['success', 'Post deleted successfully.'];
        return back()->withNotify($notify);
    }

    public function posts(){
        $page_title = 'All Posts';

        $posts = Post::where('user_id', Auth::user()->id)
                     ->where('status', '!=', 3)
                     ->latest()
                     ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                     })
                     ->paginate(getPaginate());

        return view($this->activeTemplate.'user.post.index', compact('page_title', 'posts'));
    }

    public function reaction(Request $request){

        $validator = Validator::make($request->all(), [
            'value' => 'required|in:0,1',
            'id' => 'required|exists:posts,id'
        ]);

        if(!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        $post = Post::where('id', $request->id)
                    ->where('status', 1)
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->first();

        if(!$post){
            return response()->json(['success'=>false, 'message'=>'Invalid Request']);
        }

        $user = Auth::user();
        $reaction = Reaction::where('user_id', $user->id)->where('post_id', $post->id)->first();

        $userReact = $request->value;

        if($reaction){
            if($reaction->reaction == $userReact){
                $message = $userReact == 1 ? 'Already Up Voted' : 'Already Down Voted';
                return response()->json(['success'=>false, 'message'=>$message]);
            }else{
                if($userReact == 1){
                    $reaction->reaction = 1;
                    $reaction->save();

                    $post->increment('up_vote');
                    $post->decrement('down_vote');
                    $post->save();

                    return response()->json([
                        'success'=>true,
                        'message'=>'Added Up Vote Successfully',
                        'down'=>$post->down_vote,
                        'up'=>$post->up_vote
                    ]);
                }else{
                    $reaction->reaction = 0;
                    $reaction->save();

                    $post->decrement('up_vote');
                    $post->increment('down_vote');
                    $post->save();

                    return response()->json([
                        'success'=>true,
                        'message'=>'Added Down Vote Successfully',
                        'down'=>$post->down_vote,
                        'up'=>$post->up_vote
                    ]);
                }
            }
        }

        $newReact = new Reaction();
        $newReact->user_id = $user->id;
        $newReact->post_id = $post->id;
        $newReact->reaction = $userReact;
        $newReact->save();

        $react = null;

        if($newReact->reaction == 1){
            $react = 'Added Up Vote Successfully';
            $post->increment('up_vote');
            $post->save();
        }else{
            $react = 'Added Down Vote Success';
            $post->increment('down_vote');
            $post->save();
        }

        return response()->json([
            'success'=>true,
            'message'=>$react,
            'down'=>$post->down_vote,
            'up'=>$post->up_vote
        ]);
    }

    public function comment(Request $request){

        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|max:60000',
            'id' => 'required|exists:posts,id'
        ]);

        if(!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        $post = Post::where('id', $request->id)
                    ->where('status', 1)
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->first();

        if(!$post){
            return response()->json(['success'=>false, 'message'=>'Invalid Request']);
        }

        $user = Auth::user();

        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->post_id = $post->id;
        $comment->comment = $request->comment;
        $comment->save();
        $post->increment('comment');
        $post->save();
        $notify[] = ['success', 'Comment Published successfully.'];
        return back()->withNotify($notify);

    }



}
