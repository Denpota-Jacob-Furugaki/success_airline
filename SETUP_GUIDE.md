# サクセスキャリアエアライン - SWELL子テーマ セットアップガイド
## ワイヤーフレーム反映済み（PC/SP全8画面対応）

## 📁 ファイル構成

```
swell-child/
├── style.css              # 子テーマ定義
├── functions.php           # ショートコード・機能追加（告知バー、フッター雲、講師カード等）
└── assets/
    ├── css/
    │   └── custom.css      # カスタムCSS（1700行以上、全ページ対応）
    ├── js/
    │   └── custom.js       # カスタムJS（アニメーション、3ボタンCTA等）
    └── images/
        ├── cloud-divider-top.svg
        ├── cloud-divider-bottom.svg
        └── instructor.jpg  # ← 講師写真をここに配置
```

---

## 🚀 Step 1: 子テーマのインストール

### 方法A: FTP/ファイルマネージャーでアップロード
1. Xserverのファイルマネージャーにログイン
2. `sca-airline.com/public_html/wp-content/themes/` に移動
3. `swell-child` フォルダ一式をアップロード

### 方法B: ZIPでアップロード
1. `swell-child` フォルダをZIP圧縮
2. WordPress管理画面 → 外観 → テーマ → 新規追加 → テーマのアップロード
3. ZIPファイルをアップロードして有効化

---

## 🎨 Step 2: WordPress管理画面での設定

### 2-1. テーマの有効化
- 外観 → テーマ → 「SWELL CHILD - SCA Airline」を有効化

### 2-2. Google Fonts
→ **自動読み込み済み**（functions.phpでCormorant Garamond + Noto Serif JPをエンキュー）

### 2-3. SWELLカスタマイザー設定
- **メインカラー**: `#f2b5c3`（ピンク系）
- **リンクカラー**: `#e87fa0`
- **ヘッダーロゴ**: ロゴ画像設定
- **フッター背景色**: 透明（ピンク雲が自動表示されます）

### 2-4. 告知バー設定
設定 → 一般 の下部に「告知バーテキスト」と「告知バーリンクURL」が追加されています。
デフォルト: 「予約レッスン＆エントリーシート添削受付中！」

### 2-5. 講師写真の配置
`swell-child/assets/images/instructor.jpg` に菊地先生の写真を配置してください。
フッターとお問合せページで自動表示されます。

---

## 📄 Step 3: TOPページ構築

### 3-1. メインビジュアル
SWELLのメインビジュアル設定で画像スライダーを設定。
`background-attachment: fixed` が自動適用されパララックス効果が出ます。

### 3-2. 内定速報ティッカー
MVの直下に「カスタムHTML」ブロックを配置：
```html
[sca_ticker]
```
※ 速度調整: `[sca_ticker speed="40"]`

管理画面の「内定速報」メニューからテキストを編集できます。

### 3-3. お知らせセクション
SWELLフルワイドブロック使用：
- 背景色: `#ffffff`
- 英語ラベル＋見出し構成

### 3-4. 内定実績セクション
SWELLフルワイドブロック + カスタムHTML：
```html
<div class="sca-results-grid sca-fade-in">
  <div class="sca-result-card">
    <div class="sca-result-card__number">
      [sca_counter number="156" suffix="名"]
    </div>
    <div class="sca-result-card__label">2024年 内定者数</div>
  </div>
  <div class="sca-result-card">
    <div class="sca-result-card__number">
      [sca_counter number="125" suffix="名"]
    </div>
    <div class="sca-result-card__label">CA内定者</div>
  </div>
  <div class="sca-result-card">
    <div class="sca-result-card__number">
      [sca_counter number="31" suffix="名"]
    </div>
    <div class="sca-result-card__label">GS内定者</div>
  </div>
  <div class="sca-result-card">
    <div class="sca-result-card__number">
      [sca_counter number="33" suffix="名"]
    </div>
    <div class="sca-result-card__label">JAL内定者</div>
  </div>
  <div class="sca-result-card">
    <div class="sca-result-card__number">
      [sca_counter number="17" suffix="名"]
    </div>
    <div class="sca-result-card__label">ANA内定者</div>
  </div>
</div>
```

### 3-5. 講座紹介セクション（雲デザイン付き）
```html
[sca_cloud_divider position="top" color="#c9e8ff"]

<!-- SWELLフルワイドブロック（背景色: #c9e8ff → #ffffff グラデーション）-->
<!-- 講座カード等をここに配置 -->

[sca_cloud_divider position="bottom" color="#ffffff"]
```

### 3-6. 各セクションにフェードインアニメーション
ブロックの「追加CSSクラス」に追加：
- `sca-fade-in` — 下からフェードイン
- `sca-fade-in-left` — 左からフェードイン
- `sca-fade-in-right` — 右からフェードイン
- `sca-delay-1` 〜 `sca-delay-4` — 遅延

---

## 📮 Step 4: お問い合わせページ（ワイヤーフレーム準拠）

### ページ構成
固定ページ「お問合せ」を作成し、以下の順序でブロックを配置：

1. **ヒーローエリア**: SWELLフルワイドブロック（背景色: `#fff4f7`）
   - 見出し「お問合せ」

2. **CONTACTセクションラベル**: カスタムHTMLブロック
```html
<div class="sca-contact-heading">
  <span class="sca-contact-heading__en">CONTACT</span>
  <span class="sca-contact-heading__ja">整形術員のある方はこちらへ</span>
</div>
```

3. **講師プロフィールカード**: ショートコード
```html
[sca_instructor_card]
```

