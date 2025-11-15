<?php
require_once 'db-config.php';
require_once 'translations.php';
$currentLang = getCurrentLanguage();
?>
<!DOCTYPE html>
<html lang="<?php echo $currentLang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo t('legal.metaTitle'); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="logo-thellsol copia.png" type="image/png">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #fcf9f4; }
        .navbar-title { font-family: 'Cormorant Garamond', serif !important; font-size: 28px; font-weight: 700; letter-spacing: 1px; color: #fff; text-shadow: 0 1px 2px #0002; }
        .navbar { width: 100%; background: #181e29; color: #fff; display: flex; align-items: center; justify-content: center; padding: 0; height: 54px; box-sizing: border-box; position: sticky; top: 0; z-index: 100; gap: 0; position: relative; }
        .navbar-left { display: flex; align-items: center; gap: 10px; margin-right: 18px; position: absolute; left: 2cm; top: 0; height: 54px; }
        .navbar-center { flex: 0 0 auto; display: flex; justify-content: center; align-items: center; }
        .navbar-right { display: flex; align-items: center; gap: 10px; margin-left: 18px; position: absolute; right: 2cm; top: 0; height: 54px; }
        .navbar-logo { height: 36px; width: 36px; border-radius: 6px; background: #fff; object-fit: contain; }
        .navbar-link { color: #fff; text-decoration: none; font-size: 15px; font-weight: 500; padding: 4px 10px; border-radius: 3px; transition: background 0.2s; }
        .navbar-link:hover, .navbar-link.active { background: #232a3a; }
        @media (max-width: 768px) { .navbar-logo, .navbar-title, .navbar-left, .navbar-right { display: none !important; } .navbar-mobile-title { display: block !important; } .hamburger { display: flex !important; } }
        .navbar-mobile-title { display: none; width: 100%; text-align: center; font-family: 'Cormorant Garamond', serif !important; font-size: 2rem; font-weight: 700; letter-spacing: 1px; color: #fff; background: #181e29; padding: 10px 0 0 0; z-index: 1201; }
        .hamburger { display: none; position: fixed; top: 18px; right: 18px; width: 44px; height: 44px; flex-direction: column; justify-content: center; align-items: center; z-index: 1202; background: none; border: none; cursor: pointer; }
        .hamburger span { display: block; width: 30px; height: 4px; margin: 4px 0; background: #111; border-radius: 2px; transition: 0.3s; }
        .mobile-menu-bg { display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.25); z-index: 1200; }
        .mobile-menu { display: none; position: fixed; top: 0; right: 0; width: 80vw; max-width: 340px; height: 100vh; background: #e3e3e3; box-shadow: -2px 0 12px #0002; z-index: 1203; flex-direction: column; padding: 32px 24px 0 24px; animation: slideIn 0.3s; }
        .mobile-menu.open { display: flex; }
        .mobile-menu-bg.open { display: block; }
        @keyframes slideIn { from { right: -100vw; } to { right: 0; } }
        .mobile-menu a { color: #181e29; text-decoration: none; font-size: 1.2rem; font-weight: 600; margin: 18px 0; display: block; border-radius: 6px; padding: 8px 12px; transition: background 0.2s; }
        .mobile-menu a:hover { background: #d1d1d1; }
        .legal-main { max-width: 1100px; margin: 40px auto 0; display: flex; gap: 32px; align-items: flex-start; }
        .legal-col { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #0001; padding: 24px 24px 18px; flex: 1; min-width: 280px; }
        .legal-logo { width: 240px; height: 240px; max-width: 100%; display: block; margin: 0 auto 18px; object-fit: contain; background: #fff; padding: 16px; box-sizing: border-box; border-radius: 16px; }
        .legal-text { color: #222; font-size: 1rem; margin-bottom: 0; }
        .legal-pdf-list { list-style: none; padding: 0; margin: 0; }
        .legal-pdf-list li { margin-bottom: 10px; }
        .legal-pdf-link { color: #0a53e4; text-decoration: none; font-size: 1rem; display: flex; align-items: center; gap: 8px; transition: color 0.2s; }
        .legal-pdf-link:hover { color: #0051a2; text-decoration: underline; }
        .legal-pdf-link::before { content: '\1F4C4'; font-size: 1.1em; }
        .legal-videos { max-width: 1100px; margin: 32px auto 0; display: flex; flex-direction: column; gap: 24px; }
        .legal-video { width: 100%; max-width: 700px; margin: 0 auto; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px #0001; background: #000; }
        @media (max-width: 1100px) { .legal-main { flex-direction: column; gap: 18px; } }
        .footer { background: #181e29; color: #fff; padding: 40px 20px; margin-top: 60px; }
        .footer-content { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; }
        .footer-section h4 { margin: 0 0 20px; font-size: 1.1rem; color: #fff; }
        .footer-section p { margin: 0 0 10px; color: #ccc; font-size: 0.9rem; }
        .footer-section a { color: #ccc; text-decoration: none; display: block; margin-bottom: 8px; font-size: 0.9rem; }
        .footer-section a:hover { color: #fff; }
        .whatsapp-button { position: fixed; bottom: 20px; right: 20px; background: #25D366; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 10px rgba(0,0,0,0.2); transition: transform 0.2s; z-index: 1000; }
        .whatsapp-button:hover { transform: scale(1.1); }
        .whatsapp-button img { width: 35px; height: 35px; }
        #cookie-banner { position: fixed; left: 0; right: 0; bottom: 0; background: #181e29; color: #fff; padding: 18px 10px; box-shadow: 0 -2px 12px #0003; z-index: 2000; font-size: 1rem; display: none; justify-content: center; align-items: center; }
        .cookie-banner-content { max-width: 700px; margin: 0 auto; display: flex; flex-wrap: wrap; align-items: center; gap: 18px; justify-content: center; }
        #accept-cookies-btn { background: #0a53e4; color: #fff; border: none; border-radius: 5px; padding: 8px 22px; font-size: 1rem; font-weight: bold; cursor: pointer; transition: background 0.2s; box-shadow: 0 1px 4px #0002; }
        #accept-cookies-btn:hover { background: #003399; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-mobile-title">ThellSol Real Estate</div>
        <button class="hamburger" id="hamburgerBtn" aria-label="Abrir menú" onclick="openMobileMenu()">
          <span></span>
          <span></span>
          <span></span>
        </button>
        <div class="navbar-left">
            <img src="./images/logo-thellsol.png" alt="Logo Thellsol" class="navbar-logo" />
            <a href="<?php echo getLangUrl('index.php'); ?>" class="navbar-link"><?php echo t('nav.home'); ?></a>
            <a href="<?php echo getLangUrl('comprar.php'); ?>" class="navbar-link"><?php echo t('nav.buy'); ?></a>
            <a href="<?php echo getLangUrl('vender.php'); ?>" class="navbar-link"><?php echo t('nav.sell'); ?></a>
        </div>
        <div class="navbar-center">
            <span class="navbar-title">ThellSol Real Estate</span>
        </div>
        <div class="navbar-right">
            <?php include 'language-selector.php'; ?>
            <a href="<?php echo getLangUrl('informacion-legal.php'); ?>" class="navbar-link active"><?php echo t('nav.legal'); ?></a>
            <a href="<?php echo getLangUrl('contacto.php'); ?>" class="navbar-link"><?php echo t('nav.contact'); ?></a>
        </div>
    </nav>
    <div class="mobile-menu-bg" id="mobileMenuBg" onclick="closeMobileMenu()"></div>
    <div class="mobile-menu" id="mobileMenu">
      <a href="<?php echo getLangUrl('index.php'); ?>"><?php echo t('nav.home'); ?></a>
      <a href="<?php echo getLangUrl('comprar.php'); ?>"><?php echo t('nav.buy'); ?></a>
      <a href="<?php echo getLangUrl('vender.php'); ?>"><?php echo t('nav.sell'); ?></a>
      <a href="<?php echo getLangUrl('informacion-legal.php'); ?>"><?php echo t('nav.legal'); ?></a>
      <a href="<?php echo getLangUrl('contacto.php'); ?>"><?php echo t('nav.contact'); ?></a>
    </div>

    <div class="legal-main">
        <div class="legal-col" style="text-align:center;">
            <img src="./images/logo-thellsol.png" alt="Logo Thellsol" class="legal-logo" />
            <div class="legal-text"><?php echo nl2br(t('legal.description')); ?></div>
        </div>
        <div class="legal-col" style="text-align:center;">
            <img src="./images/logo martinez echevarria.jpeg" alt="Martínez-Echevarría" class="legal-logo" />
            <ul class="legal-pdf-list">
                <li><a href="pdf/ME_FolletoInmo_Español.pdf" class="legal-pdf-link" download><?php echo t('legal.pdf.spanish'); ?></a></li>
                <li><a href="pdf/ME_FolletoInmo_Ingles.pdf" class="legal-pdf-link" download><?php echo t('legal.pdf.english'); ?></a></li>
                <li><a href="pdf/ME_FolletoInmo_Polaco.pdf" class="legal-pdf-link" download><?php echo t('legal.pdf.polish'); ?></a></li>
                <li><a href="pdf/ME_FolletoInmo_Ruso.pdf" class="legal-pdf-link" download><?php echo t('legal.pdf.russian'); ?></a></li>
                <li><a href="pdf/ME köp guide 2024.pdf" class="legal-pdf-link" download><?php echo t('legal.pdf.swedish'); ?></a></li>
                <li><a href="pdf/MARTINEZ ECHEVARRIA - GUIA DE COMPRA - FRANÇAIS.pdf" class="legal-pdf-link" download><?php echo t('legal.pdf.french'); ?></a></li>
            </ul>
        </div>
    </div>

    <div class="legal-videos">
        <div class="legal-video">
            <iframe width="100%" height="315" src="https://www.youtube.com/embed/H2qC3xBXkUM" title="Video 1" frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="legal-video">
            <iframe width="100%" height="315" src="https://www.youtube.com/embed/LabJ5V2R2Pk" title="Video 2" frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="legal-video">
            <iframe width="100%" height="315" src="https://www.youtube.com/embed/-jdwhxqqlg4" title="Video 3" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4><?php echo t('footer.contactTitle'); ?></h4>
                <p><b>Andre Richard Tell</b><br>Thellsol Real Estate</p>
                <p>Fuengirola 29640<br>Málaga, Spain</p>
                <p><a href="mailto:andre@thellsol.com">andre@thellsol.com</a><br>+34 676 335 313</p>
            </div>
            <div class="footer-section">
                <h4><?php echo t('footer.legalLinks'); ?></h4>
                <a href="politica-privacidad.html"><?php echo t('footer.privacyPolicy'); ?></a>
                <a href="politica-cookies.html"><?php echo t('footer.cookiesPolicy'); ?></a>
                <a href="aviso-legal.html"><?php echo t('footer.legalNotice'); ?></a>
            </div>
        </div>
    </footer>

    <a href="https://wa.me/34676335313" class="whatsapp-button" target="_blank">
        <img src="./images/whatsapp-icon.png" alt="WhatsApp">
    </a>

    <div id="cookie-banner">
        <div class="cookie-banner-content">
            <span id="cookie-text"></span>
            <button id="accept-cookies-btn"></button>
        </div>
    </div>

    <script>
    const cookieMessage = <?php echo json_encode(t('cookies.message')); ?>;
    const cookieMoreInfo = <?php echo json_encode(t('cookies.moreInfo')); ?>;
    const cookieAccept = <?php echo json_encode(t('cookies.accept')); ?>;

    function openMobileMenu() {
      document.getElementById('mobileMenu').classList.add('open');
      document.getElementById('mobileMenuBg').classList.add('open');
    }
    function closeMobileMenu() {
      document.getElementById('mobileMenu').classList.remove('open');
      document.getElementById('mobileMenuBg').classList.remove('open');
    }

    (function() {
        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "")  + expires + "; path=/";
        }
        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }
        if (!getCookie('cookies_accepted')) {
            document.getElementById('cookie-text').innerHTML = cookieMessage + ' <a href="politica-cookies.html" style="color:#0a53e4;text-decoration:underline;">' + cookieMoreInfo + '</a>.';
            document.getElementById('accept-cookies-btn').textContent = cookieAccept;
            var banner = document.getElementById('cookie-banner');
            banner.style.display = 'flex';
            document.getElementById('accept-cookies-btn').onclick = function() {
                setCookie('cookies_accepted', 'yes', 30);
                banner.style.display = 'none';
            };
        }
    })();
    </script>
</body>
</html>
