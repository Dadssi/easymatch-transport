<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="manifest" href="../../manifest.json">
    <meta charset="utf-8">
    <title>EasyMatch - Transport</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="transport de colis partout au Maroc" name="keywords">
    <meta content="la prmière plateforme d'envoi des colis au Maroc" name="description">

    <!-- Favicon -->
    <link href="<?php echo ROOT ?>/assets/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?php echo ROOT ?>/assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?php echo ROOT ?>/assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo ROOT ?>/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?php echo ROOT ?>/assets/css/style.css" rel="stylesheet">
    
    <!--  bibliothèque Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    
    

</head>
<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar Start -->
        <div class="container-fluid nav-bar bg-transparent">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
                <a href="index.html" class="navbar-brand d-flex align-items-center text-center">
                    <div class="icon p-2 me-2">
                        <img class="img-fluid" src="<?php echo ROOT ?>/assets/img/logo-easymatch.png" alt="Icon" style="width: 30px; height: 30px;">
                    </div>
                    <h1 class="m-0 text-primary">EasyMatch</h1>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <a href="#" class="nav-item nav-link active">Accueil</a>
                        <a href="#about-section" class="nav-item nav-link">A propos</a>
                        <a href="#conducteurs-certifies" class="nav-item nav-link">Conducteurs</a>
                        <a href="contact.html" class="nav-item nav-link">nous contacter</a>
                    </div>
                    <a href="" class="btn btn-primary px-3 d-none d-lg-flex">Se Connecter</a>
                </div>
            </nav>
        </div>
        <!-- Navbar End -->

        <!-- Header Start -->
        <div class="container-fluid header bg-white p-0 mt-4">
            <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
                <div class="col-md-6 p-5 mt-lg-5">
                    <h1 class="display-5 animated fadeIn mb-4">Trouvez <span class="text-primary">le transport idéal</span> pour vos colis</h1>
                    <p class="animated fadeIn mb-4 pb-2">Facilitez l’envoi de vos marchandises en toute simplicité. Trouvez un 
                        conducteur sur votre itinéraire et expédiez vos colis en toute sécurité. Réduisez les coûts tout en 
                        optimisant l’espace disponible des véhicules.</p>
                    <a href="" class="btn btn-primary py-3 px-5 me-3 animated fadeIn">Se lancer</a>
                </div>
                <div class="col-md-6 animated fadeIn">
                    <div class="owl-carousel header-carousel">
                        <div class="owl-carousel-item">
                            <img class="img-fluid" src="<?php echo ROOT ?>/assets/img/carousel-1.jpg" alt="">
                        </div>
                        <div class="owl-carousel-item">
                            <img class="img-fluid" src="<?php echo ROOT ?>/assets/img/carousel-2.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->


        <!-- Search Start -->
        <div class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
            <div class="container">
                <div class="row g-2">
                    <div class="col-md-10">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <input type="text" id="datePicker" class="form-control border-0 py-3" placeholder="Select Date">
                            </div>
                            <div class="col-md-4">
                                <select class="form-select border-0 py-3" id="start">
                                    <option value="">Ville de départ</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select border-0 py-3" id="end">
                                    <option value="">Ville d'arrivée</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-dark border-0 w-100 py-3" onclick="displayRoute()">Search</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Search End -->
        
        <!-- Map start -->
        <div class="container" id="map-container">
            <div id="waypoints"></div>
            <div id="map"></div>
        </div>
        <!-- Map end -->

        <!-- Conducteurs certifiés Start -->
        <div class="container-xxl py-5" id="conducteurs-certifies">
            <div class="container">
                <div class="row g-0 gx-5 align-items-end" id="conducteurs-verifies-container">
                    <div class="col-lg-6" id="verified-title">
                        <div class="text-start mx-auto mb-5 wow " data-wow-delay="0.1s">
                            <h1 class="mb-3">Nos conducteurs certifiés</h1>
                            <p>Nos chauffeurs certifiés sont rigoureusement sélectionnés pour garantir un transport fiable et sécurisé. 
                        Chaque conducteur a été vérifié afin d’assurer un service de qualité et une expérience optimale pour l’expéditeur. 
                        Faites confiance à nos professionnels pour acheminer vos colis en toute sérénité.</p>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-1.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-2.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-3.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-4.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-5.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-6.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                                <a class="btn btn-primary py-3 px-5" href="">Afficher plus de Conducteurs</a>
                            </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <div class="col-lg-4 col-md-6">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-1.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-2.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-3.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-4.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-5.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-6.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <a class="btn btn-primary py-3 px-5" href="">Afficher plus de Conducteurs</a>
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <div class="col-lg-4 col-md-6">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-1.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-2.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-3.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-4.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-5.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="conducteur-box rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="<?php echo ROOT ?>/assets/img/driver-6.jpg" alt=""></a>
                                        <div class="rounded position-absolute start-0 top-0 m-4 py-1 px-1"><img src="<?php echo ROOT ?>/assets/img/verified.png" alt="verified" id="verified-img" style="height: 40px; width: 100px;"></div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">type vehicule</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="">Nom du conducteur</a>
                                        <p>date d'inscription</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <a class="btn btn-primary py-3 px-5" href="">Afficher plus de Conducteurs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Conducteurs certifiés End -->

        <!-- About Start -->
        <div class="container-xxl py-5" id="about-section">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="about-img position-relative overflow-hidden p-5 pe-0">
                            <img class="img-fluid w-100" src="<?php echo ROOT ?>/assets/img/about.jpg">
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                        <h1 class="mb-4">A propos</h1>
                        <p class="mb-4">EasyMatch Transport est une plateforme innovante qui connecte les conducteurs disposant d’un 
                            espace libre dans leur véhicule avec des particuliers et entreprises souhaitant expédier des colis. Grâce à un 
                            système intelligent de correspondance des trajets, notre solution optimise le transport de marchandises en 
                            réduisant les coûts et l’empreinte carbone.</p>
                        <p><i class="fa fa-check text-primary me-3"></i>Réduction des coûts et de l’empreinte carbone en 
                        maximisant l’utilisation de l’espace disponible dans les véhicules.</p>
                        <p><i class="fa fa-check text-primary me-3"></i>Sécurité et fiabilité grâce à la vérification des profils, 
                        aux notifications en temps réel et aux évaluations des utilisateurs.</p>
                        <p><i class="fa fa-check text-primary me-3"></i>Expérience utilisateur optimisée avec une recherche intuitive, 
                        une carte interactive et un tableau de bord détaillé.</p>
                        <a class="btn btn-primary py-3 px-5 mt-3" href="">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

        <!-- Call to Action Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="bg-light rounded p-3">
                    <div class="bg-white rounded p-4" style="border: 1px dashed rgba(0, 185, 142, .3)">
                        <div class="row g-5 align-items-center">
                            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                                <img class="img-fluid rounded w-100" src="<?php echo ROOT ?>/assets/img/call-to-action.jpg" alt="">
                            </div>
                            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                                <div class="mb-4">
                                    <h1 class="mb-3">Contactez Notre Équipe de Support</h1>
                                    <p>Vous avez des questions sur l’expédition ou la réception d’un colis via EasyMatch Transport ?  
                                    Notre équipe est là pour vous aider à chaque étape du processus. Contactez-nous pour toute assistance.</p>
                                </div>
                                <a href="" class="btn btn-primary py-3 px-4 me-2"><i class="fa fa-phone-alt me-2"></i>Passer un appel</a>
                                <a href="" class="btn btn-dark py-3 px-4"><i class="fa fa-calendar-alt me-2"></i>Prendre un rendez-vous</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Call to Action End -->


       <!-- Team Start -->
        <div class="container-xxl py-4">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Notre équipe</h1>
                    <p>Derrière cette application magnifique, il y a une équipe motivée, ambitieuse et expérimentée.</p>
                </div>
                
                <div class="row g-5 justify-content-center mb-4">
                    <!-- Première ligne (3 cartes) -->
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item rounded overflow-hidden">
                            <div class="position-relative">
                                <img class="img-fluid" src="<?php echo ROOT ?>/assets/img/team-1.jpg" alt="Benoujja Oussama">
                                <div class="position-absolute start-50 top-100 translate-middle d-flex align-items-center">
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="text-center p-4 mt-3">
                                <h5 class="fw-bold mb-0">Benoujja Oussama</h5>
                                <small>Responsable technique</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="team-item rounded overflow-hidden">
                            <div class="position-relative">
                                <img class="img-fluid" src="<?php echo ROOT ?>/assets/img/team-2.jpg" alt="Dadssi Mohamed Abdelhak">
                                <div class="position-absolute start-50 top-100 translate-middle d-flex align-items-center">
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="text-center p-4 mt-3">
                                <h5 class="fw-bold mb-0">Dadssi Mohamed Abdelhak</h5>
                                <small>SCRUM MASTER</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="team-item rounded overflow-hidden">
                            <div class="position-relative">
                                <img class="img-fluid" src="<?php echo ROOT ?>/assets/img/team-3.jpg" alt="Fadwa El ouah">
                                <div class="position-absolute start-50 top-100 translate-middle d-flex align-items-center">
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="text-center p-4 mt-3">
                                <h5 class="fw-bold mb-0">Fadwa El ouah</h5>
                                <small>Responsable de qualité</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deuxième ligne (2 cartes centrées) -->
                <div class="row g-5 justify-content-center">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="team-item rounded overflow-hidden">
                            <div class="position-relative">
                                <img class="img-fluid" src="<?php echo ROOT ?>/assets/img/team-4.jpg" alt="Moudiri Abdeljabbar">
                                <div class="position-absolute start-50 top-100 translate-middle d-flex align-items-center">
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="text-center p-4 mt-3">
                                <h5 class="fw-bold mb-0">Moudiri Abdeljabbar</h5>
                                <small>Chef de Produit </small>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.9s">
                        <div class="team-item rounded overflow-hidden">
                            <div class="position-relative">
                                <img class="img-fluid" src="<?php echo ROOT ?>/assets/img/team-5.jpg" alt="">
                                <div class="position-absolute start-50 top-100 translate-middle d-flex align-items-center">
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="text-center p-4 mt-3">
                                <h5 class="fw-bold mb-0">Full Name</h5>
                                <small>Responsable Relations Médias</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Team End -->

        <!-- Testimonial Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Ce que disent nos clients !</h1>
                    <p>Nous accordons une grande importance à la satisfaction de nos clients. Grâce à notre engagement et à 
                        la qualité de nos services, nous avons gagné la confiance de nombreux utilisateurs. Leur retour 
                        positif témoigne de notre professionnalisme et de notre volonté d'offrir la meilleure expérience possible. 
                        Découvrez ce qu'ils pensent de nous !</p>
                </div>
                <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                <div class="testimonial-item bg-light rounded p-3">
                    <div class="bg-white border rounded p-4">
                        <p>Grâce à EasyMatch Transport, j'ai pu optimiser mes trajets et rentabiliser l’espace inutilisé de mon véhicule. Une plateforme fiable et intuitive !</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded" src="<?php echo ROOT ?>/assets/img/testimonial-2.jpg" style="width: 45px; height: 45px;">
                            <div class="ps-3">
                                <h6 class="fw-bold mb-1">Omar Bennani</h6>
                                <small>Chauffeur-livreur</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item bg-light rounded p-3">
                    <div class="bg-white border rounded p-4">
                        <p>Expédier mes colis n’a jamais été aussi simple ! J’ai trouvé un conducteur en quelques minutes et suivi mon envoi en toute sérénité.</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded" src="<?php echo ROOT ?>/assets/img/testimonial-1.jpg" style="width: 45px; height: 45px;">
                            <div class="ps-3">
                                <h6 class="fw-bold mb-1">Fatima El Idrissi</h6>
                                <small>Commerçante</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item bg-light rounded p-3">
                    <div class="bg-white border rounded p-4">
                        <p>En tant qu’indépendant, je cherchais un moyen de réduire mes coûts de transport. EasyMatch Transport m’a offert une solution idéale !</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded" src="<?php echo ROOT ?>/assets/img/testimonial-3.jpg" style="width: 45px; height: 45px;">
                            <div class="ps-3">
                                <h6 class="fw-bold mb-1">Yassine Mouline</h6>
                                <small>Entrepreneur</small>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->
        

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Contactez-nous</h5>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Youcode, Safi</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+212 6 66 66 66 66</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@youcode.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Liens rapides</h5>
                        <a class="btn btn-link text-white-50" href="">A propos</a>
                        <a class="btn btn-link text-white-50" href="">Nous contacter</a>
                        <a class="btn btn-link text-white-50" href="">Notre équipe</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Gallerie de photos</h5>
                        <div class="row g-2 pt-2">
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="<?php echo ROOT ?>/assets/img/driver-1.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="<?php echo ROOT ?>/assets/img/driver-2.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="<?php echo ROOT ?>/assets/img/driver-3.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="<?php echo ROOT ?>/assets/img/driver-4.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="<?php echo ROOT ?>/assets/img/driver-5.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="<?php echo ROOT ?>/assets/img/driver-6.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Newsletter</h5>
                        <p>N'hésitez pas de nous contacter pour être informé de nos offres</p>
                        <div class="position-relative mx-auto" style="max-width: 400px;">
                            <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Votre email">
                            <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Envoyer</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">EasyMatch</a>, Tous droits réservés. 
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="">Accueil</a>
                                <a href="">a propos</a>
                                <a href="">conducteurs</a>
                                <a href="">nous contacter</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo ROOT ?>/assets/lib/wow/wow.min.js"></script>
    <script src="<?php echo ROOT ?>/assets/lib/easing/easing.min.js"></script>
    <script src="<?php echo ROOT ?>/assets/lib/waypoints/waypoints.min.js"></script>
    <script src="<?php echo ROOT ?>/assets/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


    <!-- Template Javascript -->
    <script src="<?php echo ROOT ?>/assets/js/main.js"></script>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <!-- ------------------------------------------------------------------------ -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map;
    let routeLayer;
    let cities = [];
    const OPENROUTE_API_KEY = '5b3ce3597851110001cf6248a7064ad297da4fb69da7048a587efa99';
    const JSON_PATH = './includes/cities.json'; // Chemin vers votre fichier JSON

    // Fonction pour charger les villes depuis le fichier JSON
    async function loadCities() {
        try {
            const response = await fetch(JSON_PATH);
            const data = await response.json();
            console.log(data);
            cities = data.cities;
            populateSelects();
        } catch (error) {
            console.error('Erreur lors du chargement des villes:', error);
            alert('Erreur lors du chargement des villes');
        }
    }

    // Fonction pour eliminer les doublons et trier les villes
    function getUniqueCities() {
        const uniqueCities = {};
        cities.forEach(city => {
            if (!uniqueCities[city.city]) {
                uniqueCities[city.city] = city;
            }
        });
        return Object.values(uniqueCities).sort((a, b) => a.city.localeCompare(b.city));
    }

    function populateSelects() {
        const uniqueCities = getUniqueCities();
        const selects = document.querySelectorAll('select');
        selects.forEach(select => {
            if (select.options.length <= 1) {
                uniqueCities.forEach(city => {
                    const option = document.createElement('option');
                    option.value = JSON.stringify({lat: city.lat, lng: city.lon});
                    option.textContent = city.city;
                    select.appendChild(option);
                });
            }
        });
    }

    function initMap() {
        map = L.map('map').setView([31.7917, -7.0926], 6); // Centre du Maroc
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
    }

    function addWaypoint() {
        const waypointsDiv = document.getElementById('waypoints');
        const select = document.createElement('select');
        select.innerHTML = '<option value="">Ville intermediaire</option>';
        getUniqueCities().forEach(city => {
            const option = document.createElement('option');
            option.value = JSON.stringify({lat: city.lat, lng: city.lon});
            option.textContent = city.city;
            select.appendChild(option);
        });
        waypointsDiv.appendChild(select);
    }

    async function displayRoute() {
        const startValue = document.getElementById('start').value;
        const endValue = document.getElementById('end').value;

        if (!startValue || !endValue) {
            alert("Veuillez selectionner un point de depart et un point d'arrivee.");
            return;
        }

        const start = JSON.parse(startValue);
        const end = JSON.parse(endValue);

        const waypointSelects = document.querySelectorAll('#waypoints select');
        const waypoints = Array.from(waypointSelects)
            .filter(select => select.value)
            .map(select => JSON.parse(select.value));

        const coordinates = [
            [start.lng, start.lat],
            ...waypoints.map(point => [point.lng, point.lat]),
            [end.lng, end.lat]
        ];

        console.log("Coordonnees envoyees à l'API :", coordinates);

        try {
            // Suppression des anciens elements
            if (routeLayer) {
                map.removeLayer(routeLayer);
            }

            map.eachLayer(layer => {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });

            // Envoi de la requête à OpenRouteService
            const response = await fetch('https://api.openrouteservice.org/v2/directions/driving-car/geojson', {
                method: 'POST',
                headers: {
                    'Authorization': OPENROUTE_API_KEY,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ coordinates: coordinates })
            });

            if (!response.ok) {
                console.error("Erreur HTTP :", response.status, await response.text());
                throw new Error("Erreur API OpenRouteService: " + response.status);
            }

            const data = await response.json();
            console.log("Reponse API :", data);

            if (!data.features || data.features.length === 0) {
                throw new Error("Aucun itineraire trouve.");
            }

            // Ajouter des marqueurs
            coordinates.forEach(coord => {
                L.marker([coord[1], coord[0]]).addTo(map);
            });

            // Dessiner la route
            const route = data.features[0].geometry.coordinates.map(coord => [coord[1], coord[0]]);
            routeLayer = L.polyline(route, { color: 'blue', weight: 5 }).addTo(map);
            map.fitBounds(routeLayer.getBounds());

        } catch (error) {
            console.error("Erreur lors du calcul de l'itineraire :", error);
            alert("Erreur lors du calcul de l'itineraire. Verifiez vos selections.");
        }
    }



    // Initialisation
    initMap();
    loadCities();

</script>
    <!-- ------------------------------------------------------------------------ -->

</body>

</html>
