<?php
/**
 * SWELL Child Theme - サクセスキャリアエアライン
 */

// Google Fonts読み込み
add_action('wp_enqueue_scripts', 'sca_enqueue_google_fonts', 5);
function sca_enqueue_google_fonts() {
    wp_enqueue_style(
        'sca-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Noto+Serif+JP:wght@400;700&display=swap',
        array(),
        null
    );
}

// カスタムCSS読み込み
add_action('wp_enqueue_scripts', 'sca_enqueue_styles', 20);
function sca_enqueue_styles() {
    wp_enqueue_style(
        'sca-custom-style',
        get_stylesheet_directory_uri() . '/assets/css/custom.css',
        array('sca-google-fonts'),
        filemtime(get_stylesheet_directory() . '/assets/css/custom.css')
    );
}

// カスタムJSの読み込み
add_action('wp_enqueue_scripts', 'sca_enqueue_scripts', 20);
function sca_enqueue_scripts() {
    wp_enqueue_script(
        'sca-custom-script',
        get_stylesheet_directory_uri() . '/assets/js/custom.js',
        array(),
        filemtime(get_stylesheet_directory() . '/assets/js/custom.js'),
        true
    );
}

// =============================================
// 内定速報ティッカー用ショートコード
// =============================================
add_shortcode('sca_ticker', 'sca_ticker_shortcode');
function sca_ticker_shortcode($atts) {
    $atts = shortcode_atts(array(
        'speed' => '30', // アニメーション秒数
    ), $atts);

    // 内定速報データ（管理画面から更新可能にする場合はカスタムフィールドに移行）
    $ticker_items = array(
        'ANA既卒CA内定！おめでとうございます！',
        'JAL新卒CA内定！おめでとうございます！',
        'ANA新卒GS内定！おめでとうございます！',
        'スカイマークCA内定！おめでとうございます！',
        'JAL既卒CA内定！おめでとうございます！',
        'ANA新卒CA内定！おめでとうございます！',
        'AIRDO CA内定！おめでとうございます！',
        'ソラシドエア CA内定！おめでとうございます！',
    );

    // カスタマイザーやオプションから取得する場合
    $custom_items = get_option('sca_ticker_items', '');
    if (!empty($custom_items)) {
        $ticker_items = array_filter(array_map('trim', explode("\n", $custom_items)));
    }

    $output = '<div class="sca-ticker-wrap">';
    $output .= '<div class="sca-ticker-label">内定速報</div>';
    $output .= '<div class="sca-ticker-track" style="--ticker-speed: ' . esc_attr($atts['speed']) . 's;">';
    $output .= '<div class="sca-ticker-content">';

    // 2回繰り返してシームレスループにする
    for ($i = 0; $i < 2; $i++) {
        foreach ($ticker_items as $item) {
            $output .= '<span class="sca-ticker-item">' . esc_html($item) . '</span>';
        }
    }

    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}

// =============================================
// 内定速報管理画面設定
// =============================================
add_action('admin_menu', 'sca_add_admin_menu');
function sca_add_admin_menu() {
    add_menu_page(
        '内定速報設定',
        '内定速報',
        'manage_options',
        'sca-ticker',
        'sca_ticker_admin_page',
        'dashicons-megaphone',
        30
    );
}

