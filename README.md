# hamworks/wp-post-type

WordPressのカスタム投稿タイプを簡単に作成するためのライブラリです。

## インストール

```bash
composer require hamworks/wp-post-type
```

## 基本的な使い方

```php
use HAMWORKS\WP\Post_Type\Builder;

$builder = new Builder( 'book', 'Book' );
$builder->create();
```

## 詳細設定

### オプションの設定

```php
$builder = new Builder( 'book', 'Book' );
$builder->set_options( 
    [
        'public'        => true,
        'description'   => '書籍の投稿タイプ',
        'has_archive'   => true,
        'hierarchical'  => false,
        'menu_position' => 20,
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'rewrite'       => [
            'slug'       => 'books',
            'with_front' => false,
        ],
    ]
);
$builder->create();
```

### ラベルのカスタマイズ

```php
$builder = new Builder( 'book', 'Book' );
$builder->set_labels([
    'name'          => 'Books',
    'singular_name' => 'Book',
    'add_new'       => 'Add New Book',
    'add_new_item'  => 'Add New Book',
    'edit_item'     => 'Edit Book',
    'new_item'      => 'New Book',
    'view_item'     => 'View Book',
    'search_items'  => 'Search Books',
]);
$builder->create();
```

## デフォルト設定

このライブラリでは以下のデフォルト設定が適用されます：

### 基本設定
- `public`: true
- `show_ui`: true
- `show_in_rest`: true（REST API対応）
- `show_in_admin_bar`: true
- `show_in_nav_menus`: true
- `has_archive`: true
- `hierarchical`: false

### サポート機能
- title（タイトル）
- author（投稿者）
- editor（エディター）
- excerpt（抜粋）
- revisions（リビジョン）
- thumbnail（アイキャッチ画像）
- custom-fields（カスタムフィールド）

### GraphQL対応
- WPGraphQL使用時に自動でGraphQLフィールド名を設定
- 単数形と複数形のslugが自動生成される

### URL書き換え
- Doctrine Inflectorを使用してslugを自動生成
- 複数形のslugが自動設定される（例：`book` → `books`）

### 階層化投稿タイプ
`hierarchical` を `true` に設定すると、自動的に `page-attributes` サポートが追加され、管理画面でのデフォルトソート順が `menu_order` になります。

## 使用例

### イベント投稿タイプの作成

```php
$event_builder = new Builder( 'event', 'イベント' );
$event_builder->set_options([
    'public'        => true,
    'has_archive'   => true,
    'menu_position' => 25,
    'supports'      => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
    'rewrite'       => [ 'slug' => 'events' ],
]);
$event_builder->create();
```

### 階層化されたページ型投稿タイプの作成

```php
$page_builder = new Builder( 'book', 'Book' );
$page_builder->set_options([
    'hierarchical' => true,  // page-attributesが自動追加される
    'has_archive'  => false,
    'supports'     => [ 'title', 'editor', 'thumbnail' ],
]);
$page_builder->create();
```

## メソッド

### `__construct( $name, $label )`
- `$name`: 投稿タイプのスラッグ（単数形で指定）
- `$label`: 表示名

### `set_options( array $args = [] )`
投稿タイプのオプションを設定します。WordPressの `register_post_type()` と同じ引数を使用できます。

### `set_labels( array $args = [] )`
投稿タイプのラベルを設定します。

### `create()`
投稿タイプを登録し、必要なフックを追加します。

### `get_post_type()`
登録された投稿タイプオブジェクトを返します。
