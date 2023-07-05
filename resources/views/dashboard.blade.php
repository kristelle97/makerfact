<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900">
                @if($posts->count() > 0)
                    @foreach($posts as $post)
                        <div class="bg-white overflow-hidden border rounded-lg p-4 mb-4">
                            <a href="{{$post->url}}" target="_blank" class="font-bold">{{$post->title}}</a>
                            <div class="flex justify-between">
                                <div>
                                    <h1 class="p-2 m-2">By {{$post->username}}</h1>
                                    <form method="POST" action="{{ route('post.like',$post->id) }}">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        @auth()
                                            @if(count(\Illuminate\Support\Facades\Auth::user()->likes?->where('post_id',$post->id))>=1)
                                                <button class="p-2 m-2"><i class="fas fa-heart" style="color:#8c52ff;"></i></button>
                                            @else
                                                <button class="p-2 m-2"><i class="far fa-heart"></i></button>
                                            @endif
                                        @endauth

                                        @guest()
                                            <button class="p-2 m-2"><i class="far fa-heart"></i></button>
                                        @endguest
                                    </form>
                                    <button class="p-2 m-2"><i class="far fa-comment"></i></button>
                                </div>

                                <div class="flex justify-end">
                                    <h1>{{$post->likes}} like{{$post->likes != 1 ? 's' : ''}}</h1>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div>
                        <h1 class="text-black">Be the first to submit a post today!</h1>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
