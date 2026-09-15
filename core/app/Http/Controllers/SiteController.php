<?php

namespace App\Http\Controllers;

use App\Frontend;
use App\Language;
use App\Models\Page;
use App\Models\Post;
use App\User;
use App\Models\Forum;
use App\Models\Comment;
use App\Models\Currency;
use App\Models\Exchange;
use App\Models\Reaction;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use App\Models\SupportAttachment;
use App\Models\Subscriber;
use App\Withdrawal;
use App\ComplatedSurvey;
use App\Models\Survey\Survey;
use App\Models\Survey\MicroJob;
use App\Ptc;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;




class SiteController extends Controller
{
    public function index(){
        $activeTemplate = activeTemplate();
        $count = Page::where('tempname',$activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $in['tempname'] = $activeTemplate;
            $in['name'] = 'HOME';
            $in['slug'] = 'home';
            Page::create($in);
        }

        $data['page_title'] = 'Home';
        $data['sections'] = Page::where('tempname',$activeTemplate)->where('slug','home')->firstOrFail();
        try {
            $data['stats'] = [
                'members' => User::where('status', 1)->count(),
                'surveys' => Survey::where('active', 1)->count(),
                'jobs' => MicroJob::count(),
                'ads' => Ptc::count(),
                'opinions' => ComplatedSurvey::where('status', 1)->distinct('survey_id')->count(),
                'paid' => Withdrawal::where('status', 1)->sum('amount'),
            ];
            $data['payouts'] = Withdrawal::where('status', 1)->with('user')->latest()->take(8)->get();
            $data['leaders'] = User::where('status', 1)->orderByDesc('balance')->take(5)->get(['id', 'username', 'firstname', 'lastname', 'balance']);
            $data['latestPosts'] = Post::where('status', 1)->with('user')->latest()->take(3)->get();
        } catch (\Throwable $e) {
            $data['stats'] = ['members' => 0, 'surveys' => 0, 'jobs' => 0, 'ads' => 0, 'opinions' => 0, 'paid' => 0];
            $data['payouts'] = collect();
            $data['leaders'] = collect();
            $data['latestPosts'] = collect();
        }
        return view($activeTemplate . 'home', $data);
    }

    public function leaderboard()
    {
        $page_title = 'Leaderboard';
        try {
            $leaders = User::where('status', 1)
                ->withCount(['ComplatedSurvey as opinions_count' => function ($q) {
                    $q->where('status', 1);
                }])
                ->orderByDesc('balance')
                ->take(20)
                ->get();
        } catch (\Throwable $e) {
            $leaders = User::where('status', 1)->orderByDesc('balance')->take(20)->get();
        }
        return view(activeTemplate() . 'leaderboard', compact('page_title', 'leaders'));
    }

    public function howItWorks()
    {
        $page_title = 'How It Works';
        return view(activeTemplate() . 'how_it_works', compact('page_title'));
    }

    public function faq()
    {
        $page_title = 'FAQ';
        return view(activeTemplate() . 'faq', compact('page_title'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:191|unique:subscribers,email',
        ]);

        try {
            Subscriber::create(['email' => $request->email]);
            $notify[] = ['success', 'You are subscribed for earning updates.'];
        } catch (\Throwable $e) {
            $notify[] = ['error', 'Unable to save this email right now.'];
        }
        return back()->withNotify($notify);
    }

    public function blog()
    {
        $activeTemplate = activeTemplate();
        $count = Page::where('tempname',$activeTemplate)->where('slug','blog')->count();
        if($count == 0){
            $in['tempname'] = $activeTemplate;
            $in['name'] = 'Blog';
            $in['slug'] = 'blog';
            Page::create($in);
        }
        $data['page_title'] = 'Blog';
        $data['sections'] = Page::where('tempname',$activeTemplate)->where('slug','blog')->firstOrFail();
        $data['blogs'] = Frontend::where('data_keys','blog.element')->orderBy('id','desc')->paginate(getPaginate());
        return view($activeTemplate . 'blog.blogs', $data);
    }

    public function blogDetail(Frontend $id, $title=null )
    {
        $page_title = "Blog Details";
         $blog = Frontend::findOrFail($id->id);
        if(!$blog || $blog->data_keys != 'blog.element'){
            return view('errors.404');
        }
        $blog->increment('view');
        $blogs = Frontend::where('data_keys','blog.element', 'title')->latest()->get();

        return view(activeTemplate() . 'blog.details', compact('page_title','blog','blogs'));
    }

