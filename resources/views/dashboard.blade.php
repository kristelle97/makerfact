<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900">
                @if($posts->count() > 0)
                    @foreach($posts as $post)
                        <div onclick="location.href='{{route('post', $post->id)}}';" class="cursor-pointer bg-white overflow-hidden border rounded-lg p-4 mb-4">
                            <a href="{{$post->url}}" target="_blank" class="font-bold">{!!htmlspecialchars($post->title)!!}</a>
                            <div class="flex">
                                <h1 class="p-2 m-2">By {!!htmlspecialchars($post->username)!!}}</h1>
                                <form method="POST" action="{{ route('post.like',$post->id) }}">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <button class="p-2 m-2 border">Like</button>
                                </form>
                                <button class="p-2 m-2 border">Comment</button>
                            </div>
                            <div class="flex justify-end">
                                <h1>{{$post->likes}} likes</h1>
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