function sca_ticker_admin_page() {
    if (isset($_POST['sca_ticker_save']) && check_admin_referer('sca_ticker_nonce')) {
        update_option('sca_ticker_items', sanitize_textarea_field($_POST['sca_ticker_items']));
        echo '<div class="updated"><p>保存しました。</p></div>';
    }
    $items = get_option('sca_ticker_items', '');
    ?>
    <div class="wrap">
        <h1>内定速報設定</h1>
        <p>1行に1つずつ内定速報のテキストを入力してください。空の場合はデフォルトのテキストが表示されます。</p>
        <form method="post">
            <?php wp_nonce_field('sca_ticker_nonce'); ?>
            <textarea name="sca_ticker_items" rows="15" cols="80" class="large-text"><?php echo esc_textarea($items); ?></textarea>
            <p class="submit">
                <input type="submit" name="sca_ticker_save" class="button-primary" value="保存">
            </p>
        </form>
        <h3>使い方</h3>
        <p>固定ページやブロックエディタで以下のショートコードを挿入してください：</p>
        <code>[sca_ticker]</code>
        <p>速度を変更する場合：<code>[sca_ticker speed="40"]</code>（数字が大きいほど遅い）</p>
    </div>
    <?php
}

// =============================================
// 内定実績カウントアップ用ショートコード
// =============================================
add_shortcode('sca_counter', 'sca_counter_shortcode');
function sca_counter_shortcode($atts) {
    $atts = shortcode_atts(array(
        'number' => '0',
        'suffix' => '',
        'prefix' => '',
        'duration' => '2000',
    ), $atts);

    return '<span class="sca-counter" data-target="' . esc_attr($atts['number']) . '" data-duration="' . esc_attr($atts['duration']) . '">'
        . esc_html($atts['prefix'])
        . '<span class="sca-counter-number">0</span>'
        . esc_html($atts['suffix'])
        . '</span>';
}

// =============================================
// 雲デザイン用セクションデバイダー
// =============================================
add_shortcode('sca_cloud_divider', 'sca_cloud_divider_shortcode');
function sca_cloud_divider_shortcode($atts) {
    $atts = shortcode_atts(array(
        'position' => 'top',    // top or bottom
        'color'    => '#ffffff',
        'flip'     => 'false',
    ), $atts);

    $flip_style = $atts['flip'] === 'true' ? ' style="transform: scaleX(-1);"' : '';
    $position_class = 'sca-cloud-divider--' . esc_attr($atts['position']);

    return '<div class="sca-cloud-divider ' . $position_class . '"' . $flip_style . '>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path fill="' . esc_attr($atts['color']) . '" d="M0,64 C120,90 240,100 360,85 C480,70 540,45 660,50 C780,55 840,80 960,75 C1080,70 1200,50 1320,60 C1380,65 1410,70 1440,72 L1440,120 L0,120 Z"/>
            <path fill="' . esc_attr($atts['color']) . '" opacity="0.5" d="M0,80 C160,95 320,105 480,90 C640,75 720,55 880,65 C1040,75 1120,90 1280,82 C1360,78 1400,75 1440,80 L1440,120 L0,120 Z"/>
        </svg>
    </div>';
}

// =============================================
// 告知バー（ヘッダー上部ピンク帯）
// =============================================
add_action('wp_body_open', 'sca_announcement_bar');
function sca_announcement_bar() {
    $text = get_option('sca_announcement_text', '');
    if (empty($text)) {
        $text = '予約レッスン＆エントリーシート添削受付中！';
    }
    $link = get_option('sca_announcement_link', '');

    echo '<div class="sca-announcement-bar">';
    if (!empty($link)) {
        echo '<a href="' . esc_url($link) . '">' . esc_html($text) . ' →</a>';
    } else {
        echo esc_html($text);
    }
    echo '</div>';
}

// 告知バー管理画面
add_action('admin_init', 'sca_announcement_settings');
function sca_announcement_settings() {
    register_setting('general', 'sca_announcement_text', 'sanitize_text_field');
    register_setting('general', 'sca_announcement_link', 'esc_url_raw');

    add_settings_field(
        'sca_announcement_text',
        '告知バーテキスト',
        function() {
            $val = get_option('sca_announcement_text', '');
            echo '<input type="text" name="sca_announcement_text" value="' . esc_attr($val) . '" class="regular-text" />';
            echo '<p class="description">ヘッダー上部のピンク告知バーに表示するテキスト</p>';
        },
        'general'
    );

    add_settings_field(
        'sca_announcement_link',
        '告知バーリンクURL',
        function() {
            $val = get_option('sca_announcement_link', '');
            echo '<input type="url" name="sca_announcement_link" value="' . esc_attr($val) . '" class="regular-text" />';
            echo '<p class="description">空の場合はリンクなし</p>';
        },
        'general'
    );
}

