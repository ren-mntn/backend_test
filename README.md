# 書籍管理アプリ API

このプロジェクトは書籍、著者、出版社を管理するための RESTful API を提供します。API を通じて、ユーザーは書籍の CRUD 操作を行うことができ、各書籍に紐づく著者や出版社の情報も管理できます。

## 主な機能

-   書籍の管理: 書籍の追加、更新、削除、リスト表示ができます。
-   著者の管理: 著者の追加、更新、削除、リスト表示ができます。書籍との紐づけも可能です。
-   出版社の管理: 出版社の追加、更新、削除、リスト表示ができます。書籍との紐づけも可能です。

## 技術スタック

- 言語: PHP
- フレームワーク: Laravel
- データベース: MySQL

## セットアップ手順

1. リポジトリをクローンする
```
git clone https://github.com/ren-mntn/backend_test.git
```
2. 依存関係をインストールする
```
composer install
```
3. 環境設定ファイル .env を設定する
4. データベースマイグレーションを実行する
```
php artisan migrate
```
5. サーバーを起動する
```
php artisan serve
```
## APIエンドポイント
- 書籍に関するAPIエンドポイント
  - GET /api/books - すべての書籍をリスト表示
  - POST /api/books - 新しい書籍を追加
  - GET /api/books/{isbn} - 特定の書籍の詳細を表示
  - PUT /api/books/{isbn} - 特定の書籍を更新
  - DELETE /api/books/{isbn} - 特定の書籍を削除
- 著者に関するAPIエンドポイント
  - GET /api/author - すべての著者をリスト表示
  - POST /api/author - 新しい書籍を追加
  - GET /api/author/{id} - 特定の書籍の詳細を表示
  - PUT /api/author/{id} - 特定の書籍を更新
  - DELETE /api/author/{id} - 特定の書籍を削除
- 出版社に関するAPIエンドポイント
  - GET /api/publisher - すべての出版社をリスト表示
  - POST /api/publisher - 新しい出版社を追加
  - GET /api/publisher/{id} - 特定の出版社の詳細を表示
  - PUT /api/publisher/{id} - 特定の出版社を更新
  - DELETE /api/publisher/{id} - 特定の出版社を削除

## 以下は著者のリストのJSONサンプルです。(GET /api/author/1)
```
{
    'authorId',
    'name',
    'books' : [
        '*' : [
            'isbn',
            'name',
            'publishedAt',
            'authorId',
            'publisherId',
        ],
    ],
    'relatedPublishers' : [
        '*' : [
            'publisherId',
            'name',
        ],
    ],
}
```
