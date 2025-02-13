<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>EasyMatch - Envoi de Colis</title>
  <meta content="transport de colis partout au Maroc" name="keywords">
  <meta content="La première plateforme d'envoi de colis au Maroc" name="description">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <!-- Favicon -->
  <link href="<?php echo ROOT ?>/assets/img/favicon.ico" rel="icon">

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap"
    rel="stylesheet">

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

  <!-- Leaflet CSS (pour la carte) -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <style>
    #map {
      height: 500px;
      width: 100%;
      margin: 20px 0;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    .route-inputs {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }

    select {
      padding: 8px;
      min-width: 200px;
    }

    #waypoints {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin: 10px 0;
    }

    button {
      padding: 8px 16px;
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="container-xxl bg-white p-0">
    <!-- Spinner Start -->
    <div id="spinner"
      class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
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
            <img class="img-fluid" src="<?php echo ROOT ?>/assets/img/icon-deal.png" alt="Icon"
              style="width: 30px; height: 30px;">
          </div>
          <h1 class="m-0 text-primary">EasyMatch</h1>
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <div class="navbar-nav ms-auto">
            <a href="index.html" class="nav-item nav-link active">Accueil</a>
            <a href="about.html" class="nav-item nav-link">À propos</a>
            <div class="nav-item dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Services</a>
              <div class="dropdown-menu rounded-0 m-0">
                <a href="service-list.html" class="dropdown-item">Liste des services</a>
                <a href="service-type.html" class="dropdown-item">Types de services</a>
              </div>
            </div>
            <a href="contact.html" class="nav-item nav-link">Contact</a>
          </div>
          <a href="<?= ROOT . "/logout" ?>" class="btn btn-danger px-3 d-none d-lg-flex">Déconnexion</a>
        </div>
      </nav>
    </div>
    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid header bg-white p-0">
      <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
        <div class="col-md-6 p-5 mt-lg-5">
          <h1 class="display-5 animated fadeIn mb-4">Envoyez vos <span class="text-primary">colis en toute
              simplicité</span> partout au Maroc</h1>
          <p class="animated fadeIn mb-4 pb-2">EasyMatch vous permet d'envoyer vos colis rapidement et en toute sécurité
            entre deux villes. Profitez de notre service fiable et économique.</p>
          <a href="" class="btn btn-primary py-3 px-5 me-3 animated fadeIn">Commencez maintenant</a>
        </div>
        <div class="col-md-6 animated fadeIn">
          <div class="owl-carousel header-carousel">
            <div class="owl-carousel-item">
              <img class="img-fluid" src="<?php echo ROOT ?>/assets/img/carousel-1.jpg" alt="Envoi de colis">
            </div>
            <div class="owl-carousel-item">
              <img class="img-fluid" src="<?php echo ROOT ?>/assets/img/carousel-2.jpg" alt="Livraison rapide">
            </div>
            <div class="owl-carousel-item">
              <img class="img-fluid" src="<?php echo ROOT ?>/assets/img/carousel-3.jpg" alt="Envoi de colis">
            </div>
            <div class="owl-carousel-item">
              <img class="img-fluid" src="<?php echo ROOT ?>/assets/img/carousel-4.jpg" alt="Livraison rapide">
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
            
            <div id="itineraire-maroc" class="container mt-4">
              <h1 class="text-center mb-4">Itineraire au Maroc</h1>
              <div class="form-row mb-3">
                <div class="col">
                  <select id="start" class="form-control">
                    <option value="">Point de depart</option>
                  </select>
                </div>
                <div class="col">
                  <select id="end" class="form-control">
                    <option value="">Point d'arrivee</option>
                  </select>
                </div>
              </div>
              <div id="waypoints" class="form-row mb-3"></div>
              <button class="btn btn-primary mb-3" onclick="addWaypoint()">Ajouter une ville intermediaire</button>
              <button class="btn btn-success mb-3" onclick="displayRoute()">Afficher l'itineraire</button>
            </div>

          </div>
          <div class="col-md-2">
            <button class="btn btn-dark border-0 w-100 py-3" onclick="displayRoute()">Rechercher</button>
          </div>
        </div>
      </div>
      
    </div>
    <div id="map-itineraire" style="height: 500px; width: 100%; margin: 20px 0;"></div>
 

    <!-- Search End -->

    <!-- Dashboard Section End -->

    <!-- Section pour l'itinéraire au Maroc -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
      <div class="container py-5">
        <div class="row g-5">
          <div class="col-lg-3 col-md-6">
            <h5 class="text-white mb-4">Contactez-nous</h5>
            <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Rue, Casablanca, Maroc</p>
            <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+212 123 456 789</p>
            <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@easymatch.com</p>
            <div class="d-flex pt-2">
              <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
              <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
              <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
              <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <h5 class="text-white mb-4">Liens rapides</h5>
            <a class="btn btn-link text-white-50" href="">À propos</a>
            <a class="btn btn-link text-white-50" href="">Contact</a>
            <a class="btn btn-link text-white-50" href="">Nos services</a>
            <a class="btn btn-link text-white-50" href="">Politique de confidentialité</a>
            <a class="btn btn-link text-white-50" href="">Conditions générales</a>
          </div>
          <div class="col-lg-3 col-md-6">
            <h5 class="text-white mb-4">Galerie</h5>
            <div class="row g-2 pt-2">
              <div class="col-4">
                <img class="img-fluid rounded bg-light p-1" src="<?php echo ROOT ?>/assets/img/property-1.jpg"
                  alt="Colis 1">
              </div>
              <div class="col-4">
                <img class="img-fluid rounded bg-light p-1" src="<?php echo ROOT ?>/assets/img/property-2.jpg"
                  alt="Colis 2">
              </div>
              <div class="col-4">
                <img class="img-fluid rounded bg-light p-1" src="<?php echo ROOT ?>/assets/img/property-3.jpg"
                  alt="Colis 3">
              </div>
              <div class="col-4">
                <img class="img-fluid rounded bg-light p-1" src="<?php echo ROOT ?>/assets/img/property-4.jpg"
                  alt="Colis 4">
              </div>
              <div class="col-4">
                <img class="img-fluid rounded bg-light p-1" src="<?php echo ROOT ?>/assets/img/property-5.jpg"
                  alt="Colis 5">
              </div>
              <div class="col-4">
                <img class="img-fluid rounded bg-light p-1" src="<?php echo ROOT ?>/assets/img/property-6.jpg"
                  alt="Colis 6">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <h5 class="text-white mb-4">Newsletter</h5>
            <p>Abonnez-vous pour recevoir les dernières actualités et offres.</p>
            <div class="position-relative mx-auto" style="max-width: 400px;">
              <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Votre email">
              <button type="button"
                class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">S'abonner</button>
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
                <a href="">Cookies</a>
                <a href="">Aide</a>
                <a href="">FAQ</a>
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

  <!-- Leaflet JavaScript (pour la carte) -->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

  <!-- Script pour la carte -->
  <script>
    // Initialisation de la carte
    var map = L.map('map').setView([31.7917, -7.0926], 6); // Centre sur le Maroc

    // Ajout d'une couche de tuiles (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Variables pour stocker les marqueurs de départ et d'arrivée
    var departureMarker, arrivalMarker;

    // Gestion des clics sur la carte
    map.on('click', function (e) {
      var city = prompt("Entrez le nom de la ville :");
      if (city) {
        if (!departureMarker) {
          departureMarker = L.marker(e.latlng).addTo(map)
            .bindPopup('Départ : ' + city).openPopup();
          document.getElementById('departureCity').value = city;
        } else if (!arrivalMarker) {
          arrivalMarker = L.marker(e.latlng).addTo(map)
            .bindPopup('Arrivée : ' + city).openPopup();
          document.getElementById('arrivalCity').value = city;
        } else {
          alert("Vous avez déjà sélectionné les villes de départ et d'arrivée.");
        }
      }
    });
  </script>

  <!-- Script pour la gestion du formulaire -->
  <script>
    document.getElementById('addParcelForm').addEventListener('submit', function (e) {
      e.preventDefault();

      var parcelDescription = document.getElementById('parcelDescription').value;
      var departureCity = document.getElementById('departureCity').value;
      var arrivalCity = document.getElementById('arrivalCity').value;

      if (!parcelDescription || !departureCity || !arrivalCity) {
        alert("Veuillez remplir tous les champs.");
        return;
      }

      // Envoyer les données au serveur (exemple avec Fetch API)
      fetch('<?php echo ROOT ?>/addParcel', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          description: parcelDescription,
          departure: departureCity,
          arrival: arrivalCity
        })
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert("Colis ajouté avec succès !");
            // Réinitialiser le formulaire
            document.getElementById('addParcelForm').reset();
            if (departureMarker) departureMarker.remove();
            if (arrivalMarker) arrivalMarker.remove();
            departureMarker = null;
            arrivalMarker = null;
          } else {
            alert("Erreur lors de l'ajout du colis.");
          }
        })
        .catch(error => console.error('Erreur :', error));
    });
  </script>

  <!-- Template Javascript -->
  <script src="<?php echo ROOT ?>/assets/js/main.js"></script>

  <!-- Script pour la section Itinéraire au Maroc -->
  <script>
    let mapItineraire;
    let routeLayer;
    let cities = [];
    const OPENROUTE_API_KEY = '5b3ce3597851110001cf6248a7064ad297da4fb69da7048a587efa99';
    const JSON_PATH = '<?php echo ROOT . "/includes/cities.json" ?>';
    console.log(JSON_PATH);

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
      const selects = document.querySelectorAll('#itineraire-maroc select');
      selects.forEach(select => {
        if (select.options.length <= 1) {
          uniqueCities.forEach(city => {
            const option = document.createElement('option');
            option.value = JSON.stringify({ lat: city.lat, lng: city.lon });
            option.textContent = city.city;
            select.appendChild(option);
          });
        }
      });
    }

    function initMapItineraire() {
      mapItineraire = L.map('map-itineraire').setView([31.7917, -7.0926], 6); // Centre du Maroc
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
      }).addTo(mapItineraire);
    }

    function addWaypoint() {
      const waypointsDiv = document.getElementById('waypoints');
      const select = document.createElement('select');
      select.className = 'form-control col';
      select.innerHTML = '<option value="">Ville intermediaire</option>';
      getUniqueCities().forEach(city => {
        const option = document.createElement('option');
        option.value = JSON.stringify({ lat: city.lat, lng: city.lon });
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
          mapItineraire.removeLayer(routeLayer);
        }

        mapItineraire.eachLayer(layer => {
          if (layer instanceof L.Marker) {
            mapItineraire.removeLayer(layer);
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
          L.marker([coord[1], coord[0]]).addTo(mapItineraire);
        });

        // Dessiner la route
        const route = data.features[0].geometry.coordinates.map(coord => [coord[1], coord[0]]);
        routeLayer = L.polyline(route, { color: 'blue', weight: 5 }).addTo(mapItineraire);
        mapItineraire.fitBounds(routeLayer.getBounds());

      } catch (error) {
        console.error("Erreur lors du calcul de l'itineraire :", error);
        alert("Erreur lors du calcul de l'itineraire. Verifiez vos selections.");
      }
    }

    // Initialisation
    initMapItineraire();
    loadCities();
  </script>
</body>

</html>