4. **お問合せフォーム**: Contact Form 7
```html
<div class="sca-contact-section">

<div class="sca-contact-form-group">
<label>お名前<span class="required">（必須）</span></label>
[text* your-name placeholder "お名前"]
</div>

<div class="sca-contact-form-group">
<label>メールアドレス<span class="required">（必須）</span></label>
[email* your-email placeholder "メールアドレス（半角英数字で入力）"]
</div>

<div class="sca-contact-form-group">
<label>電話番号</label>
[tel your-tel placeholder "電話番号"]
</div>

<div class="sca-contact-form-group">
<label>メッセージ<span class="required">（必須）</span></label>
[textarea* your-message placeholder "ご質問内容を具体的に"]
</div>

[submit "送信する"]

</div>
```

5. **注記テキスト**: カスタムHTMLブロック
```html
<div class="sca-contact-note">
メールが届いていない場合は、直接以下にご連絡ください。<br>
<a href="mailto:success.airline@gmail.com">success.airline@gmail.com</a>
</div>
```

---

## 📅 Step 5: UTAGE予約リンク統合

講座ページの予約ボタンにUTAGEリンクを設定：
```html
<a href="【UTAGEの予約URL】" class="sca-utage-btn" target="_blank" rel="noopener">
  講座を予約する
</a>
```

※ クライアント様がUTAGEの各講座リンクを整備次第、各ページに設定

---

## 📱 Step 6: 3ボタンCTAバー

### 自動生成される要素：
- **PC版**: フッター雲エリアの下に3ボタンCTA（お悩み相談 / 個別予約 / お問合せ）
- **SP版**: 固定ボトムバーに同で3ボタン（スクロール300px以下で表示）

### リンク先変更：
- `functions.php` の `sca_footer_cloud_section()` 内のフッターCTA URL
- `custom.js` の `initFixedCTA()` 内のSP版CTA URL

### 自動生成: ピンク雲フッター
- フッターの上にピンクグラデーションの雲が自動表示
- 講師プロフィール + SNSアイコン（Instagram, Spotify, YouTube, note）
- メールアドレス

### 自動生成: 告知バー
- ヘッダー上部にピンク帯で告知テキストを表示
- 「設定 → 一般」からテキストとリンクURLを編集可能

---

## ✅ カスタマイズチェックリスト

- [ ] 子テーマアップロード・有効化
- [ ] Google Fonts設定
- [ ] SWELLカスタマイザーでカラー設定
- [ ] TOPページ: メインビジュアル設定
- [ ] TOPページ: 内定速報ティッカー配置
- [ ] TOPページ: お知らせセクション
- [ ] TOPページ: 内定実績セクション（カウントアップ付き）
- [ ] TOPページ: Welcome to SCAセクション
- [ ] TOPページ: 講座紹介セクション（雲デバイダー付き）
- [ ] TOPページ: 内定者の声セクション
- [ ] TOPページ: Instagram/YouTube埋め込み
- [ ] TOPページ: メディア掲載実績
- [ ] TOPページ: プロフィールセクション
- [ ] 投稿ページ: デザイン確認
- [ ] 固定ページ: デザイン確認
- [ ] お問い合わせ: Contact Form 7設定
- [ ] 各講座ページ: UTAGE予約リンク設定（クライアント準備次第）
- [ ] レスポンシブ確認（PC/タブレット/スマホ）
- [ ] ページ速度確認

---

## 🔑 ショートコード一覧

| ショートコード | 用途 | パラメータ |
|---|---|---|
| `[sca_ticker]` | 内定速報スライダー | `speed="30"` |
| `[sca_counter]` | カウントアップ数字 | `number`, `suffix`, `prefix`, `duration` |
| `[sca_cloud_divider]` | 雲型セクション区切り | `position`, `color`, `flip` |
| `[sca_instructor_card]` | 講師プロフィールカード | `name`, `title`, `email`, `tel`, `note` |
| `[sca_sns_grid]` | SNSアイコングリッド | （なし） |

## 🎨 CSSクラス一覧（ブロックの「追加CSSクラス」に指定）

| クラス名 | 効果 |
|---|---|
| `sca-fade-in` | 下からフェードイン |
| `sca-fade-in-left` | 左からフェードイン |
| `sca-fade-in-right` | 右からフェードイン |
| `sca-delay-1` 〜 `sca-delay-4` | アニメーション遅延 |
| `sca-cat-tag` | ピンクカテゴリタグ |
| `sca-cta-button` | ピンクCTAボタン |
| `sca-utage-btn` | ゴールド予約ボタン |

---

## ⚠️ 注意事項

1. **講座ページの申し込みフォーム**は触らないでください（クライアント指示）
2. **UTAGE予約リンク**はクライアントが週末までに整備予定
3. SWELLのアップデート時、子テーマなので影響を受けません
4. 画像の最適化はSWELLの遅延読み込み機能に任せてOK
5. **講師写真**は `swell-child/assets/images/instructor.jpg` に配置必須

---

## 📌 ワイヤーフレーム対応状況

| ページ | PC | SP | ステータス |
|---|---|---|---|
| TOP | — | ✅ WF分析済 | CSS/JS準備済、ブロック配置待ち |
| お問合せ | ✅ | ✅ | 完全対応済 |
| ブログ一覧 | ✅ | ✅ | CSS完全対応済 |
| ブログ詳細 | ✅ | ✅ | CSS完全対応済 |
| 固定ページテンプレ | — | ✅ | CSS完全対応済 |
| フッター（雲ピンク + CTA） | 共通 | 共通 | 自動生成済 |
| 告知バー | 共通 | 共通 | 自動生成済 |
| 固定ボトムCTA | — | ✅ | 自動生成済 |
