@extends('blog.layouts.blogMaster')
{{-- @section('title', 'Dhaka Metro News') --}}

@push('meta')


<title>
  @if ($blogParameter->title)
  {!! $blogParameter->title !!}
  @else
  {{ env('APP_NAME_BIG') }} | Matrimony Service in Bangladesh | Marriage Media Service provider in Bangladesh | 
  Matchmaker Service in Bangladesh
  @endif
</title>

<meta name="description" 
    content="{{ $websiteParameter->meta_description ?: 'Matrimony Service in Bangladesh
Marriage Media Service provider in Bangladesh
Matchmaker Service in Bangladesh Looing for Marriage Media In Bangladesh? Taslima marriage media is the trustworthy media in Dhaka, Bangladesh. We offer you the best matched life parner according to your profile. Create a free account and search your partner.' }}">

<meta name="keywords" content="{{ $websiteParameter->meta_keyword ?: 'Matrimony Service in Bangladesh
Marriage Media Service provider in Bangladesh
Matchmaker Service in Bangladesh' }}">

@endpush

@push('css') 



<link rel="stylesheet" type="text/css" href="{{asset('assets/slider/dist/css/slider-pro.min.css')}}" media="screen"/>
<link rel="stylesheet" type="text/css" href="{{asset('assets/slider/examples/css/examples.css')}}" media="screen"/>

<link rel="stylesheet" type="text/css" href="{{asset('assets/slideshow/pgwslideshow.css')}}" media="screen"/>

       <!-- You can use Open Graph tags to customize link previews.
    Learn more: https://developers.facebook.com/docs/sharing/webmasters -->

@endpush

@section('content')



@include('blog.parts.welcome')
@endsection

@push('js')
<script>
function myFunction() {
    var x = document.getElementById("topmenu");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}


$(document).ready(function() {
$(".btn-group-custom .btn").click(function () {
    $(".btn-group-custom .btn").removeClass("btn-success").addClass("btn-default");
    // $(".tab").addClass("active"); // instead of this do the below 
    $(this).removeClass("btn-default").addClass("btn-success");   
});
});

</script>

<script type="text/javascript" src="{{asset('assets/slider/dist/js/jquery.sliderPro.min.js')}}"></script>

<script type="text/javascript" src="{{asset('assets/slideshow/pgwslideshow.min.js')}}"></script>

<script type="text/javascript">
	$( document ).ready(function( $ ) {
		$( '#example5' ).sliderPro({
			width: 670,
			height: 330,
			orientation: 'vertical',
			loop: false,
			arrows: true,
			buttons: false,
			thumbnailsPosition: 'right',
			thumbnailPointer: true,
			thumbnailWidth: 290,
			breakpoints: {
				800: {
					thumbnailsPosition: 'bottom',
					thumbnailWidth: 270,
					thumbnailHeight: 100
				},
				500: {
					thumbnailsPosition: 'bottom',
					thumbnailWidth: 120,
					thumbnailHeight: 50
				}
			}
		});
	});
</script>

<script>
	$(document).ready(function() {
    	$('.pgwSlideshow').pgwSlideshow();
	});
</script>


<script>
	$(document).ready(function() {
  $(document).on("change", ".div-select", function(e){
    e.preventDefault();

    var that = $( this );
    var q = that.val();
    var url = that.attr("data-url");
    var urls = url+'?q='+q;

    // alert(urls);
    
    $.ajax({
      url: urls,
      type: 'GET',
      cache: false,
      dataType: 'json',
      success: function(response)
      {
       	if(response.success)
       	{
       		$(".dist-select").empty().append($('<option>',{
       			value: '',
       			text: 'District'
       		}));

       		$(".thana-select").empty().append($('<option>',{
       			value: '',
       			text: 'Thana'
       		}));

       		$.each(response.datas, function (i, item) {
					    $('.dist-select').append($('<option>', { 
					        value: item.id,
					        text : item.name 
					    }));
					});
       	}
      },
      error: function(){}
    });
  });
	});
</script>

<script>
	$(document).ready(function() {
  $(document).on("change", ".dist-select", function(e){
    e.preventDefault();

    var that = $( this );
    var q = that.val();
    var url = that.attr("data-url");
    var urls = url+'?q='+q;

    // alert(urls);
    
    $.ajax({
      url: urls,
      type: 'GET',
      cache: false,
      dataType: 'json',
      success: function(response)
      {
       	if(response.success)
       	{
       		$(".thana-select").empty().append($('<option>',{
       			value: '',
       			text: 'Thana'
       		}));

       		$.each(response.datas, function (i, item) {
					    $('.thana-select').append($('<option>', { 
					        value: item.id,
					        text : item.name 
					    }));
					});
       	}
      },
      error: function(){}
    });
  });


	});


</script>


 
@endpush
