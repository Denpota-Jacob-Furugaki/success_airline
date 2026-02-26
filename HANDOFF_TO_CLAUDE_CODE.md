# Claude Code 引継ぎドキュメント
## サクセスキャリアエアライン SWELL WordPress カスタマイズ

**作成日**: 2026-02-25
**締切**: 2026-02-27
**予算**: 50,000 JPY

---

## 1. プロジェクト概要

サクセスキャリアエアライン（エアラインスクール）のWordPressサイトを、SWELLテーマベースでカスタマイズ。
Wixサイトからの移行的リニューアル。

---

## 2. アクセス情報

| 項目 | 情報 |
|---|---|
| **WordPress管理画面** | https://sca-airline.com/wp-admin/ |
| **WPユーザー** | kikuchimika |
| **WPパスワード** | xaVrJXBZaLNAtAJnBx#Kkq9b |
| **Xserverパネル** | tsuiteru49mika@gmail.com |
| **Xserverパスワード** | fuwafuwa4976mika |
| **参考Wixサイト** | https://xxglitterxxstylexx.wixsite.com/succescareerairline |

---

## 3. 作業ディレクトリ

```
c:\Users\denpo\OneDrive\successCareer_airlines\
├── swell-child/                    # SWELL子テーマ一式（★メインの成果物）
│   ├── style.css                   # 子テーマ定義
│   ├── functions.php               # 312行: ショートコード、告知バー、フッター雲、講師カード等
│   ├── screenshot.png              # 空（要差し替え）
│   └── assets/
│       ├── css/custom.css          # 1,777行: 全ページ対応CSS
│       ├── js/custom.js            # 337行: アニメーション、パララックス、固定CTA等
│       └── images/
│           ├── cloud-divider-top.svg
│           ├── cloud-divider-bottom.svg
│           └── instructor.jpg      # ★未配置: 講師（菊地未夏）の写真をここに
├── swell-child.zip                 # WPアップロード用ZIP（最新版）
├── SETUP_GUIDE.md                  # セットアップ手順書（ワイヤーフレーム反映済み）
├── HANDOFF_TO_CLAUDE_CODE.md       # この引継ぎファイル
└── WireframeNewSite/               # ワイヤーフレーム画像（分析済み）
    ├── PC・お問合せ.jpg
    ├── PC・ブログ.jpg
    ├── PC・ブログ詳細.jpg
    ├── SP・TOP.jpg
    ├── SP・お問合せ.jpg
    ├── SP・テンプレ.jpg
    ├── SP・ブログ.jpg
    └── SP・ブログ内容詳細.jpg
```

---

## 4. 完了済みの作業

### ✅ 子テーマファイル一式作成
- `style.css` — 子テーマ定義（Template: swell）
- `functions.php` — 以下の機能を実装済み:
  - Google Fonts読み込み (Cormorant Garamond + Noto Serif JP)
  - カスタムCSS/JS読み込み
  - `[sca_ticker]` — 内定速報スライディングティッカー（管理画面「内定速報」メニューからテキスト編集可）
  - `[sca_counter]` — カウントアップアニメーション数字
  - `[sca_cloud_divider]` — 雲セクションデバイダー
  - `[sca_instructor_card]` — 講師プロフィールカード（お問合せ用）
  - `[sca_sns_grid]` — SNSアイコングリッド（Instagram, YouTube, note）
  - 告知バー — `wp_body_open`で自動挿入、「設定→一般」から編集可
  - フッター雲エリア — `wp_footer`で自動挿入（ピンクグラデーション雲 + 講師プロフィール + SNS + 3ボタンCTA）

