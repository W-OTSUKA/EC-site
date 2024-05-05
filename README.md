## 概要

ECサイト を作成しました。

出品者ユーザと一般ユーザに分け、
それぞれでログインできるようにしています。

## インストール

composer install<br>
npm install && npm run dev<br>
.env.example を .env にコピー<br>
.env の DB 関連、sanctum, session などの情報を編集<br>
php artisan key:generate<br>

## 開発中の簡易サーバー

サーバー側<br>
php artisan serve <br>

フロント側 (vite)<br>
npm run dev<br>

## 使い方

出品者ユーザ

出品した商品一覧が見れるようにしています。

出品者新規登録から出品者の登録をしてください

一般ユーザ

購入できる商品一覧見れるようにしています。

一般ユーザー新規登録から出品者の登録をしてください

## 環境

XAMPP/MySQL/PHP/javaScript/tailwindCSS

## データベース

データベース名：ecsite

テーブル

お使いの phpMyAdmin に上のデータベースを作り、ターミナルで php artisan migrate:fresh  のコマンドを叩けばお使いいただけます。