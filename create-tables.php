<?php 

require "database.php";
$db = new Database;

$sql = 'CREATE TABLE if not exists movies
(
    id         int auto_increment primary key,
    title      varchar(255)                         null,
    year       varchar(5)                           null,
    created_at datetime default current_timestamp() null,
    updated_at datetime default current_timestamp() null
);

CREATE TABLE if not exists tags
(
    id         int auto_increment primary key,
    tag      varchar(255)                         null,
    created_at datetime default current_timestamp() null,
    updated_at datetime default current_timestamp() null
);

CREATE TABLE if not exists genres
(
    id         int auto_increment primary key,
    name varchar(255) null,
    created_at datetime default current_timestamp() null

);



CREATE TABLE if not exists users
(
    id         int auto_increment primary key,
    name       varchar(255)                         null,
    gender     varchar(255)                         null,
    bio        varchar(255)                         null,
    email      varchar(255)                         null,
    password   varchar(255)                         null,
    age        tinyint                              null,
    avatar     varchar(255)                         null,
    created_at datetime default current_timestamp() null,
    updated_at datetime default current_timestamp() null
);

CREATE TABLE if not exists movies_genres
(
    id         int(11) auto_increment primary key not null,
    movie_id   int(11),
    genre_id   int(11),
    created_at  datetime default current_timestamp(),
    constraint movies_genres_movies_id_fk
    foreign key (movie_id) references movies (id)
    on update cascade on delete cascade,
    constraint movies_genres_genres_id_fk
    foreign key (genre_id) references genres (id)
    on update cascade on delete cascade

    
);
CREATE TABLE if not exists links
(
    id       int auto_increment primary key,
    movie_id int,
    imdb_id  int null,
    tmdb_id  int null,
    created_at datetime default current_timestamp() null,
    constraint links_movies_id_fk
    foreign key (movie_id) references movies (id)
    on update cascade on delete cascade

);
Create table if not exists movies_tags
(
    id        int auto_increment primary key,
    user_id   int          null,
    movie_id  int          null,
    tag       varchar(255) null,
    created_at datetime default current_timestamp() null,
     constraint movies_tags_movies_id_fk
    foreign key (movie_id) references movies (id)
    on update cascade on delete cascade,
    constraint movies_tags_users_id_fk
    foreign key (user_id) references users (id)
    on update cascade on delete cascade
);

CREATE TABLE if not exists scores
(
    id       int auto_increment primary key,
    movie_id int null,
    tag_id  int null,
    relevance  decimal(20,19),
    created_at datetime default current_timestamp() null,
        constraint scores_movies_id_fk
    foreign key (movie_id) references movies (id)
    on update cascade on delete cascade,
    constraint scores_movies_tags_id_fk
    foreign key (tag_id) references movies_tags (id)
    on update cascade on delete cascade
);

CREATE TABLE if not exists ratings
(
    id         int auto_increment primary key,
    user_id    int                                                                null,
    movie_id   int                                                                null,
    rating     float                                                              null,
    timestamp  datetime default current_timestamp()                               null,
    updated_at datetime default current_timestamp() on update current_timestamp() null,
    constraint ratings_movies_id_fk
        foreign key (movie_id) references movies (id)
            on update cascade on delete cascade,
    constraint ratings_users_id_fk
        foreign key (user_id) references users (id)
           on update cascade on delete cascade
);';

$db->write($sql);