    public function about()
    {
        $activeTemplate = activeTemplate();
        $count = Page::where('tempname',$activeTemplate)->where('slug','about')->count();
        if($count == 0){
            $in['tempname'] = $activeTemplate;
            $in['name'] = 'About';
            $in['slug'] = 'about';
            Page::create($in);
        }
        $data['page_title'] = 'About';
        $data['sections'] = Page::where('tempname',$activeTemplate)->where('slug','about')->firstOrFail();
        return view($activeTemplate . 'about', $data);
    }


    public function Payment()
    {
        $activeTemplate = activeTemplate();
        $count = Page::where('tempname',$activeTemplate)->where('slug','Payment')->count();
        if($count == 0){
            $in['tempname'] = $activeTemplate;
            $in['name'] = 'Payment';
            $in['slug'] = 'Payment';
            Page::create($in);
        }
        $data['page_title'] = 'Payment';
        $data['sections'] = Page::where('tempname',$activeTemplate)->where('slug','Payment')->firstOrFail();
        return view($activeTemplate . 'Payment', $data);
    }

    public function pages($slug)
    {
        $activeTemplate = activeTemplate();
        $page = Page::where('tempname',$activeTemplate)->where('slug',$slug)->firstOrFail();
        $data['page_title'] = $page->name;
        $data['sections'] = $page;
        return view($activeTemplate . 'pages', $data);
    }


    public function contact()
    {
        $activeTemplate = activeTemplate();
        $count = Page::where('tempname',$activeTemplate)->where('slug','contact')->count();
        if($count == 0){
            $in['tempname'] = $activeTemplate;
            $in['name'] = 'Contact';
            $in['slug'] = 'contact';
            Page::create($in);
        }
        $data['page_title'] = 'Contact';
        $data['sections'] = Page::where('tempname',$activeTemplate)->where('slug','contact')->firstOrFail();
        return view($activeTemplate . 'contact', $data);
    }

    public function Guide()
    {
        $page_title = "Guide";
        return view(activeTemplate() . 'Guide', compact('page_title'));
    }


