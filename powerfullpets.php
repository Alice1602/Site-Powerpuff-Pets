<?php require_once("cabecalho.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Powerpuff Pets</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="banner">
    <img src="images/apresentacao.png">
  </div>
  <div class="carousels-wrapper">
    <div class="container">
    <h2>Conheça nossos Gatos</h2>
      <div class="carousel">
        <div class="carousel__viewport">
          <div class="carousel__slide">
            <img src="images/gatofilhote.jpg" alt="Image 1">
          </div>
          <div class="carousel__slide">
            <img src="images/gato2.jpg" alt="Image 2">
          </div>
          <div class="carousel__slide">
            <img src="images/gato17.jpg" alt="Image 3">
          </div>
          <div class="carousel__slide">
            <img src="images/gato11.jpg" alt="Image 4">
          </div>
          <div class="carousel__slide">
            <img src="images/gato12.jpg" alt="Image 5">
          </div>
        </div>
        <button class="carousel__button carousel__button--prev">&lt;</button>
        <button class="carousel__button carousel__button--next">&gt;</button>
        <div class="carousel__indicators">
          <button class="carousel__indicator"></button>
          <button class="carousel__indicator"></button>
          <button class="carousel__indicator"></button>
          <button class="carousel__indicator"></button>
          <button class="carousel__indicator"></button>
        </div>
      </div>
    </div>
    <div class="container">
    <h2>Conheça nossos Cachorros</h2>
      <div class="carousel">
        <div class="carousel__viewport">
          <div class="carousel__slide">
            <img src="images/dog7.jpg" alt="Image 1">
          </div>
          <div class="carousel__slide">
            <img src="images/dogfilhote.jpg" alt="Image 2">
          </div>
          <div class="carousel__slide">
            <img src="images/dog6.jpg" alt="Image 3">
          </div>
          <div class="carousel__slide">
            <img src="images/dog5.jpg" alt="Image 4">
          </div>
          <div class="carousel__slide">
            <img src="images/dog4.jpg" alt="Image 5">
          </div>
        </div>
        <button class="carousel__button carousel__button--prev">&lt;</button>
        <button class="carousel__button carousel__button--next">&gt;</button>
        <div class="carousel__indicators">
        <button class="carousel__indicator"></button>
          <button class="carousel__indicator"></button>
          <button class="carousel__indicator"></button>
          <button class="carousel__indicator"></button>
          <button class="carousel__indicator"></button>
        </div>
      </div>
    </div>
  </div>

  <div class="banner2">
    <img src="images/coments.png">
  </div>

  <?php require_once("footer.php"); ?>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const carousels = document.querySelectorAll('.carousel');

      carousels.forEach((carousel) => {
        const viewport = carousel.querySelector('.carousel__viewport');
        const slides = carousel.querySelectorAll('.carousel__slide');
        const prevButton = carousel.querySelector('.carousel__button--prev');
        const nextButton = carousel.querySelector('.carousel__button--next');
        const indicators = carousel.querySelectorAll('.carousel__indicator');
        let currentIndex = 0;

        function updateCarousel() {
          const slideWidth = slides[0].clientWidth;
          viewport.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
          indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentIndex);
          });
        }

        function nextSlide() {
          currentIndex = (currentIndex + 1) % slides.length;
          updateCarousel();
        }

        function prevSlide() {
          currentIndex = (currentIndex - 1 + slides.length) % slides.length;
          updateCarousel();
        }

        nextButton.addEventListener('click', nextSlide);
        prevButton.addEventListener('click', prevSlide);

        indicators.forEach((indicator, index) => {
          indicator.addEventListener('click', () => {
            currentIndex = index;
            updateCarousel();
          });
        });

        // Auto slide
        setInterval(nextSlide, 5000); // 5 seconds

        window.addEventListener('resize', updateCarousel);

        // Initialize carousel
        updateCarousel();
      });
    });
  </script>
</body>
</html>
