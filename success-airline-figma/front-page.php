<?php
/**
 * Front page template rendered from wireframe HTML.
 */

if (!defined('ABSPATH')) {
    exit;
}

$template_dir = get_template_directory();
$template_uri = get_template_directory_uri();
$wireframe_file = $template_dir . '/wireframe-homepage.html';

if (!file_exists($wireframe_file)) {
    status_header(500);
    echo 'Missing wireframe-homepage.html';
    return;
}

$html = file_get_contents($wireframe_file);
if ($html === false) {
    status_header(500);
    echo 'Unable to load homepage template.';
    return;
}

// ── Remove the first <style>…</style> block (main CSS in <head>). ──
// Uses strpos/substr instead of preg_replace to avoid pcre.backtrack_limit
// failures on hosts with low limits (the block is ~38 KB).
$head_end = strpos($html, '</head>');
if ($head_end !== false) {
    $style_open = strpos($html, '<style');
    if ($style_open !== false && $style_open < $head_end) {
        $style_close = strpos($html, '</style>', $style_open);
        if ($style_close !== false && $style_close < $head_end) {
            $html = substr($html, 0, $style_open) . substr($html, $style_close + 8);
        }
    }
}

// ── Remove Google Font / preconnect links (small matches, regex is fine). ──
$html = preg_replace('#<link[^>]+fonts\.googleapis\.com[^>]*>\s*#i', '', $html);
$html = preg_replace('#<link[^>]+fonts\.gstatic\.com[^>]*>\s*#i', '', $html);

// ── Replace image paths (relative and absolute). ──
$img_base = esc_url($template_uri) . '/assets/images/';

$replacements = array(
    'src="images/'           => 'src="' . $img_base,
    "src='images/"           => "src='" . $img_base,
    'href="images/'          => 'href="' . $img_base,
    "href='images/"          => "href='" . $img_base,
    'src="/images/'          => 'src="' . $img_base,
    "src='/images/"          => "src='" . $img_base,
    'href="/images/'         => 'href="' . $img_base,
    "href='/images/"         => "href='" . $img_base,
    'src="/homepage/images/' => 'src="' . $img_base,
    "src='/homepage/images/" => "src='" . $img_base,
);

$html = strtr($html, $replacements);

// ── Inject wp_head() before </head>. ──
ob_start();
wp_head();
$wp_head = ob_get_clean();
$html = str_replace('</head>', $wp_head . "\n</head>", $html);

// ── Inject wp_footer() before </body>. ──
ob_start();
wp_footer();
$wp_footer = ob_get_clean();
$html = str_replace('</body>', $wp_footer . "\n</body>", $html);

echo $html;
