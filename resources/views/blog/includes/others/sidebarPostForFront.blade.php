<div class="attachment-block clearfix" style="margin-bottom: 3px;">
    <a href="{{route('welcome.postDetailsWithTitle',['post'=>$post,'title'=>new_slug($post->title)])}}">
      <img class="attachment-img" style="width: 50px;" src="{{ route('imagecache', [ 'template'=>'sbixs','filename' => $post->fiName() ]) }}" alt="{{$post->title}}">
    </a>

    <div class="attachment-pushed" style="margin-left: 60px;">
      <h4 class="attachment-heading" style="font-size: 14px;line-height: 1.3;">
        <a href="{{route('welcome.postDetailsWithTitle',['post'=>$post,'title'=>new_slug($post->title)])}}">{{str_limit($post->title,25,'..')}}</a>
        
      </h4>
    </div>
  </div>