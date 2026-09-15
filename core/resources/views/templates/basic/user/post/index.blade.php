@extends($activeTemplate . 'layouts.user')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 mt-xl-0 mt-5">
                <div class="custom--card">
                    <div class="card-header justify-content-between d-flex">
                        <h6>@lang('All Posts')</h6>
                        <a href="{{ route('user.post.form') }}" class="btn btn-sm bg-primary">
                            @lang('Create New Post')
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive--md">
                            <table class="table custom--table">
                                <thead>
                                    <tr>
                                        <th>@lang('Post Title')</th>
                                        <th>@lang('Date')</th>
                                        <th>@lang('Status')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse($posts as $post)
                                        <tr>
                                            <td data-label="@lang('Topic Title')">
                                                {{ shortDescription(__($post->post_title), 25) }}
                                            </td>
                                            <td data-label="@lang('Date')">
                                                {{ showDateTime($post->created_at, 'd-m-Y') }}
                                            </td>
                                            <td data-label="@lang('Status')">
                                                @if ($post->status == 1)
                                                    <span class="badge bg-success">@lang('Approved')</span>
                                                @elseif($post->status == 2)
                                                    <span class="badge bg-warning">@lang('Pending')</span>
                                                @endif
                                            </td>
                                            <td data-label="Action">



                                                

                                            </td>
                                           <td data-label="@lang('Action')">
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button" id="dropdownMenu2"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="menu-icon la la-expand"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                  <li class="nav">
                                                  <a href="{{ route('post.details', ['slug' => slug($post->post_title), 'id' => $post->id]) }}"
                                                    class="icon-btn bg-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-original-title="@lang('View')">
                                                    <i class="las la-eye"></i>View Post
                                                </a> 
                                                  </li>   
                                                  <li class="nav">
                                                <a href="{{ route('user.post.update.form', $post->id) }}"
                                                    class="icon-btn bg-success" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-original-title="@lang('Edit')">
                                                    <i class="las la-edit"></i>Edit Post
                                                </a>
                                                     </li>   
                                                    <li class="nav">
                                                 <a href="#0" class="icon-btn bg-danger deleteBtn" 
                                                    data-id="{{ $post->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-original-title="@lang('Delete')">
                                                    <i class="las la-trash-alt"></i>Delete Post
                                                </a>
                                               </li>   
                                                </div>
                                            </div>
                                        </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%" class="text-center">@lang('Data Not Found')!</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>

                            {{ $posts->links() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">@lang('Confirmation')!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.post.delete') }}" method="post">
                    @csrf

                    <div class="modal-body">
                        <input type="hidden" name="id" required="" id="deleteId">
                        <p>@lang('Are you sure to delete this post')?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-md bg--danger text-white"
                            data-bs-dismiss="modal">@lang('Close')</button>
                        <input type="submit" class="btn btn-md bg-primary" value="@lang('Confirm')">
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.deleteBtn').on('click', function() {

                var deleteId = $('#deleteId');
                deleteId.val($(this).data('id'));

            });

        })(jQuery);
    </script>
@endpush
