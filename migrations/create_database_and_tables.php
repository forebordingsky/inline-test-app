<?php

(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('CLI mod only.');

require_once 'src/connection.php';

$db->query('DROP DATABASE IF EXISTS ' . DB_NAME . ';');

$db->query('CREATE DATABASE IF NOT EXISTS ' . DB_NAME . ' DEFAULT CHARACTER SET utf8;');
$db->query('USE '. DB_NAME . ';');
$db->query('CREATE TABLE posts(
    userId INT NOT NULL,
    id INT AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    PRIMARY KEY(id));');
$db->query('CREATE TABLE comments(
    postId INT NOT NULL,
    id INT AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    PRIMARY KEY(id),
    CONSTRAINT fk_post FOREIGN KEY(postId) REFERENCES posts(id) ON DELETE CASCADE);');
echo 'Database ' . DB_NAME . ' was created with tables posts and comments.';