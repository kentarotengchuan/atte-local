## Atte

このアプリは勤怠管理アプリです。ユーザー作成、メール認証、ログインを経て勤怠登録画面に進むことができます。登録された勤怠データは日付ごと、ユーザーごとに管理画面から確認することができます。

<p align="center">
<img src="https://github.com/user-attachments/assets/3d4b0e18-1b9c-4afa-ad34-04d2cecfd977">
</p>

## 作成した目的

模擬案件を通して実践に近い開発経験を積むため。

## アプリケーションURL

[デプロイのURL](http://54.238.66.93/)

このアプリはユーザー登録と、メールアドレスを用いた認証によって利用することができます。

### 他のリポジトリ

## 機能一覧

・会員登録・・・Laravel Breezeを使用

・ログイン・・・Laravel Breezeを使用

・ログアウト・・・Laravel Breezeを使用

・メール認証・・・Laravel Breezeを使用

・勤務開始・・・日を跨いだ時点で翌日の出勤操作に切り替える

・勤務終了・・・日を跨いだ時点で翌日の出勤操作に切り替える

・休憩開始・・・一日に何度でも可能

・休憩終了・・・一日に何度でも可能

・日付別勤怠情報取得

・ユーザー別勤怠情報取得

・ページネーション・・・5件ずつ取得

## 使用技術（実行環境）

PHP 8.2.24

Laravel sail

Laravel Breeze

Laravel Framework 11.27.2

EC2(Amazon Linux2)

RDS(mysql 8.0.32)

Mailpit v1.20.5（ローカル環境のみ）

phpmyadmin(ローカル環境のみ)

## テーブル設計

<p align="center">
<img src="https://github.com/user-attachments/assets/8a11063e-6d99-4c15-8457-98f04e7bee1b">
</p>

## ER図

<p align="center">
<img src="https://github.com/user-attachments/assets/c02a7bd0-7801-46ea-b3e3-08e55cb910c6">
</p>

## ローカル環境の構築手順

1.コマンドライン上で任意のパスに「git clone」を行う。

2.アプリディレクトリに移動し「sudo cp .env.example .env」を実行。

3.「docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs」を実行してcomposerをインストール。

4.「sudo chown -R {Linuxのユーザー名} atte-local」で所有者の変更。

4.「./vendor/bin/sail up -d」を実行し、アプリを立ち上げる。

5.「./vendor/bin/sail artisan key:generate」を実行し、キーを発行する。

6.「./vendor/bin/sail artisan migrate:fresh」を実行し、マイグレーションする。

7.「./vendor/bin/sail artisan db:seed」を実行し、テストユーザーを作成する。

    ユーザー名：test

    メールアドレス：test@test.com

    パスワード：hogehoge

8.ブラウザ上でlocalhostにアクセスして、テストユーザーでログイン、もしくはユーザー作成→メール認証→ログインを行う。

(ローカル環境では8025番ポートにおいてMailpitでの認証を行う)