<?php
if (!function_exists('getCurrentLanguage')) {
    require_once 'translations.php';
}

$currentLang = getCurrentLanguage();
$currentYear = date('Y');

if (!defined('THELLSOL_FOOTER_STYLES')) {
    define('THELLSOL_FOOTER_STYLES', true);
    ?>
    <style>
    .thellsol-footer {
        background: #050f1f;
        color: #f5f6fa;
        padding: 70px 20px 40px 20px;
        margin-top: 80px;
        font-family: 'Inter', Arial, sans-serif;
    }
    .thellsol-footer-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    .thellsol-footer-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
        align-items: stretch;
    }
    .thellsol-footer-card {
        background: #0f1a2f;
        border-radius: 22px;
        padding: 32px;
        border: 1px solid rgba(255,255,255,0.06);
        box-shadow: 0 20px 40px rgba(5, 15, 31, 0.35);
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .thellsol-footer-card h4 {
        margin: 0;
        font-size: 1.05rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .thellsol-footer-line {
        width: 48px;
        height: 3px;
        background: linear-gradient(90deg, #5aa9ff, #9b7bff);
        border-radius: 999px;
        margin: 8px 0 16px 0;
    }
    .thellsol-footer-card p,
    .thellsol-footer-card a {
        margin: 0;
        color: #d5d9e6;
        text-decoration: none;
        font-size: 0.95rem;
        line-height: 1.6;
    }
    .thellsol-footer-card a:hover {
        color: #7ec3ff;
    }
    .thellsol-footer-logo-card {
        align-items: center;
        justify-content: center;
    }
    .thellsol-footer-logo-card img {
        width: 140px;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.35);
    }
    .thellsol-footer-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 40px;
        padding-top: 24px;
        border-top: 1px solid rgba(255,255,255,0.08);
        font-size: 0.95rem;
        color: #9aa4c2;
    }
    @media (max-width: 600px) {
        .thellsol-footer-card {
            padding: 24px;
        }
        .thellsol-footer-bottom {
            flex-direction: column;
            align-items: flex-start;
        }
    }
    </style>
    <?php
}
?>
<footer class="thellsol-footer">
    <div class="thellsol-footer-container">
        <div class="thellsol-footer-cards">
            <div class="thellsol-footer-card">
                <h4><?php echo t('footer.contactTitle'); ?></h4>
                <div class="thellsol-footer-line"></div>
                <p><strong>Andre Richard Tell</strong><br>TellSol Real Estate</p>
                <p>Fuengirola 29640<br>Málaga, Spain</p>
                <p><a href="mailto:andre@thellsol.com">andre@thellsol.com</a><br>+34 676 335 313</p>
            </div>
            <div class="thellsol-footer-card">
                <h4><?php echo t('footer.legalLinks'); ?></h4>
                <div class="thellsol-footer-line"></div>
                <a href="politica-privacidad.php"><?php echo t('footer.privacyPolicy'); ?></a>
                <a href="politica-cookies.php"><?php echo t('footer.cookiesPolicy'); ?></a>
                <a href="aviso-legal.php"><?php echo t('footer.legalNotice'); ?></a>
            </div>
            <div class="thellsol-footer-card thellsol-footer-logo-card">
                <img src="./images/logo-thellsol.png" alt="Thellsol Logo">
            </div>
        </div>
        <div class="thellsol-footer-bottom">
            <span><?php echo t('footer.developedBy'); ?></span>
            <span><?php echo t('footer.copyrightPrefix'); ?> <?php echo $currentYear; ?></span>
        </div>
    </div>
</footer>