// =============================================
// フッター：ピンク雲 + プロフィール + SNS + 3ボタンCTA
// =============================================
add_action('wp_footer', 'sca_footer_cloud_section', 5);
function sca_footer_cloud_section() {
    ?>
    <div class="sca-footer-cloud-area">
        <div class="sca-footer-profile">
            <img src="<?php echo esc_url(get_option('sca_instructor_img', get_stylesheet_directory_uri() . '/assets/images/instructor.jpg')); ?>"
                 alt="菊地未夏" class="sca-footer-profile__img" width="120" height="120" loading="lazy">
            <div class="sca-footer-profile__name">菊地未夏</div>
            <div class="sca-footer-profile__title">SUCCESS CAREER AIRLINE 代表</div>
            <dl class="sca-footer-profile__links">
                <dd><a href="mailto:success.airline@gmail.com">success.airline@gmail.com</a></dd>
            </dl>
            <div class="sca-footer-sns">
                <a href="https://www.instagram.com/success_career_airline/" target="_blank" rel="noopener" aria-label="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                </a>
                <a href="#" target="_blank" rel="noopener" aria-label="Spotify">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/></svg>
                </a>
                <a href="https://www.youtube.com/@user-qo4vy8wd4y" target="_blank" rel="noopener" aria-label="YouTube">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                </a>
                <a href="https://note.com/success_airline" target="_blank" rel="noopener" aria-label="note">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M14.906 4.769c-1.328 0-2.907.405-4.248 1.238-1.326.823-2.388 2.053-2.874 3.693-.255.86-.214 1.653.097 2.32.306.657.825 1.118 1.367 1.397.508.261 1.014.374 1.367.429l.09.014c-.026.168-.076.46-.15.805-.115.539-.273 1.175-.457 1.714-.097.283.054.59.338.688.283.097.59-.054.688-.338.2-.585.37-1.264.49-1.826.084-.393.14-.718.17-.905l.016-.095.11-.007c.442-.031.988-.148 1.524-.402.545-.258 1.092-.665 1.497-1.287.405-.621.623-1.42.623-2.422 0-1.627-.55-2.89-1.47-3.752-.92-.864-2.157-1.264-3.378-1.264zm-5.65 5.182c.383-1.293 1.245-2.28 2.345-2.962 1.1-.683 2.432-1.02 3.505-1.02.98 0 1.968.32 2.686.995.718.674 1.162 1.706 1.162 3.121 0 .84-.178 1.457-.465 1.897-.287.44-.678.744-1.107.947-.37.175-.756.27-1.077.316-.148.597-.397 1.406-.69 2.05-.328.726-.76 1.384-1.36 1.618-1.247.486-2.257.162-2.97-.33-.356-.246-.623-.535-.802-.766a3.087 3.087 0 0 1-.186-.272l-.007-.012c-.272-.058-.655-.148-1.026-.339-.415-.213-.82-.567-1.047-1.056-.222-.478-.253-1.07-.054-1.74l.001-.004z"/><path d="M6.727 12c0-2.89 2.383-5.273 5.273-5.273 2.89 0 5.273 2.383 5.273 5.273 0 2.89-2.383 5.273-5.273 5.273-2.89 0-5.273-2.383-5.273-5.273zM12 5.455A6.545 6.545 0 1 0 12 18.545 6.545 6.545 0 0 0 12 5.455z"/></svg>
                </a>
            </div>
        </div>
    </div>
    <!-- フッター3ボタンCTA -->
    <div class="sca-footer-cta">
        <a href="/counseling" class="sca-footer-cta__btn sca-footer-cta__btn--1">お悩み相談</a>
        <a href="/booking" class="sca-footer-cta__btn sca-footer-cta__btn--2">個別予約</a>
        <a href="/contact" class="sca-footer-cta__btn sca-footer-cta__btn--3">お問合せ</a>
    </div>
    <?php
}

