@extends('site.app')
@section('title', 'Homepage')

@section('content')

<header class="section-header">
    <section class="header-main border-bottom">
    <div class="container">
        <a href="http://bootstrap-ecommerce.com" class="brand-wrap"><img class="logo" src="../images/logo.png"></a>
    </div> <!-- container.// -->
    </section>
</header> <!-- section-header.// -->


<!-- ========================= SECTION  ========================= -->
<section class="section-name  padding-y-sm">
    <div class="container">

    <header class="section-heading">
        <a href="#" class="btn btn-outline-primary float-right">See all</a>
        <h3 class="section-title">Popular products</h3>
    </header><!-- sect-heading -->


    <div class="row">
        <div class="col-md-3">
            <div href="#" class="card card-product-grid">
                <a href="#" class="img-wrap"> <img src="images/items/1.jpg"> </a>
                <figcaption class="info-wrap">
                    <a href="#" class="title">Just another product name</a>
                    <div class="price mt-1">$179.00</div> <!-- price-wrap.// -->
                </figcaption>
            </div>
        </div> <!-- col.// -->
        <div class="col-md-3">
            <div href="#" class="card card-product-grid">
                <a href="#" class="img-wrap"> <img src="images/items/2.jpg"> </a>
                <figcaption class="info-wrap">
                    <a href="#" class="title">Some item name here</a>
                    <div class="price mt-1">$280.00</div> <!-- price-wrap.// -->
                </figcaption>
            </div>
        </div> <!-- col.// -->
        <div class="col-md-3">
            <div href="#" class="card card-product-grid">
                <a href="#" class="img-wrap"> <img src="images/items/3.jpg"> </a>
                <figcaption class="info-wrap">
                    <a href="#" class="title">Great product name here</a>
                    <div class="price mt-1">$56.00</div> <!-- price-wrap.// -->
                </figcaption>
            </div>
        </div> <!-- col.// -->
        <div class="col-md-3">
            <div href="#" class="card card-product-grid">
                <a href="#" class="img-wrap"> <img src="images/items/4.jpg"> </a>
                <figcaption class="info-wrap">
                    <a href="#" class="title">Just another product name</a>
                    <div class="price mt-1">$179.00</div> <!-- price-wrap.// -->
                </figcaption>
            </div>
        </div> <!-- col.// -->
        <div class="col-md-3">
            <div href="#" class="card card-product-grid">
                <a href="#" class="img-wrap"> <img src="images/items/5.jpg"> </a>
                <figcaption class="info-wrap">
                    <a href="#" class="title">Just another product name</a>
                    <div class="price mt-1">$179.00</div> <!-- price-wrap.// -->
                </figcaption>
            </div>
        </div> <!-- col.// -->
        <div class="col-md-3">
            <div href="#" class="card card-product-grid">
                <a href="#" class="img-wrap"> <img src="images/items/6.jpg"> </a>
                <figcaption class="info-wrap">
                    <a href="#" class="title">Some item name here</a>
                    <div class="price mt-1">$280.00</div> <!-- price-wrap.// -->
                </figcaption>
            </div>
        </div> <!-- col.// -->
        <div class="col-md-3">
            <div href="#" class="card card-product-grid">
                <a href="#" class="img-wrap"> <img src="images/items/7.jpg"> </a>
                <figcaption class="info-wrap">
                    <a href="#" class="title">Great product name here</a>
                    <div class="price mt-1">$56.00</div> <!-- price-wrap.// -->
                </figcaption>
            </div>
        </div> <!-- col.// -->
        <div class="col-md-3">
            <div href="#" class="card card-product-grid">
                <a href="#" class="img-wrap"> <img src="images/items/9.jpg"> </a>
                <figcaption class="info-wrap">
                    <a href="#" class="title">Just another product name</a>
                    <div class="price mt-1">$179.00</div> <!-- price-wrap.// -->
                </figcaption>
            </div>
        </div> <!-- col.// -->
    </div> <!-- row.// -->

    </div><!-- container // -->
    </section>
    <!-- ========================= SECTION  END// ========================= -->


<!-- ========================= SECTION  ========================= -->
<section class="section-name padding-y bg">
    <div class="container">

    <div class="row">
    <div class="col-md-6">
        <h3>Download app demo text</h3>
        <p>Get an amazing app  to make Your life easy</p>
    </div>
    <div class="col-md-6 text-md-right">
        <a href="#"><img src="images/misc/appstore.png" height="40"></a>
        <a href="#"><img src="images/misc/appstore.png" height="40"></a>
    </div>
    </div> <!-- row.// -->
    </div><!-- container // -->
    </section>
    <!-- ========================= SECTION  END// ======================= -->


@stop
