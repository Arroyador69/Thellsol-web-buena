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
    <title><?php echo t('sell.metaTitle'); ?></title>
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
        .navbar-right::after { content: ''; display: inline-block; width: 60px; height: 1px; }
        @media (max-width: 900px) { .navbar { padding: 0 10px; } .navbar-title { font-size: 20px; } .navbar-link { font-size: 13px; } }
        @media (max-width: 768px) { .navbar-logo, .navbar-title, .navbar-left, .navbar-right { display: none !important; } .navbar-mobile-title { display: block !important; } .hamburger { display: flex !important; } }
        .navbar-mobile-title { display: none; width: 100%; text-align: center; font-family: 'Cormorant Garamond', serif !important; font-size: 2rem; font-weight: 700; letter-spacing: 1px; color: #fff; background: #181e29; padding: 10px 0 0; z-index: 1201; }
        .hamburger { display: none; position: fixed; top: 18px; right: 18px; width: 44px; height: 44px; flex-direction: column; justify-content: center; align-items: center; z-index: 1202; background: none; border: none; cursor: pointer; }
        .hamburger span { display: block; width: 30px; height: 4px; margin: 4px 0; background: #111; border-radius: 2px; transition: 0.3s; }
        .mobile-menu-bg { display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.25); z-index: 1200; }
        .mobile-menu { display: none; position: fixed; top: 0; right: 0; width: 80vw; max-width: 340px; height: 100vh; background: #e3e3e3; box-shadow: -2px 0 12px #0002; z-index: 1203; flex-direction: column; padding: 32px 24px 0; animation: slideIn 0.3s; }
        .mobile-menu.open { display: flex; }
        .mobile-menu-bg.open { display: block; }
        @keyframes slideIn { from { right: -100vw; } to { right: 0; } }
        .mobile-menu a { color: #181e29; text-decoration: none; font-size: 1.2rem; font-weight: 600; margin: 18px 0; display: block; border-radius: 6px; padding: 8px 12px; transition: background 0.2s; }
        .mobile-menu a:hover { background: #d1d1d1; }
        .mobile-language-selector { margin-bottom: 15px; display: flex; justify-content: flex-end; }
        .vender-container { max-width: 800px; margin: 40px auto 0; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #0001; padding: 36px 32px 32px; }
        .vender-titulo { font-size: 1.5rem; font-weight: bold; text-align: center; margin-bottom: 6px; }
        .vender-sub { text-align: center; color: #888; font-size: 1.05rem; margin-bottom: 28px; }
        .vender-intro { background: #f7f8fa; border-radius: 8px; padding: 18px 22px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; gap: 24px; }
        .vender-intro-text { color: #222; font-size: 1rem; flex: 1; }
        .vender-intro-ref { background: #fff; border-radius: 6px; box-shadow: 0 1px 4px #0001; padding: 12px 18px; font-size: 0.98rem; color: #222; min-width: 180px; max-width: 220px; }
        .vender-pasos { display: flex; flex-direction: column; gap: 18px; margin-bottom: 24px; }
        .vender-paso { background: #f7f8fa; border-radius: 8px; box-shadow: 0 1px 4px #0001; padding: 18px 22px; display: flex; gap: 16px; align-items: flex-start; }
        .vender-paso-num { font-weight: bold; color: #111; font-size: 1.2rem; margin-right: 8px; min-width: 28px; }
        .vender-paso-titulo { font-weight: bold; font-size: 1.05rem; margin-bottom: 4px; }
        .vender-paso-list { margin: 0; padding-left: 18px; color: #444; font-size: 0.97rem; }
        .vender-final { background: #eaf4ff; border-radius: 8px; padding: 18px 22px; font-weight: bold; color: #0a53e4; margin-top: 18px; margin-bottom: 0; font-size: 1.05rem; display: flex; align-items: center; gap: 10px; }
        .vender-final-text { color: #222; font-weight: normal; font-size: 0.98rem; margin-left: 8px; }
        @media (max-width: 900px) { .vender-container { padding: 18px 6px; } .vender-intro { flex-direction: column; gap: 10px; } }
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
        @media (max-width: 600px) { .cookie-banner-content { font-size: 0.95rem; gap: 8px; } #accept-cookies-btn { padding: 8px 12px; font-size: 0.95rem; } }
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
            <a href="<?php echo getLangUrl('vender.php'); ?>" class="navbar-link active"><?php echo t('nav.sell'); ?></a>
        </div>
        <div class="navbar-center">
            <span class="navbar-title">ThellSol Real Estate</span>
        </div>
        <div class="navbar-right">
            <?php include 'language-selector.php'; ?>
            <a href="<?php echo getLangUrl('informacion-legal.php'); ?>" class="navbar-link"><?php echo t('nav.legal'); ?></a>
            <a href="<?php echo getLangUrl('contacto.php'); ?>" class="navbar-link"><?php echo t('nav.contact'); ?></a>
        </div>
    </nav>
    <div class="mobile-menu-bg" id="mobileMenuBg" onclick="closeMobileMenu()"></div>
    <div class="mobile-menu" id="mobileMenu">
      <div class="mobile-language-selector">
        <?php $languageSelectorClass = 'language-selector-mobile'; include 'language-selector.php'; ?>
      </div>
      <a href="<?php echo getLangUrl('index.php'); ?>"><?php echo t('nav.home'); ?></a>
      <a href="<?php echo getLangUrl('comprar.php'); ?>"><?php echo t('nav.buy'); ?></a>
      <a href="<?php echo getLangUrl('vender.php'); ?>"><?php echo t('nav.sell'); ?></a>
      <a href="<?php echo getLangUrl('informacion-legal.php'); ?>"><?php echo t('nav.legal'); ?></a>
      <a href="<?php echo getLangUrl('contacto.php'); ?>"><?php echo t('nav.contact'); ?></a>
    </div>

    <div class="vender-container">
        <div class="vender-titulo"><?php echo t('sell.title'); ?></div>
        <div class="vender-sub"><?php echo t('sell.subtitle'); ?></div>
        <div class="vender-intro">
            <div class="vender-intro-text"><?php echo nl2br(t('sell.intro')); ?></div>
            <div class="vender-intro-ref">
                <img src="./images/logo martinez echevarria.jpeg" alt="Martínez-Echevarría" style="width:180px;display:block;margin:0 auto 10px auto;object-fit:contain;" />
            </div>
        </div>
        <div class="vender-pasos">
            <div class="vender-paso">
                <div class="vender-paso-num">1.</div>
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 10h12"/><path d="M4 14h9"/><path d="M19 6a7.7 7.7 0 0 0-5.2-2A7.9 7.9 0 0 0 6 12c0 4.4 3.5 8 7.8 8 2 0 3.8-.8 5.2-2"/></svg>
                    </span>
                    <div>
                        <div class="vender-paso-titulo"><?php echo t('sell.step1.title'); ?></div>
                        <?php echo t('sell.step1.desc'); ?>
                    </div>
                </div>
            </div>
            <div class="vender-paso">
                <div class="vender-paso-num">2.</div>
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    </span>
                    <div>
                        <div class="vender-paso-titulo"><?php echo t('sell.step2.title'); ?></div>
                        <?php echo t('sell.step2.desc'); ?>
                    </div>
                </div>
            </div>
            <div class="vender-paso">
                <div class="vender-paso-num">3.</div>
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
                    </span>
                    <div>
                        <div class="vender-paso-titulo"><?php echo t('sell.step3.title'); ?></div>
                        <ul class="vender-paso-list">
                            <li><?php echo t('sell.step3.item1'); ?></li>
                            <li><?php echo t('sell.step3.item2'); ?></li>
                            <li><?php echo t('sell.step3.item3'); ?></li>
                            <li><?php echo t('sell.step3.item4'); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="vender-paso">
                <div class="vender-paso-num">4.</div>
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 2v20l4-2 4 2 4-2 4 2V2"/><path d="M8 6h8"/><path d="M8 10h8"/><path d="M8 14h6"/></svg>
                    </span>
                    <div>
                        <div class="vender-paso-titulo"><?php echo t('sell.step4.title'); ?></div>
                        <?php echo t('sell.step4.desc'); ?>
                    </div>
                </div>
            </div>
            <div class="vender-paso">
                <div class="vender-paso-num">5.</div>
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                    </span>
                    <div>
                        <div class="vender-paso-titulo"><?php echo t('sell.step5.title'); ?></div>
                        <?php echo t('sell.step5.desc'); ?>
                    </div>
                </div>
            </div>
            <div class="vender-paso">
                <div class="vender-paso-num">6.</div>
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="5" x2="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/></svg>
                    </span>
                    <div>
                        <div class="vender-paso-titulo"><?php echo t('sell.step6.title'); ?></div>
                        <ul class="vender-paso-list">
                            <li><?php echo t('sell.step6.item1'); ?></li>
                            <li><?php echo t('sell.step6.item2'); ?></li>
                            <li><?php echo t('sell.step6.item3'); ?></li>
                            <li><?php echo t('sell.step6.item4'); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="vender-paso">
                <div class="vender-paso-num">7.</div>
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m11 17 2 2a1 1 0 1 0 3-3"/><path d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.88-3.88a3 3 0 0 0-4.24 0l-.88.88a1 1 0 1 1-3-3l2.81-2.81a5.79 5.79 0 0 1 7.06-.87l.47.28a2 2 0 0 0 1.42.25L21 4"/><path d="m21 3 1 11h-2"/><path d="M3 3 2 14l6.5 6.5a1 1 0 1 0 3-3"/><path d="M3 4h8"/></svg>
                    </span>
                    <div>
                        <div class="vender-paso-titulo"><?php echo t('sell.step7.title'); ?></div>
                        <?php echo t('sell.step7.desc'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="vender-final">
            <span>✔</span> <?php echo t('sell.finalMessage'); ?>
        </div>
        <form class="vender-form" action="enviar-formulario.php" method="POST" style="max-width:500px;margin:48px auto 32px auto;background:#fff;border-radius:12px;box-shadow:0 2px 8px #0001;padding:32px 24px 24px 24px;">
            <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:700;text-align:center;margin-bottom:18px;letter-spacing:1px;">
                <?php echo t('sell.form.title'); ?>
            </h3>
            <label style="display:block;font-weight:bold;margin-bottom:6px;"><?php echo t('sell.form.name'); ?> *</label>
            <input type="text" name="nombre" required style="width:100%;padding:8px 10px;margin-bottom:16px;border-radius:6px;border:1px solid #ccc;font-size:1rem;">
            <label style="display:block;font-weight:bold;margin-bottom:6px;"><?php echo t('sell.form.phone'); ?> *</label>
            <input type="tel" name="telefono" required style="width:100%;padding:8px 10px;margin-bottom:16px;border-radius:6px;border:1px solid #ccc;font-size:1rem;">
            <label style="display:block;font-weight:bold;margin-bottom:6px;"><?php echo t('sell.form.email'); ?> *</label>
            <input type="email" name="email" required style="width:100%;padding:8px 10px;margin-bottom:16px;border-radius:6px;border:1px solid #ccc;font-size:1rem;">
            <label style="display:block;font-weight:bold;margin-bottom:6px;"><?php echo t('sell.form.messageOptional'); ?></label>
            <textarea name="mensaje" rows="3" style="width:100%;padding:8px 10px;margin-bottom:18px;border-radius:6px;border:1px solid #ccc;font-size:1rem;"></textarea>
            <button type="submit" style="width:100%;background:#181e29;color:#fff;font-weight:bold;padding:12px 0;border:none;border-radius:6px;font-size:1.1rem;cursor:pointer;">
                <?php echo t('sell.form.submit'); ?>
            </button>
        </form>
    </div>

    <?php include 'footer.php'; ?>

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
            document.getElementById('cookie-text').innerHTML = cookieMessage + ' <a href="politica-cookies.php" style="color:#0a53e4;text-decoration:underline;">' + cookieMoreInfo + '</a>.';
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