// =============================================
// お問い合わせページ：講師プロフィールカード ショートコード
// =============================================
add_shortcode('sca_instructor_card', 'sca_instructor_card_shortcode');
function sca_instructor_card_shortcode($atts) {
    $atts = shortcode_atts(array(
        'name'  => '菊地未夏（きくちみか）',
        'title' => 'SUCCESS CAREER AIRLINE 代表 / エアラインスクール講師',
        'email' => 'success.airline@gmail.com',
        'tel'   => '',
        'note'  => 'メディアアートにつれないときにはこちらのお問い合わせフォームで、ご連絡ください。',
    ), $atts);

    $img_url = get_option('sca_instructor_img', get_stylesheet_directory_uri() . '/assets/images/instructor.jpg');

    $output = '<div class="sca-contact-instructor">';
    $output .= '<img src="' . esc_url($img_url) . '" alt="' . esc_attr($atts['name']) . '" class="sca-contact-instructor__img" width="80" height="80" loading="lazy">';
    $output .= '<div class="sca-contact-instructor__info">';
    $output .= '<div class="sca-contact-instructor__name">' . esc_html($atts['name']) . '</div>';
    $output .= '<div class="sca-contact-instructor__title">' . esc_html($atts['title']) . '</div>';
    $output .= '<div class="sca-contact-instructor__meta">';
    if (!empty($atts['email'])) {
        $output .= 'メール: <a href="mailto:' . esc_attr($atts['email']) . '">' . esc_html($atts['email']) . '</a><br>';
    }
    if (!empty($atts['tel'])) {
        $output .= '電話: <a href="tel:' . esc_attr(str_replace('-', '', $atts['tel'])) . '">' . esc_html($atts['tel']) . '</a><br>';
    }
    if (!empty($atts['note'])) {
        $output .= '<small>' . esc_html($atts['note']) . '</small>';
    }
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}

// =============================================
// SNSアイコングリッド ショートコード（TOP用）
// =============================================
add_shortcode('sca_sns_grid', 'sca_sns_grid_shortcode');
function sca_sns_grid_shortcode($atts) {
    $output = '<div class="sca-sns-grid">';
    $output .= '<a href="https://www.instagram.com/success_career_airline/" target="_blank" rel="noopener" aria-label="Instagram">';
    $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>';
    $output .= '</a>';
    $output .= '<a href="https://www.youtube.com/@user-qo4vy8wd4y" target="_blank" rel="noopener" aria-label="YouTube">';
    $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>';
    $output .= '</a>';
    $output .= '<a href="https://note.com/success_airline" target="_blank" rel="noopener" aria-label="note">';
    $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M14.906 4.769c-1.328 0-2.907.405-4.248 1.238-1.326.823-2.388 2.053-2.874 3.693-.255.86-.214 1.653.097 2.32.306.657.825 1.118 1.367 1.397.508.261 1.014.374 1.367.429l.09.014c-.026.168-.076.46-.15.805-.115.539-.273 1.175-.457 1.714-.097.283.054.59.338.688.283.097.59-.054.688-.338.2-.585.37-1.264.49-1.826.084-.393.14-.718.17-.905l.016-.095.11-.007c.442-.031.988-.148 1.524-.402.545-.258 1.092-.665 1.497-1.287.405-.621.623-1.42.623-2.422 0-1.627-.55-2.89-1.47-3.752-.92-.864-2.157-1.264-3.378-1.264z"/></svg>';
    $output .= '</a>';
    $output .= '</div>';
    return $output;
}