### ✅ custom.css (1,777行)
全ページのCSSをワイヤーフレーム8枚の分析結果に基づいて実装:
- カラー変数（ピンク系テーマ）
- 告知バー（ヘッダー上部ピンク帯）
- ヘッダーCTAボタン
- パララックス背景（CSS/JSハイブリッド、iOS対応）
- 内定速報ティッカー
- MV強化
- セクション見出し（英語ラベル + 日本語見出し + ゴールドライン）
- 内定実績カード + カウントアップ
- 講座紹介カード
- 雲セクションデバイダー
- お知らせセクション
- 内定者の声カード
- CTAボタン
- 3ボタンフッターCTA（PC） + 固定ボトムCTA（SP）
- スクロールフェードインアニメーション
- SWELL上書き（ヘッダー、ナビ、ボタン等）
- 投稿ページテンプレ（h2ピンク左ボーダー、h3下ボーダー）
- お問合せ（ヒーロー、講師カード、フォーム、送信ボタン、注記）
- メディア掲載
- ブログ一覧（ヒーロー、カテゴリタグ、記事カード、サイドバー）
- ブログ詳細（著者BOX、SNSシェアボタン）
- 固定ページテンプレ
- SNSアイコングリッド
- UTAGE予約ボタン
- 全レスポンシブ対応（959px/768px/599px）

### ✅ custom.js (337行)
- IntersectionObserver フェードインアニメーション
- カウントアップアニメーション（easeOutQuart）
- パララックス背景（JSベース、スマホ無効）
- iOSパララックスシミュレート
- スムーススクロール
- ヘッダースクロール変化
- ティッカーシームレスループ保証
- SP固定ボトム3ボタンCTA（スクロール300px以降表示）

### ✅ ワイヤーフレーム分析（8枚全て完了）
各ページのデザイン仕様を把握してCSSに反映済み。

### ✅ swell-child.zip 作成済み
WP管理画面からアップロード可能な状態。

### ✅ SETUP_GUIDE.md 作成済み
全手順をドキュメント化。

---

## 5. 未完了の作業（★ここからやる）

### 🔴 優先度: 高

#### A. 子テーマをWordPressにアップロード・有効化
1. `swell-child.zip` を WP管理画面 → 外観 → テーマ → 新規追加 → テーマのアップロード
2. 「SWELL CHILD - SCA Airline」を有効化
3. 表示確認（崩れないこと）

**注意**: WP REST APIのBasic認証は401で弾かれた（アプリケーションパスワード未設定のため）。
**方法**: ブラウザで直接wp-adminにログインしてアップロードするか、FTP/Xserverファイルマネージャーで `/wp-content/themes/swell-child/` にファイルを配置。

#### B. 講師写真の配置
- `swell-child/assets/images/instructor.jpg` に菊地未夏先生の写真を配置
- WP内のメディアライブラリから取得するか、Wixサイトからダウンロード

#### C. TOPページ構築（ブロックエディタ）
SETUP_GUIDE.md の Step 3 に従って、SWELLのブロックエディタで以下のセクションを配置:
1. MV（メインビジュアル）— SWELLのMV設定で画像スライダー
2. `[sca_ticker]` — 内定速報ティッカー
3. 内定実績セクション — カスタムHTMLで `sca-results-grid` + `[sca_counter]`
4. `[sca_sns_grid]` — SNSアイコン
5. 講座紹介セクション — 雲デバイダー付き
6. 内定者の声
7. メディア掲載
8. フェードインアニメーション（各ブロックに `sca-fade-in` クラス追加）

#### D. お問合せページ作成
SETUP_GUIDE.md の Step 4 に従って:
1. Contact Form 7 インストール・有効化
2. 固定ページ「お問合せ」作成
3. CONTACTセクションラベル + `[sca_instructor_card]` + CF7フォーム + 注記テキスト

### 🟡 優先度: 中

#### E. SWELLカスタマイザー設定
- メインカラー: `#f2b5c3`
- リンクカラー: `#e87fa0`
- フッター背景色: 透明

#### F. UTAGE予約リンク統合
- クライアントがUTAGE側のリンクを週末までに整備予定
- 準備できたら各講座ページに `sca-utage-btn` クラスのリンクを設置

#### G. レスポンシブ確認・最終テスト
- PC/タブレット/スマホで全ページ表示確認
- 3ボタンCTA動作確認
- パララックス動作確認
- ティッカー動作確認

---

## 6. 絶対にやらないこと

1. **講座ページの申し込みフォーム**（`/service` 配下）は触らない（クライアント指示）
2. Wixのカレンダーは使わない（UTAGE予約に置き換え）
3. 既存の投稿コンテンツは削除しない

---

## 7. 技術的な注意点