    public function contactSubmit(Request $request)
    {
        $ticket = new SupportTicket();
        $message = new SupportMessage();

        $imgs = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'attachments' => [
                'sometimes',
                'max:4096',
                function ($attribute, $value, $fail) use ($imgs, $allowedExts) {
                    foreach ($imgs as $img) {
                        $ext = strtolower($img->getClientOriginalExtension());
                        if (($img->getSize() / 1000000) > 2) {
                            return $fail("Images MAX  2MB ALLOW!");
                        }
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, pdf images are allowed");
                        }
                    }
                    if (count($imgs) > 5) {
                        return $fail("Maximum 5 images can be uploaded");
                    }
                },
            ],
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);


        $random = getNumber();

        $ticket->user_id = auth()->id();
        $ticket->name = $request->name;
        $ticket->email = $request->email;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $path = imagePath()['ticket']['path'];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $image) {
                try {
                    SupportAttachment::create([
                        'support_message_id' => $message->id,
                        'image' => uploadImage($image, $path),
                    ]);
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload your ' . $image];
                    return back()->withNotify($notify)->withInput();
                }

            }
        }
        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function lang($lang){
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function policy($id,$slug){
        $item = Frontend::where('id',$id)->where('data_keys','footer_link.element')->firstOrFail();
        $page_title = $item->data_values->title;
        return view(activeTemplate().'policy',compact('page_title','item'));
    }

  

    public function allPost(Request $request){
        $activeTemplate = activeTemplate();
        $posts = Post::whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                     })
                     ->where('status', 1)
                     ->when($request->q, function ($query) use ($request) {
                         $query->where(function ($inner) use ($request) {
                             $inner->where('post_title', 'like', '%'.$request->q.'%')
                                 ->orWhere('description', 'like', '%'.$request->q.'%');
                         });
                     })
                     ->with(['user', 'subCategory'])
                     ->latest()
                     ->paginate(getPaginate());

        $page_title = 'Community';
        $user = auth()->user();
        return view($activeTemplate.'post',compact('page_title', 'user', 'posts'));
    }

    public function forum($slub, $id){
       $activeTemplate = activeTemplate();
        $forum = Forum::where('status', 1)->where('id', $id)->firstOrFail();
        $pageTitle = $forum->name;
        return view($activeTemplate.'forum',compact('pageTitle','forum'));
    }

    public function subCategoryPosts($slug, $id){
 $activeTemplate = activeTemplate();
        $subCategory = SubCategory::where('id', $id)
                            ->where('status', 1)
                            ->whereHas('category', function($cat){
                                $cat->where('status', 1)->whereHas('forum', function($forum){
                                    $forum->where('status', 1);
                                });
                            })->select('id', 'name')->firstOrFail();

        $posts = Post::where('status', 1)
                     ->where('sub_category_id', $subCategory->id)
                     ->with(['user', 'subCategory.category'])
                     ->latest()
                     ->paginate(getPaginate());

        $page_title = 'All Posts of '.$subCategory->name;
        return view($this->activeTemplate.'post',compact('page_title','posts'));
    }

    public function user($slug, $id){
       $activeTemplate = activeTemplate();
        $user = User::findOrFail($id);
        $posts = Post::where('user_id', $user->id)->whereHas('subCategory', function($subCat){
            $subCat->where('status', 1)->whereHas('category', function($cat){
                $cat->where('status', 1)->whereHas('forum', function($forum){
                    $forum->where('status', 1);
                });
            });
         })
         ->where('status', 1)
         ->with(['user', 'subCategory'])
         ->latest()
         ->paginate(getPaginate());
        $page_title = 'User '.$user->fullname;
        return view($activeTemplate.'profile',compact('page_title','user', 'posts'));
    }

    public function userTopics($slug, $id){
 $activeTemplate = activeTemplate();
        $user = User::findOrFail($id);
        $pageTitle = 'Topics of '.$user->fullname;

        $posts = Post::where('user_id', $id)
                     ->where('status', 1)
                     ->with('subCategory')
                     ->latest()
                     ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                     })
                     ->paginate(getPaginate());

        return view($activeTemplate.'profile_post',compact('pageTitle','user', 'posts'));
    }

    public function userAnswer($slug, $id){
 $activeTemplate = activeTemplate();
        $user = User::findOrFail($id);
        $pageTitle = 'Answered '.$user->fullname;

        $comments = Comment::where('user_id', $id)->get('post_id')->toArray();

        $posts = Post::where('status', 1)
                     ->whereIn('id', $comments)
                     ->latest()
                     ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                     })
                     ->paginate(getPaginate());

        return view($activeTemplate.'profile_post',compact('pageTitle','user', 'posts'));
    }

    public function userUpVote($slug, $id){
 $activeTemplate = activeTemplate();
        $user = User::findOrFail($id);
        $pageTitle = 'Up Vote '.$user->fullname;

        $upVotes = Reaction::where('user_id', $id)->where('reaction', 1)->get('post_id');

        $posts = Post::where('status', 1)
                     ->whereIn('id', $upVotes)
                     ->latest()
                     ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                     })
                     ->paginate(getPaginate());

        return view($activeTemplate.'profile_post',compact('pageTitle','user', 'posts'));
    }

    public function userDownVote($slug, $id){
 $activeTemplate = activeTemplate();
        $user = User::findOrFail($id);
        $page_title = 'Down Vote '.$user->fullname;

        $downVotes = Reaction::where('user_id', $id)->where('reaction', 0)->get('post_id');

        $posts = Post::where('status', 1)
                     ->whereIn('id', $downVotes)
                     ->latest()
                     ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                     })
                     ->paginate(getPaginate());

        return view($activeTemplate.'profile_post',compact('page_title','user', 'posts'));
    }



    public function postDetails($slug, $id){
 $activeTemplate = activeTemplate();
        $post = Post::where('id', $id)
                    ->with(['user'])
                    ->where('status', 1)
                    ->whereHas('subCategory', function($subCat){
                        $subCat->where('status', 1)->whereHas('category', function($cat){
                            $cat->where('status', 1)->whereHas('forum', function($forum){
                                $forum->where('status', 1);
                            });
                        });
                    })
                    ->firstOrFail();

        $post->increment('view');
        $post->save();

        $page_title = $post->post_title;
        $user = Auth::user();

        $comments = Comment::where('post_id', $post->id)->with('user')->latest()->take(5)->get();

        return view($activeTemplate.'post_details',compact('page_title', 'post', 'user', 'comments'));
    }

    public function moreComment(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:comments,id',
            'postId' => 'required|exists:posts,id'
        ]);

        if(!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        $post = Post::where('id', $request->postId)->firstOrFail();

        if(!$post){
            return response()->json(['success'=>false, 'message'=>'Invalid Request']);
        }

        $id = $request->id - 4;

        $comments = Comment::where('id', '<', $id)
                               ->where('post_id', $request->postId)
                               ->with('user')
                               ->latest()
                               ->take(5)
                               ->get();

        $nextComment = Comment::where('id','<',@$comments[0]->id??1)->where('post_id', $request->postId)->first();

        if($nextComment){
            $msg = 200;
        }else{
            $msg = 400;
        }

        return response()->json(['success'=>true, 'array'=>$comments,'message'=>$msg]);
    }
  
  
  
}
