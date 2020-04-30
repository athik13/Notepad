<!DOCTYPE html>
<html lang="en">

<head>
    <title>Note Cosmetics Maldives</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
    <link rel="stylesheet" href="/fonts/icomoon/style.css">

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/magnific-popup.css">
    <link rel="stylesheet" href="/css/jquery-ui.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/owl.theme.default.min.css">
    <link rel="shortcut icon" href="/images/favicon.png" />
    <link rel="apple-touch-icon" href="/images/favicon.png" />

    <link rel="stylesheet" href="/css/aos.css">

    <link rel="stylesheet" href="/css/style.css">
    @yield('css')
</head>

<body>

    <div class="site-wrap">
        <header class="site-navbar" role="banner">
            <div class="site-navbar-top">
                <div class="container">
                    <div class="row align-items-center">

                        <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
                            <!-- <form action="" class="site-block-top-search">
                                <span class="icon icon-search2"></span>
                                <input type="text" class="form-control border-0" placeholder="Search">
                            </form> -->
                        </div>

                        <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">

                            <div class="site-logo">
                                <img src="/note.png" width="200px">
                            </div>
                        </div>

                        <div class="col-6 col-md-4 order-3 order-md-3 text-right">
                            <div class="site-top-icons">
                                <ul>
                                    <li><a href="#"><span class="icon icon-person"></span></a></li>
                                    <li>
                                        <a href="/cart" class="site-cart">
                                            <span class="icon icon-shopping_cart"></span>
                                        </a>
                                    </li>
                                    <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <nav class="site-navigation text-right text-md-center" role="navigation">
                <div class="container">
                    <ul class="site-menu js-clone-nav d-none d-md-block">
                        <li><a href="#">Home</a></li>
                        <li class="has-children active">
                            <a href="#">Shop All</a>
                            <ul class="dropdown">
                                @foreach($types as $type)
                                <li class="has-children">
                                    <a href="/collections/{{ $type->id }}">{{ $type->name }}</a>
                                    <ul class="dropdown">
                                        @if (!$type->sub_types->isEmpty()) @foreach($type->sub_types as $sub_type)
                                        <li>
                                            <a href="/collections/{{ $type->id }}/{{ $sub_type->id }}">{{ $sub_type->name }}</a>
                                        </li>
                                        @endforeach @endif
                                    </ul>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a href="/contact-us">Contact Us</a></li>
                        <li><a href="#">Our Shops</a></li>
                    </ul>
                </div>
            </nav>
        </header>

        @yield('content')

        <footer class="site-footer border-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="footer-heading mb-4">Navigations</h3>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <ul class="list-unstyled">
                                    <li><a href="#">About Note</a></li>
                                    <li><a href="#">Contact Us</a></li>
                                    <li><a href="#">Store Locations</a></li>
                                    <li><a href="#">Careers</a></li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <ul class="list-unstyled">
                                    <li><a href="#">Affiliate</a></li>
                                    <li><a href="#">FAQ</a></li>
                                    <li><a href="#">Delivery</a></li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <ul class="list-unstyled">
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Terms and Conditions</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                        <h3 class="footer-heading mb-4">Promo</h3>
                        <a href="#" class="block-6">
                            <img src="/images/yaniu.png" alt="Image placeholder" class="img-fluid rounded mb-4">
                            <h3 class="font-weight-light  mb-0">Finding Your Perfect Lipstick</h3>
                            <p>Promo till March 2020</p>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="block-5 mb-5">
                            <h3 class="footer-heading mb-4">Contact Info</h3>
                            <ul class="list-unstyled">
                                <li class="address">Kuhlhavahmaage , Moonlight Higun, Male' Maldives</li>
                                <li class="phone"><a href="tel://23923929210">+960 7779423</a></li>
                                <li class="email">yaniu@avasride.app</li>
                            </ul>
                        </div>

                        <div class="block-7">
                            <form action="#" method="post">
                                <label for="email_subscribe" class="footer-heading">Subscribe</label>
                                <div class="form-group">
                                    <input type="text" class="form-control py-4" id="email_subscribe" placeholder="Email">
                                    <input class="btn btn-sm btn-primary" value="Send">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row pt-5 mt-5 text-center">
                    <div class="col-md-12">
                        <p>

                            Copyright &copy; {{ date('Y') }} All rights reserved
                        </p>
                    </div>

                </div>
            </div>
        </footer>
    </div>

    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/jquery-ui.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/owl.carousel.min.js"></script>
    <script src="/js/jquery.magnific-popup.min.js"></script>
    <script src="/js/aos.js"></script>

    <script src="/js/main.js"></script>

    @yield('js')

</body>

</html>
