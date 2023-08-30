@extends('layouts.master')
@section('content')
     @php
        $breadcrumb = frontend_section()->where("slug",'breadcrumb_section')->first();
     @endphp
     @includeWhen(@site_settings('breadcrumbs') == App\Enums\StatusEnum::true->status(),'frontend.partials.breadcrumb',['breadcrumb' => $breadcrumb])
      <section class="blogPage bg-light-1 pt-110 pb-110">
        <div class="container">
          <div class="content-top">
            <div class="content-top-left">
              <div class="view-options">
                <span class="view-option mode-is-active"> <i class="fa-duotone fa-grid-2"></i> </span>
                <span class="view-option"> <i class="fa-duotone fa-list"></i> </span>
              </div>
            </div>
               @php
                  $filterRoute  = request()->routeIs('article.category') ? route("article.category",@get_translation($article_category->slug)) : route("article.list");
               @endphp
              <form action="{{$filterRoute}}" id="articleFilter" >
                    <div class="content-top-right ">
                        <select id="sortBy" name="sort_by" class="niceSelect">
                            <option {{request()->sort_by == 'latest' ? "selected" :""}} value="latest">
                              {{translate("Latest")}}
                            </option>
                            <option {{request()->sort_by == 'feature' ? "selected" :""}} value="feature">
                              {{translate("Feature")}}
                            </option>
                            <option {{request()->sort_by == 'most_viewed' ? "selected" :""}} value="most_viewed">
                              {{translate("Most Viewed")}}
                            </option>
                            <option {{request()->sort_by == 'least_viewed' ? "selected" :""}} value="least_viewed">
                              {{translate("Least Viewed")}}
                            </option>
                        </select>
                    </div>
              </form>
          </div>
          <div class="row g-3 g-lg-2 g-xl-3 gy-5">
            <div class="col-12 col-xl-9 col-lg-8">
                <div class="blogPage-items">
                    @foreach($articles as $article)
                        <div class="blog-item-one">
                          <div class="image-wrapper">
                            <img  loading="lazy" src="{{imageUrl(config("settings")['file_path']['article']['path']."/".@$article->file->name ,@$article->file->disk ) }}" alt="{{@$article->file->name}}" />
                          </div>
                          <div class="blog-content">
                            <a href="{{route("article.category",@get_translation($article->category?->slug))}}" class="category">
                                {{@get_translation($article->category?->title)}}
                            </a>
                            <h4 class="title">
                              <a href="{{route("article.details",$article->slug)}}">
                                {{($article->title)}}
                              </a>
                            </h4>
                            <p>
                                {{limit_words(strip_tags($article->description),20)}}
                            </p>
                            <div class="bottom-area">
                              <div class="articles-like">

                                <button data-id="{{$article->id}}" class="like-btn like article-like ">

                                    @if(auth_user('web') && in_array(auth_user('web')->id , $article->liked_by ? $article->liked_by : []))
                                    <i class="isLike fa-solid fa-thumbs-up"></i>
                                    @else
                                        <i class="fa-duotone fa-thumbs-up"></i>
                                    @endif

                                </button>

                                <span class="article-likes-count">
                                    {{$article->likes_count}}
                                </span>

                            </div>
                                <div class="blog-meta-info-item ps-0">
                                    <i class="fa-duotone fa-eye"></i>
                                    <span>{{$article->view}}</span>
                                </div>
                            </div>

                          </div>
                        </div>
                    @endforeach
                </div>
                <div class="Paginations">
                     {{ $articles->links() }}
                </div>
                @if($articles->count() == 0)
                    <div class="justify-content-center text-center">
                        @include('frontend.partials.not_found')
                    </div>
                @endif

            </div>

            <div class="col-12 col-xl-3 col-lg-4">
              <div class="blogPage-right sticky-side-div">
                <div class="blogPage-right-content">
                  <div class="box">
                    <div class="box-header">
                      <h4>
                         {{translate("Categories")}}
                      </h4>
                    </div>
                    <div class="blog-category">
                      @foreach($categories as $category)

                         <a @if( request()->routeIs('article.category') &&  $article_category->id == $category->id )  class="article-active"   @endif  href="{{route("article.category",@get_translation($category->slug))}}">
                            {{@get_translation($category->title)}}
                           <small>
                              {{$category->articles_count}}
                          </small>
                        </a>
                      @endforeach
                    </div>
                  </div>

                  @if(add_shortcode("articles") && site_settings("google_ads") != App\Enums\StatusEnum::true->status())
                    <div class="box-sm shadow-one">
                        @php echo add_shortcode("articles") @endphp
                    </div>
                  @endif


                </div>
              </div>
            </div>
          </div>
      </section>

@endsection

@push('script-push')
<script>
	(function($){
       	"use strict";
        $(document).on('change','#sortBy',function(e){
           $('#articleFilter').submit()
        })

	})(jQuery);
</script>
@endpush