- **SWELL テーマ**: ブロックエディタ（Gutenberg）ベース。フルワイドブロック、リスト、カラム等を使う。
- **子テーマ方式**: 親テーマ(swell)を上書きせず、子テーマで追加CSS/JS/functions.phpのみ。
- **ショートコード**: ブロックエディタの「ショートコード」ブロックまたは「カスタムHTML」ブロックに挿入。
- **フッター雲・告知バー・固定CTA**: functions.phpのフック（`wp_body_open`, `wp_footer`）で自動出力されるため、ブロックエディタでの配置不要。
- **WP REST API**: Basic認証は使えない。ブラウザログインかFTPで作業。

---

## 8. ファイル内容クイックリファレンス

### functions.php の主要関数
| 関数名 | 説明 |
|---|---|
| `sca_enqueue_google_fonts()` | Google Fonts読み込み |
| `sca_enqueue_styles()` | custom.css読み込み |
| `sca_enqueue_scripts()` | custom.js読み込み |
| `sca_ticker_shortcode()` | `[sca_ticker]` ショートコード |
| `sca_ticker_admin_page()` | 管理画面「内定速報」メニュー |
| `sca_counter_shortcode()` | `[sca_counter]` ショートコード |
| `sca_cloud_divider_shortcode()` | `[sca_cloud_divider]` ショートコード |
| `sca_announcement_bar()` | 告知バー自動挿入 |
| `sca_announcement_settings()` | 告知バー管理画面設定 |
| `sca_footer_cloud_section()` | フッター雲+プロフィール+CTA |
| `sca_instructor_card_shortcode()` | `[sca_instructor_card]` ショートコード |
| `sca_sns_grid_shortcode()` | `[sca_sns_grid]` ショートコード |

### custom.css のセクション構成 (25セクション)
1. カラー変数・基本設定
1b. 告知バー
1c. ヘッダーCTAボタン
2. パララックス背景
3. 内定速報ティッカー
4. MV強化
5. セクション見出し
6. 内定実績
7. 講座紹介カード
8. 雲デバイダー
9. お知らせ
10. 内定者の声
11. CTAボタン
11b. 3ボタンCTA（PC+SP）
12. フェードインアニメーション
13. SWELLテーマ上書き + フッター雲ピンク
14. 投稿/固定ページテンプレート
15. お問合せページ
16. メディア掲載
17. (Google Fonts補助)
18. レスポンシブ
19. プリント
20. UTAGE予約ボタン
21. ブログ一覧
22. ブログ詳細（著者BOX、シェアボタン）
23. 固定ページテンプレ
24. SNSアイコングリッド
25. 追加レスポンシブ

### custom.js の初期化フロー
```
init()
  ├── initScrollAnimations()   // IntersectionObserver
  ├── initCounters()           // カウントアップ
  ├── initParallax()           // JSパララックス
  ├── initSwellParallax()      // iOS対応
  ├── initSmoothScroll()       // アンカーリンク
  ├── initHeaderScroll()       // ヘッダースクロール変化
  ├── initTicker()             // ティッカーループ保証
  └── initFixedCTA()           // SP固定3ボタンCTA
```

---

## 9. 即座に実行すべきコマンド（Claude Code向け）

### Step 1: 子テーマアップロード
WP REST APIが使えないため、以下のいずれかで:

**方法A: Xserverファイルマネージャー**
1. Xserverにログイン (tsuiteru49mika@gmail.com / fuwafuwa4976mika)
2. ファイルマネージャー → sca-airline.com → public_html → wp-content → themes
3. swell-child フォルダをアップロード

**方法B: FTP**
- ホスト: sca-airline.com (sv16631.xserver.jp)
- FTPユーザー/パスはXserverパネルで確認

**方法C: WP管理画面**
- https://sca-airline.com/wp-admin/ にログイン
- 外観 → テーマ → 新規追加 → テーマのアップロード → swell-child.zip

### Step 2: 有効化後
```
設定 → 一般 で告知バーテキストを確認
管理画面左メニュー「内定速報」で速報テキスト設定
外観 → カスタマイズ でカラー設定
```

### Step 3: TOPページ構築
→ SETUP_GUIDE.md の Step 3 参照

### Step 4: お問合せページ構築
→ SETUP_GUIDE.md の Step 4 参照
