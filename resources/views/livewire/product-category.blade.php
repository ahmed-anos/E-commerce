{{-- <section class="products-grid container">
    <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">{{ __('front.featured_products') }}</h2>

    <div class="row">

      @foreach ($products as $product)
      <div class="col-6 col-md-4 col-lg-3">
        <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
          <div class="pc__img-wrapper">
            <a href="details.html">
              <img loading="lazy" src="{{ asset('storage/' .$product->images[0]) }}" width="330" height="400"
                alt="{{ $product->name }}" class="pc__img">
            </a>
            @if($product->is_new)
            <div class="product-label text-uppercase bg-white top-0 left-0 mt-2 mx-2">New</div>
            @endif

            @if($product->offers->isNotEmpty()) 
              <div class="product-label bg-red text-white right-0 top-0 left-auto mt-2 mx-2">
                  -{{ $product->offers->first()->discount_price }}
                   {{ $product->offers->first()->discount_type == 'fixed' ?'جنيه' :'%'}}
              </div>
          @endif


          </div>

          <div class="pc__info position-relative">
            <h6 class="pc__title"><a href="details.html">{{ $product->name }}</a></h6>
            <div class="product-card__price d-flex align-items-center">
              <span class="money price text-secondary">{{ $product->price }} {{ __('front.currency') }}</span>
            </div>

            <div
              class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
              <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
              <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                <span class="d-none d-xxl-block">Quick View</span>
                <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_view" />
                  </svg></span>
              </button>
              <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_heart" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
      @endforeach

    </div><!-- /.row -->

    <div class="text-center mt-2">
      <button wire:click="loadMore" class="btn-link btn-link_lg default-underline text-uppercase fw-medium" >Load More</button>
    </div>
  </section> --}}

  <div>
    hhhhhhhhhhhhhhhhhhhhhhhh
  </div>